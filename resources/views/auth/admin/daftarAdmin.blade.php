<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Akun Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">

                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
                        <a href="{{ route('admin.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            {{ __('Tambah Admin Baru') }}
                        </a>
                        
                        {{-- Search bar dengan tombol --}}
                        <form method="GET" action="{{ route('admin.index') }}" class="w-full sm:w-auto">
                            <div class="relative w-full sm:w-64">
                                <x-text-input type="text" name="search" class="w-full" placeholder="Cari nama atau email..." value="{{ request('search') }}" />
                                <x-primary-button class="absolute top-0 right-0 h-full">
                                    Cari
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Update Terakhir</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($admins as $admin)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ($admins->currentPage() - 1) * $admins->perPage() + $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $admin->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->updated_at->timezone('Asia/Makassar')->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                            <a href="{{ route('admin.edit', $admin->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                                            <a href="{{ route('admin.change_password_form', $admin->id) }}" class="text-green-600 hover:underline">Ubah Pass</a>
                                            <button onclick="confirmDelete('{{ $admin->id }}', '{{ $admin->name }}')" class="text-red-600 hover:underline">Hapus</button>
                                            
                                            <form id="delete-form-{{ $admin->id }}" action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">Tidak ada data admin ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $admins->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Anda Yakin?',
            text: `Akun admin "${name}" akan dihapus secara permanen!`,
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
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}' });
    @endif
</script>