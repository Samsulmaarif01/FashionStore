@php $title = 'Pesanan Saya' @endphp

<x-member-layout :title="$title">
    <div class="mb-8">
        <h1 class="text-3xl font-black tracking-tighter text-black">Riwayat Pesanan</h1>
        <p class="text-gray-500 mt-1 text-sm">Semua pesanan yang pernah Anda buat.</p>
    </div>

    <!-- Flash Success -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        @if ($orders->isEmpty())
            <div class="py-20 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-400 font-medium text-sm">Belum ada pesanan</p>
                <p class="text-gray-400 text-xs mt-1">Mulai belanja dan pesanan Anda akan muncul di sini.</p>
                <a href="/" class="inline-block mt-6 px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-colors rounded-xl">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500">No. Pesanan</th>
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500 hidden md:table-cell">Tanggal</th>
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500">Total</th>
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500">Status</th>
                            <th class="text-left px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500 hidden lg:table-cell">Alamat Pengiriman</th>
                            <th class="text-right px-6 py-4 text-xs font-black uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-mono text-xs font-black text-gray-800">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-400 mt-1 md:hidden">{{ $order->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-4 text-gray-600 hidden md:table-cell">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900 text-sm">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'pending'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'shipped'    => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            'completed'  => 'bg-green-50 text-green-700 border-green-200',
                                            'cancelled'  => 'bg-red-50 text-red-700 border-red-200',
                                        ];
                                        $labels = [
                                            'pending'    => 'Menunggu Konfirmasi',
                                            'processing' => 'Diproses',
                                            'shipped'    => 'Dikirim',
                                            'completed'  => 'Selesai',
                                            'cancelled'  => 'Dibatalkan',
                                        ];
                                        $colorClass = $colors[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                        $label = $labels[$order->status] ?? ucfirst($order->status);
                                    @endphp
                                    <span class="inline-block px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider border rounded-md {{ $colorClass }}">
                                        {{ $label }}
                                    </span>
                                    @if($order->status === 'cancelled' && $order->cancel_reason)
                                        <p class="text-[10px] text-red-500 mt-1 italic max-w-[150px]">Alasan: {{ $order->cancel_reason }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs hidden lg:table-cell max-w-[200px]">
                                    {{ $order->shipping_address ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-right space-y-3">
                                    <a href="{{ route('member.orders.invoice', $order) }}" target="_blank" class="block text-black hover:text-indigo-600 transition-colors font-bold text-[10px] uppercase tracking-widest whitespace-nowrap">
                                        Download Invoice
                                    </a>
                                    
                                    @if($order->status === 'pending')
                                        <form method="POST" action="{{ route('member.orders.cancel', $order) }}" onsubmit="return confirm('Anda yakin ingin membatalkan pesanan ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="block w-full text-right text-red-600 hover:text-red-800 transition-colors font-bold text-[10px] uppercase tracking-widest whitespace-nowrap">
                                                Batalkan
                                            </button>
                                        </form>
                                    @elseif($order->status === 'shipped')
                                        <form method="POST" action="{{ route('member.orders.complete', $order) }}" onsubmit="return confirm('Apakah pesanan sudah Anda terima dengan baik?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="block w-full text-right text-indigo-600 hover:text-indigo-800 transition-colors font-bold text-[10px] uppercase tracking-widest whitespace-nowrap">
                                                Pesanan Diterima
                                            </button>
                                        </form>
                                    @elseif($order->status === 'completed')
                                        <button type="button" onclick="openReviewModal('{{ $order->id }}')" class="block w-full text-right text-green-600 hover:text-green-800 transition-colors font-bold text-[10px] uppercase tracking-widest whitespace-nowrap">
                                            Beri Ulasan
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            
                            @if($order->status === 'completed')
                                <!-- Modal for Reviews (Hidden by default) -->
                                <div id="review-modal-{{ $order->id }}" class="fixed inset-0 z-50 hidden bg-black/50 items-center justify-center backdrop-blur-sm">
                                    <div class="bg-white rounded-[2rem] w-full max-w-lg p-8 relative shadow-2xl mx-4">
                                        <button onclick="closeReviewModal('{{ $order->id }}')" class="absolute top-6 right-6 text-gray-400 hover:text-black transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                        <h3 class="text-2xl font-bold text-black tracking-tight mb-2">Beri Ulasan</h3>
                                        <p class="text-gray-500 text-sm mb-6">Bagikan pengalaman Anda tentang produk dari pesanan {{ $order->order_number }}.</p>
                                        
                                        <div class="max-h-[60vh] overflow-y-auto pr-2">
                                            @foreach($order->items as $item)
                                                <div class="mb-6 pb-6 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                                                    <div class="flex items-center gap-4 mb-4">
                                                        <div class="w-16 h-16 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0">
                                                            <img src="{{ $item->product && $item->product->image ? $item->product->image : 'https://placehold.co/100x100' }}" class="w-full h-full object-cover">
                                                        </div>
                                                        <div>
                                                            <h4 class="font-bold text-sm text-black">{{ $item->product ? $item->product->name : 'Produk Tidak Diketahui' }}</h4>
                                                            <p class="text-xs text-gray-500">{{ $item->quantity }}x</p>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($item->product)
                                                        @php
                                                            $existingReview = \App\Models\Review::where('order_id', $order->id)->where('product_id', $item->product->id)->first();
                                                        @endphp
                                                        @if($existingReview)
                                                            <div class="bg-gray-50 p-4 rounded-xl">
                                                                <p class="text-[11px] font-bold text-green-600 uppercase tracking-widest mb-2 flex items-center gap-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                                    Ulasan Tersimpan
                                                                </p>
                                                                <div class="flex text-amber-400 mb-1">
                                                                    @for($i=1; $i<=5; $i++)
                                                                        <svg class="w-3 h-3 {{ $i <= $existingReview->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                                    @endfor
                                                                </div>
                                                                <p class="text-xs text-gray-600 italic">"{{ $existingReview->comment }}"</p>
                                                            </div>
                                                        @else
                                                            <form action="{{ route('member.orders.review', $order) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                                <div class="mb-3">
                                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Rating</label>
                                                                    <div class="flex items-center gap-1 star-container">
                                                                        @for($i=1; $i<=5; $i++)
                                                                            <label class="cursor-pointer">
                                                                                <input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} class="sr-only star-input">
                                                                                <svg data-value="{{ $i }}" class="w-8 h-8 star-icon {{ $i <= 5 ? 'fill-amber-400 text-amber-400' : 'text-gray-300' }} hover:fill-amber-400 transition-colors" viewBox="0 0 20 20">
                                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                                </svg>
                                                                            </label>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Komentar</label>
                                                                    <textarea name="comment" rows="2" class="w-full text-sm border-gray-200 rounded-lg focus:ring-black focus:border-black resize-none" placeholder="Tulis pengalaman Anda..."></textarea>
                                                                </div>
                                                                <button type="submit" class="w-full py-2 bg-black text-white text-[11px] font-bold uppercase tracking-widest rounded-lg hover:bg-gray-800 transition-colors">Kirim Ulasan</button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>

    <script>
        function openReviewModal(id) {
            document.getElementById('review-modal-' + id).classList.remove('hidden');
            document.getElementById('review-modal-' + id).classList.add('flex');
        }
        function closeReviewModal(id) {
            document.getElementById('review-modal-' + id).classList.add('hidden');
            document.getElementById('review-modal-' + id).classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.star-container').forEach(container => {
                const starIcons = container.querySelectorAll('.star-icon');
                
                function highlight(value, isHover) {
                    starIcons.forEach(icon => {
                        const iconValue = parseInt(icon.getAttribute('data-value'));
                        if (iconValue <= value) {
                            icon.classList.add('fill-amber-400', 'text-amber-400');
                            icon.classList.remove('text-gray-300');
                        } else {
                            icon.classList.remove('fill-amber-400', 'text-amber-400');
                            if (!isHover || iconValue > value) {
                                icon.classList.add('text-gray-300');
                            }
                        }
                    });
                }

                container.addEventListener('mouseover', function(e) {
                    const star = e.target.closest('svg');
                    if (star) highlight(parseInt(star.getAttribute('data-value')), true);
                });

                container.addEventListener('mouseout', function(e) {
                    const checkedInput = container.querySelector('.star-input:checked');
                    highlight(checkedInput ? parseInt(checkedInput.value) : 0, false);
                });

                container.addEventListener('click', function(e) {
                    const star = e.target.closest('svg');
                    if (star) {
                        const value = parseInt(star.getAttribute('data-value'));
                        container.querySelector(`.star-input[value="${value}"]`).checked = true;
                        highlight(value, false);
                    }
                });
            });
        });
    </script>
</x-member-layout>
