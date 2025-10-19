<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Catatan Pemeliharaan Darurat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- [PERBAIKAN] Mengarahkan form ke route 'store' --}}
                    <form method="POST" action="{{ route('pemeliharaan-darurat.store') }}" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                <x-input-label for="tanggal_pemeliharaan" :value="__('Tanggal Pemeliharaan')" />
                                <x-text-input id="tanggal_pemeliharaan" class="block mt-1 w-full" type="date" name="tanggal_pemeliharaan" :value="old('tanggal_pemeliharaan', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_pemeliharaan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_seharusnya" :value="__('Jadwal Seharusnya (Opsional)')" />
                                <x-text-input id="tanggal_seharusnya" class="block mt-1 w-full" type="date" name="tanggal_seharusnya" :value="old('tanggal_seharusnya')" />
                                <x-input-error :messages="$errors->get('tanggal_seharusnya')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="sarana" :value="__('Nama Sarana')" />
                            <x-text-input id="sarana" class="block mt-1 w-full" type="text" name="sarana" :value="old('sarana')" required autofocus placeholder="Contoh: AC, Proyektor"/>
                            <x-input-error :messages="$errors->get('sarana')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required placeholder="Contoh: Ruang A, Lantai 1"/>
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="deskripsi_kerusakan" :value="__('Deskripsi Kerusakan')" />
                            <textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan kerusakan yang terjadi...">{{ old('deskripsi_kerusakan') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kerusakan')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('pemeliharaan-darurat.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Batal</a>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>