<x-site-layout>
    <x-slot name="title">Katalog — {{ config('app.name') }}</x-slot>

    <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center gap-2">
        <i class="fa-solid fa-layer-group text-[#0d7f7a]"></i> Modul Sistem
    </h1>
    <p class="text-gray-600 mb-8">Empat modul inti pada Integrated Operational System.</p>

    <div class="grid sm:grid-cols-2 gap-6">
        @foreach ($modules as $module)
            <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="font-semibold text-lg text-gray-900 mb-2 flex items-center gap-2">
                    <i class="fa-solid {{ $module['icon'] }} text-[#0d7f7a]"></i>
                    {{ $module['name'] }}
                </h2>
                <p class="text-sm text-gray-600">{{ $module['description'] }}</p>
            </article>
        @endforeach
    </div>
</x-site-layout>
