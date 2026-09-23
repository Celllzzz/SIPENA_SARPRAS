<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    Perbarui Pemeliharaan Darurat
                </h2>
                <p class="text-xs text-gray-500 mt-1">Ubah rincian penanganan, status perbaikan, atau biaya kerusakan sarana</p>
            </div>
            <a href="{{ route('pemeliharaan-darurat.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-gray-300 rounded-md text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm self-start sm:self-auto">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 sm:p-8">
                <div class="mb-6 pb-4 border-b border-gray-100">
                    <h3 class="font-heading font-bold text-base sm:text-lg text-gray-900">Detail Catatan Darurat</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Ubah rincian sarana, status pengerjaan, atau biaya perbaikan sarana</p>
                </div>

                <form method="POST" action="{{ route('pemeliharaan-darurat.update', $pemeliharaan->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_pemeliharaan" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Tanggal Pemeliharaan <span class="text-red-500">*</span>
                            </label>
                            <input id="tanggal_pemeliharaan" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3" type="date" name="tanggal_pemeliharaan" value="{{ old('tanggal_pemeliharaan', $pemeliharaan->tanggal_pemeliharaan) }}" required />
                            <x-input-error :messages="$errors->get('tanggal_pemeliharaan')" class="mt-1" />
                        </div>
                        <div>
                            <label for="tanggal_seharusnya" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Jadwal Seharusnya (Opsional)
                            </label>
                            <input id="tanggal_seharusnya" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3" type="date" name="tanggal_seharusnya" value="{{ old('tanggal_seharusnya', $pemeliharaan->tanggal_seharusnya) }}" />
                            <x-input-error :messages="$errors->get('tanggal_seharusnya')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <label for="sarana" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Nama Sarana <span class="text-red-500">*</span>
                        </label>
                        <input id="sarana" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3.5 py-2.5 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" name="sarana" value="{{ old('sarana', $pemeliharaan->sarana) }}" required autofocus />
                        <x-input-error :messages="$errors->get('sarana')" class="mt-1" />
                    </div>

                    <div>
                        <label for="lokasi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input id="lokasi" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3.5 py-2.5 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" name="lokasi" value="{{ old('lokasi', $pemeliharaan->lokasi) }}" required />
                        <x-input-error :messages="$errors->get('lokasi')" class="mt-1" />
                    </div>

                    <div>
                        <label for="deskripsi_kerusakan" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Deskripsi Kerusakan
                        </label>
                        <textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm p-3">{{ old('deskripsi_kerusakan', $pemeliharaan->deskripsi_kerusakan) }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi_kerusakan')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Status Pengerjaan
                            </label>
                            <select id="status" name="status" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2.5 px-3">
                                <option value="Dalam Pengerjaan" @selected(old('status', $pemeliharaan->status) == 'Dalam Pengerjaan')>Dalam Pengerjaan</option>
                                <option value="Selesai" @selected(old('status', $pemeliharaan->status) == 'Selesai')>Selesai</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-1" />
                        </div>
                        <div>
                            <label for="biaya" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Biaya Perbaikan (Rp)
                            </label>
                            <input id="biaya" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3" type="number" name="biaya" value="{{ old('biaya', $pemeliharaan->biaya) }}" placeholder="0" />
                            <x-input-error :messages="$errors->get('biaya')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <label for="catatan_perbaikan" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Catatan Perbaikan
                        </label>
                        <textarea id="catatan_perbaikan" name="catatan_perbaikan" rows="3" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm p-3" placeholder="Tindakan yang telah diambil...">{{ old('catatan_perbaikan', $pemeliharaan->catatan_perbaikan) }}</textarea>
                        <x-input-error :messages="$errors->get('catatan_perbaikan')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('pemeliharaan-darurat.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-teal-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wider hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>