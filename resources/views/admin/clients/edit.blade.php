<x-admin-layout>
    <x-slot name="title">Edit klien</x-slot>

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2"><i class="fa-solid fa-user-pen text-[#0d7f7a]"></i> Edit klien</h1>

    <form action="{{ route('admin.clients.update', $client) }}" method="POST" class="max-w-xl space-y-4 bg-white p-6 rounded-lg border border-gray-200">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $client->clientProfile?->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea name="address" rows="2" class="w-full rounded-md border-gray-300 shadow-sm">{{ old('address', $client->clientProfile?->address) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
            <input type="text" name="company_name" value="{{ old('company_name', $client->clientProfile?->company_name) }}" class="w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select name="category" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="individu" @selected(old('category', $client->clientProfile?->category) === 'individu')>Individu</option>
                <option value="korporat" @selected(old('category', $client->clientProfile?->category) === 'korporat')>Korporat</option>
                <option value="internal" @selected(old('category', $client->clientProfile?->category) === 'internal')>Internal</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status akun profil</label>
            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="active" @selected(old('status', $client->clientProfile?->status) === 'active')>Aktif</option>
                <option value="inactive" @selected(old('status', $client->clientProfile?->status) === 'inactive')>Inaktif</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0d7f7a] text-white px-4 py-2 text-sm font-medium"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
            <a href="{{ route('admin.clients.index') }}" class="px-4 py-2 text-sm text-gray-600">Batal</a>
        </div>
    </form>
</x-admin-layout>
