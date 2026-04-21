<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Integrated Operational System — Platform manajemen proyek, RFQ, katalog, dan sertifikat digital terpadu.">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --site-primary: #0d7f7a;
            --site-primary-dark: #0a5f5b;
            --site-primary-light: #10a8a2;
            --site-accent: #14b8a6;
            --site-gold: #f59e0b;
        }
        body { font-family: 'Inter', sans-serif; }

        /* Glassmorphism Navbar */
        .navbar-glass {
            background: rgba(10, 95, 91, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .navbar-glass.scrolled {
            background: rgba(10, 95, 91, 0.96);
            box-shadow: 0 4px 30px rgba(0,0,0,0.15);
        }

        /* Nav link style */
        .nav-link-site {
            position: relative;
            color: rgba(255,255,255,0.82);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.5rem 0;
            transition: color 0.25s ease;
        }
        .nav-link-site::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--site-accent), var(--site-gold));
            border-radius: 2px;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-link-site:hover, .nav-link-site.is-active {
            color: #fff;
        }
        .nav-link-site:hover::after, .nav-link-site.is-active::after {
            width: 100%;
        }

        /* CTA button glow */
        .btn-glow {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--site-primary-light) 0%, var(--site-primary) 100%);
            transition: all 0.3s ease;
        }
        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .btn-glow:hover::before { left: 100%; }
        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(20,184,166,0.35);
            transform: translateY(-1px);
        }

        .btn-outline-glow {
            border: 1.5px solid rgba(255,255,255,0.4);
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-outline-glow:hover {
            border-color: var(--site-accent);
            background: rgba(20,184,166,0.1);
            box-shadow: 0 0 20px rgba(20,184,166,0.15);
        }

        /* Animated gradient background */
        .gradient-mesh {
            background:
                radial-gradient(ellipse at 20% 50%, rgba(13,127,122,0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(20,184,166,0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(245,158,11,0.04) 0%, transparent 50%);
        }

        /* Mobile menu */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-menu.open { transform: translateX(0); }

        /* Footer gradient */
        .footer-gradient {
            background: linear-gradient(180deg, #0c1a19 0%, #0a1412 100%);
        }

        /* Floating particles */
        @keyframes float-particle {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.4; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.8; }
        }
        .particle {
            position: absolute;
            width: 4px; height: 4px;
            background: var(--site-accent);
            border-radius: 50%;
            animation: float-particle 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased bg-white text-gray-900 min-h-screen flex flex-col" x-data="{ mobileOpen: false }" @keydown.escape.window="mobileOpen = false">

    {{-- ═══════════════════ NAVBAR ═══════════════════ --}}
    <header
        id="site-navbar"
        class="navbar-glass fixed top-0 left-0 right-0 z-[100] transition-all duration-300"
        x-data="{
            scrolled: false,
            init() {
                window.addEventListener('scroll', () => { this.scrolled = window.scrollY > 20 })
            }
        }"
        :class="{ 'scrolled': scrolled }"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-[72px]">
                {{-- Brand --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center shadow-lg shadow-black/10 group-hover:bg-white/25 transition-all duration-300">
                        <i class="fa-solid fa-layer-group text-white text-lg"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-white font-bold text-[15px] tracking-tight block leading-tight">{{ config('app.name') }}</span>
                        <span class="text-[10px] text-teal-200/60 font-medium uppercase tracking-[0.15em]">Operational Platform</span>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="nav-link-site @if(request()->routeIs('home')) is-active @endif">
                        Beranda
                    </a>
                    <a href="{{ route('catalog') }}" class="nav-link-site @if(request()->routeIs('catalog')) is-active @endif">
                        Katalog
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link-site">
                            Dashboard
                        </a>
                        @can('permission', 'dashboard.view')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link-site">
                                Admin
                            </a>
                        @endcan
                    @endauth
                </nav>

                {{-- Desktop Auth --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center">
                                <i class="fa-solid fa-user text-white text-xs"></i>
                            </div>
                            <span class="text-white/80 text-sm font-medium max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-white/60 hover:text-white text-sm transition-colors ml-2" title="Keluar">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white/80 hover:text-white text-sm font-medium transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-glow rounded-full px-5 py-2.5 text-white text-sm font-semibold shadow-lg">
                            Daftar Sekarang
                        </a>
                    @endauth
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
    </header>

    {{-- ═══════════════════ MOBILE MENU ═══════════════════ --}}
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="mobileOpen = false"
        class="fixed inset-0 z-[110] bg-black/50 backdrop-blur-sm md:hidden"
        x-cloak
    ></div>
    <aside
        class="mobile-menu fixed top-0 right-0 z-[120] w-[280px] h-full bg-gradient-to-b from-[#0a5f5b] to-[#08403e] shadow-2xl md:hidden overflow-y-auto"
        :class="{ 'open': mobileOpen }"
        x-cloak
    >
        <div class="p-6 space-y-6">
            <div class="flex justify-between items-center">
                <span class="text-white font-bold text-lg">Menu</span>
                <button @click="mobileOpen = false" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-medium @if(request()->routeIs('home')) bg-white/15 text-white @endif">
                    <i class="fa-solid fa-home w-5 text-center"></i> Beranda
                </a>
                <a href="{{ route('catalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-medium @if(request()->routeIs('catalog')) bg-white/15 text-white @endif">
                    <i class="fa-solid fa-store w-5 text-center"></i> Katalog
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-medium">
                        <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
                    </a>
                    @can('permission', 'dashboard.view')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-medium">
                            <i class="fa-solid fa-shield-halved w-5 text-center"></i> Admin
                        </a>
                    @endcan
                @endauth
            </nav>
            <div class="border-t border-white/10 pt-4 space-y-2">
                @auth
                    <div class="flex items-center gap-3 px-4 py-2">
                        <div class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center">
                            <i class="fa-solid fa-user text-white text-xs"></i>
                        </div>
                        <span class="text-white text-sm font-medium truncate">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-300 hover:text-white hover:bg-red-500/20 transition-all text-sm font-medium w-full">
                            <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-medium">
                        <i class="fa-solid fa-right-to-bracket w-5 text-center"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-glow flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white text-sm font-semibold mt-2">
                        <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </aside>

    {{-- Spacer --}}
    <div class="h-[72px]"></div>

    {{-- ═══════════════════ MAIN ═══════════════════ --}}
    <main class="flex-1 gradient-mesh">
        {{ $slot }}
    </main>

    {{-- ═══════════════════ FOOTER ═══════════════════ --}}
    <footer class="footer-gradient text-gray-400 relative overflow-hidden">
        {{-- Decorative top border --}}
        <div class="h-px bg-gradient-to-r from-transparent via-teal-500/40 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-4 gap-10 mb-12">
                {{-- Company Info --}}
                <div class="md:col-span-2 space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-500/15 flex items-center justify-center">
                            <i class="fa-solid fa-layer-group text-teal-400"></i>
                        </div>
                        <span class="text-white font-bold text-lg">{{ config('app.name') }}</span>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-md">
                        Platform operasional terintegrasi yang dirancang untuk mengelola seluruh proses bisnis — dari manajemen proyek, penawaran, inventori, hingga penerbitan sertifikat digital dalam satu ekosistem yang aman dan efisien.
                    </p>
                    <div class="flex gap-3">
                        <span class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-gray-500 hover:text-teal-400 hover:bg-teal-500/10 transition-all cursor-pointer">
                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                        </span>
                        <span class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-gray-500 hover:text-teal-400 hover:bg-teal-500/10 transition-all cursor-pointer">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </span>
                        <span class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-gray-500 hover:text-teal-400 hover:bg-teal-500/10 transition-all cursor-pointer">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="space-y-4">
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider">Navigasi</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-teal-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-teal-600"></i> Beranda</a></li>
                        <li><a href="{{ route('catalog') }}" class="text-gray-500 hover:text-teal-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-teal-600"></i> Katalog</a></li>
                        <li><a href="{{ route('certificates.verify', ['code' => 'DEMO-CERT-0001']) }}" class="text-gray-500 hover:text-teal-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[8px] text-teal-600"></i> Cek Sertifikat</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div class="space-y-4">
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider">Kontak</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2 text-gray-500">
                            <i class="fa-solid fa-location-dot text-teal-600 mt-1 text-xs"></i>
                            <span>Jakarta, Indonesia</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-500">
                            <i class="fa-solid fa-envelope text-teal-600 mt-1 text-xs"></i>
                            <span>info@opsystem.id</span>
                        </li>
                        <li class="flex items-start gap-2 text-gray-500">
                            <i class="fa-solid fa-phone text-teal-600 mt-1 text-xs"></i>
                            <span>+62 21 xxxx xxxx</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom strip --}}
            <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-gray-600 text-xs flex items-center gap-1.5">
                    <i class="fa-solid fa-copyright text-[10px]"></i>
                    {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
                <div class="flex items-center gap-4 text-xs text-gray-600">
                    <a href="{{ route('certificates.verify', ['code' => 'DEMO-CERT-0001']) }}" class="hover:text-teal-400 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-certificate text-[10px]"></i> Verifikasi Sertifikat
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
