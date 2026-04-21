@php
    $links = [
        ['label' => __('Beranda'), 'href' => route('home'), 'active' => request()->routeIs('home'), 'icon' => 'fa-home'],
        ['label' => __('Katalog'), 'href' => route('catalog'), 'active' => request()->routeIs('catalog'), 'icon' => 'fa-store'],
        ['label' => __('Dashboard'), 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard'), 'icon' => 'fa-gauge'],
        ['label' => __('RFQ saya'), 'href' => route('dashboard.rfqs.index'), 'active' => request()->routeIs('dashboard.rfqs.*'), 'icon' => 'fa-file-invoice-dollar'],
    ];

    if (auth()->user()?->can('permission', 'dashboard.view')) {
        $links[] = ['label' => __('Admin'), 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.*'), 'icon' => 'fa-shield-halved'];
    }
@endphp

<header
    id="ios-navbar"
    class="fixed top-0 left-0 right-0 z-[100] transition-all duration-300"
    style="background: rgba(10, 95, 91, 0.85); backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%); border-bottom: 1px solid rgba(255,255,255,0.08);"
    x-data="{ scrolled: false, mobileOpen: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
    :style="scrolled ? 'background: rgba(10, 95, 91, 0.96); box-shadow: 0 4px 30px rgba(0,0,0,0.15);' : ''"
    @keydown.escape.window="mobileOpen = false"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[72px]">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center shadow-lg shadow-black/10 group-hover:bg-white/25 transition-all">
                    <i class="fa-solid fa-layer-group text-white text-lg"></i>
                </div>
                <div class="hidden sm:block">
                    <span class="text-white font-bold text-[15px] tracking-tight block leading-tight">{{ config('app.name') }}</span>
                    <span class="text-[10px] text-teal-200/60 font-medium uppercase tracking-[0.15em]">Operational Platform</span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-7">
                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}"
                        class="relative text-sm font-medium transition-colors py-1 {{ $link['active'] ? 'text-white' : 'text-white/75 hover:text-white' }}"
                        style="{{ $link['active'] ? 'border-bottom: 2px solid #5eead4;' : '' }}"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Desktop user --}}
            <div class="hidden md:flex items-center gap-3">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-medium text-white hover:bg-white/15 transition-all">
                            <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center">
                                <i class="fa-solid fa-user text-[10px]"></i>
                            </div>
                            <span class="max-w-36 truncate">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-[8px] text-white/60"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user-edit mr-2 text-gray-400 text-xs"></i> {{ __('Edit Profil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-right-from-bracket mr-2 text-gray-400 text-xs"></i> {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile hamburger --}}
            <button
                @click="mobileOpen = !mobileOpen"
                class="md:hidden w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-white/20 transition-colors"
                aria-label="Menu"
            >
                <i class="fa-solid" :class="mobileOpen ? 'fa-xmark text-lg' : 'fa-bars'"></i>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden border-t border-white/10 bg-[#0a5854]"
        x-cloak
    >
        <div class="px-4 py-4 space-y-1">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ $link['active'] ? 'bg-white/15 text-white' : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                    <i class="fa-solid {{ $link['icon'] }} w-5 text-center text-xs"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach

            <div class="border-t border-white/10 pt-3 mt-2 space-y-1">
                <div class="flex items-center gap-3 px-4 py-2">
                    <div class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center">
                        <i class="fa-solid fa-user text-white text-xs"></i>
                    </div>
                    <span class="text-white text-sm font-medium truncate">{{ Auth::user()->name }}</span>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/75 hover:text-white hover:bg-white/10 transition-all">
                    <i class="fa-solid fa-user-edit w-5 text-center text-xs"></i> Edit Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-red-300 hover:text-white hover:bg-red-500/20 transition-all w-full">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center text-xs"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="h-[72px]"></div>
