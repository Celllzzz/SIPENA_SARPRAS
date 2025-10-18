<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800">
        <div class="min-h-screen flex flex-col">
            <header class="bg-white shadow-sm">
                <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-gray-800">SIPENA SARPRAS</h1>
                        </div>
                        <div class="flex items-center">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-grow">
                <section class="bg-white">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">
                            Solusi Pelaporan Sarana & Prasarana
                        </h1>
                        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                            Laporkan kerusakan fasilitas dengan mudah dan pantau proses perbaikannya secara transparan.
                        </p>
                        <div class="mt-8">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Mulai Sekarang
                            </a>
                        </div>
                    </div>
                </section>

                <section class="py-20 bg-gray-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center">
                            <h2 class="text-3xl font-extrabold text-gray-900">Fitur Unggulan</h2>
                            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                                Dirancang untuk memberikan kemudahan dan transparansi dalam setiap proses pelaporan.
                            </p>
                        </div>

                        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </div>
                                <h3 class="mt-5 text-lg font-medium text-gray-900">Pelaporan Mudah</h3>
                                <p class="mt-2 text-base text-gray-600">
                                    Antarmuka yang sederhana memudahkan siapa saja untuk membuat laporan kerusakan dengan cepat, lengkap dengan deskripsi dan bukti foto.
                                </p>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <h3 class="mt-5 text-lg font-medium text-gray-900">Pemantauan Status Real-time</h3>
                                <p class="mt-2 text-base text-gray-600">
                                    Pengguna dapat memantau setiap tahapan proses perbaikan, mulai dari verifikasi, pengerjaan, hingga selesai.
                                </p>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <h3 class="mt-5 text-lg font-medium text-gray-900">Histori dan Log Aktivitas</h3>
                                <p class="mt-2 text-base text-gray-600">
                                    Semua tindakan tercatat dalam log aktivitas yang transparan, memberikan jejak digital yang jelas untuk setiap laporan.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="bg-white">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>