<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Admin') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            {{-- Search + Tambah Admin --}}
            <div class="mb-4 flex items-center gap-2">
                {{-- Tombol Tambah Admin --}}
                <a href="{{ route('admin.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    + Tambah Admin
                </a>

                {{-- Search Bar --}}
                <form method="GET" action="{{ route('admin.index') }}" class="flex-1 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau email admin..."
                        class="w-1/2 border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Cari
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $admin->name }}</td>
                                <td class="px-4 py-2 border">{{ $admin->email }}</td>
                                <td class="px-4 py-2 border">
                                    {{ $admin->created_at->format('d-m-Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">
                                    Belum ada admin yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
