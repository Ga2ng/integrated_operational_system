<x-admin-layout>
    <x-slot name="title">Edit Pengguna</x-slot>

    <div class="admin-toolbar">
        <div>
            <h1 class="admin-page-title"><i class="fas fa-user-gear" style="color: var(--admin-primary);"></i> Edit Pengguna</h1>
            <p class="admin-page-desc">Atur role dan password untuk pengguna <strong>{{ $user->name }}</strong>.</p>
        </div>
    </div>

    <div class="admin-card admin-card--padded max-w-2xl">
        <form method="POST" action="{{ route('admin.settings.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label class="admin-form-label">Nama</label>
                <input type="text" value="{{ $user->name }}" class="admin-input" disabled>
            </div>

            <div>
                <label class="admin-form-label">Email</label>
                <input type="text" value="{{ $user->email }}" class="admin-input" disabled>
            </div>

            <div>
                <label for="role_id" class="admin-form-label">Role</label>
                <select name="role_id" id="role_id" class="admin-input" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="admin-form-label">Password baru (opsional)</label>
                <input type="password" name="password" id="password" class="admin-input" placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="admin-form-label">Konfirmasi password baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="admin-input">
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.settings.users.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
                <button type="submit" class="admin-btn admin-btn--primary">
                    <i class="fas fa-save"></i> Simpan perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
