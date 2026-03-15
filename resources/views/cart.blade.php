<x-layout>
    <div class="bg-gray-50 min-h-screen py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 gsap-fade-up">
                <h1 class="text-5xl font-black tracking-tighter text-black uppercase">Keranjang Belanja</h1>
                <div class="w-20 h-1.5 bg-indigo-600 mx-auto mt-6"></div>
            </div>

            @if(count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    <!-- Cart Items List -->
                    <div class="lg:col-span-8 gsap-fade-up">
                        <div class="bg-white shadow-xl overflow-hidden border border-gray-100">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100">
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Produk</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Harga</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Jumlah</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Total</th>
                                        <th class="px-6 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $details)
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-6 font-medium">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-20 h-24 bg-gray-100 overflow-hidden flex-shrink-0">
                                                        <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('product.detail', $details['slug']) }}" class="text-sm font-bold text-black hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $details['name'] }}</a>
                                                        <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-widest">Fashion Item</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-6">
                                                <span class="text-sm font-bold text-gray-900 leading-none">Rp {{ number_format($details['price'], 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-6 py-6">
                                                <div class="flex items-center justify-center gap-3">
                                                    <button onclick="updateCart('{{ $id }}', {{ $details['quantity'] - 1 }})" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-black hover:text-white transition-all focus:outline-none">-</button>
                                                    <span class="text-sm font-black w-6 text-center">{{ $details['quantity'] }}</span>
                                                    <button onclick="updateCart('{{ $id }}', {{ $details['quantity'] + 1 }})" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-black hover:text-white transition-all focus:outline-none">+</button>
                                                </div>
                                            </td>
                                            <td class="px-6 py-6">
                                                <span class="text-sm font-black text-indigo-600 leading-none">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-6 py-6 text-right">
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="lg:col-span-4 gsap-fade-up" style="animation-delay: 200ms;">
                        <div class="bg-black text-white p-8 shadow-2xl sticky top-24">
                            <h3 class="text-lg font-black uppercase tracking-[0.2em] mb-8 border-b border-gray-800 pb-4">Ringkasan Pesanan</h3>
                            
                            <div class="space-y-6">
                                <div class="flex justify-between text-gray-400">
                                    <span class="text-xs font-bold uppercase tracking-widest">Subtotal</span>
                                    <span class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-400">
                                    <span class="text-xs font-bold uppercase tracking-widest">Estimasi Pengiriman</span>
                                    <span class="text-xs uppercase font-bold text-indigo-400">Gratis Seluruh Indonesia</span>
                                </div>
                                <div class="border-t border-gray-800 pt-6 mt-6">
                                    <div class="flex justify-between items-end">
                                        <span class="text-sm font-black uppercase tracking-[0.3em]">Total Tagihan</span>
                                        <span class="text-2xl font-black text-indigo-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <button class="w-full bg-white text-black py-5 mt-10 font-black uppercase tracking-[0.3em] text-[10px] hover:bg-indigo-500 hover:text-white transition-all duration-300 shadow-xl">
                                    Lanjut ke Pembayaran
                                </button>
                                
                                <div class="mt-8 flex items-center justify-center gap-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Aman & Terenkripsi
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="max-w-md mx-auto text-center py-24 bg-white shadow-xl border border-gray-100 gsap-fade-up">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-black text-black uppercase tracking-widest mb-4">Keranjang Anda Kosong</h2>
                    <p class="text-gray-500 text-sm mb-10 px-8 font-light">Sepertinya Anda belum menambahkan produk apapun ke dalam keranjang belanja Anda.</p>
                    <a href="{{ route('collection') }}" class="inline-block bg-black text-white px-10 py-4 text-[10px] font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all shadow-lg">
                        Mulai Belanja Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function updateCart(id, qty) {
            if(qty < 1) return;
            
            fetch("{{ route('cart.update') }}", {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id,
                    quantity: qty
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.reload();
                } else if(data.error) {
                    alert(data.error);
                }
            });
        }
    </script>
</x-layout>
