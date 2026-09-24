<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | SIPENA SARPRAS PN Maros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/LogoSipena.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/LogoSipena.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-md border border-gray-200 shadow-sm p-6 sm:p-8 text-center">
        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-md flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Error 403</span>
        <h1 class="text-xl sm:text-2xl font-heading font-extrabold text-gray-900 mt-1">Akses Ditolak</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-2 leading-relaxed">
            Anda tidak memiliki hak otorisasi yang mencukupi untuk membuka menu atau data ini.
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
