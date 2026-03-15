@php
    $navItems = [
        ['label' => 'Belanja', 'url' => '#collection'],
        ['label' => 'Koleksi', 'url' => '#collection'],
        ['label' => 'Tentang', 'url' => '#'],
        ['label' => 'Kontak Kami', 'url' => '#contact'],
    ];
@endphp

<nav
    x-data="{ mobileMenuOpen: false, userMenuOpen: false }"
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
                @foreach ($navItems as $item)
                    <a href="{{ $item['url'] }}" class="relative group text-gray-800 hover:text-black font-medium text-sm tracking-wide">
                        {{ $item['label'] }}
                        <span class="absolute -bottom-1 left-0 w-full h-[2px] bg-black scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center"></span>
                    </a>
                @endforeach
            </div>

            <!-- Icons (Search / Cart / Auth) -->
            <div class="flex items-center space-x-5">
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

                <!-- Auth: Login Icon (guest) / User Icon (logged in) -->
                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button
                            @click="userMenuOpen = !userMenuOpen"
                            @click.outside="userMenuOpen = false"
                            class="flex items-center gap-2 text-gray-800 hover:text-indigo-600 transition-colors focus:outline-none"
                            id="user-menu-btn"
                        >
                            @if (auth()->user()->profile_photo)
                                <img src="{{ Storage::url(auth()->user()->profile_photo) }}" alt="Foto Profil"
                                    class="w-8 h-8 rounded-full object-cover border-2 border-indigo-200 ring-1 ring-indigo-400">
                            @else
                                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold ring-1 ring-indigo-400">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="hidden md:block text-sm font-semibold text-gray-800 max-w-[120px] truncate">
                                {{ auth()->user()->name }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            x-show="userMenuOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-none shadow-2xl border border-gray-100 z-50 overflow-hidden"
                            style="display: none;"
                        >
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Akun Saya</p>
                                <p class="text-sm font-semibold text-gray-900 truncate mt-1">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="py-1">
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                        Panel Admin
                                    </a>
                                @else
                                    <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                        Dashboard Saya
                                    </a>
                                    <a href="{{ route('member.orders') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                        Pesanan Saya
                                    </a>
                                    <a href="{{ route('member.settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        Pengaturan Profil
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Login / Guest Icon -->
                    <a href="{{ route('login') }}" id="login-icon-btn"
                        class="flex items-center gap-2 text-gray-800 hover:text-indigo-600 transition-colors group"
                        title="Masuk ke akun Anda"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span class="hidden md:block text-sm font-semibold uppercase tracking-wider">Masuk</span>
                    </a>
                @endauth

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
                @foreach ($navItems as $item)
                    <a href="{{ $item['url'] }}" @click="mobileMenuOpen = false" class="block text-2xl font-light text-gray-900 border-b border-gray-100 pb-4">{{ $item['label'] }}</a>
                @endforeach

                <div class="pt-4 border-t border-gray-100 space-y-3">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('member.dashboard') }}"
                            class="block text-sm font-semibold text-indigo-600 uppercase tracking-wider">
                            {{ auth()->user()->isAdmin() ? 'Panel Admin' : 'Dashboard Saya' }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-red-500 uppercase tracking-wider">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-sm font-semibold text-black uppercase tracking-wider">Masuk</a>
                        <a href="{{ route('register') }}" class="block text-sm font-semibold text-indigo-600 uppercase tracking-wider">Daftar</a>
                    @endauth
                </div>
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
