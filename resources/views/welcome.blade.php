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
                <a href="#collection" class="relative group inline-block overflow-hidden rounded-none px-10 py-4 bg-white text-black font-extrabold uppercase tracking-[0.2em] text-sm transition-all duration-300 hover:shadow-[0_0_20px_rgba(255,255,255,0.5)]">
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
                    <a href="#" class="text-sm font-semibold text-black uppercase tracking-widest border-b-2 border-transparent hover:border-black transition-colors duration-300 pb-1">
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
                <a href="#" class="inline-block px-8 py-3 bg-black text-white text-sm font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors duration-300">
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
                <div class="swiper-button-prev !text-black !left-0 !w-12 !h-12 bg-white rounded-full shadow-lg hidden md:flex after:!text-xl"></div>
                <div class="swiper-button-next !text-black !right-0 !w-12 !h-12 bg-white rounded-full shadow-lg hidden md:flex after:!text-xl"></div>
            </div>

            <div class="text-center mt-12 gsap-fade-up">
                <a href="{{ route('collection') }}" class="inline-block px-10 py-4 bg-black text-white text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-colors duration-300">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- Section Kontak Kami -->
    <section id="contact" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="gsap-fade-up">
                    <h2 class="text-xs font-bold tracking-[0.3em] text-indigo-600 uppercase mb-3">Terhubung</h2>
                    <h3 class="text-4xl md:text-5xl font-extrabold tracking-tighter text-black mb-6">Kontak Kami</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed max-w-md">
                        Apakah Anda memiliki pertanyaan tentang koleksi kami atau membutuhkan bantuan dengan pesanan? Tim kami siap membantu Anda dengan layanan personal.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gray-50 flex items-center justify-center rounded-none border border-gray-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-black uppercase tracking-wider text-sm">Butik Utama</h4>
                                <p class="text-gray-500 text-sm">Jl. Mode No. 123, Jakarta Selatan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gray-50 flex items-center justify-center rounded-none border border-gray-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-black uppercase tracking-wider text-sm">Email</h4>
                                <p class="text-gray-500 text-sm">hello@velour.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gsap-fade-up bg-gray-50 p-8 md:p-12 border border-gray-100 relative overflow-hidden">
                    <!-- Subtle decorative element -->
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-indigo-50 rounded-full opacity-50"></div>
                    
                    <form action="#" class="relative z-10 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-2">Nama</label>
                                <input type="text" class="w-full bg-white border-b border-gray-200 py-3 px-0 focus:outline-none focus:border-indigo-600 transition-colors text-sm" placeholder="Nama Anda">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-2">Email</label>
                                <input type="email" class="w-full bg-white border-b border-gray-200 py-3 px-0 focus:outline-none focus:border-indigo-600 transition-colors text-sm" placeholder="email@contoh.com">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-2">Pesan</label>
                            <textarea rows="4" class="w-full bg-white border-b border-gray-200 py-3 px-0 focus:outline-none focus:border-indigo-600 transition-colors text-sm resize-none" placeholder="Bagaimana kami bisa membantu?"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-black text-white font-bold py-4 uppercase tracking-[0.3em] text-xs hover:bg-indigo-600 transition-colors duration-300">
                            Kirim Pesan
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

