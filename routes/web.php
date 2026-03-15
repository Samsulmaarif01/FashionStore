<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// ── Public Routes ─────────────────────────────────────────────────────────────

Route::get('/', function () {
    $products = \App\Models\Product::where('is_active', true)
        ->where('is_trending', true)
        ->latest()
        ->take(8)
        ->get();

    // Fallback to static products if no trending products in DB
    if ($products->isEmpty()) {
        $products = collect([
            (object)['name' => 'Jaket Velour Midnight', 'category' => 'Pakaian Luar', 'price' => 2850000, 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop', 'badge' => 'Baru', 'slug' => 'jaket-velour-midnight', 'discount_percent' => 0, 'discounted_price' => 2850000, 'is_discount_active' => false],
            (object)['name' => 'Blus Esensi Sutra', 'category' => 'Atasan', 'price' => 1350000, 'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=1974&auto=format&fit=crop', 'slug' => 'blus-esensi-sutra', 'discount_percent' => 0, 'discounted_price' => 1350000, 'is_discount_active' => false],
            (object)['name' => 'Mantel Parit Minimalis', 'category' => 'Pakaian Luar', 'price' => 3675000, 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop', 'slug' => 'mantel-parit-minimalis', 'discount_percent' => 0, 'discounted_price' => 3675000, 'is_discount_active' => false],
            (object)['name' => 'Rok Motif Abstrak', 'category' => 'Bawahan', 'price' => 1650000, 'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=1935&auto=format&fit=crop', 'badge' => 'Diskon', 'slug' => 'rok-motif-abstrak', 'discount_percent' => 0, 'discounted_price' => 1650000, 'is_discount_active' => false],
        ]);
    }

    return view('welcome', compact('products'));
});

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/koleksi', [ProductController::class, 'index'])->name('collection');

Route::get('/product/{slug}', function ($slug) {
    // Try DB first
    $dbProduct = \App\Models\Product::where('slug', $slug)->where('is_active', true)->first();
    if ($dbProduct) {
        $product = $dbProduct;
        return view('product-detail', compact('product'));
    }

    // Fallback static
    $products = [
        (object)['name' => 'Jaket Velour Midnight', 'category' => 'Pakaian Luar', 'price' => 2850000, 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop', 'badge' => 'Baru', 'description' => 'Miliki pakaian istimewa ini, dibuat dengan presisi dan dedikasi pada keanggunan modern.', 'discount_percent' => 0],
        (object)['name' => 'Blus Esensi Sutra', 'category' => 'Atasan', 'price' => 1350000, 'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=1974&auto=format&fit=crop', 'description' => 'Blus sutra premium dengan sentuhan esensi minimalis.', 'discount_percent' => 0],
        (object)['name' => 'Mantel Parit Minimalis', 'category' => 'Pakaian Luar', 'price' => 3675000, 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop', 'description' => 'Mantel parit (Trench Coat) bergaya minimalis klasik yang tahan lama.', 'discount_percent' => 0],
        (object)['name' => 'Rok Motif Abstrak', 'category' => 'Bawahan', 'price' => 1650000, 'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=1935&auto=format&fit=crop', 'badge' => 'Diskon', 'description' => 'Tingkatkan gaya urban Anda dengan Rok Motif Abstrak ini.', 'discount_percent' => 0],
    ];

    $product = collect($products)->first(fn ($item) => Str::slug($item['name']) === $slug);
    if (!$product) abort(404);

    return view('product-detail', compact('product'));
})->name('product.detail');

Route::get('/tentang-kami', function () {
    $about = \App\Models\About::first();
    if (!$about) {
        $about = (object)[
            'title' => 'Tentang Kami',
            'content' => 'Velour adalah destinasi utama untuk fesyen modern dan dinamis.',
            'image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070&auto=format&fit=crop'
        ];
    }
    return view('about', compact('about'));
})->name('about');

// ── Breeze Dashboard redirect ─────────────────────────────────────────────────
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('member.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Member Routes ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders',    [MemberController::class, 'orders'])->name('orders');
    Route::get('/settings',  [MemberController::class, 'settings'])->name('settings');

    Route::patch('/profile/update',   [MemberController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/password', [MemberController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo',     [MemberController::class, 'updatePhoto'])->name('profile.photo');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
});

Route::post('/member/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('member.wishlist.toggle');

// ── Admin Routes ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Products CRUD
    Route::get('/products',              [AdminController::class, 'products'])->name('products');
    Route::get('/products/create',       [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products',             [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit',    [AdminController::class, 'editProduct'])->name('products.edit');
    Route::patch('/products/{product}',       [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}',      [AdminController::class, 'destroyProduct'])->name('products.destroy');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    // Members
    Route::get('/members', [AdminController::class, 'members'])->name('members');

    // About Us
    Route::get('/about', [AdminController::class, 'editAbout'])->name('about.edit');
    Route::patch('/about', [AdminController::class, 'updateAbout'])->name('about.update');

    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::patch('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
});

// ── Breeze Profile Routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
