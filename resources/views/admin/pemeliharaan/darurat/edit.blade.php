<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Pemeliharaan Darurat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pemeliharaan-darurat.update', $pemeliharaan->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_pemeliharaan" :value="__('Tanggal Pemeliharaan')" />
                                <x-text-input id="tanggal_pemeliharaan" class="block mt-1 w-full" type="date" name="tanggal_pemeliharaan" :value="old('tanggal_pemeliharaan', $pemeliharaan->tanggal_pemeliharaan)" required />
                                <x-input-error :messages="$errors->get('tanggal_pemeliharaan')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="tanggal_seharusnya" :value="__('Jadwal Seharusnya (Opsional)')" />
                                <x-text-input id="tanggal_seharusnya" class="block mt-1 w-full" type="date" name="tanggal_seharusnya" :value="old('tanggal_seharusnya', $pemeliharaan->tanggal_seharusnya)" />
                                <x-input-error :messages="$errors->get('tanggal_seharusnya')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="sarana" :value="__('Nama Sarana')" />
                            <x-text-input id="sarana" class="block mt-1 w-full" type="text" name="sarana" :value="old('sarana', $pemeliharaan->sarana)" required autofocus />
                            <x-input-error :messages="$errors->get('sarana')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi', $pemeliharaan->lokasi)" required />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="deskripsi_kerusakan" :value="__('Deskripsi Kerusakan')" />
                            <textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi_kerusakan', $pemeliharaan->deskripsi_kerusakan) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kerusakan')" class="mt-2" />
                        </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Dalam Pengerjaan" @selected(old('status', $pemeliharaan->status) == 'Dalam Pengerjaan')>Dalam Pengerjaan</option>
                                    <option value="Selesai" @selected(old('status', $pemeliharaan->status) == 'Selesai')>Selesai</option>
                                </select>
                                 <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="biaya" :value="__('Biaya Perbaikan (Rp)')" />
                                <x-text-input id="biaya" class="block mt-1 w-full" type="number" name="biaya" :value="old('biaya', $pemeliharaan->biaya)" placeholder="Contoh: 50000" />
                                <x-input-error :messages="$errors->get('biaya')" class="mt-2" />
                            </div>
                        </div>
                         <div>
                            <x-input-label for="catatan_perbaikan" :value="__('Catatan Perbaikan')" />
                            <textarea id="catatan_perbaikan" name="catatan_perbaikan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan_perbaikan', $pemeliharaan->catatan_perbaikan) }}</textarea>
                            <x-input-error :messages="$errors->get('catatan_perbaikan')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('pemeliharaan-darurat.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Batal</a>
                            <x-primary-button>Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>