@php $title = 'Kelola Pesanan' @endphp

<x-admin-layout :title="$title">
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-2xl font-black tracking-tighter text-black">Manajemen Pesanan</h2>
        <p class="text-sm text-gray-500 mt-1">{{ $orders->total() }} total pesanan</p>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm overflow-hidden rounded-2xl">
        @if ($orders->isEmpty())
            <div class="py-16 text-center">
                <p class="text-gray-400 text-sm">Belum ada pesanan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                            <tr>
                                <th class="text-left px-5 py-3">No. Pesanan</th>
                                <th class="text-left px-5 py-3">Pelanggan</th>
                                <th class="text-left px-5 py-3">Total</th>
                                <th class="text-left px-5 py-3">Status</th>
                                <th class="text-left px-5 py-3">Tgl Pesan</th>
                                <th class="text-right px-5 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-4 font-mono text-xs font-bold text-gray-800">{{ $order->order_number }}</td>
                                    <td class="px-5 py-4">
                                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                        <p class="text-[11px] text-gray-400">{{ $order->user->email }}</p>
                                    </td>
                                    <td class="px-5 py-4 font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4">
                                        @php
                                            $colors = ['pending'=>'bg-amber-50 text-amber-700 border-amber-200','processing'=>'bg-blue-50 text-blue-700 border-blue-200','shipped'=>'bg-indigo-50 text-indigo-700 border-indigo-200','completed'=>'bg-green-50 text-green-700 border-green-200','cancelled'=>'bg-red-50 text-red-700 border-red-200'];
                                            $labelMap = ['pending'=>'Menunggu Konfirmasi','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Batal'];
                                        @endphp
                                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border rounded-md {{ $colors[$order->status] ?? 'bg-gray-50 border-gray-200 text-gray-700' }}">
                                            {{ $labelMap[$order->status] ?? $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-gray-500 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-5 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($order->status === 'pending')
                                                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="px-3 py-1.5 bg-black text-white text-[11px] font-medium hover:bg-gray-800 transition-colors rounded-md">Proses Pesanan</button>
                                                </form>
                                                
                                                <button type="button" onclick="cancelOrder('{{ $order->id }}')" class="px-3 py-1.5 bg-white border border-gray-200 text-red-600 text-[11px] font-medium hover:bg-red-50 transition-colors rounded-md">Batalkan</button>
                                                <form id="cancel-form-{{ $order->id }}" method="POST" action="{{ route('admin.orders.status', $order) }}" class="hidden">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <input type="hidden" name="cancel_reason" id="reason-{{ $order->id }}">
                                                </form>
                                            @elseif($order->status === 'processing')
                                                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="shipped">
                                                    <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white text-[11px] font-medium hover:bg-indigo-700 transition-colors rounded-md">Tandai Dikirim</button>
                                                </form>
                                            @endif
                                            
                                            <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="p-1.5 text-indigo-600 hover:text-indigo-800 transition-colors" title="Cetak Invoice">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                            </a>
                                            
                                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Anda yakin ingin menghapus riwayat pesanan ini secara permanen?');" class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors" title="Hapus Permanen">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif
        </div>

        <script>
            function cancelOrder(id) {
                const reason = prompt('Masukkan alasan pembatalan:');
                if (reason !== null && reason.trim() !== '') {
                    document.getElementById('reason-' + id).value = reason;
                    document.getElementById('cancel-form-' + id).submit();
                } else if (reason !== null) {
                    alert('Alasan pembatalan harus diisi.');
                }
            }
        </script>
    </x-admin-layout>
