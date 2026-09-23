<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    {{ __('Kelola Akun Admin') }}
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Daftar administrator yang memiliki hak akses sistem
                </p>
            </div>
            <a href="{{ route('admin.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wider hover:bg-teal-700 transition shadow-sm">
                Tambah Admin Baru
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
                    <form method="GET" action="{{ route('admin.index') }}" class="flex items-center text-xs text-gray-600">
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
                    <form method="GET" action="{{ route('admin.index') }}" class="w-full sm:w-auto">
                        <div class="flex rounded-md shadow-sm border border-gray-300 overflow-hidden focus-within:border-teal-500 focus-within:ring-1 focus-within:ring-teal-500 bg-white">
                            <input type="text" name="search" class="w-full sm:w-64 px-3 py-1.5 text-xs sm:text-sm border-0 focus:ring-0 focus:outline-none text-gray-900 placeholder-gray-400" placeholder="Cari nama atau email..." value="{{ request('search') }}" />
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
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembaruan Terakhir</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($admins as $admin)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-500 font-medium">
                                        {{ ($admins->currentPage() - 1) * $admins->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-semibold text-gray-900">
                                        {{ $admin->name }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-600">
                                        {{ $admin->email }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                        {{ $admin->updated_at->timezone('Asia/Makassar')->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-medium text-center space-x-1.5">
                                        <a href="{{ route('admin.edit', $admin->id) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-teal-50 text-teal-700 hover:bg-teal-100 transition-colors">
                                            Edit
                                        </a>
                                        <a href="{{ route('admin.change_password_form', $admin->id) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors">
                                            Kata Sandi
                                        </a>
                                        <button onclick="confirmDelete('{{ $admin->id }}', '{{ $admin->name }}')" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition-colors">
                                            Hapus
                                        </button>
                                        
                                        <form id="delete-form-{{ $admin->id }}" action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-xs sm:text-sm">
                                        Tidak ada data admin yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Akun Admin?',
            text: `Akun admin "${name}" akan dihapus permanen dari sistem!`,
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
    @if(session('error'))
        Swal.fire({ 
            icon: 'error', 
            title: 'Gagal!', 
            text: '{{ session('error') }}',
            confirmButtonColor: '#0D9488'
        });
    @endif
</script>