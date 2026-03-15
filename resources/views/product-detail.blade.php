@php
    $productObj = is_array($product) ? (object)$product : $product;
    $hasDiscount = isset($productObj->discount_percent) && $productObj->discount_percent > 0;
    $price = $productObj->price ?? 0;
    $discountedPrice = $hasDiscount 
        ? ($productObj->discounted_price ?? $price * (1 - ($productObj->discount_percent / 100))) 
        : $price;
@endphp

<x-layout>
    <!-- Navigation / Breadcrumbs -->
    <div class="bg-gray-50 py-4 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-sm text-gray-500 font-medium">
                <a href="/" class="hover:text-indigo-600 transition-colors">Beranda</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $productObj->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Detail Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-24">
                
                <!-- Product Image (Left side) -->
                <div class="gsap-fade-up relative overflow-hidden rounded-lg bg-gray-100 group">
                    @if($hasDiscount)
                        <div class="absolute top-6 left-6 z-10 px-4 py-2 bg-red-600 text-white text-xs font-black uppercase tracking-widest shadow-xl">
                            DISKON {{ $productObj->discount_percent }}%
                        </div>
                    @endif
                    <img 
                        src="{{ $productObj->image }}" 
                        alt="{{ $productObj->name }}" 
                        class="w-full h-auto object-cover object-center max-h-[80vh] transition-transform duration-700 hover:scale-105"
                    />
                </div>

                <!-- Product Info (Right side) -->
                <div class="flex flex-col justify-center gsap-fade-up" style="animation-delay: 100ms;">
                    <p class="text-xs font-bold tracking-[0.2em] text-indigo-600 uppercase mb-3">
                        {{ $productObj->category_rel->name ?? ($productObj->category ?? 'Fashion') }}
                    </p>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tighter text-black mb-4 uppercase">{{ $productObj->name }}</h1>
                    
                    <div class="flex items-end gap-4 mb-8 border-b border-gray-100 pb-8">
                        @if($hasDiscount)
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-400 line-through mb-1">Rp {{ number_format($price, 0, ',', '.') }}</span>
                                <span class="text-4xl font-black text-red-600">Rp {{ number_format($discountedPrice, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="text-4xl font-black text-black">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose prose-sm text-gray-600 mb-10 leading-relaxed font-light">
                        <p>{{ $productObj->description ?? 'Detail produk tidak tersedia untuk sampel ini.' }}</p>
                    </div>

                    <!-- Select Size -->
                    <div class="mb-8" x-data="{ selectedSize: null }">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-black">Pilih Ukuran</h3>
                            <a href="#" class="text-[10px] font-bold uppercase tracking-wider text-gray-400 hover:text-black transition-all">Panduan</a>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            <template x-for="size in ['S', 'M', 'L', 'XL']" :key="size">
                                <button 
                                    @click="selectedSize = selectedSize === size ? null : size"
                                    :class="selectedSize === size ? 'border-black bg-black text-white' : 'border-gray-100 text-gray-400 hover:border-black hover:text-black'"
                                    class="border py-4 text-xs font-bold uppercase tracking-widest transition-all cursor-pointer focus:outline-none"
                                    x-text="size"
                                ></button>
                            </template>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-10">
                        <button class="flex-1 bg-black text-white py-5 px-8 font-black uppercase tracking-widest text-[10px] hover:bg-indigo-600 transition-all duration-300 shadow-xl">
                            Tambah ke Keranjang
                        </button>
                        <button class="w-full sm:w-16 h-16 items-center justify-center flex border border-gray-100 text-gray-300 hover:text-red-500 hover:border-red-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Extra Info -->
                    <div class="border-t border-gray-100 pt-6">
                        <ul class="space-y-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            <li class="flex items-center">
                                <span class="w-5 h-5 flex items-center justify-center bg-gray-50 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                Tersedia di toko dan online
                            </li>
                            <li class="flex items-center">
                                <span class="w-5 h-5 flex items-center justify-center bg-gray-50 rounded-full mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                Pengembalian gratis selama 30 hari
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
