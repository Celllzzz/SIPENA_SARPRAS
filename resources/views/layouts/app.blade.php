<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' - SIPENA SARPRAS PN Maros' : 'SIPENA SARPRAS - Pengadilan Negeri Maros' }}</title>
        <meta name="description" content="Sistem Informasi Perencanaan dan Pelaporan Pemeliharaan Sarana Prasarana di lingkungan Pengadilan Negeri Maros.">
        <link rel="canonical" href="{{ url()->current() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/LogoSipena.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/LogoSipena.png') }}">

        <!-- Open Graph / Meta Sosial -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ isset($title) ? $title . ' - SIPENA SARPRAS PN Maros' : 'SIPENA SARPRAS - Pengadilan Negeri Maros' }}">
        <meta property="og:description" content="Sistem Informasi Perencanaan dan Pelaporan Pemeliharaan Sarana Prasarana di lingkungan Pengadilan Negeri Maros.">
        <meta property="og:image" content="{{ asset('images/LogoSipena.png') }}">

        <!-- Fonts: Open Sans & Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">
        {{-- Top Navigation Loading Bar --}}
        <div id="top-progress-bar" style="width: 0%; opacity: 0;"></div>

        <div class="min-h-screen flex bg-gray-50">
            
            {{-- Sidebar (Desktop & Mobile Drawer) --}}
            @include('layouts.sidebar')

            {{-- Main Content Area (Offset for Desktop Sidebar) --}}
            <div class="lg:pl-64 flex flex-col flex-1 min-h-screen min-w-0">
                
                {{-- Mobile Topbar Header --}}
                <header class="lg:hidden h-16 bg-white border-b border-gray-200 px-4 flex items-center justify-between sticky top-0 z-30 shadow-xs">
                    <button @click="sidebarOpen = true" class="p-2 -ml-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <x-application-logo class="w-6 h-6" />
                        <span class="font-heading font-bold text-sm text-gray-900">SIPENA SARPRAS</span>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="p-2 -mr-2 rounded-md text-gray-600 hover:text-gray-900">
                        <span class="text-xs font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                    </a>
                </header>

                {{-- Page Header --}}
                @isset($header)
                    <header class="bg-white border-b border-gray-200">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                {{-- Page Content --}}
                <main class="page-fade-in flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>

        {{-- Global Interactivity & Loading Scripts --}}
        <script>
            // 1. Top Navigation Progress Bar on link click (Anti-Blink)
            document.addEventListener('DOMContentLoaded', () => {
                const bar = document.getElementById('top-progress-bar');
                if (bar) {
                    bar.style.width = '100%';
                    bar.style.opacity = '1';
                    setTimeout(() => {
                        bar.style.opacity = '0';
                        setTimeout(() => { bar.style.width = '0%'; }, 200);
                    }, 200);
                }

                document.querySelectorAll('a[href]').forEach(link => {
                    link.addEventListener('click', (e) => {
                        const href = link.getAttribute('href');
                        const target = link.getAttribute('target');
                        if (href && !href.startsWith('#') && !href.startsWith('javascript:') && target !== '_blank' && !e.ctrlKey && !e.metaKey) {
                            if (bar) {
                                bar.style.width = '40%';
                                bar.style.opacity = '1';
                                setTimeout(() => { bar.style.width = '80%'; }, 250);
                            }
                        }
                    });
                });

                // 2. Global Button Spinner on Form Submission (< 1 - 2 detik)
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', function (e) {
                        if (this.hasAttribute('data-no-spinner')) return;
                        const btn = this.querySelector('button[type="submit"]');
                        if (btn && !btn.disabled) {
                            btn.disabled = true;
                            btn.classList.add('opacity-80', 'cursor-not-allowed');
                            const originalHtml = btn.innerHTML;
                            btn.setAttribute('data-original-text', originalHtml);
                            btn.innerHTML = `
                                <svg class="animate-spin -ml-1 mr-2 h-3.5 w-3.5 inline-block text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memproses...</span>
                            `;
                            // Re-enable if form takes too long or download triggers
                            setTimeout(() => {
                                btn.disabled = false;
                                btn.classList.remove('opacity-80', 'cursor-not-allowed');
                                btn.innerHTML = originalHtml;
                            }, 5000);
                        }
                    });
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>
