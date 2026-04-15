<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#0d7f7a] leading-tight flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> {{ __('Ajukan RFQ') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard.rfqs.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Produk / layanan</label>
                    <select name="product_id" required class="w-full rounded-md border-gray-300 shadow-sm">
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>{{ $p->name }} — Rp {{ number_format($p->base_price, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nilai yang diusulkan</label>
                    <input type="number" step="0.01" min="0" name="quoted_amount" value="{{ old('quoted_amount') }}" required class="w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                    <a href="{{ route('dashboard.rfqs.index') }}" class="px-4 py-2 text-sm text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
