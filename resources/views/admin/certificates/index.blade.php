<x-admin-layout>
    <x-slot name="title">Sertifikat</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-award" style="color: var(--admin-primary);"></i> Sertifikat</h1>
            <p class="admin-page-desc">Penerbitan dan kode validasi.</p>
        </div>
        @can('permission', 'certificate.create')
            <a href="{{ route('admin.certificates.create') }}" class="admin-btn admin-btn--primary"><i class="fas fa-plus"></i> Tambah</a>
        @endcan
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Peserta</th>
                    <th>Terbit</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certificates as $cert)
                    <tr>
                        <td class="font-mono text-xs font-medium">{{ $cert->validation_code }}</td>
                        <td>{{ $cert->participant->name }}</td>
                        <td class="text-slate-600">{{ $cert->issued_at->format('d M Y') }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('certificates.verify', $cert->validation_code) }}" target="_blank" class="text-slate-500 hover:text-slate-800" title="Validasi"><i class="fas fa-search"></i></a>
                            @can('permission', 'certificate.update')
                                <a href="{{ route('admin.certificates.edit', $cert) }}" class="font-semibold" style="color: var(--admin-primary);"><i class="fas fa-pen"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $certificates->links() }}</div>
</x-admin-layout>
