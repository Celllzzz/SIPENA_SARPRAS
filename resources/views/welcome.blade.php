<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Selamat Datang - SIPENA Sarpras</title>

        <!-- Fonts: Open Sans & Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-gray-50">
        
        <div class="relative min-h-screen flex flex-col items-center justify-center p-4">
            
            <div class="max-w-xl w-full mx-auto p-8 bg-white rounded-md shadow-sm border border-gray-200">
                <div class="flex flex-col items-center text-center">
                    
                    <img src="{{ asset('images/LogoSipena.png') }}" alt="Logo Sipena" class="h-20 w-auto">

                    <h1 class="mt-5 text-2xl sm:text-3xl font-heading font-bold text-gray-900">
                        SIPENA-Sarpras
                    </h1>

                    <p class="mt-3 text-xs sm:text-sm text-gray-600 text-center leading-relaxed">
                        Sistem Informasi Perencanaan dan Pelaporan Pemeliharaan Sarana Prasarana di lingkungan Pengadilan Negeri Maros.
                    </p>

                    <div class="mt-7 flex flex-wrap justify-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-colors shadow-sm">
                                Masuk ke Dasbor
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-colors shadow-sm">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-colors shadow-sm">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>