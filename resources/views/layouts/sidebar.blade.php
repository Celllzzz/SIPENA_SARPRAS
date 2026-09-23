{{-- Sidebar Mobile Overlay Backdrop --}}
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-200" 
     x-transition:enter-start="opacity-0" 
     x-transition:enter-end="opacity-100" 
     x-transition:leave="transition-opacity ease-linear duration-200" 
     x-transition:leave-start="opacity-100" 
     x-transition:leave-end="opacity-0" 
     @click="sidebarOpen = false" 
     class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden" 
     x-cloak>
</div>

{{-- Sidebar Container (Desktop Fixed & Mobile Drawer) --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col transition-transform duration-200 ease-in-out">
    
    {{-- Header Sidebar: Logo & Nama Aplikasi --}}
    <div class="h-16 flex items-center justify-between px-5 border-b border-gray-100 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <x-application-logo class="w-8 h-8" />
            <div class="flex flex-col">
                <span class="font-heading font-extrabold text-sm tracking-tight text-gray-900 leading-tight group-hover:text-teal-600 transition-colors">
                    SIPENA SARPRAS
                </span>
                <span class="text-[10px] text-gray-400 font-medium tracking-wider uppercase">
                    PN MAROS
                </span>
            </div>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Menu Navigasi --}}
    <div class="flex-1 overflow-y-auto px-3.5 py-4 space-y-6">
        
        {{-- Grup Utama --}}
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                Menu Utama
            </div>
            <nav class="space-y-1">
                {{-- Dasbor --}}
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dasbor
                </a>

                {{-- Notifikasi --}}
                <a href="{{ route('notifikasi.index') }}" 
                   class="flex items-center justify-between px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('notifikasi.*') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('notifikasi.*') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Notifikasi
                    </div>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold text-white bg-red-600 rounded-md">
                            {{ $unreadNotificationsCount }}
                        </span>
                    @endif
                </a>
            </nav>
        </div>

        {{-- Grup Layanan (Berdasarkan Role) --}}
        <div>
            @if (Auth::user()->role === 'admin')
                <div class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                    Kelola Fasilitas
                </div>
                <nav class="space-y-1">
                    {{-- Tindak Lanjut --}}
                    <a href="{{ route('tindak-lanjut.index') }}" 
                       class="flex items-center px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('tindak-lanjut.*') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('tindak-lanjut.*') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Tindak Lanjut Pelaporan
                    </a>

                    {{-- Pemeliharaan Rutin --}}
                    <a href="{{ route('pemeliharaan-rutin.index') }}" 
                       class="flex items-center px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('pemeliharaan-rutin.*') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('pemeliharaan-rutin.*') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Pemeliharaan Rutin
                    </a>

                    {{-- Pemeliharaan Darurat --}}
                    <a href="{{ route('pemeliharaan-darurat.index') }}" 
                       class="flex items-center px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('pemeliharaan-darurat.*') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('pemeliharaan-darurat.*') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Pemeliharaan Darurat
                    </a>

                    {{-- Ekspor Laporan --}}
                    <a href="{{ route('ekspor.index') }}" 
                       class="flex items-center px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('ekspor.*') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('ekspor.*') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Ekspor Laporan
                    </a>

                    {{-- Manajemen Admin --}}
                    <a href="{{ route('admin.index') }}" 
                       class="flex items-center px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('admin.*') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('admin.*') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manajemen Admin
                    </a>
                </nav>
            @else
                <div class="px-3 mb-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                    Layanan Sarpras
                </div>
                <nav class="space-y-1">
                    {{-- Pelaporan Saya --}}
                    <a href="{{ route('pelaporan.index') }}" 
                       class="flex items-center px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('pelaporan.index') || request()->routeIs('pelaporan.show') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('pelaporan.index') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Data Pelaporan Saya
                    </a>

                    {{-- Buat Laporan Baru --}}
                    <a href="{{ route('pelaporan.create') }}" 
                       class="flex items-center px-3 py-2 text-xs font-semibold rounded-md transition-colors {{ request()->routeIs('pelaporan.create') ? 'bg-teal-50 text-teal-800 border-l-4 border-teal-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        <svg class="w-4 h-4 mr-2.5 flex-shrink-0 {{ request()->routeIs('pelaporan.create') ? 'text-teal-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Laporan Baru
                    </a>
                </nav>
            @endif
        </div>

    </div>

    {{-- Footer Sidebar: Profil Pengguna (Tanpa Badge Role) & Logout --}}
    <div class="p-3.5 border-t border-gray-100 bg-gray-50/50 flex-shrink-0 space-y-2">
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center justify-between p-2 rounded-md hover:bg-white hover:shadow-xs transition-colors group">
            <div class="flex flex-col min-w-0">
                <span class="text-xs font-bold text-gray-800 truncate group-hover:text-teal-700 transition-colors">
                    {{ Auth::user()->name }}
                </span>
                <span class="text-[11px] text-gray-400 truncate">
                    {{ Auth::user()->email }}
                </span>
            </div>
            <span class="text-xs text-gray-400 group-hover:text-teal-600">&rarr;</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 px-3 py-1.5 text-xs font-medium text-gray-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar dari Akun
            </button>
        </form>
    </div>

</aside>
