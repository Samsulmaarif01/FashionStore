@php $title = 'Kelola Member' @endphp

<x-admin-layout :title="$title">
    <div class="mb-6">
        <h2 class="text-2xl font-black tracking-tighter text-black">Daftar Member</h2>
        <p class="text-sm text-gray-500 mt-1">{{ $members->total() }} member terdaftar</p>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm overflow-hidden">
        @if ($members->isEmpty())
            <div class="py-16 text-center">
                <p class="text-gray-400 text-sm">Belum ada member.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-black uppercase tracking-wider text-gray-500">
                            <th class="text-left px-5 py-3">#</th>
                            <th class="text-left px-5 py-3">Nama</th>
                            <th class="text-left px-5 py-3">Email</th>
                            <th class="text-left px-5 py-3">No. HP</th>
                            <th class="text-left px-5 py-3">Pesanan</th>
                            <th class="text-left px-5 py-3">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($members as $index => $member)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-4 text-gray-400 text-xs">{{ $members->firstItem() + $index }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($member->profile_photo)
                                            <img src="{{ Storage::url($member->profile_photo) }}" alt="Foto"
                                                class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xs font-black flex-shrink-0">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $member->name }}</p>
                                            @if ($member->address)
                                                <p class="text-xs text-gray-400 truncate max-w-[150px]">{{ $member->address }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-600">{{ $member->email }}</td>
                                <td class="px-5 py-4 text-gray-600 text-sm">{{ $member->phone ?? '—' }}</td>
                                <td class="px-5 py-4">
                                    <span class="font-black text-gray-900">{{ $member->orders()->count() }}</span>
                                    <span class="text-gray-400 text-xs ml-1">pesanan</span>
                                </td>
                                <td class="px-5 py-4 text-gray-500 text-xs">{{ $member->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($members->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $members->links() }}
                </div>
            @endif
        @endif
    </div>
</x-admin-layout>
