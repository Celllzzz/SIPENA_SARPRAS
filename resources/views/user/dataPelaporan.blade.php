<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pelaporan Kerusakan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">

                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
                        <form method="GET" action="{{ route('pelaporan.index') }}" class="flex items-center text-sm">
                            <label for="per_page" class="mr-2 text-gray-600">Tampilkan</label>
                            <select name="per_page" id="per_page" onchange="this.form.submit()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @foreach([10, 25, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
                            <span class="ml-2 text-gray-600">data</span>
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        </form>

                        <form method="GET" action="{{ route('pelaporan.index') }}" class="w-full sm:w-auto">
                            <div class="relative w-full sm:w-64">
                                <x-text-input type="text" name="search" class="w-full" placeholder="Cari laporan..." value="{{ request('search') }}" />
                                <x-primary-button class="absolute top-0 right-0 h-full">
                                    Cari
                                </x-primary-button>
                            </div>
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                        </form>
                    </div>

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sarana & Lokasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Update Terakhir</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pelaporans as $laporan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ($pelaporans->currentPage() - 1) * $pelaporans->perPage() + $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-medium text-gray-900">{{ $laporan->sarana }}</div>
                                            <div class="text-gray-500">{{ $laporan->lokasi }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($laporan->status == 'verifikasi') bg-yellow-100 text-yellow-800 @endif
                                                @if($laporan->status == 'dalam_perbaikan') bg-blue-100 text-blue-800 @endif
                                                @if($laporan->status == 'selesai') bg-green-100 text-green-800 @endif">
                                                {{ str_replace('_', ' ', ucfirst($laporan->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $laporan->updated_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            <a href="{{ route('pelaporan.show', $laporan->id) }}" class="text-indigo-600 hover:underline">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                            Tidak ada data laporan yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $pelaporans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>