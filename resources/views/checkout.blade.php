<x-layout>
    <div class="bg-gray-50 min-h-screen py-10 md:py-20">
        <div class="max-w-[1400px] w-full mx-auto px-4 sm:px-8 lg:px-12">
            
            <!-- Header Section -->
            <div class="mb-12 md:mb-16">
                <nav class="flex mb-4 text-[11px] font-semibold uppercase tracking-widest text-gray-400">
                    <a href="{{ route('cart.index') }}" class="hover:text-black transition-colors">Keranjang</a>
                    <span class="mx-3 text-gray-300">/</span>
                    <span class="text-black">Pembayaran</span>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-black tracking-tight">Checkout</h1>
                <p class="text-gray-500 mt-2 text-sm font-medium">Lengkapi detail pengiriman Anda untuk menyelesaikan pesanan.</p>
            </div>

            <form action="{{ route('payment.createInvoice') }}" method="POST" class="w-full">
                @csrf
                <div class="flex flex-col lg:flex-row gap-10 lg:gap-14 items-start w-full">
                    
                    <!-- Form Section (Left) -->
                    <div class="w-full lg:flex-[1.8]">
                        <!-- Shipping Information Card -->
                        <div class="bg-white p-8 md:p-14 shadow-sm relative overflow-hidden" style="border-radius: 2.5rem;">
                            
                            <h3 class="text-xl font-bold text-black tracking-tight mb-10">Informasi Pengiriman</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Nama Penerima Lengkap</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}" 
                                        class="w-full bg-white border border-gray-200 px-5 py-4 text-[15px] font-medium text-black focus:border-black focus:ring-1 focus:ring-black transition-all rounded-xl placeholder-gray-300" 
                                        placeholder="Contoh: Budi Santoso" required>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Nomor WhatsApp</label>
                                    <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" 
                                        class="w-full bg-white border border-gray-200 px-5 py-4 text-[15px] font-medium text-black focus:border-black focus:ring-1 focus:ring-black transition-all rounded-xl placeholder-gray-300" 
                                        placeholder="0812XXXXXXXX" required>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Metode Pembayaran</label>
                                    <div class="relative">
                                        <select name="payment_method" class="w-full bg-white border border-gray-200 px-5 py-4 text-[15px] font-medium text-black focus:border-black focus:ring-1 focus:ring-black transition-all appearance-none cursor-pointer rounded-xl" required>
                                            <option value="bank_transfer">Transfer Bank (BCA/Mandiri)</option>
                                            <option value="qris">QRIS / E-Wallet</option>
                                            <option value="cod">Bayar di Tempat (COD)</option>
                                        </select>
                                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Alamat Lengkap</label>
                                    <textarea name="address" rows="3" 
                                        class="w-full bg-white border border-gray-200 px-5 py-4 text-[15px] font-medium text-black focus:border-black focus:ring-1 focus:ring-black transition-all resize-none rounded-xl placeholder-gray-300" 
                                        placeholder="Nama Jalan, Kota, Provinsi, Kode Pos" required>{{ auth()->user()->address ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Protection Info -->
                        <div class="flex items-center gap-5 bg-white p-6 md:px-10 border border-gray-100 shadow-sm rounded-[2rem] mt-6">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center flex-shrink-0 border border-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-[14px] font-bold text-black tracking-tight mb-0.5">Transaksi 100% Aman</h4>
                                <p class="text-[13px] text-gray-500 leading-relaxed font-normal">Data pribadi Anda dikelola dengan standar enkripsi tertinggi untuk privasi penuh.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Sidebar (Right) -->
                    <div class="w-full lg:flex-[0.9] lg:max-w-sm sticky top-14 pt-4 md:pt-14 px-2 lg:px-6">
                        <div class="space-y-8">
                            <h2 class="text-xl font-bold text-black tracking-tight mb-8">Ringkasan Pesanan</h2>
                            
                            <!-- Items Mini List -->
                            <div class="space-y-6 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar border-b border-gray-200/80 pb-8 rounded-sm">
                                @foreach($cart as $id => $details)
                                    <div class="flex items-center gap-4 group">
                                        <div class="w-[60px] h-[75px] bg-gray-100 overflow-hidden flex-shrink-0 rounded-md border border-gray-50">
                                            <img src="{{ $details['image'] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0 pr-2">
                                            <h4 class="text-[13px] font-bold text-black tracking-tight truncate">{{ $details['name'] }}</h4>
                                            <p class="text-[12px] text-gray-400 mt-1 font-medium">Qty: {{ $details['quantity'] }}</p>
                                        </div>
                                        <div class="text-[13px] font-bold text-black whitespace-nowrap">
                                            <span class="text-[11px] text-gray-500 font-medium mr-1">{{ $details['quantity'] }}x</span> Rp {{ number_format($details['price'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Cost Breakdown -->
                            <div class="space-y-4 pt-2">
                                @php
                                    $originalSubtotal = 0;
                                    foreach($cart as $item) {
                                        $originalSubtotal += ($item['original_price'] ?? $item['price']) * $item['quantity'];
                                    }
                                    $totalSavings = $originalSubtotal - $total;
                                @endphp
                                
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500 text-[15px] font-normal">Subtotal</span>
                                    <span class="text-black font-bold text-[15px] tracking-tight">Rp {{ number_format($originalSubtotal, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500 text-[15px] font-normal">Pengiriman</span>
                                    <span class="text-black font-bold text-[15px] tracking-tight">Gratis</span>
                                </div>

                                @if($totalSavings > 0)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500 text-[15px] font-normal">Hemat Koleksi</span>
                                        <span class="text-black font-bold text-[15px] tracking-tight">-Rp {{ number_format($totalSavings, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-1">
                                         <span class="w-full text-right text-gray-200">_</span>
                                    </div>
                                @endif

                                <div class="pt-6 border-t border-gray-200 flex justify-between items-end mb-6">
                                    <span class="text-lg font-bold text-black tracking-tight">Total</span>
                                    <span class="text-[20px] font-bold text-black tracking-tight leading-none">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            
                            <button type="submit" class="block w-full bg-black text-white py-[14px] mt-6 font-medium text-center text-[13px] hover:bg-gray-800 transition-all rounded-md">
                                Bayar Sekarang
                            </button>
                            
                            <div class="text-center mt-6">
                                <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-[12px] font-medium text-gray-400 hover:text-black transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                    Kembali ke Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
</x-layout>
