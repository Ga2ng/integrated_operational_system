<x-admin-layout>
    <x-slot name="title">RFQ</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-file-invoice-dollar" style="color: var(--admin-primary);"></i> RFQ</h1>
            <p class="admin-page-desc">Penawaran dan status transaksi.</p>
        </div>
        @can('permission', 'rfq.create')
            <a href="{{ route('admin.rfqs.create') }}" class="admin-btn admin-btn--primary"><i class="fas fa-plus"></i> Tambah</a>
        @endcan
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Klien</th>
                    <th>Kebutuhan</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Material</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rfqs as $rfq)
                    <tr>
                        <td class="font-medium text-slate-800">{{ $rfq->client->name }}</td>
                        <td>{{ $rfq->request_title }}</td>
                        <td>Rp {{ number_format($rfq->quoted_amount, 0, ',', '.') }}</td>
                        <td><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium capitalize">{{ $rfq->status }}</span></td>
                        <td>{{ $rfq->material_items_count }}</td>
                        <td class="admin-table-actions">
                            @can('permission', 'rfq.update')
                                <a href="{{ route('admin.rfqs.edit', $rfq) }}" class="font-semibold" style="color: var(--admin-primary);"><i class="fas fa-pen"></i></a>
                            @endcan
                            @can('permission', 'rfq.delete')
                                <form action="{{ route('admin.rfqs.destroy', $rfq) }}" method="POST" class="inline" onsubmit="return confirm('Hapus RFQ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--danger !p-0"><i class="fas fa-trash"></i></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $rfqs->links() }}</div>

    <div class="admin-card mt-4">
        <div class="admin-card-header flex items-center gap-2">
            <i class="fas fa-right-from-bracket" style="color: var(--admin-primary);"></i>
            Log item keluar dari RFQ
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>RFQ</th>
                        <th>Material</th>
                        <th>Qty keluar</th>
                        <th>Stok sebelum</th>
                        <th>Stok sesudah</th>
                        <th>Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stockOutLogs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td>#{{ $log->rfq_id }} - {{ $log->rfq?->request_title ?? '-' }}</td>
                            <td>{{ $log->material?->name ?? '-' }}</td>
                            <td>{{ number_format($log->qty, 2) }}</td>
                            <td>{{ number_format($log->stock_before, 2) }}</td>
                            <td>{{ number_format($log->stock_after, 2) }}</td>
                            <td>{{ $log->creator?->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">Belum ada log item keluar dari RFQ.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
