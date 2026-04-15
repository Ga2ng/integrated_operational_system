<x-admin-layout>
    <x-slot name="title">Edit RFQ</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-pen" style="color: var(--admin-primary);"></i> Edit RFQ</h1>
    <p class="admin-page-desc">Perbarui status, nilai penawaran, dan referensi stok material.</p>

    <form action="{{ route('admin.rfqs.update', $rfq) }}" method="POST" class="admin-card admin-card--padded w-full space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="admin-label">Klien</label>
            <select name="client_user_id" required class="admin-input">
                @foreach ($clients as $c)
                    <option value="{{ $c->id }}" @selected(old('client_user_id', $rfq->client_user_id) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="admin-label">Judul kebutuhan RFQ</label>
            <input type="text" name="request_title" value="{{ old('request_title', $rfq->request_title) }}" required class="admin-input">
        </div>
        <div>
            <label class="admin-label">Nilai</label>
            <input type="number" step="0.01" min="0" name="quoted_amount" value="{{ old('quoted_amount', $rfq->quoted_amount) }}" required class="admin-input">
        </div>
        <div>
            <label class="admin-label">Tanggal</label>
            <input type="date" name="transaction_date" value="{{ old('transaction_date', $rfq->transaction_date->format('Y-m-d')) }}" required class="admin-input">
        </div>
        <div>
            <label class="admin-label">Status</label>
            <select name="status" class="admin-input">
                <option value="pending" @selected(old('status', $rfq->status) === 'pending')>pending</option>
                <option value="approved" @selected(old('status', $rfq->status) === 'approved')>approved</option>
                <option value="closed" @selected(old('status', $rfq->status) === 'closed')>closed</option>
            </select>
        </div>
        <div>
            <label class="admin-label">Catatan</label>
            <textarea name="notes" rows="2" class="admin-input">{{ old('notes', $rfq->notes) }}</textarea>
        </div>
        <div class="rounded-lg border border-slate-200 p-3">
            <p class="mb-2 text-sm font-semibold text-slate-700">Kebutuhan material (opsional)</p>
            @php
                $items = old('materials', $rfq->materialItems->map(fn ($it) => ['material_inventory_id' => $it->material_inventory_id, 'qty_needed' => $it->qty_needed])->values()->all());
            @endphp
            <div class="space-y-2">
                @for ($i = 0; $i < 3; $i++)
                    <div class="grid gap-2 sm:grid-cols-3">
                        <select name="materials[{{ $i }}][material_inventory_id]" class="admin-input">
                            <option value="">- Pilih material -</option>
                            @foreach ($materials as $m)
                                <option value="{{ $m->id }}" @selected(($items[$i]['material_inventory_id'] ?? null) == $m->id)>
                                    {{ $m->name }} (stok: {{ number_format($m->current_stock, 2) }} {{ $m->uom }}, min: {{ number_format($m->minimum_stock, 2) }}) [{{ $m->stock_status }}]
                                </option>
                            @endforeach
                        </select>
                        <input type="number" step="0.01" min="0" name="materials[{{ $i }}][qty_needed]" value="{{ $items[$i]['qty_needed'] ?? '' }}" placeholder="Qty kebutuhan" class="admin-input">
                        <div class="flex items-center text-xs text-slate-500">Estimasi biaya otomatis dari harga material.</div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Perbarui</button>
            <a href="{{ route('admin.rfqs.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
