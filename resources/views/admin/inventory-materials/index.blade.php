<x-admin-layout>
    <x-slot name="title">Inventory Material</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-warehouse" style="color: var(--admin-primary);"></i> Inventory Material</h1>
            <p class="admin-page-desc">Saldo stok, minimum stok, dan status LOW/OK untuk referensi RFQ dan katalog publik.</p>
        </div>
        @can('permission', 'inventory.create')
            <a href="{{ route('admin.inventory-materials.create') }}" class="admin-btn admin-btn--primary"><i class="fas fa-plus"></i> Tambah</a>
        @endcan
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:60px;">Gambar</th>
                    <th>Kode</th>
                    <th>Material</th>
                    <th>UoM</th>
                    <th>Stok Saat Ini</th>
                    <th>Minimum</th>
                    <th>Biaya Satuan</th>
                    <th>Status</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($materials as $material)
                    <tr>
                        <td>
                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200">
                                @if($material->image)
                                    <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-image text-slate-300 text-sm"></i>
                                @endif
                            </div>
                        </td>
                        <td class="font-mono text-xs">{{ $material->code }}</td>
                        <td class="font-medium text-slate-800">{{ $material->name }}</td>
                        <td>{{ $material->uom }}</td>
                        <td>{{ number_format($material->current_stock, 2) }}</td>
                        <td>{{ number_format($material->minimum_stock, 2) }}</td>
                        <td>Rp {{ number_format($material->unit_cost, 0, ',', '.') }}</td>
                        <td>
                            <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $material->stock_status === 'LOW' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $material->stock_status }}
                            </span>
                        </td>
                        <td class="admin-table-actions">
                            <a href="{{ route('catalog.show', $material) }}" target="_blank" class="font-semibold text-slate-400 hover:text-[#0d7f7a]" title="Lihat di Katalog">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('permission', 'inventory.update')
                                <a href="{{ route('admin.inventory-materials.edit', $material) }}" class="font-semibold" style="color: var(--admin-primary);"><i class="fas fa-pen"></i></a>
                            @endcan
                            @can('permission', 'inventory.delete')
                                <form action="{{ route('admin.inventory-materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Hapus material ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--danger !p-0"><i class="fas fa-trash"></i></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-8 text-center text-slate-500">Belum ada data material inventory.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $materials->links() }}</div>
</x-admin-layout>
