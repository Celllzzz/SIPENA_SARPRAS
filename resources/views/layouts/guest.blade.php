<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPENA-SARPRAS') }}</title>

        <!-- Fonts: Open Sans & Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-800 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-0 py-8">
            <div class="mb-2">
                <a href="/">
                    {{-- Logo SIPENA --}}
                    <x-application-logo class="w-16 h-16" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-6 py-6 bg-white shadow-sm border border-gray-200 overflow-hidden sm:rounded-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>