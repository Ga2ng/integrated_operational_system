<x-admin-layout>
    <x-slot name="title">Tambah peran</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-plus" style="color: var(--admin-primary);"></i> Tambah peran</h1>
    <p class="admin-page-desc">Centang izin untuk disimpan ke pivot <code class="text-xs">permission_role</code>.</p>

    <form action="{{ route('admin.settings.roles.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="admin-card admin-card--padded w-full space-y-4">
            <div>
                <label class="admin-label">Nama tampilan</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="admin-input">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="admin-label">Kode unik <span class="font-normal text-slate-500">(a-z, angka, _)</span></label>
                <input type="text" name="code" value="{{ old('code') }}" required pattern="[a-z][a-z0-9_]*" class="admin-input font-mono text-sm" placeholder="staff_ops">
                @error('code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="admin-label">Deskripsi</label>
                <textarea name="description" rows="2" class="admin-input">{{ old('description') }}</textarea>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="admin-label">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="admin-input">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-slate-300">
                        Peran aktif
                    </label>
                </div>
            </div>
        </div>

        <div class="admin-card admin-card--padded w-full">
            <h2 class="mb-4 flex items-center gap-2 text-base font-semibold text-slate-800"><i class="fas fa-key" style="color: var(--admin-primary);"></i> Izin</h2>
            @foreach ($permissions as $module => $items)
                <div class="mb-6 last:mb-0">
                    <h3 class="mb-2 text-xs font-bold uppercase tracking-wide text-slate-500">{{ $module }}</h3>
                    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($items as $perm)
                            <label class="flex cursor-pointer items-start gap-2 rounded-lg border border-slate-100 p-2.5 text-sm hover:bg-slate-50">
                                <input type="checkbox" name="permission_ids[]" value="{{ $perm->id }}" @checked(in_array($perm->id, old('permission_ids', []), true)) class="mt-0.5 rounded border-slate-300">
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
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.settings.roles.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
