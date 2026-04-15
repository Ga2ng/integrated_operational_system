<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <h1 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-gauge text-[#0d7f7a]"></i> Ringkasan
    </h1>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="rounded-lg bg-white shadow p-4 border border-gray-200">
            <p class="text-sm text-gray-500 flex items-center gap-2"><i class="fa-solid fa-diagram-project text-[#0d7f7a]"></i> Proyek</p>
            <p class="text-2xl font-bold text-gray-900">{{ $projectCount }}</p>
        </div>
        <div class="rounded-lg bg-white shadow p-4 border border-gray-200">
            <p class="text-sm text-gray-500 flex items-center gap-2"><i class="fa-solid fa-hourglass-half text-amber-600"></i> RFQ pending</p>
            <p class="text-2xl font-bold text-gray-900">{{ $pendingRfqCount }}</p>
        </div>
        <div class="rounded-lg bg-white shadow p-4 border border-gray-200">
            <p class="text-sm text-gray-500 flex items-center gap-2"><i class="fa-solid fa-box text-[#0d7f7a]"></i> Produk</p>
            <p class="text-2xl font-bold text-gray-900">{{ $productCount }}</p>
        </div>
        <div class="rounded-lg bg-white shadow p-4 border border-gray-200">
            <p class="text-sm text-gray-500 flex items-center gap-2"><i class="fa-solid fa-award text-[#0d7f7a]"></i> Sertifikat (cuplikan)</p>
            <p class="text-2xl font-bold text-gray-900">{{ $recentCertificates->count() }}</p>
        </div>
    </div>

    <h2 class="text-lg font-semibold mb-3 flex items-center gap-2"><i class="fa-solid fa-clock-rotate-left text-[#0d7f7a]"></i> Sertifikat terbaru</h2>
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-2">Kode</th>
                    <th class="px-4 py-2">Peserta</th>
                    <th class="px-4 py-2">Terbit</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentCertificates as $c)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-2 font-mono text-xs">{{ $c->validation_code }}</td>
                        <td class="px-4 py-2">{{ $c->participant->name }}</td>
                        <td class="px-4 py-2">{{ $c->issued_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
