<x-admin-layout>
    <x-slot name="title">Kelola Persyaratan: {{ $certificationProgram->name }}</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.certification-programs.index') }}" class="text-sm text-slate-500 hover:text-[#0d7f7a] mb-2 inline-block"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h1 class="admin-page-title"><i class="fas fa-list-check" style="color: var(--admin-primary);"></i> Kelola Form Persyaratan</h1>
        <p class="admin-page-desc">Program: {{ $certificationProgram->name }}</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 space-y-4">
            @forelse($certificationProgram->requirements as $index => $req)
                <div class="admin-card p-5 flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">{{ $index + 1 }}</span>
                            @if($req->type === 'file')
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded uppercase">Upload File</span>
                            @else
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-bold rounded uppercase">Teks</span>
                            @endif
                            
                            @if($req->is_required)
                                <span class="text-red-500 text-xs font-bold">* Wajib</span>
                            @endif
                        </div>
                        <p class="font-medium text-slate-800">{{ $req->question }}</p>
                    </div>
                    <form action="{{ route('admin.certification-programs.requirements.destroy', $req) }}" method="POST" onsubmit="return confirm('Hapus persyaratan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 p-2"><i class="fas fa-times"></i></button>
                    </form>
                </div>
            @empty
                <div class="admin-card p-8 text-center text-slate-500 border-dashed border-2">
                    Belum ada persyaratan. Form sertifikasi ini masih kosong.
                </div>
            @endforelse
        </div>

        <div class="admin-card p-6 bg-slate-50 border-t-4 border-[#0d7f7a]">
            <h3 class="font-bold text-slate-800 mb-4">Tambah Pertanyaan Baru</h3>
            <form action="{{ route('admin.certification-programs.requirements.store', $certificationProgram) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="admin-label">Pertanyaan / Instruksi</label>
                    <textarea name="question" rows="2" required class="admin-input" placeholder="Masukkan pertanyaan..."></textarea>
                </div>
                <div>
                    <label class="admin-label">Jenis Jawaban</label>
                    <select name="type" class="admin-input" required>
                        <option value="text">Teks Pendek/Panjang</option>
                        <option value="file">Upload File (Bukti PDF/Gambar)</option>
                    </select>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-700">
                    <input type="hidden" name="is_required" value="0">
                    <input type="checkbox" name="is_required" value="1" checked class="rounded border-slate-300">
                    Wajib diisi
                </label>
                <button type="submit" class="admin-btn admin-btn--primary w-full"><i class="fas fa-plus"></i> Tambah</button>
            </form>
        </div>
    </div>
</x-admin-layout>
