<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        $updatedCart = false;
        foreach($cart as $id => $item) {
            // Extra check: if original_price is missing, fetch it
            if (!isset($item['original_price']) || !isset($item['discount_percent'])) {
                $product = Product::find($id);
                if ($product) {
                    $cart[$id]['original_price'] = $product->price;
                    $cart[$id]['discount_percent'] = $product->discount_percent;
                    $updatedCart = true;
                }
            }
            $total += $cart[$id]['price'] * $cart[$id]['quantity'];
        }

        if ($updatedCart) {
            session()->put('cart', $cart);
        }
        
        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        if ($product->stock <= 0) {
            return back()->with('error', 'Produk ini sedang habis.');
        }

        $size = $request->input('size', 'M'); // Default to M if not provided
        $cart = session()->get('cart', []);
        $cartKey = $product->id . '-' . $size;

        if(isset($cart[$cartKey])) {
            if ($cart[$cartKey]['quantity'] >= $product->stock) {
                 return back()->with('error', 'Stok produk tidak mencukupi.');
            }
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->discounted_price,
                "original_price" => $product->price,
                "discount_percent" => $product->discount_percent,
                "image" => $product->image,
                "slug" => $product->slug,
                "size" => $size
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $item = $cart[$request->id] ?? null;
            if (!$item) return response()->json(['error' => 'Item tidak ditemukan.'], 404);

            $product = Product::find($item['product_id']);
            
            if ($request->quantity > $product->stock) {
                return response()->json(['error' => 'Stok tidak mencukupi.'], 400);
            }

            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => 'Keranjang diperbarui.']);
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return back()->with('success', 'Produk dihapus dari keranjang.');
        }
    }
}
