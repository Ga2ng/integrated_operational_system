<x-admin-layout>
    <x-slot name="title">Produk</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2"><i class="fa-solid fa-box text-[#0d7f7a]"></i> Produk</h1>
        @can('permission', 'product.create')
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium hover:opacity-90">
                <i class="fa-solid fa-plus"></i> Tambah
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Harga</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($product->base_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            @can('permission', 'product.update')
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-[#0d7f7a] hover:underline"><i class="fa-solid fa-pen"></i></a>
                            @endcan
                            @can('permission', 'product.delete')
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?');">
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
    <div class="mt-4">{{ $products->links() }}</div>
</x-admin-layout>
