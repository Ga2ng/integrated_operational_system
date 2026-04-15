<x-admin-layout>
    <x-slot name="title">Proyek</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-diagram-project" style="color: var(--admin-primary);"></i> Tracking proyek</h1>
            <p class="admin-page-desc">Status, jadwal, dan penanggung jawab.</p>
        </div>
        @can('permission', 'project.create')
            <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn--primary"><i class="fas fa-plus"></i> Tambah</a>
        @endcan
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td class="font-medium text-slate-800">{{ $project->name }}</td>
                        <td><span class="rounded bg-slate-100 px-2 py-0.5 text-xs font-medium">{{ $project->status }}</span></td>
                        <td class="text-slate-600">{{ $project->start_date?->format('d M Y') ?? '—' }}</td>
                        <td class="text-slate-600">{{ $project->end_date?->format('d M Y') ?? '—' }}</td>
                        <td class="admin-table-actions">
                            @can('permission', 'project.update')
                                <a href="{{ route('admin.projects.edit', $project) }}" class="font-semibold" style="color: var(--admin-primary);"><i class="fas fa-pen"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $projects->links() }}</div>
</x-admin-layout>
