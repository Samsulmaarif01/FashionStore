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

    <!-- Featured Products Grid -->
    @php
        $products = [
            [
                'name' => 'Jaket Velour Midnight',
                'category' => 'Pakaian Luar',
                'price' => 2850000,
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop',
                'badge' => 'Baru'
            ],
            [
                'name' => 'Blus Esensi Sutra',
                'category' => 'Atasan',
                'price' => 1350000,
                'image' => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=1974&auto=format&fit=crop',
            ],
            [
                'name' => 'Mantel Parit Minimalis',
                'category' => 'Pakaian Luar',
                'price' => 3675000,
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop',
            ],
            [
                'name' => 'Rok Motif Abstrak',
                'category' => 'Bawahan',
                'price' => 1650000,
                'image' => 'https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?q=80&w=1935&auto=format&fit=crop',
                'badge' => 'Diskon'
            ]
        ];
    @endphp

    <section id="collection" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-16">
                <div class="gsap-fade-up">
                    <h2 class="text-xs font-bold tracking-[0.3em] text-indigo-600 uppercase mb-3">Pilihan Terkurasi</h2>
                    <h3 class="text-4xl md:text-5xl font-extrabold tracking-tighter text-black">Produk Baru</h3>
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
                    @foreach (array_merge($products, $products) as $product)
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

