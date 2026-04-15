<x-admin-layout>
    <x-slot name="title">Tambah RFQ</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-plus" style="color: var(--admin-primary);"></i> Tambah RFQ</h1>
    <p class="admin-page-desc">Hubungkan klien dengan kebutuhan RFQ dan referensi stok material.</p>

    <form action="{{ route('admin.rfqs.store') }}" method="POST" class="admin-card admin-card--padded w-full space-y-4">
        @csrf
        <div>
            <label class="admin-label">Klien (user)</label>
            <select name="client_user_id" required class="admin-input">
                @foreach ($clients as $c)
                    <option value="{{ $c->id }}" @selected(old('client_user_id') == $c->id)>{{ $c->name }} ({{ $c->email }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="admin-label">Judul kebutuhan RFQ</label>
            <input type="text" name="request_title" value="{{ old('request_title') }}" required class="admin-input" placeholder="Contoh: Pengadaan material instalasi panel">
        </div>
        <div>
            <label class="admin-label">Nilai penawaran</label>
            <input type="number" step="0.01" min="0" name="quoted_amount" value="{{ old('quoted_amount') }}" required class="admin-input">
        </div>
        <div>
            <label class="admin-label">Tanggal transaksi</label>
            <input type="date" name="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d')) }}" required class="admin-input">
        </div>
        <div>
            <label class="admin-label">Status</label>
            <select name="status" class="admin-input">
                <option value="pending" @selected(old('status') === 'pending')>pending</option>
                <option value="approved" @selected(old('status') === 'approved')>approved</option>
                <option value="closed" @selected(old('status') === 'closed')>closed</option>
            </select>
        </div>
        <div>
            <label class="admin-label">Catatan</label>
            <textarea name="notes" rows="2" class="admin-input">{{ old('notes') }}</textarea>
        </div>
        <div class="rounded-lg border border-slate-200 p-3">
            <p class="mb-2 text-sm font-semibold text-slate-700">Kebutuhan material (opsional)</p>
            <div class="space-y-2">
                @for ($i = 0; $i < 3; $i++)
                    <div class="grid gap-2 sm:grid-cols-3">
                        <select name="materials[{{ $i }}][material_inventory_id]" class="admin-input">
                            <option value="">- Pilih material -</option>
                            @foreach ($materials as $m)
                                <option value="{{ $m->id }}" @selected(old("materials.$i.material_inventory_id") == $m->id)>
                                    {{ $m->name }} (stok: {{ number_format($m->current_stock, 2) }} {{ $m->uom }}, min: {{ number_format($m->minimum_stock, 2) }}) [{{ $m->stock_status }}]
                                </option>
                            @endforeach
                        </select>
                        <input type="number" step="0.01" min="0" name="materials[{{ $i }}][qty_needed]" value="{{ old("materials.$i.qty_needed") }}" placeholder="Qty kebutuhan" class="admin-input">
                        <div class="flex items-center text-xs text-slate-500">Estimasi biaya otomatis dari harga material.</div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.rfqs.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
