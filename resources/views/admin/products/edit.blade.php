<x-admin-layout>
    <x-slot name="title">Edit produk</x-slot>

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2"><i class="fa-solid fa-pen text-[#0d7f7a]"></i> Edit produk</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="max-w-xl space-y-4 bg-white p-6 rounded-lg border border-gray-200">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $product->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
            <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" required class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga dasar</label>
            <input type="number" step="0.01" min="0" name="base_price" value="{{ old('base_price', $product->base_price) }}" required class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ketersediaan</label>
            <select name="availability_status" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="available" @selected(old('availability_status', $product->availability_status) === 'available')>Tersedia</option>
                <option value="out_of_stock" @selected(old('availability_status', $product->availability_status) === 'out_of_stock')>Habis</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $product->is_active)) class="rounded border-gray-300">
            <label for="is_active">Aktif</label>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium">
                <i class="fa-solid fa-floppy-disk"></i> Perbarui
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm text-gray-600">Batal</a>
        </div>
    </form>
</x-admin-layout>
