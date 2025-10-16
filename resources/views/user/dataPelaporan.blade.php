<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pelaporan') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                {{-- Dropdown entries --}}
                <div>
                    <form method="GET" action="{{ route('pelaporan.index') }}" class="flex items-center gap-2">
                        <label for="per_page" class="text-sm text-gray-600">Show</label>
                        <select name="per_page" id="per_page" onchange="this.form.submit()"
                                class="border border-gray-300 rounded px-3 py-1 text-sm w-20">
                            @foreach([10,25,50,100] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-sm text-gray-600">entries</span>

                        {{-- biar search tetap nyangkut --}}
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    </form>
                </div>

                {{-- Search bar --}}
                <form method="GET" action="{{ route('pelaporan.index') }}" class="flex gap-2 w-full sm:w-auto">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari..."
                        class="w-full sm:w-64 border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-200">
                    <button type="submit"
                            class="px-3 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                        Cari
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
                <table class="w-full border border-gray-200 table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Sarana</th>
                            <th class="px-4 py-2 border">Lokasi</th>
                            <th class="px-4 py-2 border">Bukti</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Catatan</th>
                            <th class="px-4 py-2 border">Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelaporans as $p)
                            <tr class="hover:bg-gray-50">
                                {{-- Kolom Nomor --}}
                                <td class="px-4 py-2 border text-center">
                                    {{ ($pelaporans->currentPage() - 1) * $pelaporans->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-4 py-2 border whitespace-nowrap">{{ $p->sarana }}</td>
                                <td class="px-4 py-2 border whitespace-nowrap">{{ $p->lokasi }}</td>
                                <td class="px-4 py-2 border">
                                    @if ($p->bukti)
                                        @if (Str::endsWith($p->bukti, ['jpg','jpeg','png']))
                                            <img src="{{ asset('storage/' . $p->bukti) }}" 
                                                alt="Bukti" 
                                                class="h-16 w-16 object-cover rounded-md transform transition-transform duration-300 hover:scale-150">
                                        @else
                                            <a href="{{ asset('storage/' . $p->bukti) }}" 
                                                target="_blank" 
                                                class="text-blue-600 underline">
                                                Lihat File
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-gray-500 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">
                                    @if ($p->status === 'verifikasi')
                                        <span class="px-2 py-1 rounded text-white bg-blue-600">
                                            Verifikasi
                                        </span>
                                    @elseif ($p->status === 'dalam_perbaikan')
                                        <span class="px-2 py-1 rounded text-white bg-yellow-500">
                                            Dalam Perbaikan
                                        </span>
                                    @elseif ($p->status === 'selesai')
                                        <span class="px-2 py-1 rounded text-white bg-green-600">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded text-white bg-gray-500">
                                            {{ $p->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border max-w-xs break-words whitespace-normal">
                                    @if($p->catatan)
                                        {{-- Desktop: selalu tampil full --}}
                                        <span class="hidden sm:block">
                                            {{ $p->catatan }}
                                        </span>

                                        {{-- Mobile: potong teks + tombol --}}
                                        <span class="block sm:hidden">
                                            @php
                                                $limit = 50; // batas karakter
                                                $isLong = strlen($p->catatan) > $limit;
                                            @endphp

                                            @if($isLong)
                                                <span class="truncate block">
                                                    {{ Str::limit($p->catatan, $limit) }}
                                                </span>
                                                <button type="button"
                                                        class="text-blue-600 underline text-sm mt-1"
                                                        onclick="showFullCatatan(`{{ $p->catatan }}`)">
                                                    Lihat Catatan
                                                </button>
                                            @else
                                                {{ $p->catatan }}
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-gray-500 italic">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2 border whitespace-nowrap">{{ $p->updated_at->timezone('Asia/Makassar')->format('d-m-Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showFullCatatan(catatan) {
        Swal.fire({
            title: 'Catatan Perbaikan',
            text: catatan,
            icon: 'info',
            confirmButtonText: 'Tutup',
            width: '600px'
        });
    }
</script>