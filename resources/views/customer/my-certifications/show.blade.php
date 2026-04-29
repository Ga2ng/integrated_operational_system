<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Formulir Sertifikasi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-6 md:p-8 border-b border-slate-100 bg-gradient-to-r from-[#0d7f7a] to-teal-600 text-white">
                    <a href="{{ route('dashboard.my-certifications.index') }}" class="text-sm text-teal-100 hover:text-white mb-4 inline-block"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
                    <h1 class="text-2xl font-bold mb-2">{{ $participant->program->name }}</h1>
                    <p class="text-teal-50">{{ $participant->program->description ?? 'Harap lengkapi semua persyaratan di bawah ini untuk proses sertifikasi.' }}</p>
                </div>

                <div class="p-6 md:p-8">
                    @if($participant->status === 'rejected')
                        <div class="mb-8 p-4 rounded-xl bg-red-50 border border-red-200">
                            <h4 class="font-bold text-red-800 flex items-center gap-2 mb-2"><i class="fas fa-exclamation-triangle"></i> Status: Perlu Revisi</h4>
                            <p class="text-sm text-red-700">Pengajuan sertifikasi Anda dikembalikan. Catatan Reviewer: <strong>{{ $participant->review_notes ?? 'Silakan lengkapi kembali sesuai instruksi.' }}</strong></p>
                        </div>
                    @endif

                    @if($participant->status === 'submitted' || $participant->status === 'reviewed')
                        <div class="mb-8 p-6 rounded-xl bg-blue-50 border border-blue-200 text-center">
                            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <h4 class="font-bold text-blue-800 text-lg mb-2">Formulir Telah Dikirim</h4>
                            <p class="text-sm text-blue-700">Anda telah mengirimkan jawaban pada {{ $participant->submitted_at?->format('d M Y, H:i') }}. Saat ini sedang dalam tahap pengecekan oleh Tim Admin.</p>
                        </div>
                    @elseif($participant->status === 'approved')
                        <div class="mb-8 p-6 rounded-xl bg-emerald-50 border border-emerald-200 text-center">
                            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h4 class="font-bold text-emerald-800 text-lg mb-2">Sertifikasi Lulus!</h4>
                            <p class="text-sm text-emerald-700 mb-4">Selamat, jawaban dan bukti persyaratan Anda telah disetujui.</p>
                            @if(isset($certificate))
                                <div class="bg-white p-4 rounded-xl border border-emerald-200 shadow-sm mt-4 inline-block text-left mx-auto">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Kode Sertifikat:</span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl font-mono font-bold text-emerald-800">{{ $certificate->validation_code }}</span>
                                        <a href="{{ route('certificates.verify', $certificate->validation_code) }}" target="_blank" class="px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded text-xs font-bold transition-colors">
                                            <i class="fas fa-external-link-alt mr-1"></i> Cek Validitas
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($participant->review_notes)
                                <div class="bg-white p-3 rounded text-sm text-slate-600 text-left border border-emerald-100 shadow-sm mt-4">
                                    <span class="font-bold text-emerald-800 block mb-1">Catatan Admin:</span>
                                    {{ $participant->review_notes }}
                                </div>
                            @endif
                        </div>
                    @endif

                    <form action="{{ route('dashboard.my-certifications.store', $participant) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        @foreach($participant->program->requirements as $index => $req)
                            @php
                                $answer = $participant->answers->where('certification_requirement_id', $req->id)->first();
                                $isDisabled = in_array($participant->status, ['submitted', 'reviewed', 'approved']);
                            @endphp
                            
                            <div class="p-6 rounded-xl border {{ $errors->has('req_'.$req->id) ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-white shadow-sm' }}">
                                <label class="block font-medium text-slate-800 mb-2">
                                    <span class="text-[#0d7f7a] mr-1">{{ $index + 1 }}.</span> {{ $req->question }}
                                    @if($req->is_required) <span class="text-red-500">*</span> @endif
                                </label>

                                @if($req->type === 'text')
                                    <textarea 
                                        name="req_{{ $req->id }}" 
                                        rows="3" 
                                        class="w-full rounded-lg border-slate-300 focus:border-[#0d7f7a] focus:ring-[#0d7f7a] text-sm disabled:bg-slate-50 disabled:text-slate-500" 
                                        placeholder="Tuliskan jawaban Anda di sini..."
                                        {{ $req->is_required ? 'required' : '' }}
                                        {{ $isDisabled ? 'disabled' : '' }}
                                    >{{ old('req_'.$req->id, $answer->answer_text ?? '') }}</textarea>
                                
                                @elseif($req->type === 'file')
                                    <div class="space-y-3">
                                        @if(!$isDisabled)
                                            <input 
                                                type="file" 
                                                name="req_{{ $req->id }}" 
                                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer border border-slate-200 rounded-lg p-2"
                                                accept=".pdf,image/*"
                                                {{ $req->is_required && !$answer ? 'required' : '' }}
                                            >
                                            <p class="text-xs text-slate-400">Format: PDF, JPG, PNG. Maksimal 5MB.</p>
                                        @endif
                                        
                                        @if($answer && $answer->file_path)
                                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200 w-fit">
                                                <i class="fas fa-file-alt text-2xl text-slate-400"></i>
                                                <div>
                                                    <p class="text-sm font-medium text-slate-700">File Tersimpan</p>
                                                    <a href="{{ asset('storage/' . $answer->file_path) }}" target="_blank" class="text-xs text-[#0d7f7a] hover:underline font-bold">Lihat Dokumen</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @error('req_'.$req->id)
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        @if(in_array($participant->status, ['pending', 'rejected']))
                            <div class="flex justify-end pt-6 border-t border-slate-100">
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-[#0d7f7a] border border-transparent rounded-xl font-bold text-sm text-white hover:bg-teal-800 focus:bg-teal-800 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-[#0d7f7a] focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                    <i class="fas fa-paper-plane mr-2"></i> Submit Persyaratan
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
