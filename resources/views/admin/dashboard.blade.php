@php $title = 'Dashboard Admin' @endphp

<x-admin-layout :title="$title">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        @php
            $stats = [
                ['label' => 'Total Produk', 'value' => $totalProducts, 'color' => 'indigo', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                ['label' => 'Total Pesanan', 'value' => $totalOrders, 'color' => 'amber', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['label' => 'Total Member', 'value' => $totalMembers, 'color' => 'green', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ];
            $colorMap = ['indigo' => 'bg-indigo-50 text-indigo-600', 'amber' => 'bg-amber-50 text-amber-600', 'green' => 'bg-green-50 text-green-600'];
        @endphp

        @foreach ($stats as $stat)
            <div class="bg-white border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-black uppercase tracking-wider text-gray-500">{{ $stat['label'] }}</p>
                    <div class="w-10 h-10 {{ $colorMap[$stat['color']] }} flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <p class="text-5xl font-black text-black">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.products.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
        <a href="{{ route('admin.orders') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-200 text-gray-700 text-xs font-bold uppercase tracking-widest hover:border-black transition-colors">
            Kelola Pesanan
        </a>
        <a href="{{ route('admin.members') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-200 text-gray-700 text-xs font-bold uppercase tracking-widest hover:border-black transition-colors">
            Kelola Member
        </a>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-xs font-black uppercase tracking-wider text-black">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders') }}" class="text-xs font-semibold text-indigo-600 hover:underline uppercase tracking-wider">Lihat Semua</a>
        </div>

        @if ($recentOrders->isEmpty())
            <div class="py-12 text-center">
                <p class="text-gray-400 text-sm">Belum ada pesanan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-black uppercase tracking-wider text-gray-500">
                            <th class="text-left px-6 py-3">No. Pesanan</th>
                            <th class="text-left px-6 py-3">Pelanggan</th>
                            <th class="text-left px-6 py-3">Total</th>
                            <th class="text-left px-6 py-3">Status</th>
                            <th class="text-left px-6 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-gray-800">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = ['pending'=>'bg-amber-50 text-amber-700 border-amber-200','processing'=>'bg-blue-50 text-blue-700 border-blue-200','shipped'=>'bg-indigo-50 text-indigo-700 border-indigo-200','delivered'=>'bg-green-50 text-green-700 border-green-200','cancelled'=>'bg-red-50 text-red-700 border-red-200'];
                                        $labels = ['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Batal'];
                                    @endphp
                                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border {{ $colors[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                        {{ $labels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-admin-layout>
