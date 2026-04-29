<x-site-layout>
    <x-slot name="title">{{ $material->name }} — Katalog — {{ config('app.name') }}</x-slot>

    <style>
        .detail-hero-img {
            background: linear-gradient(135deg, #f0fdf9 0%, #e6fffa 100%);
        }
        .spec-row:not(:last-child) {
            border-bottom: 1px solid rgba(13,127,122,0.07);
        }
        .badge-low { background:#fee2e2; color:#dc2626; }
        .badge-ok  { background:#dcfce7; color:#16a34a; }

        @keyframes float-up {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .animate-float-up { animation: float-up 0.5s ease-out forwards; }
        .animate-float-up-delay { animation: float-up 0.5s 0.15s ease-out both; }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8 animate-float-up">
            <a href="{{ route('home') }}" class="hover:text-[#0d7f7a] transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ route('catalog') }}" class="hover:text-[#0d7f7a] transition-colors">Katalog</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-gray-700 font-medium truncate max-w-[200px]">{{ $material->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-10 xl:gap-16 items-start">

            {{-- ══ LEFT: Image ══ --}}
            <div class="animate-float-up">
                <div class="detail-hero-img rounded-3xl overflow-hidden aspect-square flex items-center justify-center shadow-xl border border-teal-50 relative group">
                    @if($material->image)
                        <img
                            src="{{ asset('storage/' . $material->image) }}"
                            alt="{{ $material->name }}"
                            class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                        >
                    @else
                        <div class="text-center p-12 space-y-5">
                            <div class="w-24 h-24 mx-auto rounded-3xl bg-teal-100 flex items-center justify-center">
                                <i class="fa-solid fa-cubes text-teal-500 text-4xl"></i>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-400 text-sm font-medium">Gambar belum tersedia</p>
                                <p class="text-gray-300 text-xs">{{ $material->uom }}</p>
                            </div>
                        </div>
                    @endif
                    {{-- Code watermark --}}
                    <div class="absolute top-4 left-4">
                        <span class="font-mono text-xs font-bold text-[#0d7f7a] bg-white/90 backdrop-blur-sm border border-teal-100 px-3 py-1.5 rounded-xl shadow-sm tracking-wider">
                            {{ $material->code }}
                        </span>
                    </div>
                    {{-- Status badge --}}
                    <div class="absolute top-4 right-4">
                        <span class="text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm {{ $material->stock_status === 'LOW' ? 'badge-low' : 'badge-ok' }}">
                            @if($material->stock_status === 'LOW')
                                <i class="fa-solid fa-triangle-exclamation mr-1"></i>Stok Rendah
                            @else
                                <i class="fa-solid fa-circle-check mr-1"></i>Tersedia
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Social share / back --}}
                <div class="mt-5 flex items-center gap-3">
                    <a href="{{ route('catalog') }}" class="flex-1 flex items-center justify-center gap-2 border border-gray-200 text-gray-600 hover:border-[#0d7f7a] hover:text-[#0d7f7a] px-5 py-3 rounded-xl text-sm font-medium transition-all">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Katalog
                    </a>
                </div>
            </div>

            {{-- ══ RIGHT: Detail ══ --}}
            <div class="animate-float-up-delay space-y-6">

                {{-- Header --}}
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight mb-2">
                        {{ $material->name }}
                    </h1>
                    @if($material->specification)
                        <p class="text-gray-500 leading-relaxed text-sm">
                            {{ $material->specification }}
                        </p>
                    @endif
                </div>

                {{-- Price highlight --}}
                <div class="rounded-2xl bg-gradient-to-br from-teal-50 to-emerald-50 border border-teal-100 p-5">
                    <div class="text-xs text-teal-600 font-semibold uppercase tracking-wider mb-1">Harga Satuan</div>
                    <div class="text-3xl font-extrabold text-gray-900">
                        Rp {{ number_format($material->unit_cost, 0, ',', '.') }}
                        <span class="text-base font-normal text-gray-400 ml-1">/ {{ $material->uom }}</span>
                    </div>
                </div>

                {{-- Spec table --}}
                <div class="rounded-2xl bg-white border border-gray-100 overflow-hidden shadow-sm">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Informasi Material</span>
                    </div>
                    <div class="divide-y divide-gray-50">
                        <div class="spec-row flex items-center px-5 py-3.5">
                            <span class="text-sm text-gray-500 w-40 shrink-0">Kode Material</span>
                            <span class="font-mono text-sm font-bold text-[#0d7f7a]">{{ $material->code }}</span>
                        </div>
                        <div class="spec-row flex items-center px-5 py-3.5">
                            <span class="text-sm text-gray-500 w-40 shrink-0">Satuan (UoM)</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $material->uom }}</span>
                        </div>
                        <div class="spec-row flex items-center px-5 py-3.5">
                            <span class="text-sm text-gray-500 w-40 shrink-0">Stok Tersedia</span>
                            <span class="text-sm font-semibold text-gray-800">
                                {{ number_format($material->current_stock, 2) }} {{ $material->uom }}
                            </span>
                        </div>
                        <div class="spec-row flex items-center px-5 py-3.5">
                            <span class="text-sm text-gray-500 w-40 shrink-0">Minimum Stok</span>
                            <span class="text-sm font-semibold text-gray-800">
                                {{ number_format($material->minimum_stock, 2) }} {{ $material->uom }}
                            </span>
                        </div>
                        <div class="spec-row flex items-center px-5 py-3.5">
                            <span class="text-sm text-gray-500 w-40 shrink-0">Status Stok</span>
                            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $material->stock_status === 'LOW' ? 'badge-low' : 'badge-ok' }}">
                                {{ $material->stock_status === 'LOW' ? 'Stok Rendah' : 'Stok OK' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="space-y-3 pt-2">
                    @auth
                        <a href="{{ route('dashboard.rfqs.create') }}"
                           class="flex items-center justify-center gap-3 w-full bg-gradient-to-r from-[#0d7f7a] to-[#14b8a6] text-white font-bold py-4 rounded-2xl hover:shadow-xl hover:shadow-teal-500/25 hover:-translate-y-0.5 transition-all text-sm">
                            <i class="fa-solid fa-file-invoice-dollar text-base"></i>
                            Ajukan RFQ untuk Material Ini
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="flex items-center justify-center gap-3 w-full bg-gradient-to-r from-[#0d7f7a] to-[#14b8a6] text-white font-bold py-4 rounded-2xl hover:shadow-xl hover:shadow-teal-500/25 hover:-translate-y-0.5 transition-all text-sm">
                            <i class="fa-solid fa-right-to-bracket text-base"></i>
                            Masuk untuk Ajukan RFQ
                        </a>
                        <p class="text-center text-xs text-gray-400">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-[#0d7f7a] font-semibold hover:underline">Daftar sekarang</a>
                        </p>
                    @endauth
                </div>

                {{-- Info note --}}
                <div class="flex items-start gap-3 bg-amber-50 border border-amber-100 rounded-2xl px-4 py-3">
                    <i class="fa-solid fa-circle-info text-amber-500 mt-0.5 text-sm shrink-0"></i>
                    <p class="text-xs text-amber-700 leading-relaxed">
                        Harga dan ketersediaan stok dapat berubah sewaktu-waktu. Hubungi kami untuk informasi terkini dan penawaran khusus volume besar.
                    </p>
                </div>
            </div>
        </div>

        {{-- ══ Related / Back CTA ══ --}}
        <div class="mt-16 pt-10 border-t border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-bold text-gray-800">Material Lainnya</h3>
                <a href="{{ route('catalog') }}" class="text-sm text-[#0d7f7a] font-semibold hover:underline flex items-center gap-1">
                    Lihat semua <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
            @php
                $related = \App\Models\MaterialInventory::where('is_active', true)
                    ->where('id', '!=', $material->id)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();
            @endphp
            @if($related->isNotEmpty())
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($related as $rel)
                        <a href="{{ route('catalog.show', $rel) }}" class="group block bg-white border border-gray-100 rounded-2xl overflow-hidden hover:border-teal-200 hover:shadow-lg hover:-translate-y-1 transition-all">
                            <div class="aspect-video bg-gradient-to-br from-teal-50 to-emerald-50 flex items-center justify-center overflow-hidden">
                                @if($rel->image)
                                    <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <i class="fa-solid fa-cubes text-teal-300 text-2xl group-hover:scale-110 transition-transform"></i>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="font-mono text-[9px] text-teal-600 font-bold mb-1">{{ $rel->code }}</p>
                                <h4 class="font-semibold text-gray-800 text-xs line-clamp-2 group-hover:text-[#0d7f7a] transition-colors">{{ $rel->name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($rel->unit_cost, 0, ',', '.') }} / {{ $rel->uom }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-site-layout>
