<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('admin.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold">Nama</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded mt-1"
                               value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Email</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded mt-1"
                               value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Password</label>
                        <input type="password" name="password" class="w-full border-gray-300 rounded mt-1" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded mt-1" required>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
