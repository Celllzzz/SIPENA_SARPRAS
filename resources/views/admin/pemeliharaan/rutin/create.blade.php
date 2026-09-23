<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    {{ __('Tambah Jadwal Pemeliharaan Baru') }}
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Jadwalkan pemeriksaan dan servis sarana secara berkala
                </p>
            </div>
            <a href="{{ route('pemeliharaan-rutin.index') }}" class="text-xs sm:text-sm font-semibold text-teal-700 hover:text-teal-800 transition-colors">
                &larr; Kembali ke Jadwal
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 sm:p-8">
                <div class="mb-6">
                    <h2 class="font-heading font-bold text-base sm:text-lg text-gray-900">Formulir Jadwal Pemeliharaan Rutin</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Tentukan sarana, frekuensi pemeriksaan, dan tanggal pelaksanaan servis.</p>
                </div>

                <form method="POST" action="{{ route('pemeliharaan-rutin.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="sarana" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Nama Sarana / Prasarana <span class="text-red-500">*</span>
                        </label>
                        <input id="sarana" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3 py-2 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" name="sarana" value="{{ old('sarana') }}" required autofocus placeholder="Contoh: AC Ruang Guru, Genset Utama" />
                        <x-input-error :messages="$errors->get('sarana')" class="mt-1" />
                    </div>

                    <div>
                        <label for="lokasi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input id="lokasi" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3 py-2 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="text" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Gedung A Lantai 1" />
                        <x-input-error :messages="$errors->get('lokasi')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="frekuensi" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Frekuensi Pemeriksaan
                            </label>
                            <select id="frekuensi" name="frekuensi" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3 bg-white">
                                <option value="Harian" @selected(old('frekuensi') == 'Harian')>Harian</option>
                                <option value="Mingguan" @selected(old('frekuensi') == 'Mingguan')>Mingguan</option>
                                <option value="Bulanan" @selected(old('frekuensi') == 'Bulanan')>Bulanan</option>
                                <option value="Per 3 Bulan" @selected(old('frekuensi') == 'Per 3 Bulan')>Per 3 Bulan</option>
                                <option value="Per 6 Bulan" @selected(old('frekuensi') == 'Per 6 Bulan')>Per 6 Bulan</option>
                                <option value="Tahunan" @selected(old('frekuensi') == 'Tahunan')>Tahunan</option>
                            </select>
                            <x-input-error :messages="$errors->get('frekuensi')" class="mt-1" />
                        </div>

                        <div>
                            <label for="tanggal_berikutnya" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                                Tanggal Berikutnya <span class="text-red-500">*</span>
                            </label>
                            <input id="tanggal_berikutnya" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm focus:border-teal-500 focus:ring-teal-500 shadow-sm py-2 px-3" type="date" name="tanggal_berikutnya" value="{{ old('tanggal_berikutnya') }}" required />
                            <x-input-error :messages="$errors->get('tanggal_berikutnya')" class="mt-1" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('pemeliharaan-rutin.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2 bg-teal-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wider hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition shadow-sm">
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>