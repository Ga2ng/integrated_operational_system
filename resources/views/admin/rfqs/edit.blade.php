<x-admin-layout>
    <x-slot name="title">Edit RFQ</x-slot>

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2"><i class="fa-solid fa-pen text-[#0d7f7a]"></i> Edit RFQ</h1>

    <form action="{{ route('admin.rfqs.update', $rfq) }}" method="POST" class="max-w-xl space-y-4 bg-white p-6 rounded-lg border border-gray-200">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Klien</label>
            <select name="client_user_id" required class="w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($clients as $c)
                    <option value="{{ $c->id }}" @selected(old('client_user_id', $rfq->client_user_id) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
            <select name="product_id" required class="w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($products as $p)
                    <option value="{{ $p->id }}" @selected(old('product_id', $rfq->product_id) == $p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai</label>
            <input type="number" step="0.01" min="0" name="quoted_amount" value="{{ old('quoted_amount', $rfq->quoted_amount) }}" required class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="transaction_date" value="{{ old('transaction_date', $rfq->transaction_date->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="pending" @selected(old('status', $rfq->status) === 'pending')>pending</option>
                <option value="approved" @selected(old('status', $rfq->status) === 'approved')>approved</option>
                <option value="closed" @selected(old('status', $rfq->status) === 'closed')>closed</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $rfq->notes) }}</textarea>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium"><i class="fa-solid fa-floppy-disk"></i> Perbarui</button>
            <a href="{{ route('admin.rfqs.index') }}" class="px-4 py-2 text-sm text-gray-600">Batal</a>
        </div>
    </form>
</x-admin-layout>
