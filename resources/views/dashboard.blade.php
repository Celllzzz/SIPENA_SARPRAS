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

            {{-- Card: Buat & Lihat Laporan --}}
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <a href="{{ route('pelaporan.create') }}" 
                class="block p-6 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition text-center">
                    ➕ Buat Laporan Baru
                </a>

                <a href="{{ route('pelaporan.index') }}" 
                class="block p-6 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition text-center">
                    📑 Lihat Laporan
                </a>

                {{-- Card: Tindak Lanjut (hanya admin) --}}
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('tindak-lanjut.index') }}" 
                    class="block p-6 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition text-center">
                        🛠️ Tindak Lanjut
                    </a>

                    {{-- Card: Kelola Admin --}}
                    <a href="{{ route('admin.index') }}" 
                    class="block p-6 mt-4 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition text-center">
                        👤 Kelola Admin
                    </a>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
