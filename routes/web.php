<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// ── Public Routes ─────────────────────────────────────────────────────────────

Route::get('/', function () {
    $products = \App\Models\Product::where('is_active', true)->latest()->take(8)->get()->map(function ($p) {
        return [
            'name'        => $p->name,
            'category'    => $p->category,
            'price'       => $p->price,
            'image'       => $p->image,
            'badge'       => $p->badge,
            'slug'        => $p->slug,
        ];
    })->toArray();

    // Fallback to static products if no DB products yet
    if (empty($products)) {
        $products = [
            ['name' => 'Jaket Velour Midnight', 'category' => 'Pakaian Luar', 'price' => 2850000, 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop', 'badge' => 'Baru', 'slug' => 'jaket-velour-midnight'],
            ['name' => 'Blus Esensi Sutra', 'category' => 'Atasan', 'price' => 1350000, 'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=1974&auto=format&fit=crop', 'slug' => 'blus-esensi-sutra'],
            ['name' => 'Mantel Parit Minimalis', 'category' => 'Pakaian Luar', 'price' => 3675000, 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop', 'slug' => 'mantel-parit-minimalis'],
            ['name' => 'Rok Motif Abstrak', 'category' => 'Bawahan', 'price' => 1650000, 'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=1935&auto=format&fit=crop', 'badge' => 'Diskon', 'slug' => 'rok-motif-abstrak'],
        ];
    }

    return view('welcome', compact('products'));
});

Route::get('/product/{slug}', function ($slug) {
    // Try DB first
    $dbProduct = \App\Models\Product::where('slug', $slug)->where('is_active', true)->first();
    if ($dbProduct) {
        $product = $dbProduct->toArray();
        return view('product-detail', compact('product'));
    }

    // Fallback static
    $products = [
        ['name' => 'Jaket Velour Midnight', 'category' => 'Pakaian Luar', 'price' => 2850000, 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop', 'badge' => 'Baru', 'description' => 'Miliki pakaian istimewa ini, dibuat dengan presisi dan dedikasi pada keanggunan modern.'],
        ['name' => 'Blus Esensi Sutra', 'category' => 'Atasan', 'price' => 1350000, 'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=1974&auto=format&fit=crop', 'description' => 'Blus sutra premium dengan sentuhan esensi minimalis.'],
        ['name' => 'Mantel Parit Minimalis', 'category' => 'Pakaian Luar', 'price' => 3675000, 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop', 'description' => 'Mantel parit (Trench Coat) bergaya minimalis klasik yang tahan lama.'],
        ['name' => 'Rok Motif Abstrak', 'category' => 'Bawahan', 'price' => 1650000, 'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=1935&auto=format&fit=crop', 'badge' => 'Diskon', 'description' => 'Tingkatkan gaya urban Anda dengan Rok Motif Abstrak ini.'],
    ];

    $product = collect($products)->first(fn ($item) => Str::slug($item['name']) === $slug);
    if (!$product) abort(404);

    return view('product-detail', compact('product'));
})->name('product.detail');

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
});

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
});

// ── Breeze Profile Routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
