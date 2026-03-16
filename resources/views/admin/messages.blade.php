@php $title = 'Pesan Masuk' @endphp

<x-admin-layout :title="$title">
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h2 class="text-2xl font-black tracking-tighter text-black">Pesan Masuk</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola pesan dan pertanyaan dari pelanggan.</p>
        </div>
        <div class="hidden md:block">
            <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                {{ $messages->total() }} Total Pesan
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-black text-white text-xs font-black uppercase tracking-widest rounded-xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-100 shadow-sm overflow-hidden rounded-2xl">
        @if ($messages->isEmpty())
            <div class="py-24 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                </div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Belum ada pesan masuk.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-[10px] font-black uppercase tracking-widest text-gray-500">
                            <th class="text-left px-6 py-4">Pengirim</th>
                            <th class="text-left px-6 py-4">Isi Pesan</th>
                            <th class="text-left px-6 py-4">Waktu</th>
                            <th class="text-center px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($messages as $msg)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-6 border-transparent">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white text-[10px] font-black">
                                            {{ strtoupper(substr($msg->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-black text-black uppercase tracking-tight text-xs">{{ $msg->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium">{{ $msg->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="max-w-md">
                                        <p class="text-gray-600 text-xs leading-relaxed italic">"{{ $msg->message }}"</p>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-[10px] font-bold text-gray-400 uppercase">
                                    {{ $msg->created_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors p-2 hover:bg-red-50 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($messages->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $messages->links() }}
                </div>
            @endif
        @endif
    </div>
</x-admin-layout>
