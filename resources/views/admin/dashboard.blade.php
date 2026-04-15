<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title">
                <i class="fas fa-chart-line" style="color: var(--admin-primary);"></i>
                Ringkasan
            </h1>
            <p class="admin-page-desc">Cuplikan data operasional dan sertifikat terbaru.</p>
        </div>
    </div>

    <div class="admin-stat-grid">
        <div class="admin-stat">
            <p class="admin-stat-label"><i class="fas fa-diagram-project" style="color: var(--admin-primary);"></i> Proyek</p>
            <p class="admin-stat-value">{{ $projectCount }}</p>
        </div>
        <div class="admin-stat">
            <p class="admin-stat-label"><i class="fas fa-hourglass-half text-amber-600"></i> RFQ pending</p>
            <p class="admin-stat-value">{{ $pendingRfqCount }}</p>
        </div>
        <div class="admin-stat">
            <p class="admin-stat-label"><i class="fas fa-warehouse" style="color: var(--admin-primary);"></i> Inventory material</p>
            <p class="admin-stat-value">{{ $inventoryCount }}</p>
        </div>
        <div class="admin-stat">
            <p class="admin-stat-label"><i class="fas fa-award" style="color: var(--admin-primary);"></i> Sertifikat (cuplikan)</p>
            <p class="admin-stat-value">{{ $recentCertificates->count() }}</p>
        </div>
    </div>

    <div class="admin-card overflow-hidden">
        <div class="admin-card-header flex items-center gap-2">
            <i class="fas fa-clock-rotate-left" style="color: var(--admin-primary);"></i>
            Sertifikat terbaru
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Peserta</th>
                        <th>Terbit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentCertificates as $c)
                        <tr>
                            <td class="font-mono text-xs">{{ $c->validation_code }}</td>
                            <td>{{ $c->participant->name }}</td>
                            <td>{{ $c->issued_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
