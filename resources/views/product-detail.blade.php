<x-layout>
    <!-- Navigation / Breadcrumbs -->
    <div class="bg-gray-50 py-4 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-sm text-gray-500 font-medium">
                <a href="/" class="hover:text-indigo-600 transition-colors">Beranda</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $product['name'] }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Detail Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-24">
                
                <!-- Product Image (Left side) -->
                <div class="gsap-fade-up relative overflow-hidden rounded-lg bg-gray-100 group">
                    <img 
                        src="{{ $product['image'] }}" 
                        alt="{{ $product['name'] }}" 
                        class="w-full h-auto object-cover object-center max-h-[80vh] transition-transform duration-700 hover:scale-105"
                    />
                </div>

                <!-- Product Info (Right side) -->
                <div class="flex flex-col justify-center gsap-fade-up" style="animation-delay: 100ms;">
                    <p class="text-xs font-bold tracking-[0.3em] text-indigo-600 uppercase mb-3">{{ $product['category'] }}</p>
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tighter text-black mb-4">{{ $product['name'] }}</h1>
                    
                    <div class="text-3xl font-bold text-gray-900 mb-8 border-b border-gray-100 pb-8">
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                    </div>

                    <!-- Description -->
                    <div class="prose prose-sm text-gray-600 mb-10 leading-relaxed font-light">
                        <p>{{ $product['description'] ?? 'Detail produk tidak tersedia untuk sampel ini.' }}</p>
                    </div>

                    <!-- Select Size -->
                    <div class="mb-8" x-data="{ selectedSize: null }">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-black">Pilih Ukuran</h3>
                            <a href="#" class="text-xs text-gray-400 hover:text-black hover:underline transition-all">Panduan Ukuran</a>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            <template x-for="size in ['S', 'M', 'L', 'XL']" :key="size">
                                <button 
                                    @click="selectedSize = selectedSize === size ? null : size"
                                    :class="selectedSize === size ? 'border-black bg-black text-white hover:bg-gray-800' : 'border-gray-200 text-black hover:border-black hover:bg-gray-50'"
                                    class="border py-3 text-sm font-semibold transition-all cursor-pointer focus:outline-none"
                                    x-text="size"
                                ></button>
                            </template>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mb-10">
                        <button class="flex-1 bg-black text-white py-4 px-8 font-bold uppercase tracking-widest text-sm hover:bg-indigo-600 transition-colors duration-300 shadow-xl hover:shadow-indigo-500/30">
                            Tambah ke Keranjang
                        </button>
                        <button class="w-14 items-center justify-center flex border border-gray-200 text-gray-400 hover:text-red-500 hover:border-red-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Extra Info -->
                    <div class="border-t border-gray-100 pt-6 mt-auto">
                        <ul class="space-y-3 text-sm text-gray-500 font-light">
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Tersedia di toko dan online
                            </li>
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Pengembalian gratis selama 30 hari
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layout>
