<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catatan Pemeliharaan Darurat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
                        <a href="{{ route('pemeliharaan-darurat.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Tambah Catatan Baru
                        </a>
                        <form method="GET" action="{{ route('pemeliharaan-darurat.index') }}" class="w-full sm:w-auto">
                            <div class="relative w-full sm:w-64">
                                <x-text-input type="text" name="search" class="w-full" placeholder="Cari sarana atau lokasi..." value="{{ request('search') }}" />
                                <x-primary-button class="absolute top-0 right-0 h-full">Cari</x-primary-button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sarana & Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pemeliharaan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jadwal Seharusnya</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($darurats as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ($darurats->currentPage() - 1) * $darurats->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-medium text-gray-900">{{ $item->sarana }}</div>
                                            <div class="text-gray-500">{{ $item->lokasi }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($item->tanggal_pemeliharaan)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->tanggal_seharusnya ? \Carbon\Carbon::parse($item->tanggal_seharusnya)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span @class([
                                                'px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                'bg-blue-100 text-blue-800' => $item->status === 'Dalam Pengerjaan',
                                                'bg-green-100 text-green-800' => $item->status === 'Selesai',
                                            ])>
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                            <a href="{{ route('pemeliharaan-darurat.edit', $item->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                                            <button onclick="confirmDelete('{{ $item->id }}')" class="text-red-600 hover:underline">Hapus</button>
                                            <form id="delete-form-{{ $item->id }}" action="{{ route('pemeliharaan-darurat.destroy', $item->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada catatan pemeliharaan darurat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">{{ $darurats->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Anda Yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
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
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 1500, showConfirmButton: true });
    @endif
</script>