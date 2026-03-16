@php $title = 'Kelola Produk' @endphp

<x-admin-layout :title="$title">
    <!-- Flash Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-black tracking-tighter text-black">Daftar Produk</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} produk terdaftar</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors shadow-sm rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-100 shadow-sm overflow-hidden rounded-2xl">
        @if ($products->isEmpty())
            <div class="py-20 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <p class="text-gray-400 text-sm">Belum ada produk. Tambahkan produk pertama!</p>
                <a href="{{ route('admin.products.create') }}" class="inline-block mt-4 px-6 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors rounded-xl">
                    Tambah Produk
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Produk</th>
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Harga</th>
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Stok</th>
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Status</th>
                            <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($product->image)
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                                class="w-10 h-10 object-cover rounded-lg flex-shrink-0 bg-gray-100">
                                        @else
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                            @if ($product->badge)
                                                <span class="inline-block mt-0.5 px-1.5 py-0.5 bg-indigo-50 text-indigo-700 text-[9px] font-bold uppercase tracking-wider rounded-md">{{ $product->badge }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-600 text-xs font-medium">
                                    {{ $product->category_rel->name ?? $product->category }}
                                </td>
                                <td class="px-5 py-4 font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-5 py-4">
                                    <span class="font-bold {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-amber-600' : 'text-red-600') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($product->is_active)
                                        <span class="px-2.5 py-1 bg-green-50 text-green-700 border border-green-200 text-[10px] font-bold uppercase tracking-wider rounded-md">Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-gray-50 text-gray-500 border border-gray-200 text-[10px] font-bold uppercase tracking-wider rounded-md">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="px-3 py-1.5 border border-gray-200 text-xs font-semibold text-gray-700 hover:border-indigo-500 hover:text-indigo-600 transition-colors rounded-lg">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 border border-gray-200 text-xs font-semibold text-red-600 hover:bg-red-50 hover:border-red-300 transition-colors rounded-lg">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>
</x-admin-layout>
