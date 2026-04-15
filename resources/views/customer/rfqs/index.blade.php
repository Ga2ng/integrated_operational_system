<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0d7f7a] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-file-invoice-dollar"></i> {{ __('Penawaran saya (RFQ)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="rounded-md bg-green-50 text-green-800 px-4 py-2 text-sm border border-green-200">{{ session('status') }}</div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('dashboard.rfqs.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium">
                    <i class="fa-solid fa-plus"></i> Ajukan penawaran
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-600">
                            <tr>
                                <th class="pb-2">Kebutuhan</th>
                                <th class="pb-2">Nilai</th>
                                <th class="pb-2">Status</th>
                                <th class="pb-2">Tanggal</th>
                                <th class="pb-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rfqs as $rfq)
                                <tr class="border-t border-gray-100">
                                    <td class="py-2">{{ $rfq->request_title }}</td>
                                    <td class="py-2">Rp {{ number_format($rfq->quoted_amount, 0, ',', '.') }}</td>
                                    <td class="py-2">{{ $rfq->status }}</td>
                                    <td class="py-2">{{ $rfq->transaction_date->format('d M Y') }}</td>
                                    <td class="py-2 text-right">
                                        <a href="{{ route('dashboard.rfqs.show', $rfq) }}" class="text-[#0d7f7a] hover:underline"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-4 text-gray-500">Belum ada penawaran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div>{{ $rfqs->links() }}</div>
        </div>
    </div>
</x-app-layout>
