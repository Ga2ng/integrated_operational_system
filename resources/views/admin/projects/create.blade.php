<x-admin-layout>
    <x-slot name="title">Tambah proyek</x-slot>

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2"><i class="fa-solid fa-plus text-[#0d7f7a]"></i> Tambah proyek</h1>

    <form action="{{ route('admin.projects.store') }}" method="POST" class="max-w-xl space-y-4 bg-white p-6 rounded-lg border border-gray-200">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Scope of work</label>
            <textarea name="scope_of_work" rows="3" class="w-full rounded-md border-gray-300 shadow-sm">{{ old('scope_of_work') }}</textarea>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Manajer proyek</label>
            <select name="manager_user_id" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="">—</option>
                @foreach ($managers as $m)
                    <option value="{{ $m->id }}" @selected(old('manager_user_id') == $m->id)>{{ $m->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <input type="text" name="status" value="{{ old('status', 'planning') }}" class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
            <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 text-sm text-gray-600">Batal</a>
        </div>
    </form>
</x-admin-layout>
