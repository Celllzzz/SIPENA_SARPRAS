<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Selamat Datang - SIPENA Sarpras</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        
        <div class="relative min-h-screen flex flex-col items-center justify-center bg-white">
            
            <div class="max-w-xl w-full mx-auto p-6 lg:p-8">
                <div class="flex flex-col items-center">
                    
                    <img src="{{ asset('images/LogoSipena.png') }}" alt="Logo Sipena" class="h-24 w-auto">

                    <h1 class="mt-6 text-3xl font-bold text-gray-900">
                        SIPENA-Sarpras
                    </h1>

                    <p class="mt-4 text-gray-600 text-center leading-relaxed">
                        SIPENA-Sarpras (Sistem Informasi Perencanaan dan Pelaporan Pemeliharaan Sarana Prasarana) adalah aplikasi yang didedikasikan untuk mengelola perencanaan dan pelaporan pemeliharaan sarana dan prasarana di lingkungan Pengadilan Negeri Maros.
                    </p>

                    <div class="mt-8 flex justify-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}">
                                <x-primary-button class="text-base px-6 py-3">
                                    {{ __('Masuk ke Dashboard') }}
                                </x-primary-button>
                            </a>
                        @else
                            <a href="{{ route('login') }}">
                                <x-primary-button class="text-base px-6 py-3">
                                    {{ __('Masuk') }}
                                </x-primary-button>
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">
                                    <x-secondary-button class="text-base px-6 py-3">
                                        {{ __('Daftar') }}
                                    </x-secondary-button>
                                </a>
                            @endif
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>