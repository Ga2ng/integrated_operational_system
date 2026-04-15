<x-site-layout>
    <x-slot name="title">{{ config('app.name') }} — Beranda Modern</x-slot>

    <style>
        .gradient-text {
            background: linear-gradient(135deg, #0d7f7a 0%, #1a3a3a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(13, 127, 122, 0.08);
        }
    </style>

    <!-- Hero Section -->
    <section class="text-center mb-24 pt-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#0d7f7a]/10 text-[#0d7f7a] text-xs font-bold uppercase tracking-wider mb-6">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0d7f7a] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#0d7f7a]"></span>
            </span>
            Sistem Terintegrasi v2.0
        </div>
        
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-6 max-w-4xl mx-auto leading-[1.1]">
            Sistem Operasional <br/>
            <span class="gradient-text">Terintegrasi & Cerdas</span>
        </h1>
        
        <p class="text-lg text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed">
            Kelola proyek, penawaran (RFQ), katalog layanan, registrasi klien, dan sertifikat digital dalam satu platform — cukup untuk kebutuhan arsitektur data master & transaksi.
        </p>
        
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 rounded-full bg-[#0d7f7a] text-white px-8 py-4 font-semibold hover:opacity-90 transition-all shadow-lg shadow-[#0d7f7a]/20">
                <i class="fa-solid fa-store"></i> Lihat katalog
            </a>
            @guest
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full border-2 border-gray-200 text-gray-700 px-8 py-4 font-semibold hover:bg-gray-50 transition-all">
                    <i class="fa-solid fa-user-plus text-[#0d7f7a]"></i> Registrasi online
                </a>
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section class="pb-20">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-xl text-left">
                <h2 class="text-sm font-bold text-[#0d7f7a] uppercase tracking-[0.2em] mb-3">Layanan Utama</h2>
                <p class="text-3xl font-bold text-gray-900 leading-tight">Kapabilitas Platform Terpadu</p>
            </div>
            <div class="text-gray-500 text-sm hidden md:block">
                <p>Mendukung efisiensi operasional <br/>dengan arsitektur data yang konsisten.</p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Tracking Proyek -->
            <div class="feature-card group rounded-3xl border border-gray-100 bg-white p-8 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-[#0d7f7a]/5 text-[#0d7f7a] flex items-center justify-center text-xl mb-6 group-hover:bg-[#0d7f7a] group-hover:text-white transition-colors">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">Tracking Proyek</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Monitoring status, timeline, dan penanggung jawab proyek secara real-time.</p>
            </div>

            <!-- RFQ -->
            <div class="feature-card group rounded-3xl border border-gray-100 bg-white p-8 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-[#0d7f7a]/5 text-[#0d7f7a] flex items-center justify-center text-xl mb-6 group-hover:bg-[#0d7f7a] group-hover:text-white transition-colors">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">RFQ</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Penawaran harga otomatis yang mengacu pada data klien dan produk master.</p>
            </div>

            <!-- E-Catalog -->
            <div class="feature-card group rounded-3xl border border-gray-100 bg-white p-8 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-[#0d7f7a]/5 text-[#0d7f7a] flex items-center justify-center text-xl mb-6 group-hover:bg-[#0d7f7a] group-hover:text-white transition-colors">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">E-Catalog</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Katalog publik yang konsisten dan tersinkronisasi dengan data produk internal.</p>
            </div>

            <!-- Registrasi Online -->
            <div class="feature-card group rounded-3xl border border-gray-100 bg-white p-8 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-[#0d7f7a]/5 text-[#0d7f7a] flex items-center justify-center text-xl mb-6 group-hover:bg-[#0d7f7a] group-hover:text-white transition-colors">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">Registrasi Online</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Intake pengguna dan pengelolaan profil klien yang terstruktur dan aman.</p>
            </div>

            <!-- E-Certificate -->
            <div class="feature-card group rounded-3xl border border-gray-100 bg-white p-8 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-[#0d7f7a]/5 text-[#0d7f7a] flex items-center justify-center text-xl mb-6 group-hover:bg-[#0d7f7a] group-hover:text-white transition-colors">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">E-Certificate</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Penerbitan dan validasi sertifikat digital dengan kode unik sistem otomatis.</p>
            </div>

            <!-- Role & Permission -->
            <div class="feature-card group rounded-3xl border border-gray-100 bg-white p-8 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-[#0d7f7a]/5 text-[#0d7f7a] flex items-center justify-center text-xl mb-6 group-hover:bg-[#0d7f7a] group-hover:text-white transition-colors">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="font-bold text-xl mb-3 text-gray-900">Role & Permission</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Akses modul yang fleksibel mengikuti template RBAC (Role-Based Access Control).</p>
            </div>
        </div>
    </section>
</x-site-layout>