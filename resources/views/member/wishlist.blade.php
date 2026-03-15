<x-member-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase tracking-tighter">
            {{ __('Wishlist Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 p-6">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-black uppercase tracking-tighter">Produk Favorit</h3>
                    <p class="text-gray-500 text-sm">Kumpulan produk yang Anda simpan untuk nanti.</p>
                </div>

                @if($wishlists->isEmpty())
                    <div class="text-center py-20 bg-gray-50 border border-dashed border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h4 class="text-lg font-bold text-gray-400 uppercase tracking-widest">Wishlist Kosong</h4>
                        <p class="text-gray-400 text-sm mb-6">Anda belum menambahkan produk ke wishlist.</p>
                        <a href="{{ route('collection') }}" class="inline-block bg-black text-white px-8 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all">
                            Mulai Belanja
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($wishlists as $wishlist)
                            @php $product = $wishlist->product; @endphp
                            <div class="group relative bg-white border border-gray-100 transition-all hover:shadow-xl">
                                <div class="relative aspect-square overflow-hidden bg-gray-50">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <form action="{{ route('member.wishlist.toggle', $product) }}" method="POST" class="absolute top-3 right-3 z-20">
                                        @csrf
                                        <button type="submit" class="p-2 bg-white text-red-500 shadow-md hover:bg-red-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="p-4">
                                    <h4 class="text-xs text-gray-400 font-bold uppercase mb-1">{{ $product->category }}</h4>
                                    <h3 class="font-bold text-black mb-2 truncate">{{ $product->name }}</h3>
                                    <div class="flex items-center justify-between">
                                        <span class="font-black text-blue-600">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                                        <a href="{{ route('product.detail', $product->slug) }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black">Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-member-layout>
