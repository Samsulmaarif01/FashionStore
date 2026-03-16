@php $title = 'Dashboard' @endphp

<x-member-layout :title="$title">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-black tracking-tighter text-black">Dashboard</h1>
        <p class="text-gray-500 mt-1 text-sm">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">
        @php
            $totalOrders     = auth()->user()->orders()->count();
            $activeOrders    = auth()->user()->orders()->whereIn('status', ['pending','processing','shipped'])->count();
            $completedOrders = auth()->user()->orders()->where('status', 'delivered')->count();
        @endphp

        <div class="bg-white border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow rounded-2xl">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Total Pesanan</p>
                <div class="w-10 h-10 bg-indigo-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-black">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow rounded-2xl">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Sedang Diproses</p>
                <div class="w-10 h-10 bg-amber-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-black">{{ $activeOrders }}</p>
        </div>

        <div class="bg-white border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow rounded-2xl">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Selesai</p>
                <div class="w-10 h-10 bg-green-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-black">{{ $completedOrders }}</p>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-black uppercase tracking-wider text-black">Pesanan Terbaru</h2>
            <a href="{{ route('member.orders') }}" class="text-xs font-semibold text-indigo-600 hover:underline uppercase tracking-wider">Lihat Semua</a>
        </div>

        @if ($orders->isEmpty())
            <div class="py-16 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-400 text-sm font-medium">Belum ada pesanan</p>
                <a href="/" class="inline-block mt-4 px-6 py-2 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors rounded-xl">Belanja Sekarang</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">No. Pesanan</th>
                            <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Tanggal</th>
                            <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Total</th>
                            <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs text-gray-700 font-bold">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'pending'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'shipped'    => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            'delivered'  => 'bg-green-50 text-green-700 border-green-200',
                                            'cancelled'  => 'bg-red-50 text-red-700 border-red-200',
                                        ];
                                        $colorClass = $colors[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border {{ $colorClass }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Quick Links -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('member.settings') }}" class="group flex items-center gap-4 bg-white border border-gray-100 p-5 shadow-sm hover:border-indigo-200 hover:shadow-md transition-all rounded-2xl">
            <div class="w-10 h-10 bg-gray-50 group-hover:bg-indigo-50 flex items-center justify-center transition-colors rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Edit Profil</p>
                <p class="text-xs text-gray-500 mt-0.5">Perbarui foto, nama, dan informasi Anda</p>
            </div>
        </a>

        <a href="/" class="group flex items-center gap-4 bg-white border border-gray-100 p-5 shadow-sm hover:border-indigo-200 hover:shadow-md transition-all rounded-2xl">
            <div class="w-10 h-10 bg-gray-50 group-hover:bg-indigo-50 flex items-center justify-center transition-colors rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Lanjut Belanja</p>
                <p class="text-xs text-gray-500 mt-0.5">Jelajahi koleksi terbaru kami</p>
            </div>
        </a>
    </div>
</x-member-layout>
