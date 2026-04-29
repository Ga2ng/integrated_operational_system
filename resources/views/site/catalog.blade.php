<x-site-layout>
    <x-slot name="title">Katalog Material — {{ config('app.name') }}</x-slot>

    <style>
        /* Card hover */
        .mat-card {
            background: #fff;
            border: 1px solid rgba(13,127,122,0.08);
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .mat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px -12px rgba(13,127,122,0.18);
            border-color: rgba(13,127,122,0.25);
        }
        .mat-card:hover .mat-img-wrap img,
        .mat-card:hover .mat-img-wrap .mat-placeholder {
            transform: scale(1.04);
        }

        /* Image wrap */
        .mat-img-wrap {
            overflow: hidden;
            background: linear-gradient(135deg, #f0fdf9, #e6fffa);
            aspect-ratio: 4/3;
        }
        .mat-img-wrap img,
        .mat-img-wrap .mat-placeholder {
            transition: transform 0.45s cubic-bezier(0.4,0,0.2,1);
        }

        /* Search input */
        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(13,127,122,0.15);
        }

        /* Badge LOW */
        .badge-low { background:#fee2e2; color:#dc2626; }
        .badge-ok  { background:#dcfce7; color:#16a34a; }

        /* Pagination active */
        .pagination-btn.active {
            background: linear-gradient(135deg, #0d7f7a, #14b8a6);
            color: #fff;
        }

        /* Skeleton pulse */
        @keyframes skeleton-pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
        .skeleton { animation: skeleton-pulse 1.8s ease-in-out infinite; background:#e5e7eb; border-radius:6px; }

        /* Hero */
        .catalog-hero {
            background: linear-gradient(135deg, #0a3d3a 0%, #0d7f7a 60%, #14b8a6 100%);
        }
    </style>

    {{-- ═══ HERO ═══ --}}
    <div class="catalog-hero relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.07]">
            <svg width="100%" height="100%"><defs><pattern id="cg" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.8"/></pattern></defs><rect width="100%" height="100%" fill="url(#cg)"/></svg>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-teal-300/10 blur-3xl -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full bg-white/5 blur-2xl translate-y-1/2 -translate-x-1/4"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15 mb-5">
                    <i class="fa-solid fa-boxes-stacked text-teal-300 text-xs"></i>
                    <span class="text-teal-100 text-xs font-semibold uppercase tracking-wider">Katalog Material</span>
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4">
                    Temukan Material<br>
                    <span class="bg-gradient-to-r from-teal-200 to-amber-200 bg-clip-text text-transparent">yang Anda Butuhkan</span>
                </h1>
                <p class="text-teal-100/80 text-base leading-relaxed mb-8 max-w-lg">
                    Jelajahi seluruh inventori material kami. Tersedia informasi lengkap spesifikasi, satuan, dan ketersediaan stok real-time.
                </p>

                {{-- Search Bar --}}
                <form method="GET" action="{{ route('catalog') }}" id="catalog-search-form">
                    <div class="relative max-w-xl">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input
                            id="catalog-search-input"
                            type="text"
                            name="q"
                            value="{{ $search ?? '' }}"
                            placeholder="Cari nama, kode, atau spesifikasi material..."
                            class="search-input w-full pl-11 pr-24 py-4 rounded-2xl bg-white/95 border border-white/20 text-gray-800 text-sm shadow-xl placeholder-gray-400 transition-all"
                        >
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-gradient-to-r from-[#0d7f7a] to-[#14b8a6] text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:shadow-lg hover:shadow-teal-500/30 transition-all">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ═══ CATALOG BODY ═══ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Meta info bar --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                @if($search)
                    <span class="text-sm text-gray-500">
                        Hasil pencarian untuk <strong class="text-gray-800">"{{ $search }}"</strong> — {{ $materials->total() }} item ditemukan
                    </span>
                    <a href="{{ route('catalog') }}" class="inline-flex items-center gap-1 text-xs text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-full transition-colors">
                        <i class="fa-solid fa-xmark"></i> Hapus filter
                    </a>
                @else
                    <span class="text-sm text-gray-500">
                        Menampilkan <strong class="text-gray-800">{{ $materials->total() }}</strong> material aktif
                    </span>
                @endif
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-400">
                <i class="fa-solid fa-circle text-emerald-400 text-[8px] animate-pulse"></i>
                Data stok terkini
            </div>
        </div>

        @if($materials->isEmpty())
            {{-- Empty state --}}
            <div class="text-center py-24">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-gray-100 flex items-center justify-center mb-6">
                    <i class="fa-solid fa-box-open text-gray-300 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Tidak ada material ditemukan</h3>
                <p class="text-gray-400 text-sm mb-6">
                    @if($search)
                        Coba kata kunci lain atau hapus filter pencarian.
                    @else
                        Belum ada material aktif yang tersedia saat ini.
                    @endif
                </p>
                @if($search)
                    <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-[#0d7f7a] text-white px-6 py-3 rounded-xl font-semibold text-sm hover:bg-[#0a5f5b] transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Lihat semua material
                    </a>
                @endif
            </div>
        @else
            {{-- Material Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($materials as $material)
                    <a href="{{ route('catalog.show', $material) }}" id="mat-{{ $material->id }}" class="mat-card rounded-3xl overflow-hidden group block">
                        {{-- Image --}}
                        <div class="mat-img-wrap">
                            @if($material->image)
                                <img
                                    src="{{ asset('storage/' . $material->image) }}"
                                    alt="{{ $material->name }}"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                >
                            @else
                                <div class="mat-placeholder w-full h-full flex flex-col items-center justify-center gap-3 p-6">
                                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center">
                                        <i class="fa-solid fa-cubes text-teal-500 text-xl"></i>
                                    </div>
                                    <span class="text-xs text-teal-400 font-medium text-center">{{ $material->uom }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            {{-- Code badge --}}
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-mono text-[10px] font-bold text-[#0d7f7a] bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-lg tracking-wider">
                                    {{ $material->code }}
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $material->stock_status === 'LOW' ? 'badge-low' : 'badge-ok' }}">
                                    {{ $material->stock_status === 'LOW' ? 'Stok Rendah' : 'Tersedia' }}
                                </span>
                            </div>

                            {{-- Name --}}
                            <h2 class="font-bold text-gray-900 text-sm leading-snug mb-1 group-hover:text-[#0d7f7a] transition-colors line-clamp-2">
                                {{ $material->name }}
                            </h2>

                            {{-- Spec --}}
                            @if($material->specification)
                                <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed mb-3">
                                    {{ $material->specification }}
                                </p>
                            @else
                                <div class="mb-3"></div>
                            @endif

                            {{-- Footer --}}
                            <div class="border-t border-gray-50 pt-3 flex items-center justify-between">
                                <div>
                                    <div class="text-[10px] text-gray-400 font-medium">Harga Satuan</div>
                                    <div class="text-sm font-bold text-gray-800">
                                        Rp {{ number_format($material->unit_cost, 0, ',', '.') }}
                                        <span class="text-[10px] font-normal text-gray-400">/ {{ $material->uom }}</span>
                                    </div>
                                </div>
                                <span class="w-8 h-8 rounded-full bg-teal-50 flex items-center justify-center group-hover:bg-[#0d7f7a] transition-colors duration-300">
                                    <i class="fa-solid fa-arrow-right text-[#0d7f7a] text-[10px] group-hover:text-white transition-colors duration-300"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($materials->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $materials->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- CTA Banner --}}
    <div class="bg-gradient-to-r from-[#0a3d3a] via-[#0d7f7a] to-[#14b8a6] mx-4 sm:mx-8 mb-12 rounded-3xl p-8 md:p-12 text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg width="100%" height="100%"><defs><pattern id="cg2" width="30" height="30" patternUnits="userSpaceOnUse"><circle cx="15" cy="15" r="1" fill="white"/></pattern></defs><rect width="100%" height="100%" fill="url(#cg2)"/></svg>
        </div>
        <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-3">Butuh Penawaran Harga?</h2>
            <p class="text-teal-100/80 text-sm mb-6 max-w-lg mx-auto">Ajukan Request for Quotation (RFQ) dan tim kami akan merespons dengan penawaran terbaik.</p>
            @auth
                <a href="{{ route('dashboard.rfqs.create') }}" class="inline-flex items-center gap-2 bg-white text-[#0d7f7a] font-bold px-8 py-3.5 rounded-xl hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Ajukan RFQ Sekarang
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-[#0d7f7a] font-bold px-8 py-3.5 rounded-xl hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Ajukan RFQ
                </a>
            @endauth
        </div>
    </div>

</x-site-layout>
