<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/{slug}', function ($slug) {
    $products = [
        [
            'name' => 'Jaket Velour Midnight',
            'category' => 'Pakaian Luar',
            'price' => 2850000,
            'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop',
            'badge' => 'Baru',
            'description' => 'Miliki pakaian istimewa ini, dibuat dengan presisi dan dedikasi pada keanggunan modern. Bahan premium yang memastikan kenyamanan dalam beraktivitas sepanjang hari, cocok untuk gaya hidup dinamis yang elegan.',
        ],
        [
            'name' => 'Blus Esensi Sutra',
            'category' => 'Atasan',
            'price' => 1350000,
            'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=1974&auto=format&fit=crop',
            'description' => 'Blus sutra premium dengan sentuhan esensi minimalis, menjanjikan kesejukan serta kenyamanan pada setiap pemakaiannya. Sangat cocok untuk acara semi-formal maupun keseharian.',
        ],
        [
            'name' => 'Mantel Parit Minimalis',
            'category' => 'Pakaian Luar',
            'price' => 3675000,
            'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop',
            'description' => 'Mantel parit (Trench Coat) bergaya minimalis klasik yang tahan lama. Dilengkapi detail apik yang akan mempertahankan siluet gaya berpakaian Anda pada setiap musim.',
        ],
        [
            'name' => 'Rok Motif Abstrak',
            'category' => 'Bawahan',
            'price' => 1650000,
            'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=1935&auto=format&fit=crop',
            'badge' => 'Diskon',
            'description' => 'Tingkatkan gaya urban Anda dengan Rok Motif Abstrak ini. Didesain secara khusus agar sepadan dengan berbagai atasan untuk mengeksplorasi penampilan secara dinamis.',
        ]
    ];

    $product = collect($products)->first(function ($item) use ($slug) {
        return Str::slug($item['name']) === $slug;
    });

    if (!$product) {
        abort(404);
    }

    return view('product-detail', compact('product'));
})->name('product.detail');
