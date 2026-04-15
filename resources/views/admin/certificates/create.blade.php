<x-admin-layout>
    <x-slot name="title">Tambah sertifikat</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-plus" style="color: var(--admin-primary);"></i> Tambah sertifikat</h1>
    <p class="admin-page-desc">Kode validasi dibuat otomatis. File opsional (PDF/gambar).</p>

    <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data" class="admin-card admin-card--padded w-full space-y-4">
        @csrf
        <div>
            <label class="admin-label">Peserta</label>
            <select name="participant_user_id" required class="admin-input">
                @foreach ($participants as $u)
                    <option value="{{ $u->id }}" @selected(old('participant_user_id') == $u->id)>{{ $u->name }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="admin-label">Proyek (opsional)</label>
            <select name="project_id" class="admin-input">
                <option value="">—</option>
                @foreach ($projects as $pr)
                    <option value="{{ $pr->id }}" @selected(old('project_id') == $pr->id)>{{ $pr->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="admin-label">Tanggal terbit</label>
                <input type="date" name="issued_at" value="{{ old('issued_at', now()->format('Y-m-d')) }}" required class="admin-input">
            </div>
            <div>
                <label class="admin-label">Berlaku s/d</label>
                <input type="date" name="valid_until" value="{{ old('valid_until') }}" class="admin-input">
            </div>
        </div>
        <div>
            <label class="admin-label">File (opsional, max 5MB)</label>
            <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" class="admin-input py-2">
        </div>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.certificates.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
