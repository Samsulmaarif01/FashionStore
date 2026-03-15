<x-guest-layout>
    @php $title = 'Masuk' @endphp

    <div class="mb-10">
        <h1 class="text-3xl font-black tracking-tighter text-black mb-2">Selamat Datang Kembali</h1>
        <p class="text-gray-500 text-sm font-light">Masuk ke akun Velour Anda untuk melanjutkan berbelanja.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="auth-label">Alamat Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="auth-input"
                placeholder="nama@email.com"
            />
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <label for="password" class="auth-label">Password</label>
            <div class="relative group">
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="auth-input pr-12"
                    placeholder="••••••••"
                />
                <button
                    type="button"
                    class="absolute right-0 top-0 h-full px-4 flex items-center text-gray-400 hover:text-indigo-600 transition-colors focus:outline-none"
                    @click="show = !show"
                >
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.053 0 2.062.18 3 .512M7.943 7.943A5.003 5.003 0 0112 7c2.761 0 5 2.239 5 5 0 .379-.044.747-.125 1.1M15 15l3.5 3.5M3 3l18 18" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password Row -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 border-gray-300 text-indigo-600 rounded focus:ring-indigo-500">
                <span class="text-sm text-gray-600">Ingat Saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link text-xs">Lupa Password?</a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="auth-btn">Masuk Sekarang</button>
        </div>

        <!-- Divider -->
        <div class="relative flex items-center py-2">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink mx-4 text-xs text-gray-400 font-medium uppercase tracking-wider">atau</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
            </p>
        </div>
    </form>
</x-guest-layout>
