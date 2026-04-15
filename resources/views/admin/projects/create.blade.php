<x-admin-layout>
    <x-slot name="title">Tambah proyek</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-plus" style="color: var(--admin-primary);"></i> Tambah proyek</h1>
    <p class="admin-page-desc">Data master proyek untuk tracking dan sertifikat.</p>

    <form action="{{ route('admin.projects.store') }}" method="POST" class="admin-card admin-card--padded w-full space-y-4">
        @csrf
        <div>
            <label class="admin-label">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="admin-input">
        </div>
        <div>
            <label class="admin-label">Scope of work</label>
            <textarea name="scope_of_work" rows="3" class="admin-input">{{ old('scope_of_work') }}</textarea>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="admin-label">Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="admin-input">
            </div>
            <div>
                <label class="admin-label">Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="admin-input">
            </div>
        </div>
        <div>
            <label class="admin-label">Manajer proyek</label>
            <select name="manager_user_id" class="admin-input">
                <option value="">—</option>
                @foreach ($managers as $m)
                    <option value="{{ $m->id }}" @selected(old('manager_user_id') == $m->id)>{{ $m->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="admin-label">Status</label>
            <input type="text" name="status" value="{{ old('status', 'planning') }}" class="admin-input">
        </div>
        <div>
            <label class="admin-label">Catatan</label>
            <textarea name="notes" rows="2" class="admin-input">{{ old('notes') }}</textarea>
        </div>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
