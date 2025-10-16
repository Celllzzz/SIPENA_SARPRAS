<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tindak Lanjut Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
            <form action="{{ route('tindak-lanjut.update', $pelaporan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold">Nama Pelapor</label>
                    <input type="text" value="{{ $pelaporan->user->name ?? '-' }}" class="w-full border-gray-300 rounded mt-1 bg-gray-100" disabled>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Nama Sarana</label>
                    <input type="text" value="{{ $pelaporan->sarana }}" class="w-full border-gray-300 rounded mt-1 bg-gray-100" disabled>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Lokasi</label>
                    <input type="text" value="{{ $pelaporan->lokasi }}" class="w-full border-gray-300 rounded mt-1 bg-gray-100" disabled>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Deskripsi</label>
                    <textarea class="w-full border-gray-300 rounded mt-1 bg-gray-100" disabled>{{ $pelaporan->deskripsi }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Bukti</label>
                    @if ($pelaporan->bukti)
                        @if (Str::endsWith($pelaporan->bukti, ['jpg','jpeg','png']))
                            <img src="{{ asset('storage/' . $pelaporan->bukti) }}" class="h-32 rounded">
                        @else
                            <a href="{{ asset('storage/' . $pelaporan->bukti) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                        @endif
                    @else
                        <span class="text-gray-500 italic">Tidak ada</span>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Biaya Perbaikan</label>
                    <input type="number" name="biaya" value="{{ old('biaya', $pelaporan->biaya_perbaikan) }}" class="w-full border-gray-300 rounded mt-1">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded mt-1">
                        <option value="verifikasi" {{ $pelaporan->status == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                        <option value="dalam_perbaikan" {{ $pelaporan->status == 'proses' ? 'selected' : '' }}>Dalam Perbaikan</option>
                        <option value="selesai" {{ $pelaporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Catatan</label>
                    <textarea name="catatan" rows="3" class="w-full border-gray-300 rounded mt-1">{{ old('catatan', $pelaporan->catatan) }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('tindak-lanjut.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Kembali</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>