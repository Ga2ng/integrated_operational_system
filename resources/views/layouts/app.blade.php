@php
    $u = auth()->user();
    $hasLogo = file_exists(public_path('images/logo.png'));
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="admin-app">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900" style="font-family: 'Inter', sans-serif;">
    <div class="min-h-screen lg:h-screen lg:overflow-hidden" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
        <div x-show="sidebarOpen" x-transition.opacity x-cloak class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        <div class="flex min-h-screen lg:h-screen">
            <aside
                class="admin-sidebar fixed inset-y-0 left-0 z-50 flex h-screen w-64 max-w-[min(16rem,calc(100vw-2.5rem))] -translate-x-full transform flex-col overflow-hidden transition-transform duration-200 ease-out lg:static lg:z-auto lg:max-w-none lg:shrink-0 lg:translate-x-0"
                :class="{ 'translate-x-0': sidebarOpen }"
            >
                <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="admin-sidebar-brand shrink-0 flex items-center px-5 py-4 transition-opacity hover:opacity-90">
                    @if ($hasLogo)
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-full max-h-12 object-contain object-left">
                    @else
                        <span class="flex w-full items-center gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/15 shadow-lg shadow-black/10 backdrop-blur-sm border border-white/10">
                                <i class="fas fa-layer-group text-white"></i>
                            </span>
                            <span class="text-left">
                                <span class="block text-sm font-bold leading-tight text-white">{{ config('app.name') }}</span>
                                <span class="block text-[9px] text-teal-200/50 uppercase tracking-[0.12em] font-medium">Customer Panel</span>
                            </span>
                        </span>
                    @endif
                </a>

                <nav class="admin-sidebar-nav flex-1 min-h-0 overflow-y-auto px-3 py-4 space-y-1">
                    <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="admin-nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                        <i class="fas fa-gauge w-4 text-center text-xs opacity-95"></i>
                        <span>Dashboard</span>
                        @if (request()->routeIs('dashboard'))
                            <span class="admin-nav-dot"></span>
                        @endif
                    </a>
                    <a href="{{ route('dashboard.rfqs.index') }}" @click="sidebarOpen = false" class="admin-nav-link {{ request()->routeIs('dashboard.rfqs.*') ? 'is-active' : '' }}">
                        <i class="fas fa-file-invoice-dollar w-4 text-center text-xs opacity-95"></i>
                        <span>RFQ Saya</span>
                        @if (request()->routeIs('dashboard.rfqs.*'))
                            <span class="admin-nav-dot"></span>
                        @endif
                    </a>
                    <a href="{{ route('dashboard.my-certifications.index') }}" @click="sidebarOpen = false" class="admin-nav-link {{ request()->routeIs('dashboard.my-certifications.*') ? 'is-active' : '' }}">
                        <i class="fas fa-file-signature w-4 text-center text-xs opacity-95"></i>
                        <span>Sertifikasi Saya</span>
                        @if (request()->routeIs('dashboard.my-certifications.*'))
                            <span class="admin-nav-dot"></span>
                        @endif
                    </a>
                    <a href="{{ route('profile.edit') }}" @click="sidebarOpen = false" class="admin-nav-link {{ request()->routeIs('profile.edit') ? 'is-active' : '' }}">
                        <i class="fas fa-user-edit w-4 text-center text-xs opacity-95"></i>
                        <span>Edit Profil</span>
                    </a>
                    @if ($u?->canAccessAdminPanel())
                        <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false" class="admin-nav-link {{ request()->routeIs('admin.*') ? 'is-active' : '' }}">
                            <i class="fas fa-shield-halved w-4 text-center text-xs opacity-95"></i>
                            <span>Masuk Admin</span>
                        </a>
                    @endif
                </nav>

                <div class="admin-sidebar-footer shrink-0 px-3 py-3 space-y-0.5">
                    <div class="flex items-center gap-3 px-3 py-2.5 mb-2">
                        <div class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center shrink-0 border border-white/10">
                            <i class="fas fa-user text-white text-xs"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-white text-xs font-semibold truncate">{{ $u?->name ?? 'User' }}</div>
                            <div class="text-white/40 text-[10px] truncate">{{ $u?->email ?? '' }}</div>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" @click="sidebarOpen = false" class="admin-sidebar-footer-link">
                        <i class="fas fa-external-link-alt w-4 text-center text-xs"></i>
                        <span>Lihat situs</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="admin-sidebar-footer-link is-danger w-full text-left">
                            <i class="fas fa-right-from-bracket w-4 text-center text-xs"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </aside>

            <div class="admin-main flex min-h-screen min-w-0 flex-1 flex-col lg:h-screen lg:overflow-hidden">
                <header class="admin-topbar">
                    <button type="button" class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors" @click="sidebarOpen = true" aria-label="Buka menu">
                        <i class="fas fa-bars text-xs"></i>
                        Menu
                    </button>
                    <span class="truncate text-sm font-semibold text-gray-800">{{ isset($header) ? strip_tags($header) : 'Customer Panel' }}</span>
                </header>

                <div class="admin-content flex-1 lg:overflow-y-auto">
                    @isset($header)
                        <div class="admin-toolbar">
                            {{ $header }}
                        </div>
                    @endisset
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
