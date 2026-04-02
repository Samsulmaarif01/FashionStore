<x-layout>
    <!-- Parallax Hero Header -->
    <section class="relative py-48 flex items-center justify-center overflow-hidden bg-black text-white">
        <!-- Image Background -->
        <div class="absolute inset-0 z-0 opacity-60">
            <img 
                src="https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2071&auto=format&fit=crop" 
                alt="Banner Koleksi" 
                class="w-full h-[140%] object-cover object-center -translate-y-10"
                id="collection-banner-img"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl w-full">
            <div class="inline-block relative">
                <h1 class="text-4xl md:text-7xl font-black tracking-tighter uppercase mb-4 gsap-fade-up drop-shadow-lg">
                    {{ request('q') ? 'Hasil Pencarian' : 'Koleksi Kami' }}
                </h1>
                <div class="absolute -bottom-2 left-0 w-full h-1 bg-indigo-600 gsap-fade-up" style="animation-delay: 100ms"></div>
            </div>
            <p class="text-gray-300 text-sm md:text-lg max-w-2xl mx-auto gsap-fade-up font-light tracking-wide mt-6" style="animation-delay: 200ms">
                @if(request('q'))
                    Menampilkan hasil produk dengan kata kunci: "<span class="text-white font-bold italic">{{ request('q') }}</span>"
                @else
                    Jelajahi pilihan terbaik kami yang menggabungkan kenyamanan maksimal dengan gaya modern yang abadi.
                @endif
            </p>
        </div>
    </section>

    <!-- Filters & List -->
    <section class="py-16 bg-white min-h-screen relative -mt-6 rounded-t-[2.5rem] z-20 shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Category Filter -->
            <div class="flex flex-wrap justify-center items-center gap-3 mb-16 gsap-fade-up" style="animation-delay: 300ms">
                <span class="text-xs font-black uppercase tracking-widest text-gray-400 mr-4 hidden md:block">Filter:</span>
                <a href="{{ route('collection') }}" 
                    class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-full transition-all duration-300 border {{ !request('category') || request('category') == 'all' ? 'bg-black text-white border-black shadow-lg shadow-black/20' : 'bg-white text-gray-500 border-gray-200 hover:border-black hover:text-black' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('collection', ['category' => $cat->slug]) }}" 
                        class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-full transition-all duration-300 border {{ request('category') == $cat->slug ? 'bg-black text-white border-black shadow-lg shadow-black/20' : 'bg-white text-gray-500 border-gray-200 hover:border-black hover:text-black' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-14">
                @forelse($products as $index => $product)
                    <div class="gsap-fade-up" style="animation-delay: {{ ($index % 4) * 100 }}ms">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-200 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-400 tracking-tight">Belum ada produk di kategori ini.</h3>
                        <a href="{{ route('collection') }}" class="inline-flex items-center gap-2 mt-8 text-indigo-600 font-bold uppercase tracking-widest text-xs hover:text-black transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            Kembali ke Semua Koleksi
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-20 border-t border-gray-100 pt-10 flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                gsap.to("#collection-banner-img", {
                    scrollTrigger: {
                        trigger: "section",
                        start: "top top",
                        end: "bottom top",
                        scrub: true
                    },
                    y: "15%"
                });
            }
        });
    </script>
</x-layout>
