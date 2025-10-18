<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail & Tindak Lanjut Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <div class="lg:col-span-2 space-y-8">
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Laporan</h3>
                                <div class="space-y-4 border rounded-lg p-4">
                                    <div>
                                        <x-input-label :value="__('Nama Pelapor')" />
                                        <x-text-input class="block mt-1 w-full bg-gray-100" type="text" :value="$pelaporan->user->name ?? '-'" disabled />
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Nama Sarana')" />
                                        <x-text-input class="block mt-1 w-full bg-gray-100" type="text" :value="$pelaporan->sarana" disabled />
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Lokasi')" />
                                        <x-text-input class="block mt-1 w-full bg-gray-100" type="text" :value="$pelaporan->lokasi" disabled />
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Deskripsi Kerusakan')" />
                                        <textarea class="block mt-1 w-full border-gray-300 rounded-md shadow-sm bg-gray-100" disabled rows="4">{{ $pelaporan->deskripsi }}</textarea>
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Bukti')" />
                                        @if ($pelaporan->bukti)
                                            @php
                                                $fileExtension = strtolower(pathinfo($pelaporan->bukti, PATHINFO_EXTENSION));
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                            @endphp
                                            @if (in_array($fileExtension, $imageExtensions))
                                                <img src="{{ asset('storage/' . $pelaporan->bukti) }}" alt="Bukti" class="mt-1 w-full max-w-sm h-auto object-cover rounded-md cursor-pointer" onclick="showImageModal(`{{ asset('storage/' . $pelaporan->bukti) }}`)">
                                            @else
                                                <a href="{{ asset('storage/' . $pelaporan->bukti) }}" target="_blank" class="mt-1 inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                                                    <span>Lihat File Bukti</span>
                                                </a>
                                            @endif
                                        @else
                                            <p class="mt-1 text-sm text-gray-500 italic">Tidak ada bukti yang dilampirkan.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Log Aktivitas</h3>
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

                        <div class="lg:col-span-1">
                            <div class="sticky top-24">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Form Tindak Lanjut</h3>
                                <form action="{{ route('tindak-lanjut.update', $pelaporan->id) }}" method="POST" class="space-y-6 border rounded-lg p-4">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <x-input-label for="status" :value="__('Ubah Status Laporan')" />
                                        <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="verifikasi" @selected($pelaporan->status == 'verifikasi')>Verifikasi</option>
                                            <option value="dalam_perbaikan" @selected($pelaporan->status == 'dalam_perbaikan')>Dalam Perbaikan</option>
                                            <option value="selesai" @selected($pelaporan->status == 'selesai')>Selesai</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="biaya" :value="__('Biaya Perbaikan (Rp)')" />
                                        <x-text-input id="biaya" class="block mt-1 w-full" type="text" name="biaya" :value="old('biaya', number_format($pelaporan->biaya_perbaikan, 0, ',', '.'))" placeholder="Contoh: 50.000" />
                                    </div>
                                    <div>
                                        <x-input-label for="catatan" :value="__('Catatan Perbaikan')" />
                                        <textarea id="catatan" name="catatan" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan tindakan yang telah dilakukan...">{{ old('catatan', $pelaporan->catatan) }}</textarea>
                                    </div>
                                    <div class="flex items-center justify-end gap-4 pt-4">
                                        <a href="{{ route('tindak-lanjut.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                            {{ __('Kembali') }}
                                        </a>
                                        <x-primary-button>
                                            {{ __('Update Laporan') }}
                                        </x-primary-button>
                                    </div>
                                </form>
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

    // Script untuk format Rupiah otomatis
    document.addEventListener('DOMContentLoaded', function(){
        const biayaInput = document.getElementById('biaya');

        biayaInput.addEventListener('keyup', function(e) {
            let angka = this.value.replace(/[^,\d]/g, '').toString();
            let split = angka.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            this.value = rupiah;
        });
    });
</script>