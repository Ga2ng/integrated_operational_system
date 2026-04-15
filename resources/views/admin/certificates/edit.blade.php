<x-admin-layout>
    <x-slot name="title">Edit sertifikat</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-pen" style="color: var(--admin-primary);"></i> Edit sertifikat</h1>
    <p class="admin-page-desc">Kode: <span class="font-mono text-sm">{{ $certificate->validation_code }}</span></p>

    <form action="{{ route('admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data" class="admin-card admin-card--padded w-full space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="admin-label">Kode validasi</label>
            <input type="text" value="{{ $certificate->validation_code }}" readonly class="admin-input bg-slate-50 font-mono text-sm">
        </div>
        <div>
            <label class="admin-label">Peserta</label>
            <select name="participant_user_id" required class="admin-input">
                @foreach ($participants as $u)
                    <option value="{{ $u->id }}" @selected(old('participant_user_id', $certificate->participant_user_id) == $u->id)>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="admin-label">Proyek</label>
            <select name="project_id" class="admin-input">
                <option value="">—</option>
                @foreach ($projects as $pr)
                    <option value="{{ $pr->id }}" @selected(old('project_id', $certificate->project_id) == $pr->id)>{{ $pr->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="admin-label">Tanggal terbit</label>
                <input type="date" name="issued_at" value="{{ old('issued_at', $certificate->issued_at->format('Y-m-d')) }}" required class="admin-input">
            </div>
            <div>
                <label class="admin-label">Berlaku s/d</label>
                <input type="date" name="valid_until" value="{{ old('valid_until', $certificate->valid_until?->format('Y-m-d')) }}" class="admin-input">
            </div>
        </div>
        @if ($certificate->document_path)
            <p class="text-sm text-slate-600">File: <a href="{{ \Illuminate\Support\Facades\Storage::url($certificate->document_path) }}" class="font-semibold underline" style="color: var(--admin-primary);" target="_blank"><i class="fas fa-download"></i> Unduh</a></p>
        @endif
        <div>
            <label class="admin-label">Ganti file (opsional)</label>
            <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" class="admin-input py-2">
        </div>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Perbarui</button>
            <a href="{{ route('admin.certificates.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
