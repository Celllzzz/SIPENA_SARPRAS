<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Card: You’re logged in --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

                @if(Auth::user()->role === 'admin')
                    {{-- UNTUK ADMIN --}}

                    {{-- Card Dropdown: Laporan Kerusakan --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="block w-full p-6 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition text-center focus:outline-none">
                            Laporan Kerusakan
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute z-50 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('pelaporan.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">➕ Buat Laporan Baru</a>
                                <a href="{{ route('pelaporan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">📑 Lihat Laporan</a>
                                <a href="{{ route('tindak-lanjut.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">🛠️ Tindak Lanjut</a>
                            </div>
                        </div>
                    </div>

                    {{-- Card Dropdown: Rencana Pemeliharaan --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="block w-full p-6 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition text-center focus:outline-none">
                            Rencana Pemeliharaan
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute z-50 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('pemeliharaan.rutin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">🗓️ Pemeliharaan Rutin</a>
                                <a href="{{ route('pemeliharaan.darurat') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">🚨 Pemeliharaan Darurat</a>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Kelola Admin --}}
                    <a href="{{ route('admin.index') }}" class="block p-6 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition text-center">
                        👤 Kelola Admin
                    </a>

                    {{-- Card: Notifikasi (BARU) --}}
                    <a href="{{ route('notifikasi.index') }}" class="block p-6 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition text-center">
                        🔔 Notifikasi
                    </a>
                
                    {{-- Card: Ekspor PDF (BARU) --}}
                    <a href="{{ route('ekspor.index') }}" class="block p-6 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800 transition text-center">
                        📄 Ekspor PDF
                    </a>

                @else
                    {{-- UNTUK USER BIASA: Tampilan tetap sama --}}
                    <a href="{{ route('pelaporan.create') }}" class="block p-6 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition text-center">
                        ➕ Buat Laporan Baru
                    </a>
                    <a href="{{ route('pelaporan.index') }}" class="block p-6 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition text-center">
                        📑 Lihat Laporan
                    </a>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>