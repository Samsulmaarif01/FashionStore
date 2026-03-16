@php $title = 'Pengaturan Akun' @endphp

<x-member-layout :title="$title">
    <div class="mb-8">
        <h1 class="text-3xl font-black tracking-tighter text-black">Pengaturan Akun</h1>
        <p class="text-gray-500 mt-1 text-sm">Kelola informasi profil, keamanan, dan preferensi akun Anda.</p>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">

        <!-- ── Photo Profile ────────────────────────────────────── -->
        <div class="bg-white border border-gray-100 shadow-sm overflow-hidden rounded-2xl">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-xs font-black uppercase tracking-wider text-gray-700">Foto Profil</h2>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-6">
                    <!-- Current Photo -->
                    @if ($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="Foto Profil"
                            class="w-20 h-20 rounded-full object-cover ring-4 ring-indigo-100 border-2 border-indigo-300">
                    @else
                        <div class="w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center text-white text-2xl font-black ring-4 ring-indigo-100">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-900 mb-1">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500 mb-4">JPG, PNG, GIF atau WebP. Maks. 2MB.</p>

                        <form method="POST" action="{{ route('member.profile.photo') }}" enctype="multipart/form-data" class="flex items-center gap-3">
                            @csrf
                            <label for="profile_photo" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-xs font-bold uppercase tracking-wider text-gray-700 hover:border-indigo-500 hover:text-indigo-600 transition-colors rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                Pilih Foto
                            </label>
                            <input id="profile_photo" type="file" name="profile_photo" class="hidden" accept="image/*" onchange="this.form.submit()">
                            @error('profile_photo') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Informasi Profil ────────────────────────────────── -->
        <div class="bg-white border border-gray-100 shadow-sm overflow-hidden rounded-2xl">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-xs font-black uppercase tracking-wider text-gray-700">Informasi Profil</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('member.profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Nama Lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Alamat Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Nomor Telepon</label>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                placeholder="+62 812-3456-7890"
                                class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="3"
                            placeholder="Jl. Contoh No. 123, Kecamatan, Kota, Kode Pos"
                            class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors resize-none">{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors rounded-xl">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ── Ubah Password ──────────────────────────────────────── -->
        <div class="bg-white border border-gray-100 shadow-sm overflow-hidden rounded-2xl">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-xs font-black uppercase tracking-wider text-gray-700">Keamanan — Ubah Password</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('member.profile.password') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div x-data="{ show: false }">
                            <label for="current_password" class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Password Saat Ini</label>
                            <div class="relative">
                                <input id="current_password" :type="show ? 'text' : 'password'" name="current_password" required
                                    class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors pr-12">
                                <button type="button" @click="show = !show" class="absolute right-0 top-0 h-full px-4 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.053 0 2.062.18 3 .512M7.943 7.943A5.003 5.003 0 0112 7c2.761 0 5 2.239 5 5 0 .379-.044.747-.125 1.1M15 15l3.5 3.5M3 3l18 18"/></svg>
                                </button>
                            </div>
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div x-data="{ show: false }">
                            <label for="new_password" class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Password Baru</label>
                            <div class="relative">
                                <input id="new_password" :type="show ? 'text' : 'password'" name="password" required
                                    class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors pr-12">
                                <button type="button" @click="show = !show" class="absolute right-0 top-0 h-full px-4 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.053 0 2.062.18 3 .512M7.943 7.943A5.003 5.003 0 0112 7c2.761 0 5 2.239 5 5 0 .379-.044.747-.125 1.1M15 15l3.5 3.5M3 3l18 18"/></svg>
                                </button>
                            </div>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div x-data="{ show: false }">
                            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required
                                    class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors pr-12">
                                <button type="button" @click="show = !show" class="absolute right-0 top-0 h-full px-4 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.053 0 2.062.18 3 .512M7.943 7.943A5.003 5.003 0 0112 7c2.761 0 5 2.239 5 5 0 .379-.044.747-.125 1.1M15 15l3.5 3.5M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors rounded-xl">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-member-layout>
