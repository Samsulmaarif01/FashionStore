<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Category;
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
        $totalMessages = \App\Models\Message::count();
        $recentOrders  = Order::with('user')->latest()->take(5)->get();
        $recentMessages = \App\Models\Message::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalMembers', 'totalMessages', 'recentOrders', 'recentMessages'));
    }

    // ── Products CRUD ─────────────────────────────────────────────────────────

    public function products()
    {
        $products = Product::with('category_rel')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'new_category' => ['nullable', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'discount_start'   => ['nullable', 'date'],
            'discount_end'     => ['nullable', 'date', 'after_or_equal:discount_start'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'url', 'max:500'],
            'badge'        => ['nullable', 'string', 'max:50'],
            'stock'        => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'is_active'    => ['boolean'],
            'is_trending'  => ['boolean'],
        ]);

        // Handle new category creation
        if (!empty($validated['new_category'])) {
            $newCat = Category::firstOrCreate(
                ['name' => $validated['new_category']],
                ['slug' => Str::slug($validated['new_category'])]
            );
            $validated['category_id'] = $newCat->id;
            $validated['category'] = $newCat->name;
        } elseif (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
            $validated['category'] = $category->name;
        } else {
            return back()->withErrors(['category_id' => 'Kategori harus dipilih atau dibuat baru.'])->withInput();
        }

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_trending'] = $request->has('is_trending');

        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 5;

        Product::updateOrCreate(['slug' => $validated['slug']], $validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'new_category' => ['nullable', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'discount_start'   => ['nullable', 'date'],
            'discount_end'     => ['nullable', 'date', 'after_or_equal:discount_start'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'url', 'max:500'],
            'badge'        => ['nullable', 'string', 'max:50'],
            'stock'        => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'is_active'    => ['boolean'],
            'is_trending'  => ['boolean'],
        ]);

        // Handle new category creation
        if (!empty($validated['new_category'])) {
            $newCat = Category::firstOrCreate(
                ['name' => $validated['new_category']],
                ['slug' => Str::slug($validated['new_category'])]
            );
            $validated['category_id'] = $newCat->id;
            $validated['category'] = $newCat->name;
        } elseif (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
            $validated['category'] = $category->name;
        } else {
            return back()->withErrors(['category_id' => 'Kategori harus dipilih atau dibuat baru.'])->withInput();
        }

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_trending'] = $request->has('is_trending');
        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 5;

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
        $request->validate([
            'status' => ['required', 'string', 'in:pending,processing,shipped,completed,cancelled'],
            'cancel_reason' => ['nullable', 'string', 'max:500']
        ]);
        
        $data = ['status' => $request->status];

        if ($request->status === 'shipped') {
            $data['shipped_at'] = now();
        } elseif ($request->status === 'completed') {
            $data['completed_at'] = now();
        } elseif ($request->status === 'cancelled') {
            $data['cancel_reason'] = $request->cancel_reason;
        }

        $order->update($data);
        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function destroyOrder(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Riwayat pesanan berhasil dihapus.');
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

    // ── Categories CRUD ────────────────────────────────────────────────────────
    
    public function categories()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
