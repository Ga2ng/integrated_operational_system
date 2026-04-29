<x-admin-layout>
    <x-slot name="title">Review Detail: {{ $participant->user->name }}</x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.certification-programs.submissions', $participant->certification_program_id) }}" class="text-sm text-slate-500 hover:text-[#0d7f7a] mb-2 inline-block"><i class="fas fa-arrow-left"></i> Kembali</a>
            <h1 class="admin-page-title"><i class="fas fa-file-signature" style="color: var(--admin-primary);"></i> Review Form Sertifikasi</h1>
            <p class="admin-page-desc">Peserta: <span class="font-bold">{{ $participant->user->name }}</span> | Program: {{ $participant->program->name }}</p>
        </div>
        <div>
            <span class="px-3 py-1.5 bg-slate-100 text-slate-700 text-sm font-bold rounded border border-slate-200 uppercase">
                Status saat ini: {{ $participant->status }}
            </span>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 space-y-6">
            <div class="admin-card p-6">
                <h3 class="font-bold text-slate-800 mb-6 border-b border-slate-100 pb-2">Jawaban Peserta</h3>
                
                <div class="space-y-6">
                    @foreach($participant->program->requirements as $index => $req)
                        @php
                            $answer = $participant->answers->where('certification_requirement_id', $req->id)->first();
                        @endphp
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <p class="font-medium text-slate-800 mb-2"><span class="text-slate-400 mr-2">{{ $index + 1 }}.</span> {{ $req->question }}</p>
                            
                            <div class="pl-6 border-l-2 border-[#0d7f7a] ml-1">
                                @if(!$answer)
                                    <span class="text-slate-400 italic text-sm">Tidak ada jawaban.</span>
                                @elseif($req->type === 'file' && $answer->file_path)
                                    <a href="{{ asset('storage/' . $answer->file_path) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-sm text-[#0d7f7a] hover:bg-teal-50 transition-colors font-medium">
                                        <i class="fas fa-download"></i> Lihat/Download File
                                    </a>
                                @elseif($req->type === 'text')
                                    <p class="text-slate-700 text-sm whitespace-pre-line">{{ $answer->answer_text ?? '-' }}</p>
                                @else
                                    <span class="text-slate-400 italic text-sm">Kosong.</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="admin-card p-6 bg-slate-50 border-t-4 border-blue-500">
            <h3 class="font-bold text-slate-800 mb-4">Keputusan Review</h3>
            <form action="{{ route('admin.certification-programs.submissions.update-status', $participant) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="admin-label">Ubah Status</label>
                    <select name="status" class="admin-input" required>
                        <option value="reviewed" {{ $participant->status === 'reviewed' ? 'selected' : '' }}>Sedang Direview</option>
                        <option value="approved" {{ $participant->status === 'approved' ? 'selected' : '' }}>Approve (Lulus)</option>
                        <option value="rejected" {{ $participant->status === 'rejected' ? 'selected' : '' }}>Reject (Gagal / Revisi)</option>
                    </select>
                </div>
                <div>
                    <label class="admin-label">Catatan Review <span class="font-normal text-slate-400">(Opsional)</span></label>
                    <textarea name="review_notes" rows="4" class="admin-input" placeholder="Berikan catatan perbaikan atau feedback untuk peserta...">{{ old('review_notes', $participant->review_notes) }}</textarea>
                </div>
                
                <button type="submit" class="admin-btn admin-btn--primary w-full"><i class="fas fa-check-circle"></i> Simpan Keputusan</button>
            </form>
        </div>
    </div>
</x-admin-layout>
