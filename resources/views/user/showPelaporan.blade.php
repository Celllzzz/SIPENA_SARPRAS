<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    {{ __('Detail Laporan Kerusakan') }}
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Informasi lengkap mengenai laporan dan riwayat tindakan
                </p>
            </div>
            <a href="{{ route('pelaporan.index') }}" class="text-xs sm:text-sm font-semibold text-teal-700 hover:text-teal-800 transition-colors">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
                
                {{-- Header Rincian --}}
                <div class="p-4 sm:p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-gray-50/50">
                    <div>
                        <span class="text-xs text-gray-500">Sarana / Prasarana:</span>
                        <h2 class="text-lg font-heading font-bold text-gray-900">{{ $pelaporan->sarana }}</h2>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500">Status:</span>
                        <x-ui.badge :type="$pelaporan->status">
                            {{ str_replace('_', ' ', ucfirst($pelaporan->status)) }}
                        </x-ui.badge>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    {{-- Flat Layout Tanpa Card Dalam Card --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        {{-- Kolom Kiri: Informasi Laporan & Bukti --}}
                        <div class="lg:col-span-2 space-y-6">
                            <div class="space-y-4 text-sm">
                                <div class="border-b border-gray-100 pb-3">
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Lokasi Sarana</span>
                                    <p class="font-medium text-gray-800 mt-1">{{ $pelaporan->lokasi }}</p>
                                </div>

                                <div class="border-b border-gray-100 pb-3">
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Tanggal Pelaporan</span>
                                    <p class="text-gray-700 mt-1">
                                        {{ $pelaporan->created_at->timezone('Asia/Makassar')->format('d F Y, H:i') }} WITA
                                    </p>
                                </div>

                                <div class="border-b border-gray-100 pb-3">
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Deskripsi Kerusakan</span>
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $pelaporan->deskripsi }}</p>
                                </div>
                            </div>

                            {{-- Bukti Kerusakan --}}
                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Berkas / Foto Bukti</span>
                                @if ($pelaporan->bukti)
                                    @php
                                        $fileExtension = strtolower(pathinfo($pelaporan->bukti, PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                    @endphp
                                    @if (in_array($fileExtension, $imageExtensions))
                                        <div class="cursor-pointer inline-block overflow-hidden rounded-md border border-gray-200 max-w-sm shadow-sm" onclick="showImageModal(`{{ asset($pelaporan->bukti) }}`)">
                                            <img src="{{ asset($pelaporan->bukti) }}" class="w-full h-auto max-h-64 object-cover" alt="Bukti {{ $pelaporan->sarana }}">
                                        </div>
                                        <p class="text-[11px] text-gray-400 mt-1">Klik gambar untuk memperbesar</p>
                                    @else
                                        <a href="{{ asset($pelaporan->bukti) }}" target="_blank" class="inline-flex items-center px-4 py-2 rounded-md border border-teal-200 bg-teal-50 text-teal-700 hover:bg-teal-100 transition-colors text-xs font-semibold">
                                            Unduh / Buka Dokumen Bukti
                                        </a>
                                    @endif
                                @else
                                    <p class="text-xs text-gray-400 italic">Tidak ada berkas bukti yang dilampirkan.</p>
                                @endif
                            </div>
                        </div>

                        {{-- Kolom Kanan: Log Aktivitas & Progres --}}
                        <div class="border-t lg:border-t-0 lg:border-l border-gray-200 pt-6 lg:pt-0 lg:pl-8">
                            <h3 class="text-sm font-heading font-bold text-gray-900 mb-4">
                                Riwayat Log Aktivitas
                            </h3>

                            <div class="relative border-l-2 border-teal-600 ml-2 pl-4 space-y-5">
                                @forelse ($pelaporan->logs as $log)
                                    <div class="relative">
                                        <div class="absolute -left-[21px] top-1.5 h-2.5 w-2.5 rounded-md bg-teal-600"></div>
                                        <p class="text-xs sm:text-sm font-medium text-gray-800 leading-snug">{{ $log->aktivitas }}</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">
                                            {{ $log->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                                        </p>
                                    </div>
                                @empty
                                    <div class="relative">
                                        <div class="absolute -left-[21px] top-1.5 h-2.5 w-2.5 rounded-md bg-gray-300"></div>
                                        <p class="text-xs text-gray-400 italic">Belum ada riwayat penanganan untuk laporan ini.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
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