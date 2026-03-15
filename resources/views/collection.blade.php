<x-layout>
    <!-- Header -->
    <section class="pt-32 pb-12 bg-white border-b border-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-black tracking-tighter uppercase mb-4 gsap-fade-up">
                    {{ request('q') ? 'Hasil Pencarian' : 'Koleksi Kami' }}
                </h1>
                <p class="text-gray-500 text-sm md:text-base max-w-2xl mx-auto gsap-fade-up" style="animation-delay: 100ms">
                    @if(request('q'))
                        Menampilkan hasil untuk: "<span class="text-black font-bold italic">{{ request('q') }}</span>"
                    @else
                        Jelajahi pilihan terbaik kami yang menggabungkan kenyamanan maksimal dengan gaya modern yang abadi.
                    @endif
                </p>
            </div>
        </div>
    </section>

    <!-- Filters & List -->
    <section class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Category Filter -->
            <div class="flex flex-wrap justify-center gap-4 mb-16 gsap-fade-up" style="animation-delay: 200ms">
                <a href="{{ route('collection') }}" 
                    class="px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all duration-300 {{ !request('category') || request('category') == 'all' ? 'bg-black text-white' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('collection', ['category' => $cat->slug]) }}" 
                        class="px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all duration-300 {{ request('category') == $cat->slug ? 'bg-black text-white' : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                @forelse($products as $index => $product)
                    <div class="gsap-fade-up" style="animation-delay: {{ ($index % 4) * 100 }}ms">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-400">Belum ada produk di kategori ini.</h3>
                        <a href="{{ route('collection') }}" class="inline-block mt-6 text-indigo-600 font-bold uppercase tracking-widest text-xs hover:text-black transition-colors">Lihat Semua Koleksi</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-20">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </section>
</x-layout>
