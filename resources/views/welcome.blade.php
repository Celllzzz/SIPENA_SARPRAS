<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIPENA SARPRAS PN Maros - Sistem Informasi Sarana Prasarana</title>
        <meta name="description" content="Aplikasi resmi Pengadilan Negeri Maros untuk pelaporan kerusakan sarana, perencanaan jadwal pemeliharaan rutin, dan pemantauan perbaikan fasilitas gedung pengadilan.">
        <link rel="canonical" href="{{ url()->current() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/LogoSipena.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/LogoSipena.png') }}">

        <!-- Open Graph / Facebook / WhatsApp -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="SIPENA SARPRAS PN Maros - Pengadilan Negeri Maros">
        <meta property="og:description" content="Aplikasi resmi Pengadilan Negeri Maros untuk pelaporan kerusakan sarana dan pemeliharaan fasilitas.">
        <meta property="og:image" content="{{ asset('images/LogoSipena.png') }}">

        <!-- Structured Data (JSON-LD) Schema.org -->
        @php
            $schemaData = [
                '@context' => 'https://schema.org',
                '@type' => 'GovernmentBuilding',
                'name' => 'Pengadilan Negeri Maros Kelas I B',
                'url' => 'https://sipena-sarpras.com',
                'sameAs' => 'https://pn-maros.go.id',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Jl. Jenderal Sudirman No. 3, Pettuadae',
                    'addressLocality' => 'Kecamatan Turikale, Kabupaten Maros',
                    'addressRegion' => 'Sulawesi Selatan',
                    'postalCode' => '90516',
                    'addressCountry' => 'ID',
                ],
            ];
        @endphp
        <script type="application/ld+json">
        {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>

        <!-- Fonts: Open Sans & Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-gray-50">
        
        <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 my-auto">
            
            <div class="max-w-xl w-full mx-auto space-y-4">
                
                {{-- Kartu Utama Sambutan & CTA --}}
                <div class="p-6 sm:p-8 bg-white rounded-md shadow-sm border border-gray-200 text-center">
                    <img src="{{ asset('images/LogoSipena.png') }}" alt="Logo SIPENA SARPRAS Pengadilan Negeri Maros" class="h-20 w-auto mx-auto">

                    <h1 class="mt-4 text-2xl sm:text-3xl font-heading font-extrabold text-gray-900 tracking-tight">
                        SIPENA SARPRAS
                    </h1>
                    <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold text-teal-800 bg-teal-50 rounded-md mt-1 uppercase tracking-wider">
                        Pengadilan Negeri Maros Kelas I B
                    </span>

                    <p class="mt-3 text-xs sm:text-sm text-gray-600 text-center leading-relaxed">
                        Sistem Informasi Perencanaan dan Pelaporan Pemeliharaan Sarana Prasarana di lingkungan Pengadilan Negeri Maros.
                    </p>

                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-colors shadow-sm">
                                Masuk ke Dasbor &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-colors shadow-sm">
                                Masuk ke Akun
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-md text-xs sm:text-sm font-semibold uppercase tracking-wider transition-colors shadow-sm">
                                    Daftar Pengguna
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                {{-- Panduan Alur Pelaporan Cepat (FAQ Singkat) --}}
                <div class="p-5 bg-white rounded-md shadow-sm border border-gray-200">
                    <h2 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3">
                        Alur Pelaporan Sarana & Prasarana
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-left">
                        <div class="p-3 bg-gray-50 rounded-md border border-gray-100">
                            <span class="text-xs font-bold text-teal-700 block mb-0.5">1. Buat Laporan</span>
                            <p class="text-[11px] text-gray-500 leading-snug">Isi sarana, lokasi, deskripsi kendala, dan unggah foto bukti kerusakan.</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-md border border-gray-100">
                            <span class="text-xs font-bold text-teal-700 block mb-0.5">2. Verifikasi Tim</span>
                            <p class="text-[11px] text-gray-500 leading-snug">Tim Sarpras meninjau kelayakan dan menetapkan jadwal penanganan.</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-md border border-gray-100">
                            <span class="text-xs font-bold text-teal-700 block mb-0.5">3. Selesai Diperbaiki</span>
                            <p class="text-[11px] text-gray-500 leading-snug">Perbaikan rampung dan tercatat dalam arsip log pemeliharaan kantor.</p>
                        </div>
                    </div>
                </div>

                {{-- Alamat Resmi & Lokasi Kantor PN Maros --}}
                <div class="p-4 bg-white rounded-md shadow-sm border border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                    <div class="text-xs text-gray-500">
                        <strong class="text-gray-900 block font-semibold">Pengadilan Negeri Maros Kelas I B</strong>
                        <span>Jl. Jenderal Sudirman No. 3, Pettuadae, Kec. Turikale, Kab. Maros, Sulawesi Selatan 90516</span>
                    </div>
                    <a href="https://maps.google.com/?q=Pengadilan+Negeri+Maros" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-[11px] font-semibold transition-colors flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>

            </div>
        </div>
    </body>
</html>