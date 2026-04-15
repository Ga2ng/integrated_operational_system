<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <header class="bg-[#0d7f7a] text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-lg">
                    <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                    <span>{{ config('app.name') }}</span>
                </a>
                <nav class="flex items-center gap-4 text-sm font-medium">
                    <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1 @if(request()->routeIs('home')) underline @endif">
                        <i class="fa-solid fa-house"></i> Beranda
                    </a>
                    <a href="{{ route('catalog') }}" class="hover:underline flex items-center gap-1 @if(request()->routeIs('catalog')) underline @endif">
                        <i class="fa-solid fa-store"></i> Katalog
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-gauge"></i> Dashboard
                        </a>
                        @can('permission', 'dashboard.view')
                            <a href="{{ route('admin.dashboard') }}" class="hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-user-shield"></i> Admin
                            </a>
                        @endcan
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-right-to-bracket"></i> Masuk
                        </a>
                        <a href="{{ route('register') }}" class="rounded-md bg-white/15 px-3 py-1.5 hover:bg-white/25 flex items-center gap-1">
                            <i class="fa-solid fa-user-plus"></i> Daftar
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{ $slot }}
    </main>

    <footer class="bg-gray-900 text-gray-400 text-sm mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row justify-between gap-4">
            <p class="flex items-center gap-2"><i class="fa-solid fa-copyright"></i> {{ date('Y') }} {{ config('app.name') }}</p>
            <a href="{{ route('certificates.verify', ['code' => 'DEMO-CERT-0001']) }}" class="hover:text-white flex items-center gap-2">
                <i class="fa-solid fa-certificate"></i> Cek sertifikat (demo)
            </a>
        </div>
    </footer>
</body>
</html>
