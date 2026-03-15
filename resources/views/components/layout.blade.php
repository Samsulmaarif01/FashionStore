<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!-- Viewport for Mobile First -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Velour | Gerakan Dinamis & Keanggunan Modern</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Tailwind/Vite (will handle CSS injection) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Base Styling & Typography adjustments */
        body { margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; background-color: #ffffff; color: #0a0a0a; overflow-x: hidden; }
        
        /* Swiper Fixes */
        .swiper-button-next, .swiper-button-prev { color: #000; }
        .swiper-pagination-bullet-active { background-color: #000; }

        /* Smooth Scrolling */
        html { scroll-behavior: smooth; }
        
        /* Hide scrollbar for clean aesthetic */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</head>
<body class="antialiased font-sans flex flex-col min-h-screen relative selection:bg-indigo-200 selection:text-indigo-900">
    
    <x-navbar />

    <!-- Flash Notifications -->
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" 
        class="fixed top-24 right-6 z-[100] transition-all duration-500 ease-in-out">
        @if(session('success'))
            <div class="bg-black text-white px-6 py-4 flex items-center gap-4 shadow-2xl border-l-4 border-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-600 text-white px-6 py-4 flex items-center gap-4 shadow-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-xs font-black uppercase tracking-widest">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer Component -->
    <x-footer />

    <!-- JS Libraries (Loaded before Alpine to ensure immediate availability) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Global Animation Scripts & Overrides -->
    <script>
        // Register ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        document.addEventListener('DOMContentLoaded', () => {
            // Navbar load animation
            gsap.from("#navbar", {
                y: -100,
                opacity: 0,
                duration: 1,
                ease: "power3.out",
                delay: 0.2
            });

            // Global scroll fade-up handler
            const fadeUpElements = document.querySelectorAll('.gsap-fade-up');
            fadeUpElements.forEach(el => {
                gsap.from(el, {
                    scrollTrigger: {
                        trigger: el,
                        start: "top 85%", // Trigger when element is 85% from top of viewport
                        toggleActions: "play none none reverse"
                    },
                    y: 50,
                    opacity: 0,
                    duration: 0.8,
                    ease: "power2.out"
                });
            });

            // Footer pattern animation is pure CSS
        });
    </script>
</body>
</html>
