<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    Catatan Pemeliharaan Darurat
                </h2>
                <p class="text-xs text-gray-500 mt-1">Penanganan insidental untuk perbaikan dan kerusakan sarana mendadak</p>
            </div>
            <a href="{{ route('pemeliharaan-darurat.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wider hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors shadow-sm self-start sm:self-auto">
                Tambah Catatan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-5 sm:p-6"
                 x-data="{ tableLoading: true }" 
                 x-init="setTimeout(() => tableLoading = false, 300)">
                
                {{-- Search Toolbar (Combined Input + Button Teal) --}}
                <div class="flex justify-end mb-5">
                    <form method="GET" action="{{ route('pemeliharaan-darurat.index') }}" class="w-full sm:w-80">
                        <div class="flex rounded-md shadow-sm border border-gray-300 overflow-hidden focus-within:border-teal-500 focus-within:ring-1 focus-within:ring-teal-500 bg-white">
                            <input type="text" name="search" class="w-full pl-3.5 pr-2 py-2 text-xs sm:text-sm text-gray-900 border-0 focus:outline-none focus:ring-0 placeholder-gray-400" placeholder="Cari sarana atau lokasi..." value="{{ request('search') }}" />
                            @if(request('search'))
                                <a href="{{ route('pemeliharaan-darurat.index') }}" class="px-2.5 py-2 text-gray-400 hover:text-gray-600 flex items-center text-xs font-semibold">
                                    Reset
                                </a>
                            @endif
                            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold transition-colors shrink-0">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Skeleton Placeholder saat Memuat --}}
                <div x-show="tableLoading">
                    <x-ui.skeleton-table :rows="5" />
                </div>

                {{-- Table --}}
                <div x-show="!tableLoading" x-cloak class="overflow-x-auto rounded-md border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-left">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th scope="col" class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sarana & Lokasi</th>
                                <th scope="col" class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Pemeliharaan</th>
                                <th scope="col" class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jadwal Seharusnya</th>
                                <th scope="col" class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-5 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($darurats as $item)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ ($darurats->currentPage() - 1) * $darurats->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-sm">
                                        <div class="font-semibold text-gray-900">{{ $item->sarana }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $item->lokasi }}</div>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pemeliharaan)->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->tanggal_seharusnya ? \Carbon\Carbon::parse($item->tanggal_seharusnya)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <span @class([
                                            'px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-md border',
                                            'bg-blue-50 text-blue-800 border-blue-200/80' => $item->status === 'Dalam Pengerjaan',
                                            'bg-emerald-50 text-emerald-800 border-emerald-200/80' => $item->status === 'Selesai',
                                        ])>
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-sm font-medium text-center space-x-1.5">
                                        <a href="{{ route('pemeliharaan-darurat.edit', $item->id) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-teal-50 text-teal-700 hover:bg-teal-100 transition-colors">
                                            Ubah
                                        </a>
                                        <button onclick="confirmDelete('{{ $item->id }}')" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition-colors">
                                            Hapus
                                        </button>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('pemeliharaan-darurat.destroy', $item->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-10 text-center text-gray-500 text-sm">
                                        Belum ada catatan pemeliharaan darurat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $darurats->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Catatan pemeliharaan darurat ini akan dihapus secara permanen!",
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