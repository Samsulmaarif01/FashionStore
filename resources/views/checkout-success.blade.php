<x-layout>
    <div class="bg-[#fafafa] min-h-screen py-12 md:py-24 flex items-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="bg-white shadow-[0_40px_100px_rgba(0,0,0,0.06)] overflow-hidden border border-gray-100 gsap-fade-up">
                
                <!-- Success Header -->
                <div class="bg-black py-16 md:py-24 text-center px-6 relative overflow-hidden">
                    <!-- Background Decoration -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-600/5 rounded-full blur-3xl -ml-32 -mb-32"></div>

                    <div class="relative z-10">
                        <div class="w-24 h-24 md:w-32 md:h-32 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl animate-bounce">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 md:h-16 md:w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black text-white uppercase tracking-[0.2em] leading-tight">Order Confirmed</h1>
                        <p class="text-gray-500 text-[10px] md:text-xs font-bold uppercase tracking-[0.4em] mt-4">Terima kasih telah mempercayai Velour</p>
                    </div>
                </div>

                <div class="p-8 md:p-16">
                    <!-- Order Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 mb-16 border-b border-gray-100 pb-12">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Order Identification</p>
                            <p class="text-xl md:text-2xl font-black text-black font-mono tracking-tighter">{{ $order->order_number }}</p>
                        </div>
                        <div class="md:text-right">
                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Amount Paid</p>
                            <p class="text-3xl md:text-4xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="space-y-12">
                        <!-- Payment Instructions -->
                        <div>
                            <h3 class="text-xs font-black uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                                <span class="w-8 h-[2px] bg-indigo-600"></span>
                                Instruksi Pembayaran
                            </h3>
                            
                            @if($order->payment_method == 'bank_transfer')
                                <div class="bg-gray-50 p-8 md:p-12 flex flex-col md:flex-row justify-between items-center gap-8 border border-gray-100">
                                    <div class="text-center md:text-left">
                                        <div class="flex items-center gap-3 justify-center md:justify-start mb-4">
                                            <div class="w-10 h-6 bg-indigo-900 rounded-sm flex items-center justify-center text-[10px] font-bold text-white uppercase">BCA</div>
                                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Bank Central Asia</p>
                                        </div>
                                        <p class="text-3xl font-black text-black tracking-widest">883 0921 112</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-2 px-3 py-1 bg-white border border-gray-200 inline-block">A.N. VELOUR GLOBAL RETAIL</p>
                                    </div>
                                    <button class="w-full md:w-auto px-10 py-5 bg-black text-white text-[10px] font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all shadow-xl">
                                        Salin Rekening
                                    </button>
                                </div>
                            @elseif($order->payment_method == 'qris')
                                <div class="bg-white border-2 border-dashed border-gray-200 p-10 text-center">
                                    <div class="w-48 h-48 md:w-56 md:h-56 bg-white mx-auto mb-6 border border-gray-100 p-4 shadow-xl">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=VelourStore-{{ $order->order_number }}" alt="QRIS" class="w-full h-full">
                                    </div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 max-w-xs mx-auto leading-loose">Pindai kode QR di atas menggunakan aplikasi mobile banking atau e-wallet Anda.</p>
                                </div>
                            @else
                                <div class="bg-indigo-50/50 p-8 border-l-4 border-indigo-600">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-700 mb-2">Cash On Delivery (COD)</p>
                                    <p class="text-sm font-medium text-indigo-950 leading-relaxed uppercase tracking-wider">Silakan siapkan dana tunai sebesar Rp {{ number_format($order->total_amount, 0, ',', '.') }} untuk diserahkan kepada kurir saat pesanan sampai.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-8 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('member.orders') }}" class="flex-1 bg-black text-white py-6 px-10 text-[11px] font-black text-center uppercase tracking-[0.4em] hover:bg-indigo-600 transition-all shadow-2xl">
                                MY ORDERS
                            </a>
                            <a href="/" class="flex-1 bg-white border border-gray-100 text-black py-6 px-10 text-[11px] font-black text-center uppercase tracking-[0.4em] hover:bg-gray-50 transition-all">
                                BACK TO HUB
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-10 text-center border-t border-gray-100">
                    <p class="text-[9px] font-bold uppercase tracking-[0.3em] text-gray-400 leading-loose max-w-xl mx-auto">Pesanan akan otomatis diproses setelah sistem kami mendeteksi pembayaran masuk. Hubungi layanan pelanggan jika terdapat kendala.</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
