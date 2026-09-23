<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    Perbarui Jadwal Pemeliharaan Rutin
                </h2>
                <p class="text-xs text-gray-500 mt-1">Kelola data jadwal dan riwayat catatan teknis pemeliharaan</p>
            </div>
            <a href="{{ route('pemeliharaan-rutin.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-gray-300 rounded-md text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm self-start sm:self-auto">
                &larr; Kembali ke Jadwal
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Form Perbarui Jadwal --}}
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 sm:p-8">
                <div class="mb-6 pb-4 border-b border-gray-100">
                    <h3 class="font-heading font-bold text-base sm:text-lg text-gray-900">Detail Jadwal Sarana</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Ubah sarana, lokasi, frekuensi, atau status pelaksanaan pemeliharaan</p>
                </div>

                <form method="POST" action="{{ route('pemeliharaan-rutin.update', $jadwal->id) }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="sarana" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Nama Sarana <span class="text-red-500">*</span>
                            </label>
                            <input id="sarana" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3.5 py-2.5 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" name="sarana" :value="old('sarana', $jadwal->sarana)" required autofocus />
                            <x-input-error :messages="$errors->get('sarana')" class="mt-1" />
                        </div>

                        <div>
                            <label for="lokasi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Lokasi <span class="text-red-500">*</span>
                            </label>
                            <input id="lokasi" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3.5 py-2.5 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" name="lokasi" :value="old('lokasi', $jadwal->lokasi)" required />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-1" />
                        </div>

                        <div>
                            <label for="frekuensi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Frekuensi Pemeliharaan
                            </label>
                            <select id="frekuensi" name="frekuensi" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2.5 px-3">
                                <option value="Harian" @selected(old('frekuensi', $jadwal->frekuensi) == 'Harian')>Harian</option>
                                <option value="Mingguan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Mingguan')>Mingguan</option>
                                <option value="Bulanan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Bulanan')>Bulanan</option>
                                <option value="Per 3 Bulan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Per 3 Bulan')>Per 3 Bulan</option>
                                <option value="Per 6 Bulan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Per 6 Bulan')>Per 6 Bulan</option>
                                <option value="Tahunan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Tahunan')>Tahunan</option>
                            </select>
                            <x-input-error :messages="$errors->get('frekuensi')" class="mt-1" />
                        </div>

                        <div>
                            <label for="tanggal_berikutnya" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Tanggal Berikutnya <span class="text-red-500">*</span>
                            </label>
                            <input id="tanggal_berikutnya" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3" type="date" name="tanggal_berikutnya" :value="old('tanggal_berikutnya', $jadwal->tanggal_berikutnya)" required />
                            <x-input-error :messages="$errors->get('tanggal_berikutnya')" class="mt-1" />
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="status" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Status Pelaksanaan
                            </label>
                            <select id="status" name="status" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2.5 px-3">
                                <option value="Terjadwal" @selected(old('status', $jadwal->status) == 'Terjadwal')>Terjadwal</option>
                                <option value="Selesai" @selected(old('status', $jadwal->status) == 'Selesai')>Selesai</option>
                                <option value="Ditangguhkan" @selected(old('status', $jadwal->status) == 'Ditangguhkan')>Ditangguhkan</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-1" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('pemeliharaan-rutin.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-teal-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wider hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Bagian Catatan Pemeliharaan (Flatted, No Card Inside Card) --}}
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6">
                <div>
                    <h3 class="font-heading font-bold text-base sm:text-lg text-gray-900">Catatan Pemeliharaan</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Riwayat hasil pemeriksaan dan catatan teknis lapangan</p>
                </div>

                {{-- Form Tambah Catatan (Seamless layout without nested card border) --}}
                <form method="POST" action="{{ route('catatan-pemeliharaan.store') }}" class="space-y-4 pt-2">
                    @csrf
                    <input type="hidden" name="pemeliharaan_rutin_id" value="{{ $jadwal->id }}">

                    <div>
                        <label for="judul" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Judul Catatan</label>
                        <input id="judul" name="judul" type="text" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm px-3.5 py-2.5 focus:border-teal-500 focus:ring-teal-500 shadow-sm" required placeholder="Contoh: Pembersihan filter AC dan pengecekan freon" />
                        <x-input-error :messages="$errors->get('judul')" class="mt-1" />
                    </div>

                    <div>
                        <label for="isi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Rincian Catatan</label>
                        <textarea id="isi" name="isi" rows="3" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm p-3.5 focus:border-teal-500 focus:ring-teal-500 shadow-sm" placeholder="Jelaskan kondisi sebelum dan sesudah pelaksanaan, atau rekomendasi teknis..."></textarea>
                        <x-input-error :messages="$errors->get('isi')" class="mt-1" />
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-md text-xs font-semibold uppercase tracking-wider transition-colors shadow-sm">
                            Tambah Catatan
                        </button>
                    </div>
                </form>

                {{-- Daftar Catatan Terlampir (Clean dividers, no nested cards) --}}
                <div class="pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-heading font-bold text-gray-800 mb-4">Riwayat Catatan Terlampir</h4>
                    <div class="divide-y divide-gray-100">
                        @forelse ($jadwal->catatans as $catatan)
                            <div class="py-3.5 first:pt-0 last:pb-0">
                                <p class="font-semibold text-gray-900 text-sm">{{ $catatan->judul }}</p>
                                <p class="text-xs sm:text-sm text-gray-600 mt-1 whitespace-pre-wrap leading-relaxed">{{ $catatan->isi }}</p>
                                <p class="text-[11px] text-gray-400 mt-2">
                                    Dicatat oleh <span class="font-medium text-gray-600">{{ $catatan->user->name }}</span> pada {{ $catatan->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                                </p>
                            </div>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-400 italic py-4 text-center">Belum ada catatan aktivitas untuk jadwal ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>