<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                {{-- Brand Logo & Title --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5">
                        <img src="{{ asset('images/LogoSipena.png') }}" alt="Logo SIPENA" class="h-9 w-auto object-contain">
                        <div class="flex flex-col">
                            <span class="font-heading font-extrabold text-base tracking-tight text-gray-900 leading-tight">SIPENA</span>
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-teal-700 leading-none">Sarana & Prasarana</span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation Links --}}
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dasbor') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'admin')
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 hover:text-gray-900 hover:border-teal-500 transition focus:outline-none">
                                        <span>Laporan Kerusakan</span>
                                        <svg class="ms-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('pelaporan.create')">{{ __('Buat Laporan Baru') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('pelaporan.index')">{{ __('Lihat Semua Laporan') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('tindak-lanjut.index')">{{ __('Tindak Lanjut') }}</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 hover:text-gray-900 hover:border-teal-500 transition focus:outline-none">
                                        <span>Rencana Pemeliharaan</span>
                                        <svg class="ms-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('pemeliharaan-rutin.index')">{{ __('Pemeliharaan Rutin') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('pemeliharaan-darurat.index')">{{ __('Pemeliharaan Darurat') }}</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        
                        <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index', 'admin.create', 'admin.edit', 'admin.change_password_form')">
                            {{ __('Kelola Admin') }}
                        </x-nav-link>
                        <x-nav-link :href="route('ekspor.index')" :active="request()->routeIs('ekspor.index')">
                            {{ __('Ekspor Laporan') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('pelaporan.index')" :active="request()->routeIs('pelaporan.index')">
                            {{ __('Riwayat Laporan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pelaporan.create')" :active="request()->routeIs('pelaporan.create')">
                            {{ __('Buat Laporan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- Right Navigation Elements --}}
            <div class="flex items-center space-x-3">
                
                {{-- Notifications (Admin) --}}
                @if (Auth::user()->role === 'admin' && isset($unreadNotificationsCount))
                    <div class="relative">
                        <x-dropdown align="right" width="80">
                            <x-slot name="trigger">
                                <button class="relative inline-flex items-center p-2 text-sm font-medium text-gray-500 hover:text-gray-700 rounded-md focus:outline-none focus:bg-gray-100 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @if($unreadNotificationsCount > 0)
                                        <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold text-white bg-red-600 rounded-md">
                                            {{ $unreadNotificationsCount }}
                                        </span>
                                    @endif
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Notifikasi Terbaru
                                </div>
                                <div class="max-h-60 overflow-y-auto divide-y divide-gray-100">
                                    @forelse ($recentNotifications as $notification)
                                        <a href="{{ route('tindak-lanjut.edit', $notification->pelaporan_id) }}" 
                                           class="block w-full px-4 py-2.5 text-start text-xs leading-snug text-gray-700 hover:bg-gray-50 transition {{ !$notification->is_read ? 'bg-teal-50/50 font-semibold' : '' }}">
                                            <p class="truncate">{{ $notification->pesan }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $notification->created_at->diffForHumans() }}</p>
                                        </a>
                                    @empty
                                        <div class="px-4 py-3 text-xs text-gray-500 text-center">Tidak ada notifikasi baru.</div>
                                    @endforelse
                                </div>
                                <div class="border-t border-gray-100">
                                    <x-dropdown-link :href="route('notifikasi.index')">{{ __('Lihat Semua Notifikasi') }}</x-dropdown-link>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                {{-- User Profile Dropdown --}}
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-1.5 border border-gray-200 rounded-md text-xs sm:text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
                                <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                                <span class="ms-1.5 px-1.5 py-0.5 text-[10px] font-semibold bg-gray-100 text-gray-600 rounded-md uppercase">
                                    {{ Auth::user()->role }}
                                </span>
                                <svg class="ms-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profil Saya') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- Mobile Hamburger --}}
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-b border-gray-200 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dasbor') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'admin')
                <div x-data="{ dropdownOpen: false }" class="border-t border-gray-100 pt-2 mt-2">
                    <button @click="dropdownOpen = !dropdownOpen" class="w-full flex justify-between items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition">
                        <span>Laporan Kerusakan</span>
                        <svg class="h-4 w-4 transform transition-transform" :class="{'rotate-180': dropdownOpen}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition class="mt-1 space-y-1 ps-4">
                        <x-responsive-nav-link :href="route('pelaporan.create')">{{ __('Buat Laporan Baru') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('pelaporan.index')">{{ __('Lihat Semua Laporan') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tindak-lanjut.index')">{{ __('Tindak Lanjut') }}</x-responsive-nav-link>
                    </div>
                </div>

                <div x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="w-full flex justify-between items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition">
                        <span>Rencana Pemeliharaan</span>
                        <svg class="h-4 w-4 transform transition-transform" :class="{'rotate-180': dropdownOpen}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition class="mt-1 space-y-1 ps-4">
                        <x-responsive-nav-link :href="route('pemeliharaan-rutin.index')">{{ __('Pemeliharaan Rutin') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('pemeliharaan-darurat.index')">{{ __('Pemeliharaan Darurat') }}</x-responsive-nav-link>
                    </div>
                </div>

                <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                    {{ __('Kelola Admin') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('ekspor.index')" :active="request()->routeIs('ekspor.index')">
                    {{ __('Ekspor Laporan') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('pelaporan.index')" :active="request()->routeIs('pelaporan.index')">
                    {{ __('Riwayat Laporan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pelaporan.create')" :active="request()->routeIs('pelaporan.create')">
                    {{ __('Buat Laporan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-3 pb-3 border-t border-gray-200">
            <div class="px-4">
                <div class="font-semibold text-sm text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">{{ Auth::user()->email }} ({{ strtoupper(Auth::user()->role) }})</div>
            </div>

            <div class="mt-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>