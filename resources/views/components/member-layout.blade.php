{{-- Member Layout --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Member' }} — Velour</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; background: #f8f8f8; color: #0a0a0a; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    <!-- Top Bar -->
    <header class="bg-black text-white px-6 py-4 flex items-center justify-between shadow-md">
        <a href="/" class="text-xl font-black tracking-tighter">V E L O U R</a>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-300 hidden sm:block">Halo, <strong class="text-white">{{ auth()->user()->name }}</strong></span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs text-gray-400 hover:text-white transition-colors uppercase tracking-wider">Keluar</button>
            </form>
        </div>
    </header>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-60 bg-white border-r border-gray-100 hidden md:flex flex-col min-h-full shadow-sm">
            <!-- Profile summary -->
            <div class="p-6 border-b border-gray-100 text-center">
                @if (auth()->user()->profile_photo)
                    <img src="{{ Storage::url(auth()->user()->profile_photo) }}" alt="Foto Profil"
                        class="w-16 h-16 rounded-full object-cover mx-auto mb-3 ring-2 ring-indigo-200">
                @else
                    <div class="w-16 h-16 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-black mx-auto mb-3 ring-2 ring-indigo-200">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 mt-0.5 truncate">{{ auth()->user()->email }}</p>
                <span class="inline-block mt-2 px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-bold uppercase tracking-wider rounded-sm">Member</span>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                @php
                    $navItems = [
                        ['label' => 'Dashboard', 'route' => 'member.dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />'],
                        ['label' => 'Pesanan Saya', 'route' => 'member.orders', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />'],
                        ['label' => 'Ulasan Saya', 'route' => 'member.reviews', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />'],
                        ['label' => 'Pengaturan', 'route' => 'member.settings', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143-.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />'],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    @php $isActive = request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-none transition-all duration-200 group
                            {{ $isActive ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-50 hover:text-black' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $isActive ? 'text-indigo-300' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            {!! $item['icon'] !!}
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="/" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-500 hover:text-black transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Toko
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-10 overflow-auto">
            <!-- Mobile nav -->
            <div class="md:hidden flex gap-2 mb-6 overflow-x-auto pb-2">
                <a href="{{ route('member.dashboard') }}"
                    class="flex-shrink-0 px-4 py-2 text-xs font-bold uppercase tracking-wider border {{ request()->routeIs('member.dashboard') ? 'bg-black text-white border-black' : 'border-gray-200 text-gray-600 hover:border-black' }} transition-colors">
                    Dashboard
                </a>
                <a href="{{ route('member.orders') }}"
                    class="flex-shrink-0 px-4 py-2 text-xs font-bold uppercase tracking-wider border {{ request()->routeIs('member.orders') ? 'bg-black text-white border-black' : 'border-gray-200 text-gray-600 hover:border-black' }} transition-colors">
                    Pesanan
                </a>
                <a href="{{ route('member.reviews') }}"
                    class="flex-shrink-0 px-4 py-2 text-xs font-bold uppercase tracking-wider border {{ request()->routeIs('member.reviews') ? 'bg-black text-white border-black' : 'border-gray-200 text-gray-600 hover:border-black' }} transition-colors">
                    Ulasan
                </a>
                <a href="{{ route('member.settings') }}"
                    class="flex-shrink-0 px-4 py-2 text-xs font-bold uppercase tracking-wider border {{ request()->routeIs('member.settings') ? 'bg-black text-white border-black' : 'border-gray-200 text-gray-600 hover:border-black' }} transition-colors">
                    Pengaturan
                </a>
            </div>

            {{ $slot }}
        </main>
    </div>

</body>
</html>
