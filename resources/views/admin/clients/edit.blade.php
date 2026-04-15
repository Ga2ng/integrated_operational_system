<x-admin-layout>
    <x-slot name="title">Edit klien</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-user-pen" style="color: var(--admin-primary);"></i> Edit klien</h1>
    <p class="admin-page-desc">{{ $client->name }} — {{ $client->email }}</p>

    <form action="{{ route('admin.clients.update', $client) }}" method="POST" class="admin-card admin-card--padded w-full space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="admin-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $client->name) }}" required class="admin-input">
        </div>
        <div>
            <label class="admin-label">Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $client->clientProfile?->phone) }}" class="admin-input">
        </div>
        <div>
            <label class="admin-label">Alamat</label>
            <textarea name="address" rows="2" class="admin-input">{{ old('address', $client->clientProfile?->address) }}</textarea>
        </div>
        <div>
            <label class="admin-label">Perusahaan</label>
            <input type="text" name="company_name" value="{{ old('company_name', $client->clientProfile?->company_name) }}" class="admin-input">
        </div>
        <div>
            <label class="admin-label">Kategori</label>
            <select name="category" class="admin-input">
                <option value="individu" @selected(old('category', $client->clientProfile?->category) === 'individu')>Individu</option>
                <option value="korporat" @selected(old('category', $client->clientProfile?->category) === 'korporat')>Korporat</option>
                <option value="internal" @selected(old('category', $client->clientProfile?->category) === 'internal')>Internal</option>
            </select>
        </div>
        <div>
            <label class="admin-label">Status profil</label>
            <select name="status" class="admin-input">
                <option value="active" @selected(old('status', $client->clientProfile?->status) === 'active')>Aktif</option>
                <option value="inactive" @selected(old('status', $client->clientProfile?->status) === 'inactive')>Inaktif</option>
            </select>
        </div>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.clients.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>
</x-admin-layout>
