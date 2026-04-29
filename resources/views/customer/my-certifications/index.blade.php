<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Sertifikasi Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 p-6 md:p-8">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-1">Daftar Penugasan Sertifikasi</h3>
                    <p class="text-sm text-slate-500">Program sertifikasi yang ditugaskan kepada Anda. Harap lengkapi persyaratan yang diminta.</p>
                </div>

                @if(session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center gap-3">
                        <i class="fas fa-check-circle text-xl text-[#0d7f7a]"></i>
                        <span class="font-medium">{{ session('status') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($certifications as $cert)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col hover:shadow-lg transition-shadow relative overflow-hidden group">
                            
                            @if($cert->status === 'approved')
                                <div class="absolute top-0 right-0 bg-emerald-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl tracking-wider">LULUS</div>
                            @elseif($cert->status === 'rejected')
                                <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl tracking-wider">REVISI</div>
                            @elseif($cert->status === 'submitted' || $cert->status === 'reviewed')
                                <div class="absolute top-0 right-0 bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl tracking-wider">PROSES REVIEW</div>
                            @else
                                <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 text-[10px] font-bold px-3 py-1 rounded-bl-xl tracking-wider">PENDING</div>
                            @endif

                            <div class="mb-4 pt-2">
                                <h4 class="text-lg font-bold text-slate-800 leading-tight mb-2 group-hover:text-[#0d7f7a] transition-colors">{{ $cert->program->name }}</h4>
                                <p class="text-sm text-slate-500 line-clamp-2">{{ $cert->program->description ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs text-slate-400">
                                    <i class="far fa-calendar-alt mr-1"></i> Ditugaskan {{ $cert->created_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('dashboard.my-certifications.show', $cert) }}" class="inline-flex items-center justify-center px-4 py-2 bg-[#0d7f7a] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-800 focus:bg-teal-800 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-[#0d7f7a] focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ $cert->status === 'pending' || $cert->status === 'rejected' ? 'Kerjakan' : 'Lihat Detail' }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-slate-500 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                            <i class="fas fa-certificate text-4xl mb-3 text-slate-300"></i>
                            <p class="font-medium text-slate-600">Belum Ada Penugasan</p>
                            <p class="text-sm">Saat ini Anda belum ditugaskan untuk mengikuti program sertifikasi apapun.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $certifications->links() }}
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
