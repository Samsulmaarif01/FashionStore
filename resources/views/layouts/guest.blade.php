<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Velour') }} — {{ $title ?? 'Autentikasi' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .auth-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e5e7eb;
            background: #fafafa;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color 0.3s, background 0.3s;
            outline: none;
        }
        .auth-input:focus {
            border-color: #4f46e5;
            background: #fff;
        }
        .auth-btn {
            width: 100%;
            padding: 0.85rem 1rem;
            background: #000;
            color: #fff;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            border: none;
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .auth-btn:hover { background: #4f46e5; box-shadow: 0 8px 25px rgba(79,70,229,0.35); }
        .auth-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #374151;
            margin-bottom: 0.4rem;
        }
        .auth-error { color: #ef4444; font-size: 0.78rem; margin-top: 0.3rem; }
        .auth-link { color: #4f46e5; font-weight: 600; text-decoration: none; font-size: 0.875rem; }
        .auth-link:hover { text-decoration: underline; }
    </style>
</head>
<body class="antialiased bg-gray-50 min-h-screen flex">

    <!-- Left Panel — Decorative -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-black flex-col justify-between p-12">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop"
                alt="Fashion"
                class="w-full h-full object-cover object-top opacity-60"
            />
        </div>
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-black/40 to-indigo-900/60"></div>

        <!-- Logo -->
        <div class="relative z-10">
            <a href="/" class="text-3xl font-black tracking-tighter text-white">V E L O U R</a>
        </div>

        <!-- Quote -->
        <div class="relative z-10">
            <div class="w-12 h-1 bg-indigo-500 mb-6"></div>
            <h2 class="text-4xl font-black tracking-tighter text-white leading-tight mb-4">
                Gerakan Dinamis.<br/>Keanggunan Modern.
            </h2>
            <p class="text-gray-300 text-lg font-light leading-relaxed">
                Bergabunglah dengan ribuan pembeli yang menikmati koleksi fashion premium kami.
            </p>
        </div>

        <!-- Bottom dots -->
        <div class="relative z-10 flex space-x-2">
            <span class="w-8 h-1 bg-white rounded-full opacity-80"></span>
            <span class="w-4 h-1 bg-white rounded-full opacity-40"></span>
            <span class="w-4 h-1 bg-white rounded-full opacity-40"></span>
        </div>
    </div>

    <!-- Right Panel — Form -->
    <div class="flex-1 flex items-center justify-center px-6 py-12 lg:px-16 bg-white">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="lg:hidden mb-10 text-center">
                <a href="/" class="text-2xl font-black tracking-tighter text-black">V E L O U R</a>
            </div>

            {{ $slot }}
        </div>
    </div>

</body>
</html>
