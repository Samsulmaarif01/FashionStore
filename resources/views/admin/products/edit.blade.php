@php $title = 'Edit Produk' @endphp

<x-admin-layout :title="$title">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.products') }}" class="text-gray-400 hover:text-gray-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-2xl font-black tracking-tighter text-black">Edit Produk</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $product->name }}</p>
        </div>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm p-6 md:p-8 max-w-3xl">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select id="category" name="category" required
                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors">
                        @foreach (['Atasan', 'Bawahan', 'Pakaian Luar', 'Gaun', 'Aksesori', 'Sepatu'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">Stok <span class="text-red-500">*</span></label>
                    <input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors">
                    @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">Badge <span class="text-gray-400 font-normal normal-case">(opsional)</span></label>
                    <input id="badge" type="text" name="badge" value="{{ old('badge', $product->badge) }}"
                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors"
                        placeholder="Baru / Diskon / Terlaris">
                    @error('badge') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Image URL -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">URL Gambar <span class="text-gray-400 font-normal normal-case">(opsional)</span></label>
                    <input id="image" type="url" name="image" value="{{ old('image', $product->image) }}"
                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors">
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Image Preview -->
                @if ($product->image || old('image'))
                    <div class="md:col-span-2" id="image-preview-container">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Preview Gambar</p>
                        <img id="image-preview" src="{{ old('image', $product->image) }}" alt="Preview"
                            class="w-32 h-32 object-cover border border-gray-200 bg-gray-50">
                    </div>
                @else
                    <div class="md:col-span-2" id="image-preview-container" style="display:none">
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-600 mb-1.5">Preview Gambar</p>
                        <img id="image-preview" src="" alt="Preview" class="w-32 h-32 object-cover border border-gray-200 bg-gray-50">
                    </div>
                @endif

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2.5 border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition-colors resize-none">{{ old('description', $product->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Is Active -->
                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="text-sm font-semibold text-gray-700">Produk Aktif (tampil di toko)</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="px-8 py-3 bg-black text-white text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors">
                    Perbarui Produk
                </button>
                <a href="{{ route('admin.products') }}" class="px-6 py-3 border border-gray-200 text-xs font-bold uppercase tracking-wider text-gray-600 hover:border-black hover:text-black transition-colors">
                    Batal
                </a>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="ml-auto"
                    onsubmit="return confirm('Yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 border border-red-200 text-xs font-bold uppercase tracking-wider text-red-600 hover:bg-red-50 hover:border-red-400 transition-colors">
                        Hapus Produk
                    </button>
                </form>
            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('image-preview-container');
        const imagePreview = document.getElementById('image-preview');
        
        imageInput.addEventListener('input', function() {
            const url = this.value.trim();
            if (url) {
                imagePreview.src = url;
                previewContainer.style.display = 'block';
                imagePreview.onerror = function() { previewContainer.style.display = 'none'; };
            } else {
                previewContainer.style.display = 'none';
            }
        });
    </script>
</x-admin-layout>
