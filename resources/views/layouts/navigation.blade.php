@php
    $links = [
        ['label' => __('Beranda'), 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => __('Katalog'), 'href' => route('catalog'), 'active' => request()->routeIs('catalog')],
        ['label' => __('Dashboard'), 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
        ['label' => __('RFQ saya'), 'href' => route('dashboard.rfqs.index'), 'active' => request()->routeIs('dashboard.rfqs.*')],
    ];

    if (auth()->user()?->can('permission', 'dashboard.view')) {
        $links[] = ['label' => __('Admin'), 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.*')];
    }
@endphp

<header id="ios-navbar" class="fixed top-0 left-0 right-0 z-[100] border-b border-white/10 bg-[#0d7f7a] text-white transition-transform duration-700 ease-[cubic-bezier(0.33,1,0.68,1)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-3 py-5">
            <a href="{{ route('home') }}" class="flex flex-shrink-0 items-center gap-2">
                <span class="font-semibold tracking-wide text-[17px]">{{ config('app.name') }}</span>
            </a>

            <nav class="hidden md:flex items-center gap-8">
                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}"
                        class="font-sans text-sm font-medium transition-colors {{ $link['active'] ? 'border-b-2 border-[#5eead4] pb-0.5 text-white' : 'text-white/80 hover:text-white' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2 flex-shrink-0">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="hidden md:inline-flex items-center gap-1.5 rounded-full border border-white/85 bg-transparent px-5 py-2.5 font-sans text-sm font-semibold text-white transition-all hover:bg-white/10">
                            <span class="max-w-36 truncate">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] opacity-90">v</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                <button id="ios-hamburger" type="button" class="rounded-lg p-2 text-white transition-colors hover:bg-white/10 md:hidden" aria-label="Menu">
                    <span id="ios-hamburger-icon" class="text-sm font-semibold tracking-wide">Menu</span>
                </button>
            </div>
        </div>
    </div>

    <div id="ios-mobile-menu" class="hidden border-t border-white/15 bg-[#0b6b67] md:hidden">
        <div class="flex flex-col gap-3 px-4 py-4">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}"
                    class="border-b border-white/10 py-2 font-sans text-sm font-medium {{ $link['active'] ? 'font-semibold text-[#5eead4]' : 'text-white/85' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach

            <div class="mt-2 grid grid-cols-2 gap-2">
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center justify-center gap-1.5 rounded-full border-2 border-white/90 px-4 py-3 font-sans text-sm font-semibold text-white">
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-1.5 rounded-full bg-[#0f766e] px-4 py-3 font-sans text-sm font-semibold text-white">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="h-[84px] md:h-[92px]"></div>

<script>
    (function() {
        const navbar = document.getElementById('ios-navbar');
        if (!navbar) return;

        let lastScrollY = window.scrollY;
        let ticking = false;
        const scrollThreshold = 80;
        const scrollDelta = 15;

        function applyScroll() {
            const scrollY = window.scrollY;

            if (scrollY > 40) {
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.08)';
            } else {
                navbar.style.boxShadow = 'none';
            }

            const delta = scrollY - lastScrollY;
            if (scrollY <= 10) {
                navbar.classList.remove('-translate-y-full');
            } else if (delta > scrollDelta && scrollY > scrollThreshold) {
                navbar.classList.add('-translate-y-full');
            } else if (delta < -scrollDelta) {
                navbar.classList.remove('-translate-y-full');
            }

            lastScrollY = scrollY;
            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(applyScroll);
                ticking = true;
            }
        }, { passive: true });
        applyScroll();

        const hamburger = document.getElementById('ios-hamburger');
        const icon = document.getElementById('ios-hamburger-icon');
        const mobileMenu = document.getElementById('ios-mobile-menu');

        if (hamburger && icon && mobileMenu) {
            hamburger.addEventListener('click', () => {
                const isOpen = !mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden');
                icon.textContent = isOpen ? 'Menu' : 'Tutup';
            });

            mobileMenu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    icon.textContent = 'Menu';
                });
            });
        }
    })();
</script>
