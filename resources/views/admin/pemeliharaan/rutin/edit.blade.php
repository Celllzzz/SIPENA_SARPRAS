<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Jadwal Pemeliharaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Jadwal</h3>
                    <form method="POST" action="{{ route('pemeliharaan-rutin.update', $jadwal->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="sarana" :value="__('Nama Sarana')" />
                                <x-text-input id="sarana" class="block mt-1 w-full" type="text" name="sarana" :value="old('sarana', $jadwal->sarana)" required autofocus />
                                <x-input-error :messages="$errors->get('sarana')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="lokasi" :value="__('Lokasi')" />
                                <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi', $jadwal->lokasi)" required />
                                <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="frekuensi" :value="__('Frekuensi Pemeliharaan')" />
                                <select id="frekuensi" name="frekuensi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Harian" @selected(old('frekuensi', $jadwal->frekuensi) == 'Harian')>Harian</option>
                                    <option value="Mingguan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Mingguan')>Mingguan</option>
                                    <option value="Bulanan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Bulanan')>Bulanan</option>
                                    <option value="Per 3 Bulan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Per 3 Bulan')>Per 3 Bulan</option>
                                    <option value="Per 6 Bulan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Per 6 Bulan')>Per 6 Bulan</option>
                                    <option value="Tahunan" @selected(old('frekuensi', $jadwal->frekuensi) == 'Tahunan')>Tahunan</option>
                                </select>
                                <x-input-error :messages="$errors->get('frekuensi')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_berikutnya" :value="__('Tanggal Pemeliharaan Berikutnya')" />
                                <x-text-input id="tanggal_berikutnya" class="block mt-1 w-full" type="date" name="tanggal_berikutnya" :value="old('tanggal_berikutnya', $jadwal->tanggal_berikutnya)" required />
                                <x-input-error :messages="$errors->get('tanggal_berikutnya')" class="mt-2" />
                            </div>
                             <div class="col-span-1 md:col-span-2">
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Terjadwal" @selected(old('status', $jadwal->status) == 'Terjadwal')>Terjadwal</option>
                                    <option value="Selesai" @selected(old('status', $jadwal->status) == 'Selesai')>Selesai</option>
                                    <option value="Ditangguhkan" @selected(old('status', $jadwal->status) == 'Ditangguhkan')>Ditangguhkan</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('pemeliharaan-rutin.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Kembali</a>
                            <x-primary-button>Update Jadwal</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Catatan Pemeliharaan</h3>
                    <form method="POST" action="{{ route('catatan-pemeliharaan.store') }}" class="mb-6 p-4 border rounded-lg space-y-4">
                        @csrf
                        <input type="hidden" name="pemeliharaan_rutin_id" value="{{ $jadwal->id }}">
                        <div>
                            <x-input-label for="judul" value="Judul Catatan" />
                            <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" required placeholder="Contoh: Pengecekan Awal" />
                             <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="isi" value="Isi Catatan" />
                            <textarea id="isi" name="isi" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan detail pengecekan atau perbaikan..."></textarea>
                             <x-input-error :messages="$errors->get('isi')" class="mt-2" />
                        </div>
                        <div class="text-right">
                            <x-primary-button>Tambah Catatan</x-primary-button>
                        </div>
                    </form>

                    <h4 class="text-md font-medium text-gray-800 mb-4">Riwayat Catatan</h4>
                    <div class="space-y-4">
                        @forelse ($jadwal->catatans as $catatan)
                            <div class="border-b pb-4">
                                <p class="font-semibold text-gray-800">{{ $catatan->judul }}</p>
                                <p class="text-gray-600 mt-1 whitespace-pre-wrap">{{ $catatan->isi }}</p>
                                <p class="text-xs text-gray-400 mt-2">Dicatat oleh {{ $catatan->user->name }} pada {{ $catatan->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada catatan untuk jadwal ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>