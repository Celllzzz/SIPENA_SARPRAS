<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    {{ __('Detail & Tindak Lanjut Laporan') }}
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Pembaruan status pengerjaan, estimasi biaya, dan catatan teknisi
                </p>
            </div>
            <a href="{{ route('tindak-lanjut.index') }}" class="text-xs sm:text-sm font-semibold text-teal-700 hover:text-teal-800 transition-colors">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                {{-- Kolom Kiri: Detail Laporan & Riwayat Log (Flat Layout) --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Detail Laporan --}}
                    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-5 sm:p-6">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200 mb-4">
                            <div>
                                <h2 class="font-heading font-bold text-base sm:text-lg text-gray-900">Informasi Laporan</h2>
                                <p class="text-xs text-gray-500">Pelapor: <strong class="text-gray-800">{{ $pelaporan->user->name ?? '-' }}</strong></p>
                            </div>
                            <x-ui.badge :type="$pelaporan->status">
                                {{ str_replace('_', ' ', ucfirst($pelaporan->status)) }}
                            </x-ui.badge>
                        </div>

                        <div class="space-y-3.5 text-xs sm:text-sm">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-3 border-b border-gray-100">
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Sarana / Prasarana</span>
                                    <span class="font-semibold text-gray-900 mt-0.5 block">{{ $pelaporan->sarana }}</span>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Lokasi</span>
                                    <span class="font-semibold text-gray-900 mt-0.5 block">{{ $pelaporan->lokasi }}</span>
                                </div>
                            </div>

                            <div class="pb-3 border-b border-gray-100">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Deskripsi Kerusakan</span>
                                <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $pelaporan->deskripsi }}</p>
                            </div>

                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Lampiran Bukti</span>
                                @if ($pelaporan->bukti)
                                    @php
                                        $fileExtension = strtolower(pathinfo($pelaporan->bukti, PATHINFO_EXTENSION));
                                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                    @endphp
                                    @if (in_array($fileExtension, $imageExtensions))
                                        <div class="cursor-pointer inline-block overflow-hidden rounded-md border border-gray-200 max-w-sm shadow-sm" onclick="showImageModal(`{{ asset($pelaporan->bukti) }}`)">
                                            <img src="{{ asset($pelaporan->bukti) }}" class="w-full h-auto max-h-56 object-cover" alt="Bukti {{ $pelaporan->sarana }}">
                                        </div>
                                        <p class="text-[11px] text-gray-400 mt-1">Klik gambar untuk memperbesar</p>
                                    @else
                                        <a href="{{ asset($pelaporan->bukti) }}" target="_blank" class="inline-flex items-center px-3.5 py-1.5 rounded-md border border-teal-200 bg-teal-50 text-teal-700 hover:bg-teal-100 transition-colors text-xs font-semibold">
                                            Buka Berkas Bukti
                                        </a>
                                    @endif
                                @else
                                    <p class="text-xs text-gray-400 italic">Tidak ada berkas bukti yang dilampirkan.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Riwayat Log Aktivitas --}}
                    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-5 sm:p-6">
                        <h2 class="font-heading font-bold text-base sm:text-lg text-gray-900 mb-4">
                            Riwayat Log Tindak Lanjut
                        </h2>
                        <div class="relative border-l-2 border-teal-600 ml-2 pl-4 space-y-4">
                            @forelse ($pelaporan->logs as $log)
                                <div class="relative">
                                    <div class="absolute -left-[21px] top-1.5 h-2.5 w-2.5 rounded-md bg-teal-600"></div>
                                    <p class="text-xs sm:text-sm font-medium text-gray-800">{{ $log->aktivitas }}</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">
                                        {{ $log->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                                    </p>
                                </div>
                            @empty
                                <div class="relative">
                                    <div class="absolute -left-[21px] top-1.5 h-2.5 w-2.5 rounded-md bg-gray-300"></div>
                                    <p class="text-xs text-gray-400 italic">Belum ada catatan aktivitas.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Form Tindak Lanjut (Sticky) --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-20 bg-white rounded-md shadow-sm border border-gray-200 p-5 sm:p-6">
                        <div class="pb-3 border-b border-gray-200 mb-4">
                            <h2 class="font-heading font-bold text-base text-gray-900">Formulir Tindak Lanjut</h2>
                            <p class="text-xs text-gray-500">Perbarui status laporan dan biaya perbaikan</p>
                        </div>
                        
                        <form action="{{ route('tindak-lanjut.update', $pelaporan->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="status" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                    Status Laporan <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" class="block w-full border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3">
                                    <option value="verifikasi" @selected($pelaporan->status == 'verifikasi')>Verifikasi</option>
                                    <option value="dalam_perbaikan" @selected($pelaporan->status == 'dalam_perbaikan')>Dalam Perbaikan</option>
                                    <option value="selesai" @selected($pelaporan->status == 'selesai')>Selesai</option>
                                </select>
                            </div>

                            <div>
                                <label for="biaya" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                    Biaya Perbaikan (Rp)
                                </label>
                                <div class="flex rounded-md shadow-sm border border-gray-300 overflow-hidden focus-within:border-teal-500 focus-within:ring-1 focus-within:ring-teal-500">
                                    <span class="inline-flex items-center px-3 bg-gray-50 text-gray-500 text-xs font-bold border-r border-gray-300">
                                        Rp
                                    </span>
                                    <input type="text" id="biaya" name="biaya" value="{{ old('biaya', number_format($pelaporan->biaya_perbaikan, 0, ',', '.')) }}" class="w-full px-3 py-2 border-0 focus:ring-0 text-xs sm:text-sm text-gray-900" placeholder="0" />
                                </div>
                            </div>

                            <div>
                                <label for="catatan" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                    Catatan Penanganan
                                </label>
                                <textarea id="catatan" name="catatan" rows="4" class="block w-full border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm p-3" placeholder="Tuliskan tindakan yang dilakukan atau nama teknisi...">{{ old('catatan', $pelaporan->catatan) }}</textarea>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                                <a href="{{ route('tindak-lanjut.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wider hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition shadow-sm">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
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

    document.addEventListener('DOMContentLoaded', function(){
        const biayaInput = document.getElementById('biaya');
        if (biayaInput) {
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
        }
    });
</script>