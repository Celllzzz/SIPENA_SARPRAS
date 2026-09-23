<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-heading font-bold text-xl text-gray-900 leading-tight">
                Pengaturan Profil
            </h2>
            <p class="text-xs text-gray-500 mt-1">Kelola data pribadi, informasi akun, dan keamanan kata sandi</p>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    <div class="p-6 sm:p-8 bg-white rounded-md shadow-sm border border-gray-200">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 bg-white rounded-md shadow-sm border border-gray-200">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="p-6 sm:p-8 bg-white rounded-md shadow-sm border border-gray-200">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>