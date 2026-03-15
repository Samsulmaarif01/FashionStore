<x-layout>
    <div class="bg-[#fafafa] min-h-screen py-12 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-12 md:mb-20 gsap-fade-up">
                <nav class="flex mb-8 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
                    <a href="{{ route('cart.index') }}" class="hover:text-black transition-colors">Keranjang</a>
                    <span class="mx-4 text-gray-200">/</span>
                    <span class="text-indigo-600">Pembayaran</span>
                </nav>
                <h1 class="text-4xl md:text-6xl font-black tracking-tighter text-black uppercase leading-none">Checkout</h1>
                <p class="text-gray-500 mt-4 uppercase text-[10px] font-black tracking-[0.3em]">Lengkapi detail pengiriman Anda</p>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST" class="relative w-full">
                @csrf
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-16 items-start w-full">
                    
                    <!-- Form Section (Left) -->
                    <div class="w-full lg:flex-1 space-y-8 md:space-y-12 gsap-fade-up">
                        
                        <!-- Shipping Information Card -->
                        <div class="bg-white p-6 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>
                            
                            <h3 class="text-xl font-black uppercase tracking-widest mb-10">Informasi Pengiriman</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3">Nama Penerima Lengkap</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}" 
                                        class="w-full bg-gray-50 border-2 border-transparent px-6 py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all uppercase tracking-tight" 
                                        placeholder="CONTOH: BUDI SANTOSO" required>
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3">Nomor WhatsApp</label>
                                    <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" 
                                        class="w-full bg-gray-50 border-2 border-transparent px-6 py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all uppercase tracking-tight" 
                                        placeholder="0812XXXXXXXX" required>
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3">Metode Pembayaran</label>
                                    <div class="relative">
                                        <select name="payment_method" class="w-full bg-gray-50 border-2 border-transparent px-6 py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all uppercase tracking-tight appearance-none cursor-pointer" required>
                                            <option value="bank_transfer">Transfer Bank (BCA/Mandiri)</option>
                                            <option value="qris">QRIS / E-Wallet</option>
                                            <option value="cod">Bayar di Tempat (COD)</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3">Alamat Lengkap</label>
                                    <textarea name="address" rows="4" 
                                        class="w-full bg-gray-50 border-2 border-transparent px-6 py-4 text-sm font-bold focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all uppercase tracking-tight resize-none" 
                                        placeholder="STREET NAME, CITY, PROVINCE, POSTAL CODE" required>{{ auth()->user()->address ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Protection Info -->
                        <div class="flex items-start gap-6 bg-white p-8 border border-gray-100 shadow-sm">
                            <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest mb-1">Transaksi Aman</h4>
                                <p class="text-[10px] text-gray-400 leading-relaxed font-medium">Data Anda dienkripsi dan kami menjamin keamanan setiap transaksi yang dilakukan melalui platform Velour.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Sidebar (Right) -->
                    <div class="w-full lg:w-[450px] space-y-6 gsap-fade-up sticky top-24" style="animation-delay: 200ms;">
                        <div class="bg-black text-white p-8 md:p-10 shadow-[0_30px_60px_rgba(0,0,0,0.15)] relative">
                            <h3 class="text-xl font-black uppercase tracking-[0.2em] mb-10">Ringkasan</h3>
                            
                            <div class="space-y-6 mb-10 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($cart as $id => $details)
                                    <div class="flex items-center gap-5 group">
                                        <div class="w-16 h-20 bg-gray-900 overflow-hidden flex-shrink-0">
                                            <img src="{{ $details['image'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-[11px] font-black uppercase tracking-tight truncate">{{ $details['name'] }}</h4>
                                            <p class="text-[9px] text-gray-500 mt-1 font-bold uppercase tracking-[0.1em]">{{ $details['quantity'] }} × Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-[11px] font-black text-indigo-400">
                                            Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-4 pt-8 border-t border-white/5">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-500">Subtotal</span>
                                    <span class="text-sm font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-500">
                                    <span class="text-[10px] font-black uppercase tracking-widest">Pengiriman</span>
                                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Gratis</span>
                                </div>
                                <div class="pt-8 mt-4 border-t border-white/10">
                                    <div class="flex justify-between items-end">
                                        <span class="text-xs font-black uppercase tracking-[0.3em] text-gray-400">Total</span>
                                        <div class="text-right">
                                            <span class="block text-3xl font-black text-white leading-none tracking-tighter">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="w-full bg-indigo-600 text-white py-6 mt-10 font-black uppercase tracking-[0.4em] text-[11px] hover:bg-white hover:text-black transition-all duration-500 group flex items-center justify-center gap-4">
                                    Buat Pesanan
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </button>
                            </div>
                        </div>
                        
                        <a href="{{ route('cart.index') }}" class="flex items-center justify-center gap-3 w-full py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            Ubah Keranjang
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #4f46e5; }
        
        input:focus, select:focus, textarea:focus {
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.1);
        }
    </style>
</x-layout>
