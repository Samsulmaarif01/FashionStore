@php $title = 'Kelola Tentang Kami' @endphp

<x-admin-layout :title="$title">
    <!-- Flash Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-4xl">
        <div class="relative mb-8">
            <h2 class="text-3xl font-black tracking-tighter text-black uppercase">Tentang Kami</h2>
            <p class="text-gray-500 text-sm mt-1">Sesuaikan narasi dan identitas merek Anda untuk pelanggan.</p>
        </div>

        <form action="{{ route('admin.about.update') }}" method="POST" class="bg-white border border-gray-100 shadow-sm p-8 space-y-8">
            @csrf
            @method('PATCH')

            <!-- Title -->
            <div class="space-y-2">
                <label for="title" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Judul Halaman</label>
                <input type="text" name="title" id="title" value="{{ old('title', $about->title) }}" 
                    class="w-full bg-gray-50 border-gray-100 py-3 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all font-bold text-lg" 
                    placeholder="Judul Tentant Kami">
                @error('title') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Image URL -->
            <div class="space-y-2">
                <label for="image" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">URL Gambar Utama</label>
                <input type="url" name="image" id="image" value="{{ old('image', $about->image) }}" 
                    class="w-full bg-gray-50 border-gray-100 py-3 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all text-sm font-medium" 
                    placeholder="https://images.unsplash.com/...">
                @if($about->image)
                    <div class="mt-4 border-l-4 border-indigo-600 pl-4">
                        <p class="text-[9px] font-bold uppercase text-gray-400 mb-2">Pratinjau Gambar:</p>
                        <img src="{{ $about->image }}" alt="Pratinjau" class="w-full max-h-48 object-cover object-center grayscale hover:grayscale-0 transition-all duration-500 shadow-lg">
                    </div>
                @endif
                @error('image') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Content -->
            <div class="space-y-2">
                <label for="content" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Konten / Cerita Kami</label>
                <textarea name="content" id="content" rows="12" 
                    class="w-full bg-gray-50 border-gray-100 py-4 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all text-sm leading-relaxed" 
                    placeholder="Tuliskan cerita brand Anda di sini...">{{ old('content', $about->content) }}</textarea>
                @error('content') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" class="bg-black text-white px-10 py-4 text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-colors shadow-xl">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
