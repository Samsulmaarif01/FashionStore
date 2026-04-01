<x-layout>
    <div class="bg-gray-50 min-h-screen py-10 md:py-20 flex items-center justify-center">
        <div class="max-w-[900px] w-full mx-auto px-4 sm:px-8">
            <div class="bg-white shadow-sm p-8 md:p-16 rounded-[2.5rem]">
                
                <!-- Success Header -->
                <div class="text-center mb-12 md:mb-16">
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8 border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-10 md:w-10 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-black tracking-tight mb-4">Pesanan Dikonfirmasi</h1>
                    <p class="text-gray-500 text-[15px] font-medium">Terima kasih telah mempercayai Velour.</p>
                </div>

                <!-- Order Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12 border-y border-gray-100 py-10">
                    <div class="text-center md:text-left">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">ID Pesanan</p>
                        <p class="text-lg md:text-xl font-bold text-black tracking-tight">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Total Pembayaran</p>
                        <p class="text-lg md:text-xl font-bold text-black tracking-tight">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="space-y-12">
                    <!-- Payment Instructions -->
                    <div>
                        <h3 class="text-[17px] font-bold text-black tracking-tight mb-6 text-center md:text-left">
                            Instruksi Pembayaran
                        </h3>
                        
                        @if($order->payment_method == 'bank_transfer')
                            <div class="bg-[#fafafa] p-8 md:p-10 flex flex-col md:flex-row justify-between items-center gap-8 rounded-2xl">
                                <div class="text-center md:text-left">
                                    <div class="flex items-center gap-3 justify-center md:justify-start mb-4">
                                        <div class="w-10 h-6 bg-black rounded-sm flex items-center justify-center text-[10px] font-bold text-white tracking-widest">BCA</div>
                                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Bank Central Asia</p>
                                    </div>
                                    <p class="text-2xl md:text-3xl font-bold text-black tracking-tight">883 0921 112</p>
                                    <p class="text-[13px] font-medium text-gray-500 mt-2 px-3 py-1 bg-white border border-gray-200 inline-block rounded-md">A.N. Velour Global Retail</p>
                                </div>
                                <button class="w-full md:w-auto px-8 py-4 bg-black text-white text-[13px] font-medium hover:bg-gray-800 transition-all rounded-lg">
                                    Salin Rekening
                                </button>
                            </div>
                        @elseif($order->payment_method == 'qris')
                            <div class="bg-[#fafafa] p-10 text-center rounded-2xl">
                                <div class="w-48 h-48 md:w-56 md:h-56 bg-white mx-auto mb-6 border border-gray-100 p-4 rounded-xl shadow-sm">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=VelourStore-{{ $order->order_number }}" alt="QRIS" class="w-full h-full object-contain">
                                </div>
                                <p class="text-[14px] font-medium text-gray-500 max-w-sm mx-auto leading-relaxed">Pindai kode QR di atas menggunakan aplikasi m-banking atau e-wallet Anda.</p>
                            </div>
                        @else
                            <div class="bg-[#fafafa] p-8 md:p-10 rounded-2xl text-center md:text-left">
                                <p class="text-xs font-semibold uppercase tracking-wider text-black mb-3">Bayar di Tempat (COD)</p>
                                <p class="text-[14px] font-medium text-gray-500 leading-relaxed max-w-2xl">Silakan siapkan dana tunai sebesar <span class="text-black font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span> untuk diserahkan kepada kurir saat pesanan Anda sampai tujuan.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('member.orders.invoice', $order) }}" target="_blank" class="flex-1 border border-gray-200 bg-white text-black py-4 px-6 text-[13px] font-medium text-center hover:bg-gray-50 transition-all rounded-lg">
                            Cetak Invoice
                        </a>
                        <a href="{{ route('member.orders') }}" class="flex-1 bg-black text-white py-4 px-6 text-[13px] font-medium text-center hover:bg-gray-800 transition-all rounded-lg">
                            Lacak Pesanan
                        </a>
                        <a href="/" class="flex-1 border border-transparent bg-gray-100 text-black py-4 px-6 text-[13px] font-medium text-center hover:bg-gray-200 transition-all rounded-lg">
                            Beranda
                        </a>
                    </div>
                </div>
                
                <div class="mt-16 text-center">
                    <p class="text-[13px] font-normal text-gray-400 leading-relaxed max-w-lg mx-auto">Pesanan akan otomatis diproses setelah sistem kami mendeteksi pembayaran masuk. Hubungi layanan pelanggan jika terdapat kendala.</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
