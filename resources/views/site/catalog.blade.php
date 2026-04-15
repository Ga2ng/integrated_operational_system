<x-site-layout>
    <x-slot name="title">Katalog — {{ config('app.name') }}</x-slot>

    <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center gap-2">
        <i class="fa-solid fa-store text-[#0d7f7a]"></i> E-Catalog
    </h1>
    <p class="text-gray-600 mb-8">Produk dan layanan aktif (read-only untuk pengunjung).</p>

    @if ($products->isEmpty())
        <p class="text-gray-500 flex items-center gap-2"><i class="fa-solid fa-circle-info"></i> Belum ada produk yang dipublikasikan.</p>
    @else
        <div class="grid sm:grid-cols-2 gap-6">
            @foreach ($products as $product)
                <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="font-semibold text-lg text-gray-900 mb-2">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-600 mb-4">{{ $product->description ?: '—' }}</p>
                    <dl class="text-sm space-y-1 text-gray-700">
                        <div class="flex justify-between"><dt class="flex items-center gap-1"><i class="fa-solid fa-ruler-combined text-[#0d7f7a]"></i> Satuan</dt><dd>{{ $product->unit }}</dd></div>
                        <div class="flex justify-between"><dt class="flex items-center gap-1"><i class="fa-solid fa-tag text-[#0d7f7a]"></i> Harga dasar</dt><dd>Rp {{ number_format($product->base_price, 0, ',', '.') }}</dd></div>
                        <div class="flex justify-between"><dt class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-[#0d7f7a]"></i> Ketersediaan</dt><dd>{{ $product->availability_status === 'available' ? 'Tersedia' : 'Habis' }}</dd></div>
                    </dl>
                </article>
            @endforeach
        </div>
    @endif
</x-site-layout>
