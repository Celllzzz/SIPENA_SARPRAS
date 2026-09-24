<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan | SIPENA SARPRAS PN Maros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-md border border-gray-200 shadow-sm p-6 sm:p-8 text-center">
        <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-md flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <span class="text-xs font-bold uppercase tracking-wider text-teal-600">Error 404</span>
        <h1 class="text-xl sm:text-2xl font-heading font-extrabold text-gray-900 mt-1">Halaman Tidak Ditemukan</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-2 leading-relaxed">
            Halaman atau tautan yang Anda cari tidak tersedia, telah dipindahkan, atau alamat URL yang dimasukkan salah.
        </p>
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-2.5">
            <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-teal-600 text-white rounded-md text-xs font-semibold hover:bg-teal-700 transition shadow-sm">
                Kembali ke Dasbor
            </a>
            <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md text-xs font-semibold hover:bg-gray-50 transition shadow-sm">
                Halaman Depan
            </a>
        </div>
        <p class="text-[11px] text-gray-400 mt-6 pt-4 border-t border-gray-100">
            SIPENA SARPRAS &bull; Pengadilan Negeri Maros
        </p>
    </div>
</body>
</html>
