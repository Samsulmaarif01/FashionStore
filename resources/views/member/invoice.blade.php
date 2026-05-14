<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        @page { margin: 40px; }
        body {
            font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            box-sizing: border-box;
            @if(!isset($is_pdf))
            padding: 40px;
            @endif
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            margin-bottom: 30px;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 20px;
        }
        .brand-name {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -1px;
            margin: 0;
            color: #000;
        }
        .brand-tagline {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 4px;
        }
        .btn-print {
            color: #4f46e5;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        .invoice-title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 24px;
            color: #000;
        }
        .info-table {
            margin-bottom: 40px;
            font-size: 14px;
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
            width: 100px;
            padding-bottom: 8px;
        }
        .info-value {
            font-weight: 700;
            color: #111827;
            padding-bottom: 8px;
        }
        .items-table {
            margin-bottom: 30px;
            width: 100%;
        }
        .items-table th {
            padding: 16px 0;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #111827;
            text-align: left;
        }
        .items-table td {
            padding: 20px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .product-name {
            font-weight: 700;
            color: #111827;
            margin: 0;
            font-size: 14px;
        }
        .product-cat {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0px;
            margin-top: 2px;
        }
        .subtotal-row td {
            padding: 12px 16px;
            background-color: #f9fafb;
            font-weight: 900;
            font-size: 14px;
        }
        .summary-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .total-box {
            background-color: #f9fafb;
            padding: 16px;
            border: 1px solid #f3f4f6;
        }
        .total-label {
            color: #4f46e5;
            font-weight: 900;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .total-value {
            font-size: 20px;
            font-weight: 900;
            color: #4f46e5;
            letter-spacing: -1px;
            text-align: right;
        }
        .note {
            font-size: 10px;
            color: #9ca3af;
            font-weight: 500;
            font-style: italic;
            text-align: right;
            margin: 0;
        }
        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #f9fafb;
            text-align: center;
        }
        .footer p {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5em;
            color: #d1d5db;
        }
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; }
            .container { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="vertical-align: middle;">
                    <h1 class="brand-name">VELOUR</h1>
                    <p class="brand-tagline">Gerakan Dinamis & Keanggunan Modern</p>
                </td>
                @if(!isset($is_pdf))
                <td style="vertical-align: middle; text-align: right; width: 100px;">
                    <button onclick="window.print()" class="no-print btn-print">
                        <span style="font-size:18px; vertical-align:middle; margin-right:4px;">&#128438;</span> Cetak
                    </button>
                </td>
                @endif
            </tr>
        </table>

        <!-- Invoice Title -->
        <h2 class="invoice-title">Invoice</h2>

        <!-- Info Grid -->
        <table class="info-table">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td class="info-label">Penjual</td>
                            <td class="info-value">: Velour Official Store</td>
                        </tr>
                        <tr>
                            <td class="info-label">Nomor</td>
                            <td class="info-value" style="font-family: monospace;">: {{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Tanggal</td>
                            <td class="info-value">: {{ $order->created_at->format('d F Y') }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td class="info-label" style="width: 120px;">Pembayaran</td>
                            <td class="info-value">: {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 45%;">NAMA PRODUK</th>
                    <th style="width: 10%; text-align: center;">JUMLAH</th>
                    <th style="width: 15%; text-align: center;">BERAT</th>
                    <th style="width: 15%; text-align: right;">HARGA</th>
                    <th style="width: 15%; text-align: right;">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td style="vertical-align: middle;">
                            <p class="product-name">{{ $item->product->name }}</p>
                            <p class="product-cat">{{ $item->product->category }}</p>
                        </td>
                        <td style="text-align: center; vertical-align: middle; font-weight: 700;">{{ $item->quantity }}</td>
                        <td style="text-align: center; vertical-align: middle; color: #9ca3af;">0.2 kg</td>
                        <td style="text-align: right; vertical-align: middle; font-weight: 500;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right; vertical-align: middle; font-weight: 700;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal-row">
                    <td colspan="4" style="text-align: right; color: #111827;">Subtotal</td>
                    <td style="text-align: right; color: #111827;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Summary using Tables for strict DOMPDF support -->
        <table class="summary-table">
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 40%;" class="total-box">
                    <table style="width: 100%;">
                        <tr>
                            <td class="total-label" style="text-align: left; vertical-align: middle;">Total</td>
                            <td class="total-value" style="text-align: right; vertical-align: middle;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 10px; text-align: right;">
                    <p class="note">* Invoice ini adalah bukti sah pembayaran untuk pesanan Anda di Velour.</p>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with Velour</p>
        </div>
    </div>
</body>
</html>
