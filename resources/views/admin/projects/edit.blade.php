<x-admin-layout>
    <x-slot name="title">Edit proyek</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-pen" style="color: var(--admin-primary);"></i> Edit proyek</h1>
    <p class="admin-page-desc">{{ $project->name }}</p>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST" class="admin-card admin-card--padded w-full space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="admin-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $project->name) }}" required class="admin-input">
        </div>
        <div>
            <label class="admin-label">Scope of work</label>
            <textarea name="scope_of_work" rows="3" class="admin-input">{{ old('scope_of_work', $project->scope_of_work) }}</textarea>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="admin-label">Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" class="admin-input">
            </div>
            <div>
                <label class="admin-label">Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}" class="admin-input">
            </div>
        </div>
        <div>
            <label class="admin-label">Manajer proyek</label>
            <select name="manager_user_id" class="admin-input">
                <option value="">—</option>
                @foreach ($managers as $m)
                    <option value="{{ $m->id }}" @selected(old('manager_user_id', $project->manager_user_id) == $m->id)>{{ $m->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="admin-label">Status</label>
            <input type="text" name="status" value="{{ old('status', $project->status) }}" class="admin-input">
        </div>
        <div>
            <label class="admin-label">Catatan</label>
            <textarea name="notes" rows="2" class="admin-input">{{ old('notes', $project->notes) }}</textarea>
        </div>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Perbarui</button>
            <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
