<x-admin-layout>
    <x-slot name="title">Peran &amp; izin</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-user-shield" style="color: var(--admin-primary);"></i> Peran &amp; izin</h1>
            <p class="admin-page-desc">Tabel <code class="rounded bg-slate-100 px-1 text-xs">roles</code> dan pivot <code class="rounded bg-slate-100 px-1 text-xs">permission_role</code>.</p>
        </div>
        @can('permission', 'role.create')
            <a href="{{ route('admin.settings.roles.create') }}" class="admin-btn admin-btn--primary"><i class="fas fa-plus"></i> Tambah peran</a>
        @endcan
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kode</th>
                    <th class="text-center">Izin</th>
                    <th class="text-center">Pengguna</th>
                    <th>Status</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td class="font-medium text-slate-800">{{ $role->name }}</td>
                        <td class="font-mono text-xs text-slate-600">{{ $role->code }}</td>
                        <td class="text-center font-semibold">{{ $role->permissions_count }}</td>
                        <td class="text-center">{{ $role->users_count }}</td>
                        <td><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium">{{ $role->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td class="admin-table-actions">
                            @can('permission', 'role.update')
                                <a href="{{ route('admin.settings.roles.edit', $role) }}" class="font-semibold" style="color: var(--admin-primary);"><i class="fas fa-pen"></i></a>
                            @endcan
                            @can('permission', 'role.delete')
                                @if (! in_array($role->code, ['super_admin', 'customer'], true) && $role->users_count === 0)
                                    <form action="{{ route('admin.settings.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Hapus peran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn--danger !p-0"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
