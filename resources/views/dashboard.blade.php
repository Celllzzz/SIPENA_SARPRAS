<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <span>Selamat datang kembali, </span><strong>{{ Auth::user()->name }}</strong>!
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
                {{-- TAMPILAN DASHBOARD UNTUK ADMIN --}}
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gray-700 text-white p-5 rounded-lg shadow-md">
                        <h3 class="text-xl sm:text-2xl font-bold">{{ $totalLaporan }}</h3>
                        <p class="mt-1 text-sm sm:text-base">Total Laporan</p>
                    </div>
                    <div class="bg-yellow-500 text-white p-5 rounded-lg shadow-md">
                        <h3 class="text-xl sm:text-2xl font-bold">{{ $laporanVerifikasi }}</h3>
                        <p class="mt-1 text-sm sm:text-base">Perlu Verifikasi</p>
                    </div>
                    <div class="bg-blue-500 text-white p-5 rounded-lg shadow-md">
                        <h3 class="text-xl sm:text-2xl font-bold">{{ $laporanDalamPerbaikan }}</h3>
                        <p class="mt-1 text-sm sm:text-base">Dalam Perbaikan</p>
                    </div>
                    <div class="bg-green-500 text-white p-5 rounded-lg shadow-md">
                        <h3 class="text-xl sm:text-2xl font-bold">{{ $laporanSelesai }}</h3>
                        <p class="mt-1 text-sm sm:text-base">Laporan Selesai</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Menu Utama</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="w-full h-full bg-gray-800 text-white p-4 rounded-lg shadow hover:bg-gray-700 transition text-center focus:outline-none text-sm sm:text-base">
                                Laporan Kerusakan
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute z-10 mt-2 w-full min-w-max rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                                <div class="py-1">
                                    <a href="{{ route('pelaporan.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Buat Laporan Baru</a>
                                    <a href="{{ route('pelaporan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lihat Laporan</a>
                                    <a href="{{ route('tindak-lanjut.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tindak Lanjut</a>
                                </div>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="w-full h-full bg-gray-800 text-white p-4 rounded-lg shadow hover:bg-gray-700 transition text-center focus:outline-none text-sm sm:text-base">
                                Rencana Pemeliharaan
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute z-10 mt-2 w-full min-w-max rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                                <div class="py-1">
                                    <a href="{{ route('pemeliharaan.rutin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pemeliharaan Rutin</a>
                                    <a href="{{ route('pemeliharaan.darurat') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pemeliharaan Darurat</a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('admin.index') }}" class="flex items-center justify-center bg-gray-800 text-white p-4 rounded-lg shadow hover:bg-gray-700 transition text-center text-sm sm:text-base">
                            Kelola Admin
                        </a>

                        <a href="{{ route('notifikasi.index') }}" class="flex items-center justify-center bg-gray-800 text-white p-4 rounded-lg shadow hover:bg-gray-700 transition text-center text-sm sm:text-base">
                            Notifikasi
                        </a>
                    
                        <a href="{{ route('ekspor.index') }}" class="flex items-center justify-center bg-gray-800 text-white p-4 rounded-lg shadow hover:bg-gray-700 transition text-center text-sm sm:text-base">
                            Ekspor PDF
                        </a>
                    </div>
                </div>


                <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-lg mb-4">Laporan Kerusakan Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                             <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sarana</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($laporanTerbaru as $laporan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $laporan->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $laporan->sarana }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $laporan->lokasi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($laporan->status == 'verifikasi') bg-yellow-100 text-yellow-800 @endif
                                                @if($laporan->status == 'dalam_perbaikan') bg-blue-100 text-blue-800 @endif
                                                @if($laporan->status == 'selesai') bg-green-100 text-green-800 @endif
                                            ">
                                                {{ str_replace('_', ' ', ucfirst($laporan->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada laporan yang masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                {{-- TAMPILAN DASHBOARD UNTUK USER BIASA --}}
                
                <div class="mb-6">
                    <a href="{{ route('pelaporan.create') }}" class="inline-flex items-center bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Buat Laporan Baru
                    </a>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4">
                        <h3 class="font-semibold text-lg text-gray-800 mb-2 sm:mb-0">Riwayat Laporan Anda</h3>
                        <a href="{{ route('pelaporan.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                             <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sarana</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($laporanUser as $laporan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $laporan->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $laporan->sarana }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $laporan->lokasi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($laporan->status == 'verifikasi') bg-yellow-100 text-yellow-800 @endif
                                                @if($laporan->status == 'dalam_perbaikan') bg-blue-100 text-blue-800 @endif
                                                @if($laporan->status == 'selesai') bg-green-100 text-green-800 @endif
                                            ">
                                                {{ str_replace('_', ' ', ucfirst($laporan->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Anda belum pernah membuat laporan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
            @endif

        </div>
    </div>
</x-app-layout>

{{-- [BARU] Script SweetAlert untuk menangkap pesan session --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 1500, 
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}'
    });
</script>
@endif