<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0d7f7a] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-gauge"></i> {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <p class="text-gray-600">{{ __('Selamat datang') }}, <strong>{{ auth()->user()->name }}</strong>. Gunakan menu untuk mengelola penawaran dan melihat sertifikat Anda.</p>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2"><i class="fa-solid fa-file-invoice-dollar text-[#0d7f7a]"></i> RFQ terbaru</h3>
                        <a href="{{ route('dashboard.rfqs.index') }}" class="text-sm text-[#0d7f7a] hover:underline">Lihat semua</a>
                    </div>
                    <ul class="divide-y divide-gray-100 text-sm">
                        @forelse ($rfqs as $rfq)
                            <li class="px-4 py-3 flex justify-between">
                                <span>{{ $rfq->request_title }}</span>
                                <span class="text-gray-500">{{ $rfq->status }}</span>
                            </li>
                        @empty
                            <li class="px-4 py-6 text-gray-500 text-center">Belum ada RFQ. <a href="{{ route('dashboard.rfqs.create') }}" class="text-[#0d7f7a] underline">Ajukan</a></li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2"><i class="fa-solid fa-award text-[#0d7f7a]"></i> Sertifikat</h3>
                    </div>
                    <ul class="divide-y divide-gray-100 text-sm">
                        @forelse ($certificates as $cert)
                            <li class="px-4 py-3 flex justify-between items-center">
                                <span class="font-mono text-xs">{{ $cert->validation_code }}</span>
                                <a href="{{ route('certificates.verify', $cert->validation_code) }}" target="_blank" class="text-[#0d7f7a] text-xs hover:underline"><i class="fa-solid fa-magnifying-glass"></i> Cek</a>
                            </li>
                        @empty
                            <li class="px-4 py-6 text-gray-500 text-center">Belum ada sertifikat.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('dashboard.rfqs.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium">
                    <i class="fa-solid fa-plus"></i> Ajukan RFQ baru
                </a>
                <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 rounded-lg border border-[#0d7f7a] text-[#0d7f7a] px-4 py-2 text-sm font-medium">
                    <i class="fa-solid fa-circle-info"></i> Lihat portal publik
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
