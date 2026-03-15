@php $title = 'Kelola Kategori' @endphp

<x-admin-layout :title="$title">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-sm text-red-700 font-medium flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Category Form -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-100 shadow-sm p-6">
                <h3 class="text-lg font-black tracking-tighter text-black uppercase mb-4">Tambah Kategori</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-2">Nama Kategori</label>
                        <input type="text" name="name" id="name" required
                            class="w-full bg-gray-50 border-gray-100 py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-600/10 focus:border-indigo-600 transition-all text-sm" 
                            placeholder="Contoh: Pakaian Luar">
                        @error('name') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full bg-black text-white py-3 text-xs font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-colors">
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories List -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Slug</th>
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500 text-center">Produk</th>
                            <th class="text-right px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-5 py-4">
                                    <div x-data="{ editing: false, name: '{{ $category->name }}' }">
                                        <div x-show="!editing" class="flex items-center gap-2">
                                            <span class="font-bold text-gray-900">{{ $category->name }}</span>
                                            <button @click="editing = true" class="opacity-0 group-hover:opacity-100 text-indigo-600 hover:underline text-[10px] font-bold uppercase tracking-wider transition-opacity">Edit</button>
                                        </div>
                                        <form x-show="editing" action="{{ route('admin.categories.update', $category) }}" method="POST" @click.outside="editing = false" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="name" x-model="name" class="text-sm border-gray-200 py-1 px-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <button type="submit" class="text-[10px] font-bold uppercase tracking-wider text-green-600 hover:underline">Simpan</button>
                                            <button type="button" @click="editing = false" class="text-[10px] font-bold uppercase tracking-wider text-gray-400 hover:underline">Batal</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-400 font-mono text-xs">{{ $category->slug }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full">
                                        {{ $category->products_count }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    @if($category->products_count == 0)
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-300 cursor-not-allowed" title="Masih ada produk">Terkunci</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-[10px] text-gray-400 mt-4 uppercase tracking-widest font-bold font-mono">Tip: Klik 'Edit' untuk mengubah nama kategori.</p>
        </div>
    </div>
</x-admin-layout>
