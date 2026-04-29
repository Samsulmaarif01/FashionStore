@props(['product'])

<div class="product-card h-full group relative bg-white flex flex-col overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 rounded-2xl">
    <!-- Stretched Link to Detail Page -->
    <a href="{{ route('product.detail', $product->slug) }}" class="absolute inset-0 z-10 w-full h-full">
        <span class="sr-only">Lihat detail {{ $product->name }}</span>
    </a>

    <!-- Image Section -->
    <div class="relative w-full aspect-[4/5] bg-gray-100 overflow-hidden">
        <!-- New/Sale Badge -->
        @if($product->discount_percent > 0)
            <span class="absolute top-4 left-4 z-10 px-3 py-1 bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-full shadow-md">
                DISKON {{ $product->discount_percent }}%
            </span>
        @elseif(isset($product->badge))
            <span class="absolute top-4 left-4 z-10 px-3 py-1 bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-full shadow-md">
                {{ $product->badge }}
            </span>
        @endif

        <!-- Image -->
        <img 
            src="{{ $product->image }}" 
            alt="{{ $product->name }}" 
            class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-110"
        />

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-500 ease-in-out"></div>


    </div>

    <!-- Product Info Section -->
    <div class="p-6 flex flex-col flex-1">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-xs text-gray-500 font-semibold tracking-wide uppercase">{{ $product->category_rel->name ?? $product->category }}</h3>
            @if($product->reviews_count > 0)
                <div class="flex items-center gap-1 bg-gray-50 px-2 py-0.5 rounded-full border border-gray-100 relative z-20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" style="color: #facc15;" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    <span class="text-[10px] font-bold text-gray-700">{{ number_format($product->average_rating, 1) }} <span class="text-gray-400 font-medium">({{ $product->reviews_count }})</span></span>
                </div>
            @endif
        </div>
        <a href="{{ route('product.detail', $product->slug) }}" class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-300 relative z-20">
            {{ $product->name }}
        </a>
        <div class="mt-auto pt-4 flex items-center justify-between">
            <div class="flex flex-col">
                @if($product->discount_percent > 0)
                    <span class="text-[11px] text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-black text-blue-600">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                        <span class="text-[10px] font-bold text-blue-100 bg-blue-600 px-1.5 py-0.5 rounded">-{{ $product->discount_percent }}%</span>
                    </div>
                @else
                    <span class="text-lg font-black text-black">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
            </div>
            

        </div>

        <!-- Product Stock Status -->
        <div class="mt-2 flex items-center justify-between">
            <div class="text-[10px] font-bold uppercase tracking-wider">
                @if($product->is_out_of_stock)
                    <span class="text-red-600 bg-red-50 px-2 py-0.5 border border-red-100 italic">Produk Habis</span>
                @elseif($product->is_low_stock)
                    <span class="text-red-600 animate-pulse">Tersisa {{ $product->stock }}</span>
                @else
                    <span class="text-gray-400">Stok: {{ $product->stock }}</span>
                @endif
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between gap-3">
            @if($product->is_out_of_stock)
                <button disabled class="flex-1 bg-gray-200 text-gray-400 py-3 text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                    Produk Kosong
                </button>
            @else
                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1 flex gap-2">
                    @csrf
                    <button type="submit" class="flex-1 bg-black text-white py-2 px-1 text-[9px] font-bold uppercase tracking-wider hover:bg-gray-800 transition-colors duration-300 relative z-20 cursor-pointer">
                        + Keranjang
                    </button>
                    <button type="submit" name="buy_now" value="1" class="flex-1 bg-indigo-600 text-white py-2 px-1 text-[9px] font-bold uppercase tracking-wider hover:bg-indigo-700 transition-colors duration-300 relative z-20 cursor-pointer">
                        Beli Langsung
                    </button>
                </form>
            @endif
            <form action="{{ route('member.wishlist.toggle', $product) }}" method="POST" class="relative z-20">
                @csrf
                <button type="submit" class="p-2.5 border border-gray-200 {{ auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'text-red-500 border-red-200 bg-red-50' : 'text-gray-400' }} hover:text-red-500 hover:border-red-500 transition-colors cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="{{ auth()->check() && auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
