<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'admin')
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 transition">
                                        <div>Laporan Kerusakan</div>
                                        <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('pelaporan.create')">{{ __('Buat Laporan Baru') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('pelaporan.index')">{{ __('Lihat Laporan') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('tindak-lanjut.index')">{{ __('Tindak Lanjut') }}</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 transition">
                                        <div>Rencana Pemeliharaan</div>
                                        <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('pemeliharaan.rutin')">{{ __('Pemeliharaan Rutin') }}</x-dropdown-link>
                                    <x-dropdown-link :href="route('pemeliharaan.darurat')">{{ __('Pemeliharaan Darurat') }}</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        
                        <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index', 'admin.create', 'admin.edit', 'admin.change_password_form')">
                            {{ __('Kelola Admin') }}
                        </x-nav-link>
                        <x-nav-link :href="route('ekspor.index')" :active="request()->routeIs('ekspor.index')">
                            {{ __('Ekspor PDF') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="flex items-center ms-6">
                <div class="hidden sm:flex sm:items-center">
                    @if (Auth::user()->role === 'admin' && isset($unreadNotificationsCount))
                    <div class="relative">
                        <x-dropdown align="right" width="80">
                            <x-slot name="trigger">
                                <button class="relative inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20"><path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM4 17h6a2 2 0 0 1-4 0Z"/></svg>
                                    @if($unreadNotificationsCount > 0)
                                    <div class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-1 -end-1">{{ $unreadNotificationsCount }}</div>
                                    @endif
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">Notifikasi Terbaru</div>
                                <div class="max-h-60 overflow-y-auto">
                                    @forelse ($recentNotifications as $notification)
                                        <a href="{{ route('tindak-lanjut.edit', $notification->pelaporan_id) }}" 
                                           class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 @if(!$notification->is_read) bg-blue-50 @endif">
                                            <p class="font-medium truncate">{{ $notification->pesan }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </a>
                                    @empty
                                        <div class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada notifikasi baru.</div>
                                    @endforelse
                                </div>
                                <div class="border-t border-gray-200"></div>
                                <x-dropdown-link :href="route('notifikasi.index')">{{ __('Lihat Semua Notifikasi') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif
                </div>

                <div class="hidden sm:flex sm:items-center ms-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
            
            <div class="-me-2 flex items-center sm:hidden">
                @if(Auth::user()->role === 'admin' && isset($unreadNotificationsCount))
                    <a href="{{ route('notifikasi.index') }}" class="relative inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 hover:text-gray-700 rounded-lg focus:outline-none">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20"><path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM4 17h6a2 2 0 0 1-4 0Z"/></svg>
                        @if($unreadNotificationsCount > 0)
                        <div class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full top-0 end-0">{{ $unreadNotificationsCount }}</div>
                        @endif
                    </a>
                @endif
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'admin')
                <div x-data="{ dropdownOpen: false }" class="border-t border-gray-200 pt-2 mt-2">
                    <button @click="dropdownOpen = !dropdownOpen" class="w-full flex justify-between items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition">
                        <span>Laporan Kerusakan</span>
                        <svg class="h-5 w-5 transform transition-transform" :class="{'rotate-180': dropdownOpen}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition class="mt-2 space-y-1 ps-4">
                        <x-responsive-nav-link :href="route('pelaporan.create')">{{ __('Buat Laporan Baru') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('pelaporan.index')">{{ __('Lihat Laporan') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('tindak-lanjut.index')">{{ __('Tindak Lanjut') }}</x-responsive-nav-link>
                    </div>
                </div>

                <div x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="w-full flex justify-between items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 transition">
                        <span>Rencana Pemeliharaan</span>
                        <svg class="h-5 w-5 transform transition-transform" :class="{'rotate-180': dropdownOpen}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition class="mt-2 space-y-1 ps-4">
                        <x-responsive-nav-link :href="route('pemeliharaan.rutin')">{{ __('Pemeliharaan Rutin') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('pemeliharaan.darurat')">{{ __('Pemeliharaan Darurat') }}</x-responsive-nav-link>
                    </div>
                </div>

                <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                    {{ __('Kelola Admin') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('ekspor.index')" :active="request()->routeIs('ekspor.index')">
                    {{ __('Ekspor PDF') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>