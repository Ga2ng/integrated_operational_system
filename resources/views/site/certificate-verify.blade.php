<x-site-layout>
    <x-slot name="title">Validasi sertifikat — {{ config('app.name') }}</x-slot>

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-magnifying-glass text-[#0d7f7a]"></i> Validasi sertifikat
    </h1>

    @if (!$certificate)
        <div class="rounded-lg border border-amber-200 bg-amber-50 text-amber-900 px-4 py-3 flex items-start gap-2">
            <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
            <div>
                <p class="font-medium">Sertifikat tidak ditemukan</p>
                <p class="text-sm mt-1">Kode: <code class="bg-amber-100 px-1 rounded">{{ $code }}</code></p>
            </div>
        </div>
    @else
        <div class="rounded-xl border border-green-200 bg-green-50 p-6 text-green-900">
            <p class="font-semibold flex items-center gap-2 mb-4"><i class="fa-solid fa-circle-check"></i> Data ditemukan</p>
            <dl class="grid sm:grid-cols-2 gap-3 text-sm">
                <div><dt class="text-green-700">Kode validasi</dt><dd class="font-mono">{{ $certificate->validation_code }}</dd></div>
                <div><dt class="text-green-700">Peserta</dt><dd>{{ $certificate->participant->name }}</dd></div>
                <div><dt class="text-green-700">Tanggal terbit</dt><dd>{{ $certificate->issued_at->format('d M Y') }}</dd></div>
                <div><dt class="text-green-700">Berlaku s/d</dt><dd>{{ $certificate->valid_until ? $certificate->valid_until->format('d M Y') : '—' }}</dd></div>
                @if ($certificate->project)
                    <div class="sm:col-span-2"><dt class="text-green-700">Proyek</dt><dd>{{ $certificate->project->name }}</dd></div>
                @endif
            </dl>
        </div>
    @endif
</x-site-layout>
