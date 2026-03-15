<x-layout>
    <!-- Header Spanduk / Hero -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden bg-black text-white">
        <div class="absolute inset-0 z-0">
            @if($about->image)
                <img src="{{ $about->image }}" alt="{{ $about->title }}" class="w-full h-full object-cover opacity-60">
            @else
                <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070&auto=format&fit=crop" alt="Default Hero" class="w-full h-full object-cover opacity-60">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/80"></div>
        </div>

        <div class="relative z-10 text-center px-4">
            <h1 class="text-5xl md:text-7xl font-black tracking-tighter uppercase mb-4 gsap-fade-up">
                {{ $about->title }}
            </h1>
            <div class="w-20 h-1 bg-indigo-600 mx-auto gsap-fade-up" style="animation-delay: 200ms"></div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="gsap-fade-up space-y-8">
                <div class="text-lg md:text-xl text-gray-700 leading-relaxed font-light tracking-wide whitespace-pre-line">
                    {{ $about->content }}
                </div>

                <div class="pt-16 grid grid-cols-1 md:grid-cols-3 gap-12 border-t border-gray-100">
                    <div class="text-center">
                        <h4 class="text-4xl font-black text-black mb-2">2024</h4>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Didirikan</p>
                    </div>
                    <div class="text-center">
                        <h4 class="text-4xl font-black text-black mb-2">50+</h4>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Koleksi</p>
                    </div>
                    <div class="text-center">
                        <h4 class="text-4xl font-black text-black mb-2">10k</h4>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pelanggan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-3xl font-black tracking-tighter mb-8 uppercase gsap-fade-up">Siap untuk perubahan gaya?</h3>
            <div class="gsap-fade-up">
                <a href="/#collection" class="inline-block bg-black text-white px-10 py-4 text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all duration-300">
                    Mulai Belanja
                </a>
            </div>
        </div>
    </section>
</x-layout>
