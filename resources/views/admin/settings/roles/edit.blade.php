<x-admin-layout>
    <x-slot name="title">Ubah peran</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-pen" style="color: var(--admin-primary);"></i> Ubah peran</h1>
    <p class="admin-page-desc">{{ $role->name }} — {{ $role->users_count }} pengguna</p>

    @if ($role->code === 'super_admin')
        <div class="admin-alert admin-alert--warning mb-4">
            <strong>Super Admin</strong> — di aplikasi, peran ini melewati <code class="text-xs">Gate::before</code>. Sinkronisasi izin tetap disimpan untuk konsistensi data.
        </div>
    @endif

    <form action="{{ route('admin.settings.roles.update', $role) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="admin-card admin-card--padded w-full space-y-4">
            <div>
                <label class="admin-label">Nama tampilan</label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" required class="admin-input">
            </div>
            <div>
                <label class="admin-label">Kode</label>
                <input
                    type="text"
                    name="code"
                    value="{{ old('code', $role->code) }}"
                    required
                    pattern="[a-z][a-z0-9_]*"
                    @if (in_array($role->code, ['super_admin', 'customer', 'admin', 'marketing'], true)) readonly class="admin-input cursor-not-allowed bg-slate-50 font-mono text-sm"
                    @else
                        class="admin-input font-mono text-sm"
                    @endif
                >
                @if (in_array($role->code, ['super_admin', 'customer', 'admin', 'marketing'], true))
                    <p class="mt-1 text-xs text-slate-500">Kode peran bawaan tidak diubah.</p>
                @endif
            </div>
            <div>
                <label class="admin-label">Deskripsi</label>
                <textarea name="description" rows="2" class="admin-input">{{ old('description', $role->description) }}</textarea>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="admin-label">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $role->sort_order) }}" min="0" class="admin-input">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $role->is_active)) class="rounded border-slate-300">
                        Peran aktif
                    </label>
                </div>
            </div>
        </div>

        <div class="admin-card admin-card--padded w-full">
            <h2 class="mb-4 flex items-center gap-2 text-base font-semibold text-slate-800"><i class="fas fa-key" style="color: var(--admin-primary);"></i> Izin</h2>
            @php
                $selected = old('permission_ids', $role->permissions->pluck('id')->all());
            @endphp
            @foreach ($permissions as $module => $items)
                <div class="mb-6 last:mb-0">
                    <h3 class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-500">{{ $module }}</h3>
                    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($items as $perm)
                            <label class="flex cursor-pointer items-start gap-2 rounded-lg border border-slate-100 p-2.5 text-sm hover:bg-slate-50">
                                <input type="checkbox" name="permission_ids[]" value="{{ $perm->id }}" @checked(in_array($perm->id, $selected, true)) class="mt-0.5 rounded border-slate-300">
                                <span>
                                    <span class="font-medium text-slate-800">{{ $perm->name }}</span>
                                    <span class="block font-mono text-xs text-slate-500">{{ $perm->code }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex flex-wrap gap-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Perbarui</button>
            <a href="{{ route('admin.settings.roles.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
