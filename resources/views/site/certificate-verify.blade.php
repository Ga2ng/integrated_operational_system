<x-site-layout>
    <x-slot name="title">Validasi sertifikat — {{ config('app.name') }}</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#0d7f7a]/8 border border-[#0d7f7a]/10 mb-6">
                <i class="fa-solid fa-shield-halved text-[#0d7f7a] text-sm"></i>
                <span class="text-[#0d7f7a] text-xs font-bold uppercase tracking-wider">Verifikasi</span>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-3">
                Validasi
                <span class="bg-gradient-to-r from-[#0d7f7a] to-[#14b8a6] bg-clip-text text-transparent">Sertifikat</span>
            </h1>
            <p class="text-gray-500 text-sm">Pastikan keaslian sertifikat digital dengan kode validasi unik.</p>
        </div>

        @if (!$certificate)
            {{-- Not found --}}
            <div class="rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50/50 p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-amber-100/50 to-transparent rounded-bl-[80px]"></div>
                <div class="relative z-10 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                    </div>
                    <div>
                        <p class="font-bold text-amber-900 text-lg mb-1">Sertifikat Tidak Ditemukan</p>
                        <p class="text-sm text-amber-700 mb-3">Pastikan kode validasi yang Anda masukkan sudah benar.</p>
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-100/80 text-amber-800 text-sm font-mono">
                            <i class="fa-solid fa-hashtag text-xs"></i>
                            {{ $code }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Found --}}
            <div class="rounded-3xl border border-green-200 bg-gradient-to-br from-green-50 to-emerald-50/50 p-8 relative overflow-hidden shadow-sm">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-bl from-green-100/40 to-transparent rounded-bl-[100px]"></div>

                <div class="relative z-10">
                    {{-- Success badge --}}
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center">
                            <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-green-900 text-lg">Sertifikat Terverifikasi</p>
                            <p class="text-xs text-green-600">Data ditemukan dalam sistem</p>
                        </div>
                    </div>

                    {{-- Details grid --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-white/80 backdrop-blur-sm border border-green-100 p-5">
                            <dt class="text-xs text-green-600 font-semibold uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-fingerprint text-[10px]"></i> Kode Validasi
                            </dt>
                            <dd class="font-mono text-green-900 font-bold text-sm">{{ $certificate->validation_code }}</dd>
                        </div>
                        <div class="rounded-2xl bg-white/80 backdrop-blur-sm border border-green-100 p-5">
                            <dt class="text-xs text-green-600 font-semibold uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-user text-[10px]"></i> Peserta
                            </dt>
                            <dd class="text-green-900 font-semibold text-sm">{{ $certificate->participant->name }}</dd>
                        </div>
                        <div class="rounded-2xl bg-white/80 backdrop-blur-sm border border-green-100 p-5">
                            <dt class="text-xs text-green-600 font-semibold uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-calendar text-[10px]"></i> Tanggal Terbit
                            </dt>
                            <dd class="text-green-900 font-semibold text-sm">{{ $certificate->issued_at->format('d M Y') }}</dd>
                        </div>
                        <div class="rounded-2xl bg-white/80 backdrop-blur-sm border border-green-100 p-5">
                            <dt class="text-xs text-green-600 font-semibold uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-hourglass-half text-[10px]"></i> Berlaku s/d
                            </dt>
                            <dd class="text-green-900 font-semibold text-sm">{{ $certificate->valid_until ? $certificate->valid_until->format('d M Y') : '—' }}</dd>
                        </div>
                        @if ($certificate->project)
                            <div class="sm:col-span-2 rounded-2xl bg-white/80 backdrop-blur-sm border border-green-100 p-5">
                                <dt class="text-xs text-green-600 font-semibold uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-diagram-project text-[10px]"></i> Proyek
                                </dt>
                                <dd class="text-green-900 font-semibold text-sm">{{ $certificate->project->name }}</dd>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Back link --}}
        <div class="text-center mt-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#0d7f7a] transition-colors font-medium">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</x-site-layout>
