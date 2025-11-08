<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Laporan Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Detail Laporan</h3>
                            <p class="text-sm text-gray-600 mt-1">Sarana: <strong>{{ $pelaporan->sarana }}</strong></p>
                        </div>
                        <a href="{{ route('pelaporan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Kembali
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-600">Lokasi</h4>
                                <p>{{ $pelaporan->lokasi }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-600">Deskripsi Kerusakan</h4>
                                <p>{{ $pelaporan->deskripsi }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-600">Bukti</h4>
                                @if ($pelaporan->bukti)
                                    @php
                                        $fileExtension = strtolower(pathinfo($pelaporan->bukti, PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                    @endphp
                                    @if (in_array($fileExtension, $imageExtensions))
                                        <img src="{{ asset($pelaporan->bukti) }}" class="mt-1 w-full max-w-sm h-auto object-cover rounded-md cursor-pointer" onclick="showImageModal(`{{ asset($pelaporan->bukti) }}`)">
                                    @else
                                        <a href="{{ asset($pelaporan->bukti) }}" target="_blank" class="mt-1 inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                                            <span>Lihat File Bukti</span>
                                        </a>
                                    @endif
                                @else
                                    <p class="mt-1 text-sm text-gray-500 italic">Tidak ada bukti.</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-semibold text-gray-600 mb-4">Log Aktivitas</h4>
                            <div class="border-l-2 border-gray-200 pl-6 space-y-6">
                                @forelse ($pelaporan->logs as $log)
                                    <div class="relative">
                                        <div class="absolute -left-[30px] top-1 h-2.5 w-2.5 rounded-full bg-gray-400 ring-4 ring-white"></div>
                                        <p class="text-sm text-gray-800">{{ $log->aktivitas }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 italic">Belum ada aktivitas.</p>
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
            imageAlt: 'Bukti Laporan',
            confirmButtonText: 'Tutup'
        });
    }
</script>