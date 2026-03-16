@php $title = 'Pesanan Saya' @endphp

<x-member-layout :title="$title">
    <div class="mb-8">
        <h1 class="text-3xl font-black tracking-tighter text-black">Riwayat Pesanan</h1>
        <p class="text-gray-500 mt-1 text-sm">Semua pesanan yang pernah Anda buat.</p>
    </div>

    <!-- Flash Success -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        @if ($orders->isEmpty())
            <div class="py-20 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-400 font-medium text-sm">Belum ada pesanan</p>
                <p class="text-gray-400 text-xs mt-1">Mulai belanja dan pesanan Anda akan muncul di sini.</p>
                <a href="/" class="inline-block mt-6 px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors rounded-xl">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500">No. Pesanan</th>
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500 hidden md:table-cell">Tanggal</th>
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500">Total</th>
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500">Status</th>
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500 hidden lg:table-cell">Alamat Pengiriman</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-mono text-xs font-black text-gray-800">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-400 mt-1 md:hidden">{{ $order->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-4 text-gray-600 hidden md:table-cell">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900 text-sm">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'pending'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'shipped'    => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            'delivered'  => 'bg-green-50 text-green-700 border-green-200',
                                            'cancelled'  => 'bg-red-50 text-red-700 border-red-200',
                                        ];
                                        $labels = [
                                            'pending'    => 'Menunggu Bayar',
                                            'processing' => 'Diproses',
                                            'shipped'    => 'Dikirim',
                                            'delivered'  => 'Terkirim',
                                            'cancelled'  => 'Dibatalkan',
                                        ];
                                        $colorClass = $colors[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                        $label = $labels[$order->status] ?? ucfirst($order->status);
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border rounded-md {{ $colorClass }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs hidden lg:table-cell max-w-[200px]">
                                    {{ $order->shipping_address ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
</x-member-layout>
