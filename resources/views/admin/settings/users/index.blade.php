<x-admin-layout>
    <x-slot name="title">Kelola Pengguna</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-users-cog" style="color: var(--admin-primary);"></i> Kelola Pengguna</h1>
            <p class="admin-page-desc">Ubah role pengguna dan reset password dari menu ini.</p>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="admin-table-actions">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="text-slate-600">{{ $user->email }}</td>
                        <td>
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium">
                                {{ $user->role?->name ?? 'Tanpa role' }}
                            </span>
                        </td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.settings.users.edit', $user) }}" class="font-semibold" style="color: var(--admin-primary);">
                                <i class="fas fa-pen"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-slate-500">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</x-admin-layout>
