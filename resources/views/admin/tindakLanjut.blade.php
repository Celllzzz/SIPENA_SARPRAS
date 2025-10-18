<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tindak Lanjut Laporan Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Detail Laporan</h3>
                            <p class="text-sm text-gray-600 mb-6">Informasi yang dilaporkan oleh pengguna.</p>
                            
                            {{-- ... (Isi detail laporan tidak berubah) ... --}}
                            <div class="space-y-4">
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
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Form Tindak Lanjut</h3>
                            <p class="text-sm text-gray-600 mb-6">Update status, biaya, dan berikan catatan perbaikan.</p>

                            <form action="{{ route('tindak-lanjut.update', $pelaporan->id) }}" method="POST" class="space-y-6">
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
                                    <x-text-input id="biaya" class="block mt-1 w-full" type="number" name="biaya" :value="old('biaya', $pelaporan->biaya_perbaikan)" placeholder="Contoh: 50000" />
                                </div>

                                <div>
                                    <x-input-label for="catatan" :value="__('Catatan Perbaikan')" />
                                    <textarea id="catatan" name="catatan" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan tindakan yang telah dilakukan...">{{ old('catatan', $pelaporan->catatan) }}</textarea>
                                </div>

                                <div class="flex items-center justify-end gap-4 pt-4">
                                    <a href="{{ route('tindak-lanjut.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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