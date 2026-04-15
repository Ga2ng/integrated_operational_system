<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@isset($title){{ $title }} — @endisset{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 min-h-screen">
    <div class="min-h-screen flex">
        <aside class="w-64 shrink-0 bg-[#0d7f7a] text-white min-h-screen p-4 flex flex-col">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-lg mb-8">
                <i class="fa-solid fa-screwdriver-wrench"></i> Panel Admin
            </a>
            <nav class="space-y-1 flex-1 text-sm">
                @can('permission', 'dashboard.view')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded px-3 py-2 hover:bg-white/10 @if(request()->routeIs('admin.dashboard')) bg-white/20 @endif">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                @endcan
                @can('permission', 'project.view')
                    <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-2 rounded px-3 py-2 hover:bg-white/10 @if(request()->routeIs('admin.projects.*')) bg-white/20 @endif">
                        <i class="fa-solid fa-diagram-project"></i> Proyek
                    </a>
                @endcan
                @can('permission', 'rfq.view')
                    <a href="{{ route('admin.rfqs.index') }}" class="flex items-center gap-2 rounded px-3 py-2 hover:bg-white/10 @if(request()->routeIs('admin.rfqs.*')) bg-white/20 @endif">
                        <i class="fa-solid fa-file-invoice-dollar"></i> RFQ
                    </a>
                @endcan
                @can('permission', 'product.view')
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 rounded px-3 py-2 hover:bg-white/10 @if(request()->routeIs('admin.products.*')) bg-white/20 @endif">
                        <i class="fa-solid fa-box"></i> Produk
                    </a>
                @endcan
                @can('permission', 'client.view')
                    <a href="{{ route('admin.clients.index') }}" class="flex items-center gap-2 rounded px-3 py-2 hover:bg-white/10 @if(request()->routeIs('admin.clients.*')) bg-white/20 @endif">
                        <i class="fa-solid fa-users"></i> Klien
                    </a>
                @endcan
                @can('permission', 'certificate.view')
                    <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2 rounded px-3 py-2 hover:bg-white/10 @if(request()->routeIs('admin.certificates.*')) bg-white/20 @endif">
                        <i class="fa-solid fa-award"></i> Sertifikat
                    </a>
                @endcan
            </nav>
            <div class="pt-4 border-t border-white/20 text-xs space-y-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2 hover:underline">
                    <i class="fa-solid fa-globe"></i> Situs publik
                </a>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:underline">
                    <i class="fa-solid fa-user"></i> Akun
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 hover:underline w-full text-left">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>
        <div class="flex-1 flex flex-col min-w-0">
            @if (session('status'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 m-4 rounded">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 m-4 rounded">{{ session('error') }}</div>
            @endif
            <div class="p-6 flex-1 overflow-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
