@php $title = 'Ulasan Saya' @endphp

<x-member-layout :title="$title">
    <div class="mb-8">
        <h1 class="text-3xl font-black tracking-tighter text-black">Ulasan Pelanggan</h1>
        <p class="text-gray-500 mt-1 text-sm">Kelola ulasan dan penilaian yang Anda berikan untuk produk kami.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm text-green-700 font-medium flex items-center gap-2 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        @forelse ($reviews as $review)
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm overflow-hidden flex flex-col md:flex-row gap-6">
                <!-- Product Preview -->
                <div class="w-full md:w-48 flex-shrink-0">
                    <div class="aspect-square bg-gray-50 rounded-xl overflow-hidden mb-3">
                        <img src="{{ $review->product && $review->product->image ? $review->product->image : 'https://placehold.co/400x400' }}" alt="Produk" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-sm text-black truncate">{{ $review->product ? $review->product->name : 'Produk Dihapus' }}</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">No. Order: {{ $review->order ? $review->order->order_number : '-' }}</p>
                </div>

                <!-- Review Content -->
                <div class="flex-1 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center text-amber-400 mb-2">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-400">Ditinjau pada {{ $review->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="editReview({{ $review->id }}, {{ $review->rating }}, '{{ addslashes($review->comment) }}')" class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors" title="Edit Ulasan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('member.reviews.destroy', $review) }}" onsubmit="return confirm('Anda yakin ingin menghapus ulasan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors" title="Hapus Ulasan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50/50 p-4 rounded-xl flex-1 border border-gray-100">
                        @if($review->comment)
                            <p class="text-sm text-gray-700 leading-relaxed font-light italic">"{{ $review->comment }}"</p>
                        @else
                            <p class="text-sm text-gray-400 italic">Tidak ada komentar tambahan.</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 text-center bg-white border border-gray-100 shadow-sm rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <p class="text-gray-400 font-medium text-sm">Anda belum memberikan ulasan apa pun.</p>
                <a href="{{ route('member.orders') }}" class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 text-xs font-bold uppercase tracking-widest transition-colors">Lihat Pesanan Saya</a>
            </div>
        @endforelse

        @if ($reviews->hasPages())
            <div class="mt-6 border-t border-gray-100 pt-6">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden bg-black/50 items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-[2rem] w-full max-w-lg p-8 relative shadow-2xl mx-4">
            <button type="button" onclick="closeEditModal()" class="absolute top-6 right-6 text-gray-400 hover:text-black transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <h3 class="text-2xl font-bold text-black tracking-tight mb-2">Edit Ulasan</h3>
            <p class="text-gray-500 text-sm mb-6">Perbarui penilaian dan testimoni Anda.</p>
            
            <form id="edit-form" method="POST" action="">
                @csrf
                @method('PATCH')
                
                <!-- Bintang Interaktif -->
                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-3">Rating</label>
                    <div class="flex items-center gap-1 group" id="star-container">
                        @for($i=1; $i<=5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only star-input">
                                <svg data-value="{{ $i }}" class="w-8 h-8 text-gray-300 hover:fill-amber-400 transition-colors star-icon" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Komentar</label>
                    <textarea id="edit-comment" name="comment" rows="4" class="w-full text-sm border-gray-200 rounded-xl focus:ring-black focus:border-black resize-none p-4" placeholder="Tulis pengalaman Anda..."></textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-black text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-colors shadow-lg">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        const starIcons = document.querySelectorAll('.star-icon');
        const starInputs = document.querySelectorAll('.star-input');
        const starContainer = document.getElementById('star-container');

        // Hover Effect
        starContainer.addEventListener('mouseover', function(e) {
            const star = e.target.closest('svg');
            if (star) {
                const value = parseInt(star.getAttribute('data-value'));
                highlightStars(value, true);
            }
        });

        // Click Effect
        starContainer.addEventListener('click', function(e) {
            const star = e.target.closest('svg');
            if (star) {
                const value = parseInt(star.getAttribute('data-value'));
                document.querySelector(`.star-input[value="${value}"]`).checked = true;
                highlightStars(value, false);
            }
        });

        // Mouse out effect (revert to checked state)
        starContainer.addEventListener('mouseout', function(e) {
            const checkedInput = document.querySelector('.star-input:checked');
            const value = checkedInput ? parseInt(checkedInput.value) : 0;
            highlightStars(value, false);
        });

        function highlightStars(value, isHover) {
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

        function editReview(id, rating, comment) {
            document.getElementById('edit-form').action = `/member/reviews/${id}`;
            document.getElementById('edit-comment').value = comment;
            
            // Set the rating
            const input = document.querySelector(`.star-input[value="${rating}"]`);
            if (input) {
                input.checked = true;
                highlightStars(rating, false);
            }
            
            document.getElementById('edit-modal').classList.remove('hidden');
            document.getElementById('edit-modal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
            document.getElementById('edit-modal').classList.remove('flex');
        }
    </script>
</x-member-layout>
