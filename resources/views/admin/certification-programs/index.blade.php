<x-admin-layout>
    <x-slot name="title">Program Sertifikasi</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-certificate" style="color: var(--admin-primary);"></i> Program Sertifikasi</h1>
            <p class="admin-page-desc">Kelola program sertifikasi dinamis dan penugasan ke pelanggan.</p>
        </div>
        <a href="{{ route('admin.certification-programs.create') }}" class="admin-btn admin-btn--primary"><i class="fas fa-plus"></i> Buat Program Baru</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama Program</th>
                    <th>Status</th>
                    <th>Total Syarat</th>
                    <th>Total Peserta</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($programs as $program)
                    <tr>
                        <td class="font-medium text-slate-800">{{ $program->name }}</td>
                        <td>
                            @if($program->is_active)
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded">Non-Aktif</span>
                            @endif
                        </td>
                        <td>{{ $program->requirements_count }}</td>
                        <td>{{ $program->participants_count }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.certification-programs.show', $program) }}" class="admin-btn admin-btn--ghost !py-1 !px-2 text-xs" title="Kelola Persyaratan">
                                <i class="fas fa-list-check"></i> Form
                            </a>
                            <a href="{{ route('admin.certification-programs.assign', $program) }}" class="admin-btn admin-btn--ghost !py-1 !px-2 text-xs text-blue-600" title="Assign Peserta">
                                <i class="fas fa-users"></i> Assign
                            </a>
                            <a href="{{ route('admin.certification-programs.submissions', $program) }}" class="admin-btn admin-btn--ghost !py-1 !px-2 text-xs text-emerald-600" title="Lihat Submissions">
                                <i class="fas fa-inbox"></i> Submissions
                            </a>
                            <a href="{{ route('admin.certification-programs.edit', $program) }}" class="font-semibold" style="color: var(--admin-primary);" title="Edit"><i class="fas fa-pen"></i></a>
                            <form action="{{ route('admin.certification-programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('Hapus program ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn--danger !p-0" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-500">Belum ada program sertifikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $programs->links() }}</div>
</x-admin-layout>
