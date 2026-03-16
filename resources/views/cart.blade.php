<x-layout>
    <div class="bg-gray-50 min-h-screen py-12 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 md:mb-16 gsap-fade-up">
                <h1 class="text-4xl md:text-6xl font-black tracking-tighter text-black uppercase leading-none">Keranjang</h1>
                <div class="w-16 h-1.5 bg-indigo-600 mt-6"></div>
            </div>

            @if(count($cart) > 0)
                <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                    <!-- Cart Items List -->
                    <div class="w-full lg:flex-1 gsap-fade-up">
                        <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden rounded-2xl">
                            <!-- Mobile View Card Version -->
                            <div class="block md:hidden divide-y divide-gray-50">
                                @foreach($cart as $id => $details)
                                    <div class="p-6">
                                        <div class="flex gap-4">
                                            <div class="w-24 h-32 bg-gray-50 overflow-hidden flex-shrink-0 rounded-xl">
                                                <img src="{{ $details['image'] }}" class="w-full h-full object-cover grayscale">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-start">
                                                    <a href="{{ route('product.detail', $details['slug']) }}" class="text-sm font-black text-black uppercase tracking-tight truncate pr-4">{{ $details['name'] }}</a>
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $id }}">
                                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Fashion Item</p>
                                                <div class="mt-4 flex justify-between items-center">
                                                    <div class="flex items-center gap-4 bg-gray-50 rounded-full px-4 py-1">
                                                        <button onclick="updateCart('{{ $id }}', {{ $details['quantity'] - 1 }})" class="text-gray-400 hover:text-black">-</button>
                                                        <span class="text-xs font-black">{{ $details['quantity'] }}</span>
                                                        <button onclick="updateCart('{{ $id }}', {{ $details['quantity'] + 1 }})" class="text-gray-400 hover:text-black">+</button>
                                                    </div>
                                                    <div class="text-right">
                                                        @if(isset($details['discount_percent']) && $details['discount_percent'] > 0)
                                                            <span class="block text-[10px] text-gray-400 line-through">Rp {{ number_format($details['original_price'] * $details['quantity'], 0, ',', '.') }}</span>
                                                        @endif
                                                        <span class="text-sm font-black text-indigo-600">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Desktop View Table Version -->
                            <table class="hidden md:table w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100">
                                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Produk</th>
                                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Harga</th>
                                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Jumlah</th>
                                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Total</th>
                                        <th class="px-8 py-5"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $details)
                                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-all group">
                                            <td class="px-8 py-8 font-medium">
                                                <div class="flex items-center gap-6">
                                                    <div class="w-20 h-28 bg-gray-100 overflow-hidden flex-shrink-0 rounded-xl">
                                                        <img src="{{ $details['image'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('product.detail', $details['slug']) }}" class="text-sm font-black text-black hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $details['name'] }}</a>
                                                        <p class="text-[9px] text-gray-400 mt-1 uppercase font-bold tracking-[0.2em]">Fashion Item</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-8">
                                                @if(isset($details['discount_percent']) && $details['discount_percent'] > 0)
                                                    <div class="flex flex-col">
                                                        <span class="text-[10px] text-gray-400 line-through">Rp {{ number_format($details['original_price'], 0, ',', '.') }}</span>
                                                        <span class="text-sm font-bold text-gray-900 leading-none">Rp {{ number_format($details['price'], 0, ',', '.') }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-sm font-bold text-gray-900 leading-none">Rp {{ number_format($details['price'], 0, ',', '.') }}</span>
                                                @endif
                                            </td>
                                            <td class="px-8 py-8">
                                                <div class="flex items-center justify-center gap-4 bg-gray-50 rounded-full px-4 py-2 w-max mx-auto">
                                                    <button onclick="updateCart('{{ $id }}', {{ $details['quantity'] - 1 }})" class="w-6 h-6 flex items-center justify-center text-gray-400 hover:text-black transition-all focus:outline-none">-</button>
                                                    <span class="text-xs font-black w-4 text-center">{{ $details['quantity'] }}</span>
                                                    <button onclick="updateCart('{{ $id }}', {{ $details['quantity'] + 1 }})" class="w-6 h-6 flex items-center justify-center text-gray-400 hover:text-black transition-all focus:outline-none">+</button>
                                                </div>
                                            </td>
                                            <td class="px-8 py-8">
                                                <span class="text-sm font-black text-indigo-600 leading-none">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                                @if(isset($details['discount_percent']) && $details['discount_percent'] > 0)
                                                    <span class="block text-[9px] font-bold text-blue-600 uppercase mt-1">Hemat {{ $details['discount_percent'] }}%</span>
                                                @endif
                                            </td>
                                            <td class="px-8 py-8 text-right">
                                                <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors bg-white hover:bg-red-50 p-2 rounded-full border border-transparent hover:border-red-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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
                    <div class="w-full lg:w-[400px] gsap-fade-up" style="animation-delay: 200ms;">
                        <div class="bg-black text-white p-8 md:p-12 shadow-2xl relative rounded-3xl overflow-hidden">
                            <h3 class="text-lg font-black uppercase tracking-[0.2em] mb-12 flex items-center gap-4">
                                <span class="w-2 h-10 bg-indigo-600"></span>
                                Total Bayar
                            </h3>
                                                        <div class="space-y-8">
                                    @php
                                        $originalSubtotal = 0;
                                        foreach($cart as $item) {
                                            $itemOrigPrice = $item['original_price'] ?? $item['price'];
                                            $originalSubtotal += (float)$itemOrigPrice * (int)$item['quantity'];
                                        }
                                        $totalSavings = max(0, $originalSubtotal - $total);
                                    @endphp
                                    <div class="flex justify-between items-center text-gray-500">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Subtotal</span>
                                        <div class="text-right">
                                            @if($totalSavings > 0)
                                                <span class="block text-[10px] text-gray-500 line-through">Rp {{ number_format($originalSubtotal, 0, ',', '.') }}</span>
                                            @endif
                                            <span class="text-sm font-bold text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    @if($totalSavings > 0)
                                        <div class="flex justify-between items-center text-blue-400">
                                            <span class="text-[10px] font-black uppercase tracking-widest">Hemat</span>
                                            <span class="text-sm font-bold">-Rp {{ number_format($totalSavings, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between items-center text-gray-500">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Pengiriman</span>
                                        <span class="text-[10px] uppercase font-black text-indigo-400 tracking-widest">Gratis</span>
                                    </div>
                                <div class="pt-10 mt-6 border-t border-white/10">
                                    <div class="flex justify-between items-start">
                                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500 mt-2">Total Harga</span>
                                        <div class="text-right">
                                            <span class="block text-indigo-400 text-xs font-black uppercase tracking-widest mb-1">Rp</span>
                                            <span class="text-4xl font-black text-white tracking-tighter leading-none">{{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('checkout.index') }}" class="block w-full bg-indigo-600 text-white py-6 mt-12 font-black text-center uppercase tracking-[0.4em] text-[10px] hover:bg-white hover:text-black transition-all duration-500 shadow-xl group flex items-center justify-center gap-4 rounded-xl">
                                    Proses Checkout
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="max-w-md mx-auto text-center py-24 bg-white shadow-xl border border-gray-100 gsap-fade-up rounded-2xl">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    </div>
                    <h2 class="text-xl font-black text-black uppercase tracking-widest mb-4">Kosong</h2>
                    <p class="text-gray-500 text-sm mb-10 px-8 font-light">Keranjang Anda masih kosong.</p>
                    <a href="{{ route('collection') }}" class="inline-block bg-black text-white px-10 py-4 text-[10px] font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all shadow-lg rounded-xl">
                        Mulai Belanja
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
