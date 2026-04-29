<x-admin-layout>
    <x-slot name="title">Edit Program Sertifikasi</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-pen" style="color: var(--admin-primary);"></i> Edit Program Sertifikasi</h1>
    <p class="admin-page-desc">{{ $certificationProgram->name }}</p>

    <form action="{{ route('admin.certification-programs.update', $certificationProgram) }}" method="POST" class="admin-card admin-card--padded w-full max-w-2xl space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="admin-label">Nama Program</label>
            <input type="text" name="name" value="{{ old('name', $certificationProgram->name) }}" required class="admin-input">
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="admin-label">Deskripsi</label>
            <textarea name="description" rows="3" class="admin-input">{{ old('description', $certificationProgram->description) }}</textarea>
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $certificationProgram->is_active)) class="rounded border-slate-300 text-[#0d7f7a] focus:ring-[#0d7f7a]">
            Program Aktif
        </label>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Perbarui</button>
            <a href="{{ route('admin.certification-programs.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
