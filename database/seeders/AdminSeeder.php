<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@velour.com'],
            [
                'name'     => 'Admin Velour',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Seed Products
        $products = [
            [
                'name'        => 'Jaket Velour Midnight',
                'category'    => 'Pakaian Luar',
                'price'       => 2850000,
                'description' => 'Miliki pakaian istimewa ini, dibuat dengan presisi dan dedikasi pada keanggunan modern. Bahan premium yang memastikan kenyamanan dalam beraktivitas sepanjang hari, cocok untuk gaya hidup dinamis yang elegan.',
                'image'       => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop',
                'badge'       => 'Baru',
                'stock'       => 25,
            ],
            [
                'name'        => 'Blus Esensi Sutra',
                'category'    => 'Atasan',
                'price'       => 1350000,
                'description' => 'Blus sutra premium dengan sentuhan esensi minimalis, menjanjikan kesejukan serta kenyamanan pada setiap pemakaiannya. Sangat cocok untuk acara semi-formal maupun keseharian.',
                'image'       => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=1974&auto=format&fit=crop',
                'stock'       => 40,
            ],
            [
                'name'        => 'Mantel Parit Minimalis',
                'category'    => 'Pakaian Luar',
                'price'       => 3675000,
                'description' => 'Mantel parit (Trench Coat) bergaya minimalis klasik yang tahan lama. Dilengkapi detail apik yang akan mempertahankan siluet gaya berpakaian Anda pada setiap musim.',
                'image'       => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop',
                'stock'       => 12,
            ],
            [
                'name'        => 'Rok Motif Abstrak',
                'category'    => 'Bawahan',
                'price'       => 1650000,
                'description' => 'Tingkatkan gaya urban Anda dengan Rok Motif Abstrak ini. Didesain secara khusus agar sepadan dengan berbagai atasan untuk mengeksplorasi penampilan secara dinamis.',
                'image'       => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=1935&auto=format&fit=crop',
                'badge'       => 'Diskon',
                'stock'       => 18,
            ],
        ];

        foreach ($products as $data) {
            $data['slug']      = Str::slug($data['name']);
            $data['is_active'] = true;
            Product::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
