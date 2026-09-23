<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                    {{ __('Ubah Kata Sandi Admin') }}
                </h1>
                <p class="text-xs text-gray-500 mt-1">
                    Ganti kata sandi untuk akun administrator {{ $admin->name }}
                </p>
            </div>
            <a href="{{ route('admin.index') }}" class="text-xs sm:text-sm font-semibold text-teal-700 hover:text-teal-800 transition-colors">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 sm:p-8">
                <div class="mb-6">
                    <h2 class="font-heading font-bold text-base sm:text-lg text-gray-900">Ubah Kata Sandi</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Admin: <strong class="text-gray-800">{{ $admin->name }}</strong> ({{ $admin->email }})</p>
                </div>

                <form method="POST" action="{{ route('admin.change_password_update', $admin->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Kata Sandi Baru <span class="text-red-500">*</span>
                        </label>
                        <input id="password" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3 py-2 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">
                            Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                        </label>
                        <input id="password_confirmation" class="block w-full border border-gray-300 rounded-md text-xs sm:text-sm text-gray-900 px-3 py-2 focus:border-teal-500 focus:ring-teal-500 shadow-sm" type="password" name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2 bg-teal-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-wider hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition shadow-sm">
                            Simpan Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>