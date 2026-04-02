<x-layout>

    <!-- Preloader / Loading Screen (Optional but adds to premium feel) -->
    <div id="preloader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center transition-all duration-700">
        <div class="text-4xl font-bold tracking-tighter text-black animate-pulse">V E L O U R</div>
    </div>

    <!-- Hero Section -->
    <section class="relative h-screen w-full flex items-center justify-center overflow-hidden bg-gray-50">
        <!-- Parallax Image Background -->
        <div class="hero-image-container absolute inset-0 z-0 w-full h-full">
            <img 
                src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop" 
                alt="Fashion Hero" 
                class="hero-img w-full h-[120%] object-cover object-top -translate-y-[10%]"
            />
            <!-- Overlay to make text pop -->
            <div class="absolute inset-0 bg-black/30"></div>
        </div>

        <!-- Typography & CTA -->
        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto flex flex-col items-center">
            <h1 class="hero-text text-5xl md:text-7xl lg:text-8xl font-black tracking-tighter text-white mb-6 leading-tight drop-shadow-lg scale-95 opacity-0 translate-y-10">
                Gerakan Dinamis.<br/>Keanggunan Modern.
            </h1>
            <p class="hero-text text-lg md:text-2xl text-gray-200 mb-10 max-w-2xl font-light tracking-wide drop-shadow-md scale-95 opacity-0 translate-y-10 border-l-2 border-indigo-500 pl-4 py-1">
                Temukan koleksi baru dengan kualitas terbaik dan gaya memukau.
            </p>
            <div class="hero-text opacity-0 translate-y-10">
                <a href="#collection" class="relative group inline-block overflow-hidden rounded-full px-10 py-4 bg-white text-black font-extrabold uppercase tracking-[0.2em] text-sm transition-all duration-300 hover:shadow-[0_0_20px_rgba(255,255,255,0.5)]">
                    <span class="relative z-10 transition-colors duration-300 group-hover:text-white">Beli Koleksi</span>
                    <!-- Fluid background effect on hover -->
                    <div class="absolute inset-0 bg-indigo-600 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500 ease-out z-0"></div>
                </a>
            </div>
        </div>
    </section>




    <section id="collection" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-16">
                <div class="gsap-fade-up">
                    <h2 class="text-xs font-bold tracking-[0.3em] text-indigo-600 uppercase mb-3">Pilihan Terkurasi</h2>
                    <h3 class="text-4xl md:text-5xl font-extrabold tracking-tighter text-black">Produk Unggulan</h3>
                </div>
                <div class="hidden md:block gsap-fade-up">
                    <a href="{{ route('collection') }}" class="text-sm font-semibold text-black uppercase tracking-widest border-b-2 border-transparent hover:border-black transition-colors duration-300 pb-1">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                @foreach($products as $index => $product)
                    <!-- Stagger delay for grid items -->
                    <div class="gsap-fade-up" style="animation-delay: {{ $index * 100 }}ms">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center md:hidden gsap-fade-up">
                <a href="{{ route('collection') }}" class="inline-block px-8 py-3 bg-black text-white text-sm font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors duration-300 rounded-xl">
                    Lihat Semua
                </a>
            </div>
        </div>
    </section>

    <!-- Parallax Separator Banner -->
    <section class="relative py-48 overflow-hidden bg-black text-white">
        <div class="banner-parallax absolute inset-0 opacity-50">
            <img 
                src="https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2071&auto=format&fit=crop" 
                alt="Fashion aesthetic" 
                class="w-full h-[150%] object-cover object-center -translate-y-1/4"
            />
        </div>
        <div class="relative z-10 max-w-3xl mx-auto text-center px-4 gsap-fade-up">
            <h2 class="text-4xl md:text-6xl font-black tracking-tighter mb-6 uppercase">Redefinisi Dasar</h2>
            <p class="text-lg md:text-xl font-light tracking-wider text-gray-300">
                Di mana kenyamanan bertemu dengan fesyen tingkat tinggi. Jelajahi bahan-bahan yang bersumber dari seluruh dunia untuk kualitas tak tertandingi.
            </p>
        </div>
    </section>

    <!-- Carousel Section (Swiper.js) -->
    <section class="py-24 bg-gray-50 overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 gsap-fade-up">
                <h3 class="text-4xl md:text-5xl font-extrabold tracking-tighter text-black">Sedang Tren</h3>
                <div class="w-16 h-1 bg-indigo-600 mx-auto mt-6"></div>
            </div>

            <!-- Swiper Slider -->
            <div class="swiper trending-swiper relative gsap-fade-up">
                <div class="swiper-wrapper">
                    @foreach ($products->concat($products) as $product)
                        <div class="swiper-slide h-auto pb-12">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
                <!-- Pagination & Navigation -->
                <div class="swiper-pagination !bottom-0"></div>
                <!-- Custom Navigation buttons hidden on mobile -->
                <div class="swiper-button-prev !text-black !left-4 !w-11 !h-11 bg-white/90 backdrop-blur-sm rounded-full shadow-sm hidden md:flex after:hidden hover:bg-black/5 hover:scale-110 transition-all duration-500 group border border-black/5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </div>
                <div class="swiper-button-next !text-black !right-4 !w-11 !h-11 bg-white/90 backdrop-blur-sm rounded-full shadow-sm hidden md:flex after:hidden hover:bg-black/5 hover:scale-110 transition-all duration-500 group border border-black/5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </div>
            </div>

            <div class="text-center mt-12 gsap-fade-up">
                <a href="{{ route('collection', ['trending' => 1]) }}" class="inline-block px-10 py-4 bg-black text-white text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-colors duration-300 rounded-xl">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- Kontak Kami Section -->
    <section id="contact" class="py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">

            <!-- Section Header -->
            <div class="text-center mb-16 gsap-fade-up">
                <span class="inline-block text-[10px] font-black tracking-[0.5em] text-indigo-600 uppercase mb-4">Terhubung Bersama Kami</span>
                <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-black leading-none uppercase">Kontak Kami</h2>
                <div class="flex justify-center mt-6">
                    <div class="w-16 h-1 bg-black rounded-full"></div>
                    <div class="w-4 h-1 bg-indigo-600 rounded-full ml-1"></div>
                </div>
            </div>

            <!-- 2-Column Card -->
            <div class="gsap-fade-up group grid grid-cols-1 md:grid-cols-2 rounded-3xl overflow-hidden shadow-[0_30px_80px_rgba(0,0,0,0.1)] border border-gray-100 transition-all duration-700 hover:shadow-[0_50px_120px_rgba(0,0,0,0.14)]">

                <!-- ===== LEFT: Info Panel ===== -->
                <div class="bg-black text-white p-12 xl:p-16 flex flex-col justify-between relative overflow-hidden">
                    <!-- Decorative blobs -->
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-indigo-600/25 rounded-full blur-3xl pointer-events-none group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="absolute -bottom-10 -left-10 w-36 h-36 bg-indigo-900/30 rounded-full blur-2xl pointer-events-none"></div>

                    <!-- Top: Icon + Heading -->
                    <div class="relative z-10">
                        <div class="inline-flex w-12 h-12 rounded-2xl bg-indigo-600 items-center justify-center mb-8 shadow-xl shadow-indigo-900/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="text-3xl xl:text-4xl font-black tracking-tight leading-tight mb-5 uppercase">
                            Ada yang bisa<br>kami <span class="text-indigo-400">bantu?</span>
                        </h3>
                        <p class="text-gray-400 text-sm font-light leading-relaxed max-w-xs">
                            Tim kami siap melayani pertanyaan seputar produk, pesanan, dan gaya hidup fashion Anda setiap hari.
                        </p>
                    </div>

                    <!-- Bottom: Contact Details -->
                    <div class="relative z-10 mt-16 space-y-7">
                        <!-- Location -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/5 flex items-center justify-center shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.35em] mb-1">Lokasi</p>
                                <p class="text-sm font-semibold text-white/90">Jl. Mode No. 123, Jakarta Selatan</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/5 flex items-center justify-center shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.35em] mb-1">Email</p>
                                <p class="text-sm font-semibold text-white/90">hello@velour.com</p>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/5 flex items-center justify-center shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.35em] mb-1">Jam Operasional</p>
                                <p class="text-sm font-semibold text-white/90">Senin – Sabtu, 09.00 – 21.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== RIGHT: Form Panel ===== -->
                <div class="bg-white p-12 xl:p-16 flex flex-col justify-center">
                    @if(session('success'))
                        <div class="mb-8 p-5 bg-indigo-600 text-white rounded-2xl flex items-center gap-4 shadow-lg shadow-indigo-200">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-8">
                        <h4 class="text-2xl font-black text-black tracking-tight">Kirim Pesan</h4>
                        <p class="text-sm text-gray-400 font-light mt-2 leading-relaxed">Isi formulir di bawah dan kami akan menghubungi Anda dalam waktu 1x24 jam.</p>
                    </div>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        {{ csrf_field() }}

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="flex flex-col gap-2">
                                <label class="text-[9px] font-black uppercase tracking-[0.4em] text-gray-500">Nama Lengkap</label>
                                <input
                                    type="text" name="name" required
                                    placeholder="Masukkan nama Anda..."
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3.5 px-5 text-sm font-medium text-gray-800 placeholder-gray-300 outline-none focus:border-black focus:bg-white focus:ring-4 focus:ring-black/5 transition-all duration-300"
                                >
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[9px] font-black uppercase tracking-[0.4em] text-gray-500">Alamat Email</label>
                                <input
                                    type="email" name="email" required
                                    placeholder="email@velour.com"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3.5 px-5 text-sm font-medium text-gray-800 placeholder-gray-300 outline-none focus:border-black focus:bg-white focus:ring-4 focus:ring-black/5 transition-all duration-300"
                                >
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-black uppercase tracking-[0.4em] text-gray-500">Pesan Anda</label>
                            <textarea
                                name="message" required rows="6"
                                placeholder="Ceritakan apa yang membutuhkan bantuan kami..."
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3.5 px-5 text-sm font-medium text-gray-800 placeholder-gray-300 outline-none focus:border-black focus:bg-white focus:ring-4 focus:ring-black/5 transition-all duration-300 resize-none"
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="group relative w-full overflow-hidden rounded-xl py-4 bg-black text-white text-xs font-black uppercase tracking-[0.4em] transition-all duration-500 hover:-translate-y-0.5 hover:shadow-[0_15px_40px_rgba(0,0,0,0.25)]"
                        >
                            <span class="relative z-10">Kirim Pesan Sekarang</span>
                            <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out z-0"></div>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>


    <!-- Alpine.js & custom JS specifically for this page features can be in app.js or here -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // Preloader fade out
            setTimeout(() => {
                const preloader = document.getElementById('preloader');
                if(preloader) {
                    preloader.style.opacity = '0';
                    setTimeout(() => preloader.style.display = 'none', 700);
                }

                // Hero Animations (Staggered fade-in up)
                const tl = gsap.timeline();
                tl.to(".hero-text", {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 1,
                    ease: "power3.out",
                    stagger: 0.2
                });
                
                // Hero Image Ken Burns / Zoom Effect
                gsap.to(".hero-img", {
                    scale: 1.05,
                    duration: 15,
                    ease: "linear",
                    repeat: -1,
                    yoyo: true
                });

            }, 500); // Slight delay for preloader

            // Parallax scroll on hero image
            gsap.to(".hero-img", {
                scrollTrigger: {
                    trigger: ".hero-image-container",
                    start: "top top",
                    end: "bottom top",
                    scrub: true
                },
                y: "20%" // Moves image down as you scroll
            });

            // Parallax scroll on banner separator
            gsap.to(".banner-parallax img", {
                scrollTrigger: {
                    trigger: ".banner-parallax",
                    start: "top bottom",
                    end: "bottom top",
                    scrub: 1 // smooth scrubbing
                },
                y: "10%"
            });

            // Swiper Initialization
            const swiper = new Swiper('.trending-swiper', {
                slidesPerView: 1.2, // peek into next slide on mobile
                spaceBetween: 20,
                centeredSlides: false,
                loop: true,
                speed: 800,
                // Autoplay for dynamic feel
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2, spaceBetween: 24 },
                    1024: { slidesPerView: 3, spaceBetween: 32 },
                    1280: { slidesPerView: 4, spaceBetween: 32 },
                }
            });
            
            // Interaction to pause swiper on hover
            const swiperEl = document.querySelector('.trending-swiper');
            if(swiperEl) {
                swiperEl.addEventListener('mouseenter', () => swiper.autoplay.stop());
                swiperEl.addEventListener('mouseleave', () => swiper.autoplay.start());
            }
        });
    </script>

</x-layout>

