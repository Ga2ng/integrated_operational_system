<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .auth-bg {
            background: linear-gradient(135deg, #0c1a19 0%, #0a3d3a 30%, #0d7f7a 60%, #0a3d3a 85%, #0c1a19 100%);
            background-size: 400% 400%;
            animation: auth-gradient 20s ease infinite;
        }
        @keyframes auth-gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .auth-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .auth-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow:
                0 25px 50px -12px rgba(0,0,0,0.25),
                0 0 80px rgba(13,127,122,0.08);
        }
        .auth-input:focus {
            border-color: #0d7f7a !important;
            box-shadow: 0 0 0 3px rgba(13,127,122,0.12) !important;
        }
    </style>
</head>
<body class="antialiased text-gray-900">
    <div class="auth-bg min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
        {{-- Background grid overlay --}}
        <div class="auth-grid absolute inset-0"></div>

        {{-- Floating orbs --}}
        <div class="absolute top-20 left-10 w-64 h-64 rounded-full bg-teal-400/10 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 rounded-full bg-teal-300/5 blur-3xl animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 w-full flex flex-col items-center">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-8 group">
                <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center shadow-lg shadow-black/20 backdrop-blur-sm border border-white/10 group-hover:bg-white/25 transition-all duration-300">
                    <i class="fa-solid fa-layer-group text-white text-2xl"></i>
                </div>
                <div>
                    <span class="text-white font-bold text-xl tracking-tight block">{{ config('app.name') }}</span>
                    <span class="text-[10px] text-teal-200/50 font-medium uppercase tracking-[0.15em]">Operational Platform</span>
                </div>
            </a>

            {{-- Card --}}
            <div class="auth-card w-full sm:max-w-md px-8 py-8 sm:rounded-3xl overflow-hidden">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <p class="mt-6 text-xs text-white/30 text-center">
                <i class="fa-solid fa-copyright text-[8px]"></i>
                {{ date('Y') }} {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>
</html>
