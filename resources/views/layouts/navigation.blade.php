<nav x-data="{ open: false }" class="bg-[#0a2d5a] border-b border-[#0a2d5a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <!-- Logo (kiri) -->
            <div class="shrink-0 flex items-center gap-2">
                <a href="{{ route('surat.index') }}" class="flex items-center gap-2 ">
                    <img src="/images/logoNavbar.png" alt="" class="h-[10rem] transition-all duration-300 hover:-translate-y-0.5">
                    {{-- <div class="bg-white rounded-md px-3 py-1.5">
                        <p class="text-sm font-bold text-[#0a2d5a] tracking-widest">SINARA</p>
                    </div> --}}
                </a>
            </div>

            <!-- Navigation Links (tengah) -->
            <div class="hidden sm:flex flex-1 justify-center items-stretch space-x-8">
                <a href="{{ route('surat.index') }}"
                    class="inline-flex items-end pb-4 h-20 px-1 text-sm font-medium transition-all duration-150
                    {{ request()->routeIs('surat.index')
                        ? 'text-white border-b-2 border-white'
                        : 'text-gray-300 border-b-2 border-transparent hover:text-white hover:border-white' }}">
                    {{ __('Nomor Surat') }}
                </a>

                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('pengguna.index') }}"
                        class="inline-flex items-end pb-4 h-20 px-1 text-sm font-medium transition-all duration-150
                        {{ request()->routeIs('pengguna.index')
                            ? 'text-white border-b-2 border-white'
                            : 'text-gray-300 border-b-2 border-transparent hover:text-white hover:border-white' }}">
                        {{ __('Pengguna') }}
                    </a>
                    <a href="{{ route('kategori.index') }}"
                        class="inline-flex items-end pb-4 h-20 px-1 text-sm font-medium transition-all duration-150
                        {{ request()->routeIs('kategori.*')
                            ? 'text-white border-b-2 border-white'
                            : 'text-gray-300 border-b-2 border-transparent hover:text-white hover:border-white' }}">
                        {{ __('Kategori') }}
                    </a>
                    <a href="{{ route('log.index') }}"
                        class="inline-flex items-end pb-4 h-20 px-1 text-sm font-medium transition-all duration-150
                        {{ request()->routeIs('log.*')
                            ? 'text-white border-b-2 border-white'
                            : 'text-gray-300 border-b-2 border-transparent hover:text-white hover:border-white' }}">
                        {{ __('Logs') }}
                    </a>
                @else
                    <a href="{{ route('surat.riwayat') }}"
                        class="inline-flex items-end pb-4 h-20 px-1 text-sm font-medium transition-all duration-150
                        {{ request()->routeIs('surat.riwayat')
                            ? 'text-white border-b-2 border-white'
                            : 'text-gray-300 border-b-2 border-transparent hover:text-white hover:border-white' }}">
                        {{ __('Riwayat Surat') }}
                    </a>
                @endif
            </div>

            <!-- User + Dropdown (kanan) -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-2 py-1 rounded-md text-white text-sm font-medium hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out hover:-translate-y-0.5">
                            <!-- Nama -->
                            <span>{{ Auth::user()->name }}</span>

                            <!-- Icon lingkaran user -->
                            <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 1114 0H5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (auth()->user()->role == 'user')
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#0a2d5a]">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->role == 'admin')
                <x-responsive-nav-link :href="route('surat.index')" :active="request()->routeIs('surat.index')">
                    <span class="text-white">{{ __('Nomor Surat') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pengguna.index')" :active="request()->routeIs('pengguna.index')">
                    <span class="text-white">{{ __('Pengguna') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">
                    <span class="text-white">{{ __('Kategori') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('log.index')" :active="request()->routeIs('log.*')">
                    <span class="text-white">{{ __('Log') }}</span>
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('surat.index')" :active="request()->routeIs('surat.index')">
                    <span class="text-white">{{ __('Nomor Surat') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('surat.riwayat')" :active="request()->routeIs('surat.riwayat')">
                    <span class="text-white">{{ __('Riwayat Surat') }}</span>
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-white/20">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="text-white">{{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>