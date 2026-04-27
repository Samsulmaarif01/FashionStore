@php $title = 'Kotak Masuk' @endphp

<x-member-layout :title="$title">
    <div class="mb-6">
        <h2 class="text-2xl font-black tracking-tighter text-black">Kotak Masuk</h2>
        <p class="text-sm text-gray-500 mt-1">Pesan dan pemberitahuan penting untuk Anda.</p>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        @if ($inboxes->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-gray-400 text-sm font-medium">Kotak masuk Anda kosong.</p>
            </div>
        @else
            <div class="divide-y divide-gray-50">
                @foreach ($inboxes as $inbox)
                    <div class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                    {{ $inbox->title }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $inbox->message }}</p>
                                <span class="text-[11px] text-gray-400 mt-2 block">{{ $inbox->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="shrink-0 text-indigo-500 bg-indigo-50 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($inboxes->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $inboxes->links() }}
                </div>
            @endif
        @endif
    </div>
</x-member-layout>
