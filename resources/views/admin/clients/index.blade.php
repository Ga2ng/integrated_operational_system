<x-admin-layout>
    <x-slot name="title">Klien</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-users" style="color: var(--admin-primary);"></i> Data klien</h1>
            <p class="admin-page-desc">Pengguna dengan peran klien dan profil master.</p>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td class="font-medium text-slate-800">{{ $client->name }}</td>
                        <td class="text-slate-600">{{ $client->email }}</td>
                        <td>{{ $client->clientProfile?->category ?? '—' }}</td>
                        <td><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium">{{ $client->clientProfile?->status ?? '—' }}</span></td>
                        <td class="admin-table-actions">
                            @can('permission', 'client.update')
                                <a href="{{ route('admin.clients.edit', $client) }}" class="font-semibold" style="color: var(--admin-primary);"><i class="fas fa-pen"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $clients->links() }}</div>
</x-admin-layout>
