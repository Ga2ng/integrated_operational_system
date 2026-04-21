<x-site-layout>
    <x-slot name="title">{{ config('app.name') }} — Beranda</x-slot>

    <style>
        /* Hero animated gradient */
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .hero-bg {
            background: linear-gradient(135deg, #0c1a19 0%, #0a3d3a 25%, #0d7f7a 50%, #0a3d3a 75%, #0c1a19 100%);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }
        .hero-pattern {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(20,184,166,0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(245,158,11,0.06) 0%, transparent 50%);
        }
        .hero-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Floating orbs */
        @keyframes float-orb-1 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(30px,-20px) scale(1.1)} }
        @keyframes float-orb-2 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(-20px,30px) scale(0.9)} }
        .orb-1 { animation: float-orb-1 8s ease-in-out infinite; }
        .orb-2 { animation: float-orb-2 10s ease-in-out infinite; }

        /* Feature card */
        .feat-card {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(13,127,122,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px -12px rgba(13,127,122,0.15);
            border-color: rgba(13,127,122,0.2);
        }
        .feat-card:hover .feat-icon {
            background: linear-gradient(135deg, #0d7f7a, #14b8a6);
            color: white;
            transform: scale(1.1) rotate(-5deg);
        }

        /* Stats counter animation */
        @keyframes count-up { from { opacity:0; transform: translateY(10px); } to { opacity:1; transform: translateY(0); } }
        .stat-animate { animation: count-up 0.6s ease-out forwards; }

        /* Profile section */
        .profile-image-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0.75rem;
            height: 400px;
        }
        .profile-image-grid > :first-child { grid-row: 1 / 3; }

        /* Glassmorphism card */
        .glass-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.4);
        }

        /* Value card */
        .value-card {
            transition: all 0.35s ease;
        }
        .value-card:hover {
            transform: translateY(-4px) scale(1.02);
        }

        /* Testimonial */
        .testimonial-card {
            background: linear-gradient(135deg, rgba(13,127,122,0.03), rgba(20,184,166,0.06));
            border: 1px solid rgba(13,127,122,0.1);
            transition: all 0.3s ease;
        }
        .testimonial-card:hover {
            border-color: rgba(13,127,122,0.25);
            box-shadow: 0 10px 40px -10px rgba(13,127,122,0.1);
        }

        /* CTA section */
        .cta-gradient {
            background: linear-gradient(135deg, #0a3d3a 0%, #0d7f7a 50%, #14b8a6 100%);
        }
    </style>

    {{-- ═══════════════════ HERO SECTION ═══════════════════ --}}
    <section class="hero-bg relative overflow-hidden -mt-[72px] pt-[72px]">
        <div class="hero-pattern absolute inset-0"></div>
        <div class="hero-grid absolute inset-0"></div>

        {{-- Floating orbs --}}
        <div class="absolute top-20 left-10 w-64 h-64 rounded-full bg-teal-400/10 blur-3xl orb-1"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 rounded-full bg-amber-400/5 blur-3xl orb-2"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-teal-500/5 blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-36">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left: Text --}}
                <div class="text-center lg:text-left space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 backdrop-blur-sm">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-teal-400"></span>
                        </span>
                        <span class="text-teal-200 text-xs font-semibold uppercase tracking-wider">Sistem Terintegrasi v2.0</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-[1.1] tracking-tight">
                        Sistem Operasional
                        <span class="block mt-2 bg-gradient-to-r from-teal-300 via-teal-200 to-amber-200 bg-clip-text text-transparent">
                            Terintegrasi & Cerdas
                        </span>
                    </h1>

                    <p class="text-lg text-gray-300/90 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                        Kelola proyek, penawaran (RFQ), katalog layanan, registrasi klien, dan sertifikat digital dalam satu platform — efisiensi di setiap lini operasional.
                    </p>

                    <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                        <a href="{{ route('catalog') }}" class="group inline-flex items-center gap-3 rounded-2xl bg-white text-[#0d7f7a] px-8 py-4 font-bold text-sm hover:shadow-xl hover:shadow-teal-500/20 transition-all duration-300 hover:-translate-y-0.5">
                            <i class="fa-solid fa-store"></i>
                            Lihat Katalog
                            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-2xl border-2 border-white/20 text-white px-8 py-4 font-semibold text-sm hover:bg-white/10 hover:border-white/40 transition-all duration-300">
                                <i class="fa-solid fa-user-plus"></i>
                                Registrasi Online
                            </a>
                        @endguest
                    </div>

                    {{-- Trust badges --}}
                    <div class="flex flex-wrap justify-center lg:justify-start gap-6 pt-4">
                        <div class="flex items-center gap-2 text-gray-400 text-xs">
                            <i class="fa-solid fa-shield-halved text-teal-400"></i>
                            <span>Data Terenkripsi</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400 text-xs">
                            <i class="fa-solid fa-server text-teal-400"></i>
                            <span>99.9% Uptime</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400 text-xs">
                            <i class="fa-solid fa-headset text-teal-400"></i>
                            <span>Support 24/7</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Dashboard preview mockup --}}
                <div class="hidden lg:block relative">
                    <div class="relative rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 p-6 shadow-2xl">
                        {{-- Mini dashboard mockup --}}
                        <div class="rounded-2xl bg-gradient-to-br from-gray-900 to-gray-800 p-5 space-y-4">
                            {{-- Top bar --}}
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                <div class="ml-4 flex-1 h-6 rounded-md bg-white/5"></div>
                            </div>
                            {{-- Stats row --}}
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-xl bg-teal-500/10 border border-teal-500/20 p-3">
                                    <div class="text-teal-400 text-[10px] font-medium mb-1">Proyek Aktif</div>
                                    <div class="text-white text-xl font-bold">24</div>
                                </div>
                                <div class="rounded-xl bg-amber-500/10 border border-amber-500/20 p-3">
                                    <div class="text-amber-400 text-[10px] font-medium mb-1">RFQ Pending</div>
                                    <div class="text-white text-xl font-bold">12</div>
                                </div>
                                <div class="rounded-xl bg-purple-500/10 border border-purple-500/20 p-3">
                                    <div class="text-purple-400 text-[10px] font-medium mb-1">Sertifikat</div>
                                    <div class="text-white text-xl font-bold">156</div>
                                </div>
                            </div>
                            {{-- Chart placeholder --}}
                            <div class="rounded-xl bg-white/5 border border-white/5 p-4 h-36 flex items-end gap-1.5">
                                @foreach([40,65,45,80,55,90,70,85,60,75,95,50] as $i => $h)
                                    <div class="flex-1 rounded-t-md bg-gradient-to-t from-teal-600 to-teal-400 opacity-80" style="height: {{ $h }}%"></div>
                                @endforeach
                            </div>
                            {{-- Bottom items --}}
                            <div class="space-y-2">
                                @foreach(['Proyek A — Surabaya', 'Proyek B — Jakarta', 'Proyek C — Bandung'] as $i => $name)
                                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/5">
                                    <div class="w-7 h-7 rounded-lg bg-teal-500/20 flex items-center justify-center">
                                        <i class="fa-solid fa-diagram-project text-teal-400 text-[10px]"></i>
                                    </div>
                                    <span class="text-gray-300 text-xs flex-1">{{ $name }}</span>
                                    <span class="text-teal-400 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-teal-500/10">Aktif</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- Glow --}}
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-3/4 h-8 bg-teal-500/20 blur-2xl rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Bottom wave --}}
        <div class="relative z-10">
            <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0,60 C360,100 720,0 1080,50 C1260,75 1380,55 1440,60 L1440,100 L0,100 Z" fill="white"/>
            </svg>
        </div>
    </section>

    {{-- ═══════════════════ STATS STRIP ═══════════════════ --}}
    <section class="relative -mt-1 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['icon' => 'fa-briefcase', 'value' => '500+', 'label' => 'Proyek Selesai', 'color' => 'teal'],
                        ['icon' => 'fa-users', 'value' => '200+', 'label' => 'Klien Terdaftar', 'color' => 'blue'],
                        ['icon' => 'fa-certificate', 'value' => '1,000+', 'label' => 'Sertifikat Terbit', 'color' => 'amber'],
                        ['icon' => 'fa-clock', 'value' => '5+', 'label' => 'Tahun Beroperasi', 'color' => 'purple'],
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div class="text-center p-6 rounded-2xl bg-{{ $stat['color'] }}-50/50 border border-{{ $stat['color'] }}-100/50">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-{{ $stat['color'] }}-100 flex items-center justify-center mb-4">
                            <i class="fa-solid {{ $stat['icon'] }} text-{{ $stat['color'] }}-600"></i>
                        </div>
                        <div class="text-3xl font-extrabold text-gray-900 mb-1">{{ $stat['value'] }}</div>
                        <div class="text-sm text-gray-500 font-medium">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════ COMPANY PROFILE ═══════════════════ --}}
    <section class="bg-gradient-to-b from-white to-gray-50/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Image grid --}}
                <div class="profile-image-grid">
                    <div class="rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-br from-[#0d7f7a] to-[#14b8a6] relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#0d7f7a] to-[#14b8a6] flex items-center justify-center p-8">
                            <div class="text-center text-white space-y-4">
                                <div class="w-20 h-20 mx-auto rounded-3xl bg-white/15 flex items-center justify-center backdrop-blur-sm border border-white/20">
                                    <i class="fa-solid fa-building text-4xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold">{{ config('app.name') }}</h3>
                                <p class="text-sm text-teal-100/80">Integrated Solutions</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-teal-700 to-teal-800 flex items-center justify-center p-6">
                        <div class="text-center text-white space-y-2">
                            <i class="fa-solid fa-chart-line text-3xl text-teal-300"></i>
                            <p class="text-xs text-teal-200 font-medium">Data-Driven</p>
                        </div>
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center p-6">
                        <div class="text-center text-white space-y-2">
                            <i class="fa-solid fa-handshake text-3xl text-amber-200"></i>
                            <p class="text-xs text-amber-100 font-medium">Trusted Partner</p>
                        </div>
                    </div>
                </div>

                {{-- About text --}}
                <div class="space-y-7">
                    <div>
                        <span class="text-xs font-bold text-[#0d7f7a] uppercase tracking-[0.2em] mb-3 block">Tentang Perusahaan</span>
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight">
                            Membangun Ekosistem
                            <span class="bg-gradient-to-r from-[#0d7f7a] to-[#14b8a6] bg-clip-text text-transparent">Digital Terpadu</span>
                        </h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Kami adalah perusahaan teknologi yang menghadirkan solusi operasional terintegrasi untuk berbagai industri. Dengan pengalaman bertahun-tahun, kami membantu organisasi mendigitalisasi proses bisnis dari hulu ke hilir — mulai dari manajemen proyek, penawaran harga, inventori, hingga penerbitan sertifikat digital yang aman dan terverifikasi.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @php
                            $values = [
                                ['icon' => 'fa-bullseye', 'title' => 'Visi', 'desc' => 'Menjadi platform operasional #1 di Indonesia'],
                                ['icon' => 'fa-rocket', 'title' => 'Misi', 'desc' => 'Digitalisasi proses bisnis end-to-end'],
                                ['icon' => 'fa-gem', 'title' => 'Nilai', 'desc' => 'Integritas, Inovasi, Kolaborasi'],
                                ['icon' => 'fa-trophy', 'title' => 'Keunggulan', 'desc' => 'All-in-one platform terpercaya'],
                            ];
                        @endphp
                        @foreach ($values as $v)
                            <div class="value-card flex items-start gap-3 p-4 rounded-xl bg-white shadow-sm border border-gray-100">
                                <div class="w-10 h-10 rounded-xl bg-[#0d7f7a]/10 flex items-center justify-center shrink-0">
                                    <i class="fa-solid {{ $v['icon'] }} text-[#0d7f7a] text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900">{{ $v['title'] }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $v['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════ FEATURES ═══════════════════ --}}
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold text-[#0d7f7a] uppercase tracking-[0.2em] mb-3 block">Layanan Utama</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4">
                    Kapabilitas
                    <span class="bg-gradient-to-r from-[#0d7f7a] to-[#14b8a6] bg-clip-text text-transparent">Platform Terpadu</span>
                </h2>
                <p class="text-gray-500 leading-relaxed">Mendukung efisiensi operasional dengan arsitektur data yang konsisten dan terintegrasi.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $features = [
                        ['icon' => 'fa-chart-line', 'title' => 'Tracking Proyek', 'desc' => 'Monitoring status, timeline, dan penanggung jawab proyek secara real-time dengan dashboard visual.', 'gradient' => 'from-teal-500 to-emerald-500'],
                        ['icon' => 'fa-file-invoice-dollar', 'title' => 'RFQ (Request for Quotation)', 'desc' => 'Penawaran harga otomatis yang mengacu pada data klien dan produk master terintegrasi.', 'gradient' => 'from-blue-500 to-cyan-500'],
                        ['icon' => 'fa-book-open', 'title' => 'E-Catalog', 'desc' => 'Katalog publik yang tersinkronisasi dengan data produk internal, mudah diakses klien.', 'gradient' => 'from-violet-500 to-purple-500'],
                        ['icon' => 'fa-user-check', 'title' => 'Registrasi Online', 'desc' => 'Intake pengguna dan pengelolaan profil klien yang terstruktur, aman, dan terverifikasi.', 'gradient' => 'from-amber-500 to-orange-500'],
                        ['icon' => 'fa-certificate', 'title' => 'E-Certificate', 'desc' => 'Penerbitan dan validasi sertifikat digital dengan kode unik dan sistem otomatis.', 'gradient' => 'from-rose-500 to-pink-500'],
                        ['icon' => 'fa-shield-halved', 'title' => 'Role & Permission', 'desc' => 'Akses modul yang fleksibel mengikuti template RBAC (Role-Based Access Control).', 'gradient' => 'from-slate-600 to-gray-700'],
                    ];
                @endphp
                @foreach ($features as $feature)
                    <div class="feat-card rounded-3xl p-8 group">
                        <div class="feat-icon w-14 h-14 rounded-2xl bg-gradient-to-br {{ $feature['gradient'] }}/10 text-[#0d7f7a] flex items-center justify-center text-xl mb-6 transition-all duration-400">
                            <i class="fa-solid {{ $feature['icon'] }}"></i>
                        </div>
                        <h3 class="font-bold text-xl mb-3 text-gray-900 group-hover:text-[#0d7f7a] transition-colors">{{ $feature['title'] }}</h3>
                        <p class="text-gray-500 leading-relaxed text-sm">{{ $feature['desc'] }}</p>
                        <div class="mt-5 flex items-center gap-1 text-[#0d7f7a] text-xs font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Pelajari lebih lanjut <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════ WHY CHOOSE US ═══════════════════ --}}
    <section class="bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div>
                        <span class="text-xs font-bold text-[#0d7f7a] uppercase tracking-[0.2em] mb-3 block">Mengapa Kami</span>
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight">
                            Dipercaya Ratusan
                            <span class="bg-gradient-to-r from-[#0d7f7a] to-[#14b8a6] bg-clip-text text-transparent">Organisasi</span>
                        </h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Platform kami didesain dengan arsitektur enterprise-grade yang memastikan keamanan, skalabilitas, dan kemudahan penggunaan di setiap tahap operasional bisnis.
                    </p>

                    <div class="space-y-5">
                        @php
                            $reasons = [
                                ['icon' => 'fa-lock', 'title' => 'Keamanan Data Premium', 'desc' => 'Enkripsi end-to-end dengan standar keamanan industri terkini.'],
                                ['icon' => 'fa-bolt', 'title' => 'Performa Tinggi', 'desc' => 'Infrastruktur cloud yang dioptimalkan untuk kecepatan akses tinggi.'],
                                ['icon' => 'fa-puzzle-piece', 'title' => 'Integrasi Fleksibel', 'desc' => 'API terbuka untuk integrasi dengan sistem existing perusahaan Anda.'],
                                ['icon' => 'fa-life-ring', 'title' => 'Dukungan Dedikasi', 'desc' => 'Tim support berpengalaman siap membantu 24/7.'],
                            ];
                        @endphp
                        @foreach ($reasons as $r)
                            <div class="flex items-start gap-4 group">
                                <div class="w-11 h-11 rounded-xl bg-[#0d7f7a]/10 flex items-center justify-center shrink-0 group-hover:bg-[#0d7f7a] transition-colors duration-300">
                                    <i class="fa-solid {{ $r['icon'] }} text-[#0d7f7a] group-hover:text-white text-sm transition-colors duration-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">{{ $r['title'] }}</h4>
                                    <p class="text-sm text-gray-500 leading-relaxed">{{ $r['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Testimonial area --}}
                <div class="space-y-6">
                    @php
                        $testimonials = [
                            ['name' => 'Budi Santoso', 'role' => 'Direktur Operasional, PT Maju Jaya', 'text' => 'Platform ini sangat membantu kami mengelola seluruh proyek dalam satu dashboard. Efisiensi tim meningkat 40%.', 'rating' => 5],
                            ['name' => 'Sari Dewi', 'role' => 'Manager IT, CV Teknologi Indonesia', 'text' => 'Fitur RFQ dan e-catalog sangat powerful. Kami tidak perlu lagi menggunakan banyak tools terpisah.', 'rating' => 5],
                            ['name' => 'Andi Pratama', 'role' => 'CEO, Startup Digital', 'text' => 'Sistem sertifikat digital mereka sangat profesional. Verifikasi online yang cepat dan terpercaya.', 'rating' => 5],
                        ];
                    @endphp
                    @foreach ($testimonials as $t)
                        <div class="testimonial-card rounded-2xl p-6">
                            <div class="flex gap-1 mb-3">
                                @for ($i = 0; $i < $t['rating']; $i++)
                                    <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                @endfor
                            </div>
                            <p class="text-gray-700 text-sm leading-relaxed mb-4 italic">"{{ $t['text'] }}"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#0d7f7a] to-[#14b8a6] flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr($t['name'], 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-sm text-gray-900">{{ $t['name'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $t['role'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════ CTA SECTION ═══════════════════ --}}
    <section class="cta-gradient relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg width="100%" height="100%"><defs><pattern id="cta-grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#cta-grid)"/></svg>
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-6">
                Siap Mengoptimalkan Operasional Anda?
            </h2>
            <p class="text-teal-100/80 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
                Bergabunglah bersama ratusan organisasi yang telah mempercayakan pengelolaan operasional mereka pada platform kami.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="group inline-flex items-center gap-3 rounded-2xl bg-white text-[#0d7f7a] px-8 py-4 font-bold text-sm hover:shadow-xl hover:shadow-black/20 transition-all duration-300 hover:-translate-y-0.5">
                        <i class="fa-solid fa-user-plus"></i>
                        Mulai Sekarang — Gratis
                        <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </a>
                @endguest
                <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 rounded-2xl border-2 border-white/30 text-white px-8 py-4 font-semibold text-sm hover:bg-white/10 hover:border-white/50 transition-all duration-300">
                    <i class="fa-solid fa-book-open"></i> Lihat Katalog
                </a>
            </div>
        </div>
    </section>

</x-site-layout>