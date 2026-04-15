<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-[#0d7f7a] font-semibold">
                        <i class="fa-solid fa-layer-group"></i>
                        <span class="hidden sm:inline">{{ config('app.name') }}</span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        <span class="inline-flex items-center gap-1"><i class="fa-solid fa-house text-xs"></i> {{ __('Beranda') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('catalog')" :active="request()->routeIs('catalog')">
                        <span class="inline-flex items-center gap-1"><i class="fa-solid fa-store text-xs"></i> {{ __('Katalog') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <span class="inline-flex items-center gap-1"><i class="fa-solid fa-gauge text-xs"></i> {{ __('Dashboard') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard.rfqs.index')" :active="request()->routeIs('dashboard.rfqs.*')">
                        <span class="inline-flex items-center gap-1"><i class="fa-solid fa-file-invoice-dollar text-xs"></i> {{ __('RFQ saya') }}</span>
                    </x-nav-link>
                    @can('permission', 'dashboard.view')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                            <span class="inline-flex items-center gap-1"><i class="fa-solid fa-user-shield text-xs"></i> {{ __('Admin') }}</span>
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <i class="fa-solid fa-user-circle me-1 text-[#0d7f7a]"></i>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-id-card text-gray-400"></i> {{ __('Profile') }}</span>
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-right-from-bracket text-gray-400"></i> {{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <i class="fa-solid text-lg" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-house"></i> {{ __('Beranda') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('catalog')" :active="request()->routeIs('catalog')">
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-store"></i> {{ __('Katalog') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard.rfqs.index')" :active="request()->routeIs('dashboard.rfqs.*')">
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-file-invoice-dollar"></i> {{ __('RFQ saya') }}</span>
            </x-responsive-nav-link>
            @can('permission', 'dashboard.view')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                    <span class="inline-flex items-center gap-2"><i class="fa-solid fa-user-shield"></i> {{ __('Admin') }}</span>
                </x-responsive-nav-link>
            @endcan
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

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
