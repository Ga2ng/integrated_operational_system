<x-admin-layout>
    <x-slot name="title">Edit sertifikat</x-slot>

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2"><i class="fa-solid fa-pen text-[#0d7f7a]"></i> Edit sertifikat</h1>

    <form action="{{ route('admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data" class="max-w-xl space-y-4 bg-white p-6 rounded-lg border border-gray-200">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kode validasi</label>
            <input type="text" value="{{ $certificate->validation_code }}" readonly class="w-full rounded-md border-gray-200 bg-gray-50 shadow-sm font-mono text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Peserta</label>
            <select name="participant_user_id" required class="w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($participants as $u)
                    <option value="{{ $u->id }}" @selected(old('participant_user_id', $certificate->participant_user_id) == $u->id)>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Proyek</label>
            <select name="project_id" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="">—</option>
                @foreach ($projects as $pr)
                    <option value="{{ $pr->id }}" @selected(old('project_id', $certificate->project_id) == $pr->id)>{{ $pr->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal terbit</label>
                <input type="date" name="issued_at" value="{{ old('issued_at', $certificate->issued_at->format('Y-m-d')) }}" required class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Berlaku s/d</label>
                <input type="date" name="valid_until" value="{{ old('valid_until', $certificate->valid_until?->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>
        @if ($certificate->document_path)
            <p class="text-sm">File saat ini: <a href="{{ \Illuminate\Support\Facades\Storage::url($certificate->document_path) }}" class="text-[#0d7f7a] underline" target="_blank"><i class="fa-solid fa-file-arrow-down"></i> Unduh</a></p>
        @endif
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti file (opsional)</label>
            <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-sm">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium"><i class="fa-solid fa-floppy-disk"></i> Perbarui</button>
            <a href="{{ route('admin.certificates.index') }}" class="px-4 py-2 text-sm text-gray-600">Batal</a>
        </div>
    </form>
</x-admin-layout>
