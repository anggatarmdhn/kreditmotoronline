<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white sticky top-0 z-30">
    @php
        $roleSlug = Auth::user()?->role?->slug;
        $isInternal = in_array($roleSlug, ['admin', 'marketing', 'surveyor', 'kolektor'], true);
        $canManageMaster = in_array($roleSlug, ['admin', 'marketing'], true);
        $canManagePayment = in_array($roleSlug, ['admin', 'marketing', 'kolektor'], true);
    @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ $isInternal ? route('dashboard') : route('landing') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white font-black flex items-center justify-center">
                        KM
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Kredit Motor</p>
                        <p class="font-bold text-slate-800 leading-tight">Online Dashboard</p>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-2 ml-6">
                    @if($isInternal)
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-full text-sm {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Dashboard</a>
                    @endif
                    <a href="{{ route('landing') }}" class="px-4 py-2 rounded-full text-sm text-slate-700 hover:bg-slate-100">Landing</a>
                    @if($isInternal)
                        <a href="{{ route('pengajuan.index') }}" class="px-4 py-2 rounded-full text-sm {{ request()->routeIs('pengajuan.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Pengajuan</a>
                    @endif
                    @if($canManagePayment)
                        <a href="{{ route('pembayaran.index') }}" class="px-4 py-2 rounded-full text-sm {{ request()->routeIs('pembayaran.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Pembayaran</a>
                    @endif
                    @if($canManageMaster)
                        <a href="{{ route('master.index') }}" class="px-4 py-2 rounded-full text-sm text-slate-700 hover:bg-slate-100">Master</a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <div class="hidden xl:flex items-center gap-3 px-4 py-2 rounded-full bg-slate-100 border border-slate-200 text-sm text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>System Online</span>
                </div>
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-slate-200 bg-white text-sm font-medium text-slate-800 hover:bg-slate-50 transition">
                            <span class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="max-w-32 truncate">{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200 bg-white">
        <div class="px-4 py-4 space-y-2">
            @if($isInternal)
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('landing')" :active="request()->routeIs('landing')">
                {{ __('Landing') }}
            </x-responsive-nav-link>
            @if($isInternal)
                <x-responsive-nav-link :href="route('pengajuan.index')" :active="request()->routeIs('pengajuan.*')">
                    {{ __('Pengajuan') }}
                </x-responsive-nav-link>
            @endif
            @if($canManagePayment)
                <x-responsive-nav-link :href="route('pembayaran.index')" :active="request()->routeIs('pembayaran.*')">
                    {{ __('Pembayaran') }}
                </x-responsive-nav-link>
            @endif
            @if($canManageMaster)
                <x-responsive-nav-link :href="route('master.index')" :active="request()->routeIs('master.index')">
                    {{ __('Master Data') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-5 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-2 px-4">
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
