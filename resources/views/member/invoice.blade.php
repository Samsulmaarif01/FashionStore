<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #1a1a1a;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                background-color: white;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
    <div class="max-w-4xl mx-auto bg-white min-h-screen p-8 md:p-12 shadow-sm">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
            <div class="flex flex-col">
                <h1 class="text-3xl font-black tracking-tighter text-black">V E L O U R</h1>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Gerakan Dinamis & Keanggunan Modern</p>
            </div>
            <button onclick="window.print()" class="no-print flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-bold text-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak
            </button>
        </div>

        <!-- Invoice Title -->
        <h2 class="text-xl font-extrabold text-black mb-6">Invoice</h2>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 text-sm">
            <div class="space-y-2">
                <div class="flex">
                    <span class="w-24 text-gray-500 font-medium">Penjual</span>
                    <span class="font-bold text-gray-900">: Velour Official Store</span>
                </div>
                <div class="flex">
                    <span class="w-24 text-gray-500 font-medium">Nomor</span>
                    <span class="font-mono font-bold text-gray-900">: {{ $order->order_number }}</span>
                </div>
                <div class="flex">
                    <span class="w-24 text-gray-500 font-medium">Tanggal</span>
                    <span class="font-bold text-gray-900">: {{ $order->created_at->format('d F Y') }}</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex">
                    <span class="w-28 text-gray-500 font-medium">Pembayaran</span>
                    <span class="font-bold text-gray-900 flex items-center gap-2">
                        : {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                        @if($order->payment_method == 'bank_transfer')
                            <span class="px-2 py-0.5 bg-indigo-900 text-[8px] text-white rounded font-black italic">BCA</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto mb-10">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b-2 border-gray-900 text-left">
                        <th class="py-4 font-black uppercase text-[11px] tracking-wider w-1/2">Nama Produk</th>
                        <th class="py-4 font-black uppercase text-[11px] tracking-wider text-center">Jumlah</th>
                        <th class="py-4 font-black uppercase text-[11px] tracking-wider text-center">Berat</th>
                        <th class="py-4 font-black uppercase text-[11px] tracking-wider text-right">Harga</th>
                        <th class="py-4 font-black uppercase text-[11px] tracking-wider text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="py-5">
                                <p class="font-bold text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5 uppercase tracking-tighter">{{ $item->product->category }}</p>
                            </td>
                            <td class="py-5 text-center font-bold">{{ $item->quantity }}</td>
                            <td class="py-5 text-center text-gray-400">0.2 kg</td>
                            <td class="py-5 text-right font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-5 text-right font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50">
                        <td colspan="4" class="py-3 px-4 text-right font-black text-black">Subtotal</td>
                        <td class="py-3 pr-4 text-right font-black text-black">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Summary -->
        <div class="flex justify-end pt-6 border-t border-gray-100">
            <div class="w-full md:w-80 space-y-4">
                <div class="flex justify-between items-center bg-gray-50 p-4 border border-gray-100">
                    <span class="text-indigo-600 font-black text-xs uppercase tracking-widest">Total</span>
                    <span class="text-xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                
                <div class="text-[10px] text-gray-400 font-medium leading-relaxed italic text-right">
                    * Invoice ini adalah bukti sah pembayaran untuk pesanan Anda di Velour.
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-20 pt-8 border-t border-gray-50 text-center">
            <p class="text-[9px] font-black uppercase tracking-[0.5em] text-gray-300">Thank you for shopping with Velour</p>
        </div>
    </div>

</body>
</html>
