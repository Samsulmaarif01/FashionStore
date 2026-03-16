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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left: Aesthetic Visual (Sticky) -->
                <div class="lg:col-span-5 hidden lg:block sticky top-32">
                    <div class="relative">
                        <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
                        
                        <div class="relative overflow-hidden rounded-3xl shadow-2xl border border-gray-100 group">
                            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop" 
                                 class="w-full h-[600px] object-cover transform group-hover:scale-105 transition-transform duration-1000" 
                                 alt="Fashion Editorial">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <div class="absolute bottom-8 left-8 right-8">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-white/80 mb-2">Our Vision</p>
                                <p class="text-xl font-bold text-white leading-tight">Elevating everyday style through conscious design & modern elegance.</p>
                            </div>
                        </div>

                        <!-- Decorative Element -->
                        <div class="absolute -right-6 top-1/2 -translate-y-1/2 flex flex-col gap-4">
                            <div class="w-12 h-[1px] bg-black"></div>
                            <div class="w-12 h-[1px] bg-black opacity-30"></div>
                            <div class="w-12 h-[1px] bg-black opacity-10"></div>
                        </div>
                    </div>
                </div>

                <!-- Right: Description Content -->
                <div class="lg:col-span-7">
                    <div class="gsap-fade-up">
                        <span class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest rounded-full mb-8">Sejarah Kami</span>
                        <h2 class="text-4xl md:text-5xl font-black text-black leading-[1.1] tracking-tighter uppercase mb-12">
                            Menciptakan <span class="text-indigo-600">Simfoni Gaya</span> dalam Setiap Jahitan.
                        </h2>
                    </div>

                    <div class="gsap-fade-up space-y-10">
                        <div class="text-lg md:text-xl text-gray-700 leading-relaxed font-light tracking-wide whitespace-pre-line border-l-4 border-gray-50 pl-8 text-justify">
                            {{ $about->content }}
                        </div>

                        <!-- Highlights / Stats -->
                        <div class="pt-16 grid grid-cols-1 sm:grid-cols-3 gap-10 border-t border-gray-100">
                            <div class="relative pr-6 border-r border-gray-100 last:border-0 group">
                                <h4 class="text-5xl font-black text-black mb-2 group-hover:text-indigo-600 transition-colors duration-300">2024</h4>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Didirikan</p>
                                <div class="absolute top-0 right-0 w-2 h-2 bg-indigo-600 rounded-full scale-0 group-hover:scale-100 transition-transform"></div>
                            </div>
                            <div class="relative pr-6 border-r border-gray-100 last:border-0 group">
                                <h4 class="text-5xl font-black text-black mb-2 group-hover:text-indigo-600 transition-colors duration-300">50+</h4>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Koleksi Utama</p>
                                <div class="absolute top-0 right-0 w-2 h-2 bg-indigo-600 rounded-full scale-0 group-hover:scale-100 transition-transform"></div>
                            </div>
                            <div class="relative group">
                                <h4 class="text-5xl font-black text-black mb-2 group-hover:text-indigo-600 transition-colors duration-300">10k</h4>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Klien Bahagia</p>
                                <div class="absolute top-0 right-0 w-2 h-2 bg-indigo-600 rounded-full scale-0 group-hover:scale-100 transition-transform"></div>
                            </div>
                        </div>
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
