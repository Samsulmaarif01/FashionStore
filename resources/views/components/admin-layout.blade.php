{{-- Admin Layout --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ $title ?? 'Panel' }} | Velour</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; background: #0a0a0a; color: #0a0a0a; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1a1a1a; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Sidebar (Dark) -->
    <aside class="w-64 bg-[#0a0a0a] border-r border-white/10 hidden md:flex flex-col min-h-screen fixed left-0 top-0 bottom-0 z-30">
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-white/10">
            <a href="/" class="text-xl font-black tracking-tighter text-white">V E L O U R</a>
            <div class="mt-1">
                <span class="px-2 py-0.5 bg-indigo-600 text-white text-[9px] font-bold uppercase tracking-widest">Admin Panel</span>
            </div>
        </div>

        <!-- Admin Info -->
        <div class="px-6 py-4 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-black">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-white truncate max-w-[150px]">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-gray-400">Administrator</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            @php
                $navItems = [
                    ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                    ['label' => 'Analytics', 'route' => 'admin.analytics', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['label' => 'Kategori', 'route' => 'admin.categories', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                    ['label' => 'Produk', 'route' => 'admin.products', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ['label' => 'Pesanan', 'route' => 'admin.orders', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['label' => 'Member', 'route' => 'admin.members', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label' => 'Tentang Kami', 'route' => 'admin.about.edit', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            @endphp

            @foreach ($navItems as $item)
                @php $isActive = request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*'); @endphp
                <a href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium transition-all duration-200 group rounded-sm
                        {{ $isActive ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 {{ $isActive ? 'text-indigo-200' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="pt-4 mt-6 border-t border-white/10 space-y-1">
                <a href="/" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-500 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Lihat Toko
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-900/20 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 md:ml-64 bg-gray-50 min-h-screen">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div class="flex items-center gap-3">
                <!-- Mobile sidebar toggle -->
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-600 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-lg font-black tracking-tight text-black">{{ $title ?? 'Dashboard' }}</h1>
                    <p class="text-xs text-gray-500">Panel Administrator Velour</p>
                </div>
            </div>
            <div class="text-xs text-gray-400">{{ now()->format('d F Y') }}</div>
        </header>

        <!-- Content -->
        <main class="p-6 md:p-8">
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/60 z-20 md:hidden" style="display:none;"></div>
    <div x-show="sidebarOpen" class="fixed inset-y-0 left-0 w-64 bg-[#0a0a0a] z-30 md:hidden border-r border-white/10 p-4" style="display:none;">
        <div class="flex justify-between items-center mb-6">
            <span class="text-white font-black tracking-tighter">V E L O U R</span>
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @foreach ($navItems ?? [] as $item)
            <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-300 hover:text-white border-b border-white/10">{{ $item['label'] }}</a>
        @endforeach
    </div>

</body>
</html>
