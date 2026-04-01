<x-layout>
    <!-- Header Banner -->
    <section class="relative py-48 flex items-center justify-center overflow-hidden bg-black text-white">
        <div class="absolute inset-0 z-0">
            @if($about->image)
                <img src="{{ $about->image }}" alt="{{ $about->title }}" class="w-full h-full object-cover opacity-50">
            @else
                <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070&auto=format&fit=crop" alt="Default Hero" class="w-full h-full object-cover opacity-50">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl">
            <h1 class="text-4xl md:text-7xl font-black tracking-tighter uppercase mb-6 gsap-fade-up">
                {{ $about->title }}
            </h1>
            <div class="w-24 h-1 bg-indigo-600 mx-auto gsap-fade-up"></div>
        </div>
    </section>

    <!-- Main Content -->
    <!-- Main Content -->
    <section class="py-32 pb-48 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 md:mb-24 gsap-fade-up">
                    <span class="inline-block px-4 py-1.5 bg-gray-50 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-full mb-8">Sejarah Kami</span>
                    <h2 class="text-4xl md:text-5xl lg:text-7xl font-black text-black leading-[1.1] tracking-tighter uppercase">
                        Menciptakan <span class="text-indigo-600">Simfoni Gaya</span><br class="hidden md:block"> dalam Setiap Jahitan.
                    </h2>
                </div>

                <div class="gsap-fade-up max-w-4xl mx-auto mb-32">
                    <div class="text-lg md:text-xl text-gray-700 leading-relaxed font-light tracking-wide text-justify px-4 md:px-0" style="text-align: justify; text-justify: inter-word;">
                        {{ $about->content }}
                    </div>
                </div>

                <!-- Stats Grid - Full Center -->
                <div class="gsap-fade-up pt-24 border-t border-gray-100">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-16 text-center max-w-4xl mx-auto">
                        <div class="group">
                            <h4 class="text-6xl font-black text-black mb-2 transition-colors group-hover:text-indigo-600">2024</h4>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Didirikan</p>
                        </div>
                        <div class="group">
                            <h4 class="text-6xl font-black text-black mb-2 transition-colors group-hover:text-indigo-600">50+</h4>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Koleksi Utama</p>
                        </div>
                        <div class="group">
                            <h4 class="text-6xl font-black text-black mb-2 transition-colors group-hover:text-indigo-600">10k</h4>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Klien Bahagia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-4xl font-black tracking-tighter mb-10 uppercase gsap-fade-up">Siap untuk perubahan gaya?</h3>
            <div class="gsap-fade-up">
                <a href="/#collection" class="inline-block bg-black text-white px-10 py-4 text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all duration-300">
                    Mulai Belanja
                </a>
            </div>
        </div>
    </section>
</x-layout>
