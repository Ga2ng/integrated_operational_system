<x-admin-layout>
    <x-slot name="title">Assign Peserta: {{ $program->name }}</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.certification-programs.index') }}" class="text-sm text-slate-500 hover:text-[#0d7f7a] mb-2 inline-block"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h1 class="admin-page-title"><i class="fas fa-users" style="color: var(--admin-primary);"></i> Assign Peserta</h1>
        <p class="admin-page-desc">Tugaskan program "{{ $program->name }}" ke pengguna.</p>
    </div>

    <form action="{{ route('admin.certification-programs.assign.store', $program) }}" method="POST" class="admin-card admin-card--padded">
        @csrf
        
        <div class="mb-4 flex justify-between items-center border-b border-slate-100 pb-3">
            <h3 class="font-bold text-slate-800">Daftar Pengguna</h3>
            <label class="flex items-center gap-2 text-sm font-semibold text-[#0d7f7a] cursor-pointer">
                <input type="checkbox" id="selectAll" class="rounded border-slate-300 text-[#0d7f7a] focus:ring-[#0d7f7a]">
                Pilih Semua
            </label>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6 max-h-[60vh] overflow-y-auto p-2">
            @foreach($users as $user)
                <label class="flex items-start gap-3 p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors
                    {{ in_array($user->id, $assignedIds) ? 'bg-teal-50 border-teal-200' : '' }}">
                    <input type="checkbox" name="participants[]" value="{{ $user->id }}" 
                           class="mt-1 participant-cb rounded border-slate-300 text-[#0d7f7a] focus:ring-[#0d7f7a]"
                           {{ in_array($user->id, $assignedIds) ? 'checked' : '' }}>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">{{ $user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        <span class="text-[10px] uppercase font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded mt-1 inline-block">{{ data_get($user, 'roles.0.name', 'User') }}</span>
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Simpan Penugasan</button>
        </div>
    </form>

    <script>
        document.getElementById('selectAll').addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('.participant-cb');
            checkboxes.forEach(cb => {
                cb.checked = e.target.checked;
                // Optional: update visual styling
                const label = cb.closest('label');
                if(e.target.checked) {
                    label.classList.add('bg-teal-50', 'border-teal-200');
                } else {
                    label.classList.remove('bg-teal-50', 'border-teal-200');
                }
            });
        });

        document.querySelectorAll('.participant-cb').forEach(cb => {
            cb.addEventListener('change', function(e) {
                const label = e.target.closest('label');
                if(e.target.checked) {
                    label.classList.add('bg-teal-50', 'border-teal-200');
                } else {
                    label.classList.remove('bg-teal-50', 'border-teal-200');
                }
            });
        });
    </script>
</x-admin-layout>
