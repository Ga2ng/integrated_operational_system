<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0d7f7a] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-file-lines"></i> {{ __('Detail RFQ') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-3 text-sm">
                <p><span class="text-gray-500">Kebutuhan:</span> {{ $rfq->request_title }}</p>
                <p><span class="text-gray-500">Nilai:</span> Rp {{ number_format($rfq->quoted_amount, 0, ',', '.') }}</p>
                <p><span class="text-gray-500">Status:</span> {{ $rfq->status }}</p>
                <p><span class="text-gray-500">Tanggal:</span> {{ $rfq->transaction_date->format('d M Y') }}</p>
                @if ($rfq->notes)
                    <p><span class="text-gray-500">Catatan:</span> {{ $rfq->notes }}</p>
                @endif
                <a href="{{ route('dashboard.rfqs.index') }}" class="inline-block mt-4 text-[#0d7f7a] hover:underline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>
