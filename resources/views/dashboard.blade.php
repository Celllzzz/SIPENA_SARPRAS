<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                {{ __('Dasbor SIPENA-SARPRAS') }}
            </h1>
            <p class="text-xs text-gray-500 mt-1">
                Ringkasan data pelaporan kerusakan dan status pemeliharaan fasilitas
            </p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Bar Sambutan Pengguna --}}
            <div class="bg-white border border-gray-200 p-4 sm:px-6 sm:py-4 rounded-md shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-xs text-gray-500 block">Selamat datang kembali,</span>
                    <h2 class="text-lg sm:text-xl font-heading font-bold text-gray-900 mt-0.5">
                        {{ Auth::user()->name }}
                    </h2>
                </div>
                <div class="text-xs text-gray-500 sm:text-right">
                    <span class="font-medium text-gray-800 block capitalize">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                    <span class="text-gray-400">Sistem Pengelolaan Sarana & Prasarana</span>
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
                {{-- TAMPILAN DASHBOARD UNTUK ADMIN --}}
                
                {{-- 1. Kartu KPI Statistik (Warna Solid, Tanpa Gradient, Rounded MD) --}}
                <div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <x-ui.stat-card 
                            title="Total Laporan" 
                            :value="$totalLaporan" 
                            variant="blue" />

                        <x-ui.stat-card 
                            title="Perlu Verifikasi" 
                            :value="$laporanVerifikasi" 
                            variant="amber" />

                        <x-ui.stat-card 
                            title="Dalam Perbaikan" 
                            :value="$laporanDalamPerbaikan" 
                            variant="sky" />

                        <x-ui.stat-card 
                            title="Laporan Selesai" 
                            :value="$laporanSelesai" 
                            variant="emerald" />
                    </div>
                </div>

                {{-- Tabel Laporan Kerusakan Terbaru (Dengan Skeleton Loader) --}}
                <div class="bg-white p-5 sm:p-6 rounded-md shadow-sm border border-gray-200" 
                     x-data="{ tableLoading: true }" 
                     x-init="setTimeout(() => tableLoading = false, 350)">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-4">
                        <div>
                            <h3 class="font-heading font-bold text-base sm:text-lg text-gray-900">Laporan Kerusakan Terbaru</h3>
                            <p class="text-xs text-gray-500">Daftar laporan sarana prasarana yang baru diajukan</p>
                        </div>
                        <a href="{{ route('pelaporan.index') }}" class="text-xs sm:text-sm font-semibold text-teal-700 hover:text-teal-800 transition-colors">
                            Lihat Semua Laporan &rarr;
                        </a>
                    </div>

                    {{-- Skeleton Placeholder saat Memuat --}}
                    <div x-show="tableLoading">
                        <x-ui.skeleton-table :rows="4" />
                    </div>

                    {{-- Tabel Sebenarnya --}}
                    <div x-show="!tableLoading" x-cloak class="overflow-x-auto rounded-md border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sarana</th>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($laporanTerbaru as $laporan)
                                    <tr class="hover:bg-gray-50/70 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-600">{{ $laporan->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-semibold text-gray-900">{{ $laporan->sarana }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-600">{{ $laporan->lokasi }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <x-ui.badge :type="$laporan->status">
                                                {{ str_replace('_', ' ', ucfirst($laporan->status)) }}
                                            </x-ui.badge>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-xs sm:text-sm text-gray-500">
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
                
                <div>
                    <a href="{{ route('pelaporan.create') }}" class="inline-flex items-center justify-center min-h-[42px] bg-teal-600 text-white font-semibold text-xs uppercase tracking-wider py-2.5 px-5 rounded-md shadow-sm hover:bg-teal-700 transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        Buat Laporan Baru
                    </a>
                </div>

                <div class="bg-white p-5 sm:p-6 rounded-md shadow-sm border border-gray-200"
                     x-data="{ tableLoading: true }" 
                     x-init="setTimeout(() => tableLoading = false, 350)">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                        <div>
                            <h3 class="font-heading font-bold text-base sm:text-lg text-gray-900">Riwayat Laporan Anda</h3>
                            <p class="text-xs text-gray-500">Daftar laporan sarana yang telah Anda ajukan</p>
                        </div>
                        <a href="{{ route('pelaporan.index') }}" class="text-xs sm:text-sm font-semibold text-teal-700 hover:text-teal-800 transition-colors">
                            Lihat Semua Laporan &rarr;
                        </a>
                    </div>

                    {{-- Skeleton Placeholder saat Memuat --}}
                    <div x-show="tableLoading">
                        <x-ui.skeleton-table :rows="3" />
                    </div>

                    {{-- Tabel Sebenarnya --}}
                    <div x-show="!tableLoading" x-cloak class="overflow-x-auto rounded-md border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sarana</th>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th scope="col" class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($laporanUser as $laporan)
                                    <tr class="hover:bg-gray-50/70 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-600">{{ $laporan->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-semibold text-gray-900">{{ $laporan->sarana }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-600">{{ $laporan->lokasi }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <x-ui.badge :type="$laporan->status">
                                                {{ str_replace('_', ' ', ucfirst($laporan->status)) }}
                                            </x-ui.badge>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-xs sm:text-sm text-gray-500">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 1500, 
        showConfirmButton: false,
        confirmButtonColor: '#0D9488'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#0D9488'
    });
</script>
@endif