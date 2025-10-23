<x-guest-layout>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">
        {{ __('Konfirmasi Password?') }}
    </h2>
    
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Ini adalah area aman dari aplikasi. Mohon konfirmasi kata sandi Anda sebelum melanjutkan.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Konfirmasi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>