<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class PaymentController extends Controller
{
    public function createInvoice(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'status' => 'pending',
                'total_amount' => $total,
                'shipping_address' => $request->address,
                'payment_method' => $request->payment_method,
                'notes' => 'Nama: ' . $request->name . ' | Telp: ' . $request->phone,
            ]);

            foreach ($cart as $id => $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);
                if (!$product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }
                
                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Stok untuk ' . $product->name . ' tidak mencukupi.');
                }
                
                $product->decrement('stock', $item['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            // Xendit Integration
            Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
            $apiInstance = new InvoiceApi();
            
            $create_invoice_request = new CreateInvoiceRequest([
                'external_id' => $order->order_number,
                'description' => 'Pembayaran Pesanan ' . $order->order_number,
                'amount' => $order->total_amount,
                'payer_email' => Auth::user()->email,
                'success_redirect_url' => route('checkout.success', $order->id),
                'failure_redirect_url' => route('cart.index'),
            ]);

            $result = $apiInstance->createInvoice($create_invoice_request);
            
            return redirect($result->getInvoiceUrl());

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $external_id = $request->input('external_id');
        $status = $request->input('status');

        $order = Order::where('order_number', $external_id)->first();

        if ($order) {
            if ($status === 'PAID' || $status === 'SETTLED') {
                $order->update([
                    'status' => 'processing',
                    'paid_at' => now(),
                ]);
            } elseif ($status === 'EXPIRED') {
                $order->update([
                    'status' => 'cancelled',
                    'cancel_reason' => 'Invoice expired',
                ]);
            }
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
