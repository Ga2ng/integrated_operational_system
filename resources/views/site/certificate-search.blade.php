<x-site-layout>
    <div class="pt-32 pb-20 lg:pt-40 lg:pb-28 bg-slate-50 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-teal-50/50 to-white"></div>
        
        <div class="container relative z-10 px-4 md:px-6 max-w-2xl mx-auto">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-teal-100 text-[#0d7f7a] mb-4 shadow-sm">
                    <i class="fas fa-search text-2xl"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-3 tracking-tight">Cek Status Sertifikat</h1>
                <p class="text-slate-600 text-lg">Masukkan Nomor Validasi Sertifikat Anda untuk mengecek keaslian dan status kelulusan sertifikasi.</p>
            </div>

            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100">
                <form action="{{ route('certificates.search.post') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="code" class="block text-sm font-bold text-slate-700 mb-2">Nomor Sertifikat / Validation Code</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-barcode"></i>
                            </div>
                            <input 
                                type="text" 
                                name="code" 
                                id="code" 
                                required 
                                placeholder="Misal: ABCD-1234-WXYZ"
                                class="w-full pl-12 pr-4 py-4 rounded-xl border-slate-200 focus:border-[#0d7f7a] focus:ring focus:ring-[#0d7f7a]/20 bg-slate-50 focus:bg-white text-lg font-mono tracking-wide text-slate-800 transition-all placeholder:text-slate-400"
                            >
                        </div>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full inline-flex justify-center items-center py-4 px-6 border border-transparent shadow-md shadow-[#0d7f7a]/20 text-base font-bold rounded-xl text-white bg-gradient-to-r from-[#0d7f7a] to-teal-500 hover:from-teal-700 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d7f7a] transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-search mr-2"></i> Cari Sertifikat
                    </button>
                </form>
                
                <div class="mt-8 text-center text-sm text-slate-500">
                    <p><i class="fas fa-info-circle mr-1 text-[#0d7f7a]"></i> Nomor sertifikat dapat ditemukan di bagian bawah sertifikat cetak/digital Anda.</p>
                </div>
            </div>
        </div>
    </div>
</x-site-layout>
