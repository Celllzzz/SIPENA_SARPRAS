<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tindak Lanjut Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('tindak-lanjut.index') }}" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama pelapor, sarana, lokasi, status..."
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Cari
                </button>
            </form>

            <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Nama Pelapor</th>
                            <th class="px-4 py-2 border">Nama Sarana</th>
                            <th class="px-4 py-2 border">Lokasi</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">Bukti</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Catatan</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelaporans as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $p->user->name ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $p->sarana }}</td>
                                <td class="px-4 py-2 border">{{ $p->lokasi }}</td>
                                <td class="px-4 py-2 border">{{ $p->deskripsi }}</td>
                                <td class="px-4 py-2 border">
                                    @if ($p->bukti)
                                        @if (Str::endsWith($p->bukti, ['jpg','jpeg','png']))
                                            <img src="{{ asset('storage/' . $p->bukti) }}" 
                                                 alt="Bukti" class="h-16 rounded">
                                        @else
                                            <a href="{{ asset('storage/' . $p->bukti) }}" 
                                               target="_blank" class="text-blue-600 underline">
                                                Lihat File
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-gray-500 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">
                                    <span class="px-2 py-1 rounded text-white
                                        {{ $p->status == 'Selesai' ? 'bg-green-600' : 
                                           ($p->status == 'Proses' ? 'bg-yellow-500' : 'bg-red-600') }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border">{{ $p->catatan ?? '-' }}</td>
                                <td class="px-4 py-2 border text-center">
                                    <a href="{{ route('tindak-lanjut.edit', $p->id) }}"
                                       class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700">
                                        Tindak Lanjut
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">
                                    Belum ada data pelaporan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $pelaporans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
