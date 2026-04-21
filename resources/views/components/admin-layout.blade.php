@php
    $u = auth()->user();
    $hasLogo = file_exists(public_path('images/logo.png'));
    $showProjectManagement = $u && $u->hasPermission('project.view');
    $showSalesInventory = $u && ($u->hasPermission('rfq.view') || $u->hasPermission('inventory.view'));
    $showMasterData = $u && $u->hasPermission('client.view');
    $showTraining = $u && $u->hasPermission('certificate.view');
    $showLogs = $u && $u->hasPermission('logs.view');
    $projectManagementOpen = request()->routeIs('admin.projects.*');
    $salesInventoryOpen = request()->routeIs('admin.rfqs.*', 'admin.inventory-materials.*');
    $masterDataOpen = request()->routeIs('admin.clients.*');
    $trainingOpen = request()->routeIs('admin.certificates.*');
    $pengaturanOpen = request()->routeIs('admin.settings.roles.*');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="admin-app">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@isset($title){{ $title }} — @endisset{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900" style="font-family: 'Inter', sans-serif;">
    <div
        class="min-h-screen lg:h-screen lg:overflow-hidden"
        x-data="{ sidebarOpen: false }"
        @keydown.window.escape="sidebarOpen = false"
    >
        {{-- Mobile overlay --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            x-cloak
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <div class="flex min-h-screen lg:h-screen">
            {{-- ═══════════════════ SIDEBAR ═══════════════════ --}}
            <aside
                id="admin-sidebar"
                data-admin-sidebar
                class="admin-sidebar fixed inset-y-0 left-0 z-50 flex h-screen w-64 max-w-[min(16rem,calc(100vw-2.5rem))] -translate-x-full transform flex-col overflow-hidden transition-transform duration-200 ease-out lg:static lg:z-auto lg:max-w-none lg:shrink-0 lg:translate-x-0"
                :class="{ 'translate-x-0': sidebarOpen }"
            >
                {{-- Brand --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    @click="sidebarOpen = false"
                    class="admin-sidebar-brand shrink-0 flex items-center px-5 py-4 transition-opacity hover:opacity-90"
                >
                    @if ($hasLogo)
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="{{ config('app.name') }}"
                            class="h-10 w-full max-h-12 object-contain object-left"
                        >
                    @else
                        <span class="flex w-full items-center gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/15 shadow-lg shadow-black/10 backdrop-blur-sm border border-white/10">
                                <i class="fas fa-layer-group text-white"></i>
                            </span>
                            <span class="text-left">
                                <span class="block text-sm font-bold leading-tight text-white">{{ config('app.name') }}</span>
                                <span class="block text-[9px] text-teal-200/50 uppercase tracking-[0.12em] font-medium">Admin Panel</span>
                            </span>
                        </span>
                    @endif
                </a>

                {{-- Nav --}}
                <nav class="admin-sidebar-nav flex-1 min-h-0 overflow-y-auto px-3 py-4 space-y-1">
                    @can('permission', 'dashboard.view')
                        <a
                            href="{{ route('admin.dashboard') }}"
                            @click="sidebarOpen = false"
                            class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
                        >
                            <i class="fas fa-chart-line w-4 text-center text-xs opacity-95"></i>
                            <span>Dashboard</span>
                            @if (request()->routeIs('admin.dashboard'))
                                <span class="admin-nav-dot"></span>
                            @endif
                        </a>
                    @endcan

                    {{-- Section label --}}
                    @if ($showProjectManagement || $showSalesInventory || $showMasterData || $showTraining)
                        <div class="px-3 pt-5 pb-1">
                            <span class="text-[9px] font-bold text-white/30 uppercase tracking-[0.15em]">Modul Operasional</span>
                        </div>
                    @endif

                    @if ($showProjectManagement)
                        <details class="admin-nav-group" {{ $projectManagementOpen ? 'open' : '' }}>
                            <summary class="admin-nav-summary">
                                <i class="fas fa-briefcase w-4 text-center text-xs"></i>
                                <span>Project Management</span>
                                <i class="fas fa-chevron-down admin-nav-chevron"></i>
                            </summary>
                            <div class="admin-nav-subwrap space-y-0.5">
                                @can('permission', 'project.view')
                                    <a href="{{ route('admin.projects.index') }}" @click="sidebarOpen = false" class="admin-nav-sublink {{ request()->routeIs('admin.projects.*') ? 'is-active' : '' }}">
                                        <i class="fas fa-diagram-project w-3 text-center"></i> Proyek
                                    </a>
                                @endcan
                            </div>
                        </details>
                    @endif

                    @if ($showSalesInventory)
                        <details class="admin-nav-group" {{ $salesInventoryOpen ? 'open' : '' }}>
                            <summary class="admin-nav-summary">
                                <i class="fas fa-warehouse w-4 text-center text-xs"></i>
                                <span>Sales & Inventory</span>
                                <i class="fas fa-chevron-down admin-nav-chevron"></i>
                            </summary>
                            <div class="admin-nav-subwrap space-y-0.5">
                                @can('permission', 'rfq.view')
                                    <a href="{{ route('admin.rfqs.index') }}" @click="sidebarOpen = false" class="admin-nav-sublink {{ request()->routeIs('admin.rfqs.*') ? 'is-active' : '' }}">
                                        <i class="fas fa-file-invoice-dollar w-3 text-center"></i> RFQ
                                    </a>
                                @endcan
                                @can('permission', 'inventory.view')
                                    <a href="{{ route('admin.inventory-materials.index') }}" @click="sidebarOpen = false" class="admin-nav-sublink {{ request()->routeIs('admin.inventory-materials.*') ? 'is-active' : '' }}">
                                        <i class="fas fa-boxes-stacked w-3 text-center"></i> Inventory Material
                                    </a>
                                @endcan
                            </div>
                        </details>
                    @endif

                    @if ($showMasterData)
                        <details class="admin-nav-group" {{ $masterDataOpen ? 'open' : '' }}>
                            <summary class="admin-nav-summary">
                                <i class="fas fa-database w-4 text-center text-xs"></i>
                                <span>Master Data</span>
                                <i class="fas fa-chevron-down admin-nav-chevron"></i>
                            </summary>
                            <div class="admin-nav-subwrap space-y-0.5">
                                @can('permission', 'client.view')
                                    <a href="{{ route('admin.clients.index') }}" @click="sidebarOpen = false" class="admin-nav-sublink {{ request()->routeIs('admin.clients.*') ? 'is-active' : '' }}">
                                        <i class="fas fa-users w-3 text-center"></i> Akun Guest / Klien
                                    </a>
                                @endcan
                            </div>
                        </details>
                    @endif

                    @if ($showTraining)
                        <details class="admin-nav-group" {{ $trainingOpen ? 'open' : '' }}>
                            <summary class="admin-nav-summary">
                                <i class="fas fa-graduation-cap w-4 text-center text-xs"></i>
                                <span>Training Management</span>
                                <i class="fas fa-chevron-down admin-nav-chevron"></i>
                            </summary>
                            <div class="admin-nav-subwrap space-y-0.5">
                                @can('permission', 'certificate.view')
                                    <a href="{{ route('admin.certificates.index') }}" @click="sidebarOpen = false" class="admin-nav-sublink {{ request()->routeIs('admin.certificates.*') ? 'is-active' : '' }}">
                                        <i class="fas fa-award w-3 text-center"></i> Sertifikasi
                                    </a>
                                @endcan
                            </div>
                        </details>
                    @endif

                    @can('permission', 'role.view')
                        <div class="px-3 pt-5 pb-1">
                            <span class="text-[9px] font-bold text-white/30 uppercase tracking-[0.15em]">Konfigurasi</span>
                        </div>
                        <details class="admin-nav-group" {{ $pengaturanOpen ? 'open' : '' }}>
                            <summary class="admin-nav-summary">
                                <i class="fas fa-cog w-4 text-center text-xs"></i>
                                <span>Pengaturan</span>
                                <i class="fas fa-chevron-down admin-nav-chevron"></i>
                            </summary>
                            <div class="admin-nav-subwrap space-y-0.5">
                                <a href="{{ route('admin.settings.roles.index') }}" @click="sidebarOpen = false" class="admin-nav-sublink {{ request()->routeIs('admin.settings.roles.*') ? 'is-active' : '' }}">
                                    <i class="fas fa-user-shield w-3 text-center"></i> Peran &amp; izin
                                </a>
                            </div>
                        </details>
                    @endcan

                    @if ($showLogs)
                        <a
                            href="{{ route('admin.logs.index') }}"
                            @click="sidebarOpen = false"
                            class="admin-nav-link mt-1 {{ request()->routeIs('admin.logs.*') ? 'is-active' : '' }}"
                        >
                            <i class="fas fa-clock-rotate-left w-4 text-center text-xs opacity-95"></i>
                            <span>Logs</span>
                            @if (request()->routeIs('admin.logs.*'))
                                <span class="admin-nav-dot"></span>
                            @endif
                        </a>
                    @endif

                    <a
                        href="{{ route('profile.edit') }}"
                        @click="sidebarOpen = false"
                        class="admin-nav-link mt-1 {{ request()->routeIs('profile.edit') ? 'is-active' : '' }}"
                    >
                        <i class="fas fa-user-edit w-4 text-center text-xs opacity-95"></i>
                        <span>Edit profil</span>
                    </a>
                </nav>

                {{-- Sidebar footer --}}
                <div class="admin-sidebar-footer shrink-0 px-3 py-3 space-y-0.5">
                    {{-- User info --}}
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
                    <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="admin-sidebar-footer-link">
                        <i class="fas fa-user w-4 text-center text-xs"></i>
                        <span>Akun klien</span>
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

            {{-- ═══════════════════ MAIN ═══════════════════ --}}
            <div class="admin-main flex min-h-screen min-w-0 flex-1 flex-col lg:h-screen lg:overflow-hidden">
                {{-- Topbar (mobile) --}}
                <header class="admin-topbar">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors"
                        @click="sidebarOpen = true"
                        aria-label="Buka menu"
                    >
                        <i class="fas fa-bars text-xs"></i>
                        Menu
                    </button>
                    <span class="truncate text-sm font-semibold text-gray-800">{{ $title ?? 'Panel Admin' }}</span>
                </header>

                {{-- Content --}}
                <div class="admin-content flex-1 lg:overflow-y-auto">
                    @if (session('status'))
                        <div class="admin-alert admin-alert--success">
                            <i class="fa-solid fa-circle-check mr-1.5"></i>{{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="admin-alert admin-alert--error">
                            <i class="fa-solid fa-circle-xmark mr-1.5"></i>{{ session('error') }}
                        </div>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
