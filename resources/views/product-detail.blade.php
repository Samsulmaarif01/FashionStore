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

                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if($productObj->stock <= 0)
                            <div class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 text-red-600 font-bold uppercase tracking-widest text-[10px] italic">
                                Stok Habis - Produk sedang kosong
                            </div>
                        @elseif($productObj->stock <= ($productObj->low_stock_threshold ?? 5))
                            <div class="inline-flex items-center px-4 py-2 bg-orange-50 border border-orange-200 text-orange-600 font-bold uppercase tracking-widest text-[10px] animate-pulse">
                                Stok Terbatas: Tersisa {{ $productObj->stock }} Produk
                            </div>
                        @else
                            <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                Stok Tersedia: {{ $productObj->stock }}
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-10">
                        @if($productObj->stock > 0)
                            <form action="{{ route('cart.add', $productObj) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-black text-white py-5 px-8 font-black uppercase tracking-widest text-[10px] hover:bg-indigo-600 transition-all duration-300 shadow-xl cursor-pointer">
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button disabled class="flex-1 bg-gray-100 text-gray-400 py-5 px-8 font-black uppercase tracking-widest text-[10px] cursor-not-allowed">
                                Stok Kosong
                            </button>
                        @endif
                        <form action="{{ route('member.wishlist.toggle', $productObj) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full sm:w-16 h-16 items-center justify-center flex border {{ auth()->check() && auth()->user()->wishlists()->where('product_id', $productObj->id)->exists() ? 'border-red-200 bg-red-50 text-red-500' : 'border-gray-100 text-gray-300' }} hover:text-red-500 hover:border-red-500 transition-all cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ auth()->check() && auth()->user()->wishlists()->where('product_id', $productObj->id)->exists() ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
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

    <!-- Reviews Section -->
    <section class="border-t border-gray-100 bg-[#fafafa] py-16 md:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <h2 class="text-2xl font-black text-black uppercase tracking-tight">Ulasan Pelanggan</h2>
                @if(isset($productObj->id) && $productObj->reviews->count() > 0)
                    <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100">
                        <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <span class="text-xl font-black text-black">{{ number_format($productObj->average_rating, 1) }} <span class="text-gray-400 text-sm font-medium">({{ $productObj->reviews_count }} Ulasan)</span></span>
                    </div>
                @endif
            </div>

            @if(!isset($productObj->id) || $productObj->reviews->isEmpty())
                <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Belum ada ulasan untuk produk ini.</p>
                    <p class="text-xs text-gray-400 mt-2">Jadilah yang pertama untuk memberikan pendapat Anda setelah membeli!</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($productObj->reviews as $review)
                        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex gap-5">
                                <div class="w-12 h-12 bg-gray-100 rounded-full overflow-hidden flex-shrink-0 border border-gray-200">
                                    <img src="{{ $review->user->profile_photo ? asset('storage/'.$review->user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name).'&background=111&color=fff' }}" alt="{{ $review->user->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-bold text-sm text-black">{{ $review->user->name }}</h4>
                                            <p class="text-[11px] text-gray-400 font-medium tracking-wide uppercase mt-1">Ditinjau pada {{ $review->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="flex text-amber-400">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layout>
