@props(['product'])

<div class="product-card group relative bg-white flex flex-col overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-1">
    <!-- Stretched Link to Detail Page -->
    <a href="{{ route('product.detail', $product['slug'] ?? \Illuminate\Support\Str::slug($product['name'])) }}" class="absolute inset-0 z-10 w-full h-full">
        <span class="sr-only">Lihat detail {{ $product['name'] }}</span>
    </a>

    <!-- Image Section -->
    <div class="relative w-full aspect-[4/5] bg-gray-100 overflow-hidden">
        <!-- New/Sale Badge -->
        @if(isset($product['badge']))
            <span class="absolute top-4 left-4 z-10 px-3 py-1 bg-indigo-600 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-md animate-pulse">
                {{ $product['badge'] }}
            </span>
        @endif

        <!-- Image -->
        <img 
            src="{{ $product['image'] }}" 
            alt="{{ $product['name'] }}" 
            class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-110"
        />

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-500 ease-in-out"></div>

        <!-- Add to Cart Button (Hidden by default, slides up on hover) -->
        <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 ease-in-out z-20 relative">
            <button class="w-full bg-white text-black py-3 font-semibold text-sm hover:bg-black hover:text-white transition-colors duration-300 shadow-lg relative z-30 cursor-pointer">
                Tambah ke Keranjang
            </button>
        </div>
    </div>

    <!-- Product Info Section -->
    <div class="p-6 flex flex-col flex-1">
        <h3 class="text-sm text-gray-500 font-medium tracking-wide uppercase mb-1">{{ $product['category'] }}</h3>
        <a href="{{ route('product.detail', $product['slug'] ?? \Illuminate\Support\Str::slug($product['name'])) }}" class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-300 relative z-20">
            {{ $product['name'] }}
        </a>
        <div class="mt-auto pt-4 flex items-center justify-between">
            <span class="text-lg font-semibold text-black">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
            
            <!-- Quick View Icon -->
            <button class="text-gray-400 hover:text-indigo-600 transition-colors duration-300 relative z-20 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
    </div>
</div>
