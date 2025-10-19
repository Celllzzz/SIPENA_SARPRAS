<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Pemeliharaan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pemeliharaan-rutin.store') }}" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="sarana" :value="__('Nama Sarana')" />
                            <x-text-input id="sarana" class="block mt-1 w-full" type="text" name="sarana" :value="old('sarana')" required autofocus placeholder="Contoh: AC, Proyektor"/>
                            <x-input-error :messages="$errors->get('sarana')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required placeholder="Contoh: Semua Ruang Kelas"/>
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="frekuensi" :value="__('Frekuensi Pemeliharaan')" />
                            <select id="frekuensi" name="frekuensi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Harian" @selected(old('frekuensi') == 'Harian')>Harian</option>
                                <option value="Mingguan" @selected(old('frekuensi') == 'Mingguan')>Mingguan</option>
                                <option value="Bulanan" @selected(old('frekuensi') == 'Bulanan')>Bulanan</option>
                                <option value="Per 3 Bulan" @selected(old('frekuensi') == 'Per 3 Bulan')>Per 3 Bulan</option>
                                <option value="Per 6 Bulan" @selected(old('frekuensi') == 'Per 6 Bulan')>Per 6 Bulan</option>
                                <option value="Tahunan" @selected(old('frekuensi') == 'Tahunan')>Tahunan</option>
                            </select>
                            <x-input-error :messages="$errors->get('frekuensi')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="tanggal_berikutnya" :value="__('Tanggal Pemeliharaan Berikutnya')" />
                            <x-text-input id="tanggal_berikutnya" class="block mt-1 w-full" type="date" name="tanggal_berikutnya" :value="old('tanggal_berikutnya')" required />
                            <x-input-error :messages="$errors->get('tanggal_berikutnya')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('pemeliharaan-rutin.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Batal</a>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>