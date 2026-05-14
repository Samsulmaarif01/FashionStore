@php $title = 'Laporan Penjualan & Analytics' @endphp

<x-admin-layout :title="$title">
    <style>
        .btn-export-csv { background-color: #16a34a !important; transition: all 0.2s; }
        .btn-export-csv:hover { background-color: #15803d !important; transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        .btn-export-pdf:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    </style>

    <!-- Date Filter -->
    <div class="bg-white border border-gray-100 p-5 shadow-sm rounded-2xl mb-8">
        <div class="flex flex-wrap items-end gap-4">
            <!-- Quick Filters -->
            <div class="flex flex-wrap gap-2">
                @php
                    $filters = [
                        'today' => 'Hari Ini',
                        'week' => 'Minggu Ini',
                        'month' => 'Bulan Ini',
                        'year' => 'Tahun Ini',
                        'all' => 'Semua'
                    ];
                @endphp
                @foreach($filters as $key => $label)
                    <a href="{{ route('admin.analytics', ['filter' => $key]) }}"
                        class="px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-xl transition-all hover:-translate-y-0.5
                        {{ ($filter ?? 'month') === $key ? 'bg-black text-white' : 'border border-gray-200 text-gray-700 hover:border-black' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
            
            <!-- Custom Date Range -->
            <form method="GET" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-gray-500 mb-2">Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-gray-500 mb-2">Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
                <button type="submit"
                    class="px-4 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all hover:-translate-y-0.5 rounded-xl">
                    Filter
                </button>
            </form>
            <div class="flex items-center gap-3 ms-auto">
                <a href="{{ route('admin.analytics.export.csv', ['start_date' => $startDate ?? '', 'end_date' => $endDate ?? '']) }}"
                    class="btn-export-csv px-4 py-2.5 text-white text-xs font-bold uppercase tracking-widest rounded-xl inline-flex items-center gap-2 shadow-sm active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l4 4m-4-4V4"/>
                    </svg>
                    CSV
                </a>
                <a href="{{ route('admin.analytics.export.pdf', ['start_date' => $startDate ?? '', 'end_date' => $endDate ?? '']) }}"
                    class="btn-export-pdf px-4 py-2.5 bg-red-600 text-white text-xs font-bold uppercase tracking-widest hover:bg-red-700 transition-all rounded-xl inline-flex items-center gap-2 shadow-sm active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 0 0 2-2V9.414a1 1 0 0 0-.293-.707l-5.414-5.414A1 1 0 0 0 12.586 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z"/>
                    </svg>
                    PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @php
            $summaryCards = [
                ['label' => 'Total Penjualan', 'value' => 'Rp ' . number_format($totalSales, 0, ',', '.'), 'color' => 'green', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Total Pesanan', 'value' => $totalOrders, 'color' => 'blue', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['label' => 'Rata-rata per Order', 'value' => 'Rp ' . number_format($avgOrderValue, 0, ',', '.'), 'color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Pesanan Dibatalkan', 'value' => $cancelledOrders, 'color' => 'red', 'icon' => 'M6 18L18 6M6 6l12 12'],
            ];
            $colorMap = [
                'green' => 'bg-green-50 text-green-600',
                'blue' => 'bg-blue-50 text-blue-600',
                'amber' => 'bg-amber-50 text-amber-600',
                'red' => 'bg-red-50 text-red-600'
            ];
        @endphp

        @foreach ($summaryCards as $card)
            <div class="bg-white border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow rounded-2xl">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-wider text-gray-500 mb-2">{{ $card['label'] }}</p>
                        <p class="text-2xl font-black text-black whitespace-nowrap">{{ $card['value'] }}</p>
                    </div>
                    <div class="w-12 h-12 {{ $colorMap[$card['color']] }} flex items-center justify-center rounded-xl shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Daily Sales Chart -->
        <div class="bg-white border border-gray-100 p-6 shadow-sm rounded-2xl">
            <h3 class="text-xs font-black uppercase tracking-wider text-black mb-6">Penjualan Harian</h3>
            <div class="relative" style="height: 200px;">
                <canvas id="dailySalesChart"></canvas>
            </div>
        </div>

        <!-- Monthly Sales Chart -->
        <div class="bg-white border border-gray-100 p-6 shadow-sm rounded-2xl">
            <h3 class="text-xs font-black uppercase tracking-wider text-black mb-6">Penjualan Bulanan ({{ now()->year }})</h3>
            <div class="relative" style="height: 200px;">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>

        <!-- Sales by Category -->
        <div class="bg-white border border-gray-100 p-6 shadow-sm rounded-2xl">
            <h3 class="text-xs font-black uppercase tracking-wider text-black mb-6">Penjualan per Kategori</h3>
            <div class="relative" style="height: 200px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="bg-white border border-gray-100 p-6 shadow-sm rounded-2xl">
            <h3 class="text-xs font-black uppercase tracking-wider text-black mb-6">Status Pesanan</h3>
            <div class="relative" style="height: 200px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-xs font-black uppercase tracking-wider text-black">Data Penjualan</h3>
            <span class="text-xs text-gray-500">{{ $ordersPaginated->total() }} pesanan</span>
        </div>
        @if($ordersPaginated->isEmpty())
            <div class="py-12 text-center">
                <p class="text-gray-400 text-sm">Belum ada data pesanan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-[10px] font-black uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-left">No. Pesanan</th>
                            <th class="px-6 py-3 text-left">Customer</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-right">Total</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($ordersPaginated as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-[10px] font-bold text-indigo-600">{{ $order->order_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-black text-xs">{{ $order->user->name ?? '-' }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $order->user->email ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'processing' => 'bg-blue-100 text-blue-700',
                                            'shipped' => 'bg-purple-100 text-purple-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'processing' => 'Diproses',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold text-black text-xs">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            @if($ordersPaginated->total() > 0)
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-500">Halaman {{ $ordersPaginated->currentPage() }} dari {{ $ordersPaginated->lastPage() }}</span>
                    <div class="flex gap-2">
                        @if(!$ordersPaginated->onFirstPage())
                            <a href="{{ $ordersPaginated->appends(request()->query())->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-bold border border-gray-200 rounded-lg hover:border-black hover:bg-gray-50 transition-colors flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Prev
                            </a>
                        @else
                            <span class="px-3 py-1.5 text-xs font-bold border border-gray-100 text-gray-300 rounded-lg cursor-not-allowed flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Prev
                            </span>
                        @endif
                        
                        @if($ordersPaginated->hasMorePages())
                            <a href="{{ $ordersPaginated->appends(request()->query())->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-bold border border-gray-200 rounded-lg hover:border-black hover:bg-gray-50 transition-colors flex items-center gap-1">
                                Next
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <span class="px-3 py-1.5 text-xs font-bold border border-gray-100 text-gray-300 rounded-lg cursor-not-allowed flex items-center gap-1">
                                Next
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </div>

    <!-- Top Selling Products & Recent Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Top Products -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-xs font-black uppercase tracking-wider text-black">Produk Terlaris</h3>
            </div>
            @if($topProducts->isEmpty())
                <div class="py-12 text-center">
                    <p class="text-gray-400 text-sm">Belum ada data penjualan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-[10px] font-black uppercase tracking-wider text-gray-500">
                            <tr>
                                <th class="px-6 py-3 text-left">Produk</th>
                                <th class="px-6 py-3 text-right">Terjual</th>
                                <th class="px-6 py-3 text-right">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($topProducts as $product)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-black text-xs">{{ $product->name }}</td>
                                    <td class="px-6 py-4 text-right text-xs font-bold">{{ $product->total_sold }}</td>
                                    <td class="px-6 py-4 text-right text-xs font-bold text-green-600">Rp {{ number_format($product->revenue, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($totalPages > 1)
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-500">Halaman {{ $page }} dari {{ $totalPages }}</span>
                    <div class="flex gap-2">
                        @if($page > 1)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}" class="px-3 py-1.5 text-xs font-bold border border-gray-200 rounded-lg hover:border-black hover:bg-gray-50 transition-colors">Prev</a>
                        @endif
                        @if($page < $totalPages)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}" class="px-3 py-1.5 text-xs font-bold border border-gray-200 rounded-lg hover:border-black hover:bg-gray-50 transition-colors">Next</a>
                        @endif
                    </div>
                </div>
                @endif
            @endif
        </div>

        <!-- Recent Completed Orders -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-xs font-black uppercase tracking-wider text-black">Pesanan Selesai Terbaru</h3>
            </div>
            @if($recentCompletedOrders->isEmpty())
                <div class="py-12 text-center">
                    <p class="text-gray-400 text-sm">Belum ada pesanan selesai.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($recentCompletedOrders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-mono text-[10px] font-bold text-indigo-600">{{ $order->order_number }}</p>
                                        <p class="font-bold text-black text-xs">{{ $order->user->name }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <p class="font-bold text-black text-xs">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $order->completed_at ? $order->completed_at->format('d M Y') : $order->created_at->format('d M Y') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Daily Sales Chart
        const dailyCtx = document.getElementById('dailySalesChart').getContext('2d');
        const dailyLabels = @json($dailySales->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M')));
        const dailyData = @json($dailySales->pluck('total'));

        const dailySalesChart = new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Penjualan Harian',
                    data: dailyData,
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: 'rgb(79, 70, 229)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Monthly Sales Chart
        const monthlyCtx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const monthlyRevenue = @json($monthlySales->pluck('total', 'month'));
        const monthlyOrderCount = @json($monthlySales->pluck('count', 'month'));

        const monthlyData = monthlyLabels.map((_, i) => monthlyRevenue[i + 1] || 0);
        const monthlyCount = monthlyLabels.map((_, i) => monthlyOrderCount[i + 1] || 0);

        const monthlySalesChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: monthlyData,
                    backgroundColor: 'rgba(79, 70, 229, 0.8)',
                    borderRadius: 6,
                    yAxisID: 'y'
                }, {
                    label: 'Jumlah Order',
                    data: monthlyCount,
                    borderColor: 'rgb(245, 158, 11)',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    type: 'line',
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($salesByCategory->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($salesByCategory->pluck('revenue')) !!},
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(139, 92, 246, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20, font: { size: 11 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusData = {!! json_encode($orderStatuses) !!};
        const statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Menunggu', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    data: [
                        statusData.pending || 0,
                        statusData.processing || 0,
                        statusData.shipped || 0,
                        statusData.completed || 0,
                        statusData.cancelled || 0
                    ],
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(79, 70, 229, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20, font: { size: 11 } }
                    }
                }
            }
        });
    </script>
</x-admin-layout>
