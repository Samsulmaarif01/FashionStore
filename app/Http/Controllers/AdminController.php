<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────────────────────

    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalMembers  = User::where('role', 'member')->count();
        $recentOrders  = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalMembers', 'recentOrders'));
    }

    // ── Products CRUD ─────────────────────────────────────────────────────────

    public function products()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'url', 'max:500'],
            'badge'       => ['nullable', 'string', 'max:50'],
            'stock'       => ['required', 'integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        Product::create($validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'url', 'max:500'],
            'badge'       => ['nullable', 'string', 'max:50'],
            'stock'       => ['required', 'integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus.');
    }

    // ── Orders ────────────────────────────────────────────────────────────────

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate(['status' => ['required', 'string', 'in:pending,processing,shipped,delivered,cancelled']]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan diperbarui.');
    }

    // ── Members ───────────────────────────────────────────────────────────────

    public function members()
    {
        $members = User::where('role', 'member')->latest()->paginate(15);
        return view('admin.members', compact('members'));
    }

    // ── About Us ──────────────────────────────────────────────────────────────

    public function editAbout()
    {
        $about = About::first();
        if (!$about) {
            $about = About::create([
                'title' => 'Tentang Kami',
                'content' => 'Selamat datang di Velour.',
            ]);
        }
        return view('admin.about', compact('about'));
    }

    public function updateAbout(Request $request)
    {
        $about = About::first();
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'url', 'max:500'],
        ]);

        $about->update($validated);

        return back()->with('success', 'Konten Tentang Kami berhasil diperbarui.');
    }
}
