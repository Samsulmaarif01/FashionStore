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

        $cart = session()->get('cart', []);

        // If cart is empty, add first product
        if(!$cart) {
            $cart = [
                    $product->id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->discounted_price,
                        "original_price" => $product->price,
                        "discount_percent" => $product->discount_percent,
                        "image" => $product->image,
                        "slug" => $product->slug
                    ]
            ];
            session()->put('cart', $cart);
            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        }

        // If cart not empty then check if this product exist then increment quantity
        if(isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] >= $product->stock) {
                 return back()->with('error', 'Stok produk tidak mencukupi.');
            }
            $cart[$product->id]['quantity']++;
            session()->put('cart', $cart);
            return back()->with('success', 'Jumlah produk di keranjang bertambah!');
        }

        // If item not exist in cart then add to cart with quantity = 1
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->discounted_price,
            "original_price" => $product->price,
            "discount_percent" => $product->discount_percent,
            "image" => $product->image,
            "slug" => $product->slug
        ];
        session()->put('cart', $cart);
        
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $product = Product::find($request->id);
            
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
