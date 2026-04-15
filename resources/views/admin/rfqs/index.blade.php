<x-admin-layout>
    <x-slot name="title">RFQ</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2"><i class="fa-solid fa-file-invoice-dollar text-[#0d7f7a]"></i> RFQ</h1>
        @can('permission', 'rfq.create')
            <a href="{{ route('admin.rfqs.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium hover:opacity-90">
                <i class="fa-solid fa-plus"></i> Tambah
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left">Klien</th>
                    <th class="px-4 py-2 text-left">Produk</th>
                    <th class="px-4 py-2 text-left">Nilai</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rfqs as $rfq)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-2">{{ $rfq->client->name }}</td>
                        <td class="px-4 py-2">{{ $rfq->product->name }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($rfq->quoted_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $rfq->status }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            @can('permission', 'rfq.update')
                                <a href="{{ route('admin.rfqs.edit', $rfq) }}" class="text-[#0d7f7a] hover:underline"><i class="fa-solid fa-pen"></i></a>
                            @endcan
                            @can('permission', 'rfq.delete')
                                <form action="{{ route('admin.rfqs.destroy', $rfq) }}" method="POST" class="inline" onsubmit="return confirm('Hapus RFQ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $rfqs->links() }}</div>
</x-admin-layout>
