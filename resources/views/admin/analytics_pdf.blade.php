<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan {{ $startDate }} - {{ $endDate }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        .header { margin-bottom: 20px; }
        .summary { margin-bottom: 20px; }
        .summary-card { 
            display: inline-block; 
            width: 45%; 
            padding: 10px; 
            margin: 5px; 
            border: 1px solid #ccc; 
            border-radius: 5px;
        }
        .summary-card .label { font-size: 10px; color: #666; }
        .summary-card .value { font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f0f0f0; padding: 8px; text-align: left; font-size: 10px; }
        td { padding: 6px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-card">
            <div class="label">TOTAL PENJUALAN</div>
            <div class="value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">TOTAL PESANAN</div>
            <div class="value">{{ $totalOrders }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Items</th>
                <th class="text-right">Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->user->name }}<br><small>{{ $order->user->email }}</small></td>
                    <td>
                        @foreach ($order->items as $item)
                            {{ $item->product->name }} ({{ $item->quantity }})<br>
                        @endforeach
                    </td>
                    <td class="text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>{{ $order->status_label }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalSales, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="text-center" style="margin-top: 30px; font-size: 10px; color: #999;">
        Dicetak pada: {{ now()->format('d F Y H:i') }}
    </div>
</body>
</html>
