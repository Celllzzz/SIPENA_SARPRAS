<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    {{ __('Jadwal Pemeliharaan Rutin') }}
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Daftar jadwal perawatan berkala untuk fasilitas dan sarana prasarana
                </p>
            </div>
            <a href="{{ route('pemeliharaan-rutin.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wider hover:bg-teal-700 transition shadow-sm">
                Tambah Jadwal Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-5 sm:p-6"
                 x-data="{ tableLoading: true }" 
                 x-init="setTimeout(() => tableLoading = false, 300)">
                
                {{-- Toolbar Filter & Gabungan Search Bar --}}
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mb-5">
                    <form method="GET" action="{{ route('pemeliharaan-rutin.index') }}" class="flex items-center text-xs text-gray-600">
                        <span class="mr-2">Tampilkan:</span>
                        <select name="per_page" id="per_page" onchange="this.form.submit()" class="border border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm text-xs py-1.5 pl-3 pr-8 min-w-[4.5rem] bg-white cursor-pointer">
                            @foreach([10, 25, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                        <span class="ml-2">baris per halaman</span>
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    </form>

                    {{-- Search Input Digabung dengan Tombol (Teal) --}}
                    <form method="GET" action="{{ route('pemeliharaan-rutin.index') }}" class="w-full sm:w-auto">
                        <div class="flex rounded-md shadow-sm border border-gray-300 overflow-hidden focus-within:border-teal-500 focus-within:ring-1 focus-within:ring-teal-500 bg-white">
                            <input type="text" name="search" class="w-full sm:w-64 px-3 py-1.5 text-xs sm:text-sm border-0 focus:ring-0 focus:outline-none text-gray-900 placeholder-gray-400" placeholder="Cari sarana atau lokasi..." value="{{ request('search') }}" />
                            <button type="submit" class="px-4 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold uppercase tracking-wider transition-colors flex-shrink-0">
                                Cari
                            </button>
                        </div>
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    </form>
                </div>

                {{-- Skeleton Placeholder saat Memuat --}}
                <div x-show="tableLoading">
                    <x-ui.skeleton-table :rows="5" />
                </div>

                {{-- Table --}}
                <div x-show="!tableLoading" x-cloak class="overflow-x-auto rounded-md border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sarana</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Frekuensi</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jadwal Berikutnya</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($jadwals as $jadwal)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-500 font-medium">
                                        {{ ($jadwals->currentPage() - 1) * $jadwals->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-semibold text-gray-900">
                                        {{ $jadwal->sarana }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-600">
                                        {{ $jadwal->lokasi }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-600">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 text-gray-700 font-medium">
                                            {{ $jadwal->frekuensi }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-600 font-medium">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal_berikutnya)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span @class([
                                            'px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-md border',
                                            'bg-amber-50 text-amber-800 border-amber-200/80' => $jadwal->status === 'Terjadwal',
                                            'bg-red-50 text-red-800 border-red-200/80' => $jadwal->status === 'Ditangguhkan',
                                            'bg-emerald-50 text-emerald-800 border-emerald-200/80' => $jadwal->status === 'Selesai',
                                        ])>
                                            {{ $jadwal->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-medium text-center space-x-1.5">
                                        <a href="{{ route('pemeliharaan-rutin.edit', $jadwal->id) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-teal-50 text-teal-700 hover:bg-teal-100 transition-colors">
                                            Perbarui
                                        </a>
                                        <button onclick="confirmDelete('{{ $jadwal->id }}')" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition-colors">
                                            Hapus
                                        </button>
                                        <form id="delete-form-{{ $jadwal->id }}" action="{{ route('pemeliharaan-rutin.destroy', $jadwal->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500 text-xs sm:text-sm">
                                        Belum ada jadwal pemeliharaan rutin.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $jadwals->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Jadwal?',
            text: "Jadwal pemeliharaan ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({ 
            icon: 'success', 
            title: 'Berhasil!', 
            text: '{{ session('success') }}', 
            timer: 1500, 
            showConfirmButton: false,
            confirmButtonColor: '#0D9488'
        });
    @endif
</script>