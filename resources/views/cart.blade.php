<x-layout>
    <div class="bg-gray-50 min-h-screen py-10 md:py-20">
        <div class="max-w-[1400px] w-full mx-auto px-4 sm:px-8 lg:px-12">
            
            @if(count($cart) > 0)
                <div class="flex flex-col lg:flex-row gap-10 lg:gap-14 items-start">
                    
                    <!-- Cart List Section (White Box) -->
                    <div class="w-full lg:w-2/3 bg-white p-8 md:p-14 shadow-sm relative z-10" style="border-radius: 2.5rem;">
                        <h1 class="text-2xl font-bold text-black tracking-tight mb-8">Cart</h1>

                        <div class="flex flex-col">
                            @foreach($cart as $id => $details)
                                <div class="py-8 group flex items-start flex-col sm:flex-row gap-8 border-t border-gray-100/60 mt-4 first:border-0 first:mt-0">
                                    
                                    <!-- Product Image -->
                                    <div class="w-28 sm:w-32 flex-shrink-0 bg-gray-100 overflow-hidden rounded-md border border-gray-50" style="aspect-ratio: 4/5; min-width: 7rem; max-width: 9rem;">
                                        <img src="{{ $details['image'] }}" class="w-full h-full object-cover">
                                    </div>

                                    <!-- Product Info & Controls -->
                                    <div class="flex-1 w-full min-w-0 flex flex-col sm:flex-row justify-between h-full">
                                        
                                        <!-- Details (Left) -->
                                        <div class="flex flex-col flex-1 pb-4 sm:pb-0">
                                            <a href="{{ route('product.detail', $details['slug']) }}" class="text-[15px] font-bold text-black hover:text-gray-500 transition-colors tracking-tight mb-2">{{ $details['name'] }}</a>
                                            
                                            <div class="space-y-1 mt-1">
                                                <p class="text-[13px] text-gray-400 font-medium tracking-tight">Size: {{ $details['size'] ?? 'M' }}</p>
                                            </div>

                                            <div class="flex items-center gap-5 mt-auto pt-6 text-gray-400">

                                                <form action="{{ route('cart.remove') }}" method="POST" class="flex items-center">
                                                    @csrf @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="hover:text-black transition-colors" aria-label="Remove item">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Price & Qty (Right) -->
                                        <div class="flex flex-col items-start sm:items-end w-full sm:w-auto mt-4 sm:mt-0 pt-4 sm:pt-0 sm:border-t-0 border-gray-100/60">
                                            <div class="text-right">
                                                <span class="text-[15px] font-bold text-black tracking-tight block">Rp {{ number_format($details['price'], 0, ',', '.') }}</span>
                                                @if(isset($details['discount_percent']) && $details['discount_percent'] > 0)
                                                    <span class="text-xs text-gray-400 line-through block mt-1">Rp {{ number_format($details['original_price'], 0, ',', '.') }}</span>
                                                @endif
                                            </div>

                                            <div class="flex items-center gap-4 mt-6 text-gray-400">
                                                <button onclick="updateCart('{{ $id }}', {{ $details['quantity'] - 1 }})" class="hover:text-black focus:outline-none transition-all">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                                </button>
                                                <span class="text-[13px] font-bold w-4 text-center text-black leading-none">{{ $details['quantity'] }}</span>
                                                <button onclick="updateCart('{{ $id }}', {{ $details['quantity'] + 1 }})" class="hover:text-black focus:outline-none transition-all">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary Section -->
                    <div class="w-full lg:w-1/3 sticky top-28 pt-4 md:pt-14 px-2 lg:px-6">
                        <div class="space-y-6">
                            <h2 class="text-xl font-bold text-black tracking-tight mb-8">Order Summary</h2>

                            <div class="space-y-4">
                                @php
                                    $originalSubtotal = 0;
                                    foreach($cart as $item) {
                                        $itemOrigPrice = $item['original_price'] ?? $item['price'];
                                        $originalSubtotal += (float)$itemOrigPrice * (int)$item['quantity'];
                                    }
                                    $totalSavings = max(0, $originalSubtotal - $total);
                                @endphp

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-[15px] font-normal">Subtotal</span>
                                    <span class="text-black font-bold text-[15px] tracking-tight">Rp {{ number_format($originalSubtotal, 0, ',', '.') }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-[15px] font-normal">Delivery</span>
                                    <span class="text-black font-bold text-[15px] tracking-tight">Rp 0</span>
                                </div>

                                @if($totalSavings > 0)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 text-[15px] font-normal">Discount</span>
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
                            
                            <a href="{{ route('checkout.index') }}" class="block w-full bg-black text-white py-[14px] mt-6 font-medium text-center text-[13px] hover:bg-gray-800 transition-all rounded-md">
                                Checkout
                            </a>

                            <div class="mt-4 border-b border-gray-300 inline-block pb-0.5" style="border-bottom: 1px solid rgba(0,0,0,0.15)">
                                <a href="#" class="text-[13px] text-gray-500 font-normal hover:text-black transition-colors">Use a promo code</a>
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
