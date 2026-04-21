<x-site-layout>
    <x-slot name="title">Katalog — {{ config('app.name') }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {{-- Header --}}
        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#0d7f7a]/8 border border-[#0d7f7a]/10 mb-6">
                <i class="fa-solid fa-layer-group text-[#0d7f7a] text-sm"></i>
                <span class="text-[#0d7f7a] text-xs font-bold uppercase tracking-wider">Modul Platform</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4">
                Modul
                <span class="bg-gradient-to-r from-[#0d7f7a] to-[#14b8a6] bg-clip-text text-transparent">Sistem</span>
            </h1>
            <p class="text-gray-500 leading-relaxed">
                Empat modul inti pada Integrated Operational System yang dirancang untuk mendukung seluruh proses bisnis Anda.
            </p>
        </div>

        {{-- Module Grid --}}
        <div class="grid sm:grid-cols-2 gap-8 max-w-4xl mx-auto">
            @foreach ($modules as $i => $module)
                @php
                    $gradients = [
                        'from-teal-500/10 to-emerald-500/5',
                        'from-blue-500/10 to-cyan-500/5',
                        'from-violet-500/10 to-purple-500/5',
                        'from-amber-500/10 to-orange-500/5',
                    ];
                    $iconBgs = [
                        'bg-teal-500/10 text-teal-600',
                        'bg-blue-500/10 text-blue-600',
                        'bg-violet-500/10 text-violet-600',
                        'bg-amber-500/10 text-amber-600',
                    ];
                    $borderColors = [
                        'border-teal-200/60',
                        'border-blue-200/60',
                        'border-violet-200/60',
                        'border-amber-200/60',
                    ];
                @endphp
                <article class="group rounded-3xl border {{ $borderColors[$i % 4] }} bg-gradient-to-br {{ $gradients[$i % 4] }} p-8 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-400 relative overflow-hidden">
                    {{-- Decorative corner --}}
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-white/30 to-transparent rounded-bl-[60px]"></div>

                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl {{ $iconBgs[$i % 4] }} flex items-center justify-center text-xl mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid {{ $module['icon'] }}"></i>
                        </div>
                        <h2 class="font-bold text-xl text-gray-900 mb-3 group-hover:text-[#0d7f7a] transition-colors">
                            {{ $module['name'] }}
                        </h2>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $module['description'] }}</p>

                        <div class="mt-6 flex items-center gap-2 text-[#0d7f7a] text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span>Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Bottom CTA --}}
        <div class="text-center mt-16">
            <div class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-gray-50 border border-gray-100">
                <i class="fa-solid fa-circle-info text-[#0d7f7a]"></i>
                <span class="text-sm text-gray-600">Hubungi kami untuk demo modul dan konsultasi kebutuhan Anda.</span>
            </div>
        </div>
    </div>
</x-site-layout>
