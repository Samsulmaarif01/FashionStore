@php $title = 'Kelola Pesanan' @endphp

<x-admin-layout :title="$title">
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-2xl font-black tracking-tighter text-black">Manajemen Pesanan</h2>
        <p class="text-sm text-gray-500 mt-1">{{ $orders->total() }} total pesanan</p>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
        @if ($orders->isEmpty())
            <div class="py-16 text-center">
                <p class="text-gray-400 text-sm">Belum ada pesanan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-black uppercase tracking-wider text-gray-500">
                            <th class="text-left px-5 py-3">No. Pesanan</th>
                            <th class="text-left px-5 py-3">Pelanggan</th>
                            <th class="text-left px-5 py-3">Total</th>
                            <th class="text-left px-5 py-3">Pembayaran</th>
                            <th class="text-left px-5 py-3">Status</th>
                            <th class="text-left px-5 py-3">Ubah Status</th>
                            <th class="text-left px-5 py-3">Tgl Pesan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-4 font-mono text-xs font-bold text-gray-800">{{ $order->order_number }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                                </td>
                                <td class="px-5 py-4 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-gray-600 text-xs">{{ $order->payment_method ?? '—' }}</td>
                                <td class="px-5 py-4">
                                    @php
                                        $colors = ['pending'=>'bg-amber-50 text-amber-700 border-amber-200','processing'=>'bg-blue-50 text-blue-700 border-blue-200','shipped'=>'bg-indigo-50 text-indigo-700 border-indigo-200','delivered'=>'bg-green-50 text-green-700 border-green-200','cancelled'=>'bg-red-50 text-red-700 border-red-200'];
                                        $labelMap = ['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Batal'];
                                    @endphp
                                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border {{ $colors[$order->status] ?? 'bg-gray-50 border-gray-200 text-gray-700' }}">
                                        {{ $labelMap[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="px-2 py-1.5 border border-gray-200 text-xs bg-white focus:outline-none focus:border-indigo-500 transition-colors">
                                            @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s)
                                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                                    {{ $labelMap[$s] ?? ucfirst($s) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="px-2 py-1.5 bg-black text-white text-[10px] font-bold uppercase tracking-wider hover:bg-indigo-600 transition-colors">
                                            OK
                                        </button>
                                    </form>
                                </td>
                                <td class="px-5 py-4 text-gray-500 text-xs">{{ $order->created_at->format('d M Y') }}</td>
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
</x-admin-layout>
