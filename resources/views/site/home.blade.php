<x-site-layout>
    <x-slot name="title">{{ config('app.name') }} — Beranda</x-slot>


    <section class="text-center mb-16">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Sistem Operasional Terintegrasi</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
            Kelola proyek, penawaran (RFQ), katalog layanan, registrasi klien, dan sertifikat digital dalam satu platform — cukup untuk kebutuhan skripsi dan demonstrasi arsitektur data master &amp; transaksi.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-6 py-3 font-medium hover:opacity-90">
                <i class="fa-solid fa-store"></i> Lihat katalog
            </a>
            @guest
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-lg border-2 border-[#0d7f7a] text-[#0d7f7a] px-6 py-3 font-medium hover:bg-[#0d7f7a]/5">
                    <i class="fa-solid fa-user-plus"></i> Registrasi online
                </a>
            @endguest
        </div>
    </section>

    <section>
        <h2 class="text-2xl font-semibold text-center mb-10 text-gray-800">Layanan utama</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="text-[#0d7f7a] text-3xl mb-3"><i class="fa-solid fa-chart-line"></i></div>
                <h3 class="font-semibold text-lg mb-2">Tracking Proyek</h3>
                <p class="text-gray-600 text-sm">Monitoring status, timeline, dan penanggung jawab proyek.</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="text-[#0d7f7a] text-3xl mb-3"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                <h3 class="font-semibold text-lg mb-2">RFQ</h3>
                <p class="text-gray-600 text-sm">Penawaran harga mengacu pada klien dan produk master.</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="text-[#0d7f7a] text-3xl mb-3"><i class="fa-solid fa-book-open"></i></div>
                <h3 class="font-semibold text-lg mb-2">E-Catalog</h3>
                <p class="text-gray-600 text-sm">Katalog publik konsisten dengan data produk.</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="text-[#0d7f7a] text-3xl mb-3"><i class="fa-solid fa-user-check"></i></div>
                <h3 class="font-semibold text-lg mb-2">Registrasi online</h3>
                <p class="text-gray-600 text-sm">Intake pengguna dan profil klien terstruktur.</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="text-[#0d7f7a] text-3xl mb-3"><i class="fa-solid fa-certificate"></i></div>
                <h3 class="font-semibold text-lg mb-2">E-Certificate</h3>
                <p class="text-gray-600 text-sm">Penerbitan dan validasi dengan kode unik.</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="text-[#0d7f7a] text-3xl mb-3"><i class="fa-solid fa-shield-halved"></i></div>
                <h3 class="font-semibold text-lg mb-2">Role &amp; permission</h3>
                <p class="text-gray-600 text-sm">Akses modul mengikuti template RBAC proyek.</p>
            </div>
        </div>
    </section>
</x-site-layout>
