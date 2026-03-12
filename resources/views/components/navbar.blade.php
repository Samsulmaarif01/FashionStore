<nav
    x-data="{ mobileMenuOpen: false }"
    class="fixed top-0 left-0 right-0 z-50 bg-white/70 backdrop-blur-md border-b border-gray-100"
    id="navbar"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="text-2xl font-bold tracking-tighter text-black">
                    V E L O U R
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                @foreach (['Belanja', 'Koleksi', 'Tentang', 'Jurnal'] as $item)
                    <a href="#" class="relative group text-gray-800 hover:text-black font-medium text-sm tracking-wide">
                        {{ $item }}
                        <span class="absolute -bottom-1 left-0 w-full h-[2px] bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center"></span>
                    </a>
                @endforeach
            </div>

            <!-- Icons (Cart/Search) -->
            <div class="flex items-center space-x-6">
                <!-- Search Icon -->
                <button class="text-gray-800 hover:text-indigo-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
                
                <!-- Cart Icon -->
                <button class="relative text-gray-800 hover:text-indigo-600 transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:animate-wiggle" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center">2</span>
                </button>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-800 hover:text-black focus:outline-none z-50 relative">
                        <!-- Hamburger Icon -->
                        <svg x-show="!mobileMenuOpen" class="h-6 w-6 transform transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Close Icon (X) -->
                        <svg x-show="mobileMenuOpen" style="display: none;" class="h-6 w-6 transform rotate-90 transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Slide-in -->
    <div 
        x-show="mobileMenuOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm md:hidden"
        style="display:none;"
        @click="mobileMenuOpen = false"
    >
        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 w-64 bg-white shadow-2xl flex flex-col pt-24 pb-6"
            @click.stop
        >
            <div class="flex-1 px-6 space-y-6 overflow-y-auto">
                @foreach (['Belanja', 'Koleksi', 'Tentang', 'Jurnal'] as $item)
                    <a href="#" class="block text-2xl font-light text-gray-900 border-b border-gray-100 pb-4">{{ $item }}</a>
                @endforeach
            </div>
        </div>
    </div>
</nav>

<!-- Push content below sticky navbar -->
<div class="h-20"></div>

<style>
@keyframes wiggle {
    0%, 100% { transform: rotate(-3deg); }
    50% { transform: rotate(3deg); }
}
.animate-wiggle {
    animation: wiggle 0.3s ease-in-out infinite;
}
</style>
