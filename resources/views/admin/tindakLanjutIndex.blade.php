<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                {{ __('Tindak Lanjut Laporan Kerusakan') }}
            </h1>
            <p class="text-xs text-gray-500 mt-1">
                Verifikasi dan penanganan laporan kerusakan sarana dari pengguna
            </p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-5 sm:p-6"
                 x-data="{ tableLoading: true }" 
                 x-init="setTimeout(() => tableLoading = false, 300)">
                
                {{-- Toolbar Filter & Gabungan Search Bar --}}
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mb-5">
                    <form method="GET" action="{{ route('tindak-lanjut.index') }}" class="flex items-center text-xs text-gray-600">
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
                    <form method="GET" action="{{ route('tindak-lanjut.index') }}" class="w-full sm:w-auto">
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
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sarana & Lokasi</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Bukti</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Catatan</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pelaporans as $laporan)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-500 font-medium">
                                        {{ ($pelaporans->currentPage() - 1) * $pelaporans->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm">
                                        <div class="font-semibold text-gray-900">{{ $laporan->sarana }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $laporan->lokasi }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-center">
                                        @if ($laporan->bukti)
                                            @php
                                                $fileExtension = strtolower(pathinfo($laporan->bukti, PATHINFO_EXTENSION));
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                            @endphp

                                            @if (in_array($fileExtension, $imageExtensions))
                                                <button type="button" class="text-xs font-semibold text-teal-700 hover:text-teal-900 underline" onclick="showImageModal(`{{ asset($laporan->bukti) }}`)">
                                                    Lihat Foto
                                                </button>
                                            @else
                                                <a href="{{ asset($laporan->bukti) }}" target="_blank" class="text-xs font-semibold text-teal-700 hover:text-teal-900 underline">
                                                    Berkas
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-gray-400 text-xs italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <x-ui.badge :type="$laporan->status">
                                            {{ str_replace('_', ' ', ucfirst($laporan->status)) }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-600 max-w-xs">
                                        <p class="truncate" title="{{ $laporan->catatan }}">{{ $laporan->catatan ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-medium text-center">
                                        <a href="{{ route('tindak-lanjut.edit', $laporan->id) }}" class="inline-flex items-center px-3 py-1 bg-teal-600 text-white text-xs font-semibold rounded-md shadow-sm hover:bg-teal-700 transition">
                                            Tindak Lanjut &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-xs sm:text-sm">
                                        Tidak ada data laporan yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

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
    function showImageModal(imageUrl) {
        Swal.fire({
            imageUrl: imageUrl,
            imageWidth: '90%',
            imageAlt: 'Bukti Kerusakan',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#0D9488'
        });
    }
</script>