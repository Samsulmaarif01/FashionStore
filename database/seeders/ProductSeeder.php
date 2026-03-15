<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Atasan', 'slug' => 'atasan'],
            ['name' => 'Bawahan', 'slug' => 'bawahan'],
            ['name' => 'Pakaian Luar', 'slug' => 'pakaian-luar'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate($cat);
        }

        $atasanId = Category::where('slug', 'atasan')->first()->id;
        $bawahanId = Category::where('slug', 'bawahan')->first()->id;
        $luarId = Category::where('slug', 'pakaian-luar')->first()->id;
        $aksesorisId = Category::where('slug', 'aksesoris')->first()->id;

        $products = [
            [
                'name' => 'Jaket Velour Midnight',
                'category' => 'Pakaian Luar',
                'category_id' => $luarId,
                'price' => 2850000,
                'discount_percent' => 10,
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop',
                'badge' => 'Terlaris',
                'stock' => 15,
                'description' => 'Jaket velour mewah dengan sentuhan warna midnight yang elegan.'
            ],
            [
                'name' => 'Blus Esensi Sutra',
                'category' => 'Atasan',
                'category_id' => $atasanId,
                'price' => 1350000,
                'discount_percent' => 0,
                'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=1974&auto=format&fit=crop',
                'badge' => 'Baru',
                'stock' => 20,
                'description' => 'Blus sutra premium dengan potongan minimalis.'
            ],
            [
                'name' => 'Mantel Parit Minimalis',
                'category' => 'Pakaian Luar',
                'category_id' => $luarId,
                'price' => 3675000,
                'discount_percent' => 5,
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop',
                'stock' => 8,
                'description' => 'Mantel parit klasik yang cocok untuk segala suasana.'
            ],
            [
                'name' => 'Rok Motif Abstrak',
                'category' => 'Bawahan',
                'category_id' => $bawahanId,
                'price' => 1650000,
                'discount_percent' => 15,
                'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=1935&auto=format&fit=crop',
                'badge' => 'Diskon',
                'stock' => 12,
                'description' => 'Rok dengan motif abstrak yang artistik dan modern.'
            ],
            [
                'name' => 'Kemeja Linen Putih',
                'category' => 'Atasan',
                'category_id' => $atasanId,
                'price' => 850000,
                'discount_percent' => 0,
                'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?q=80&w=1760&auto=format&fit=crop',
                'stock' => 25,
                'description' => 'Kemeja linen ringan yang sejuk digunakan.'
            ],
            [
                'name' => 'Celana Chino Slim Fit',
                'category' => 'Bawahan',
                'category_id' => $bawahanId,
                'price' => 1100000,
                'discount_percent' => 0,
                'image' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?q=80&w=1974&auto=format&fit=crop',
                'stock' => 18,
                'description' => 'Celana chino dengan potongan slim fit yang modern.'
            ],
            [
                'name' => 'Cardigan Rajut Oversize',
                'category' => 'Pakaian Luar',
                'category_id' => $luarId,
                'price' => 1450000,
                'discount_percent' => 20,
                'image' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=2010&auto=format&fit=crop',
                'badge' => 'Sale',
                'stock' => 10,
                'description' => 'Cardigan rajut nyaman dengan gaya oversize.'
            ],
            [
                'name' => 'Tas Bahu Kulit Vegan',
                'category' => 'Aksesoris',
                'category_id' => $aksesorisId,
                'price' => 2100000,
                'discount_percent' => 0,
                'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=1769&auto=format&fit=crop',
                'stock' => 5,
                'description' => 'Tas bahu eksklusif dari bahan kulit vegan berkualitas.'
            ],
            [
                'name' => 'Kacamata Hitam Aviator',
                'category' => 'Aksesoris',
                'category_id' => $aksesorisId,
                'price' => 1750000,
                'discount_percent' => 10,
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?q=80&w=1780&auto=format&fit=crop',
                'stock' => 15,
                'description' => 'Kacamata aviator klasik untuk melengkapi gaya Anda.'
            ],
            [
                'name' => 'Sepatu Loafers Formal',
                'category' => 'Aksesoris',
                'category_id' => $aksesorisId,
                'price' => 3200000,
                'discount_percent' => 0,
                'image' => 'https://images.unsplash.com/photo-1533867617858-e7b97e060509?q=80&w=1769&auto=format&fit=crop',
                'badge' => 'Eksklusif',
                'stock' => 7,
                'description' => 'Sepatu loafers kulit asli dengan pengerjaan tangan.'
            ],
        ];

        foreach ($products as $index => $productData) {
            $slug = Str::slug($productData['name']);
            $productData['slug'] = $slug;
            $productData['is_active'] = true;
            $productData['is_trending'] = ($index % 2 == 0); // Mark some products as trending
            Product::updateOrCreate(['slug' => $slug], $productData);
        }
    }
}
