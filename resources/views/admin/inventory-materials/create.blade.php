<x-admin-layout>
    <x-slot name="title">Tambah Inventory Material</x-slot>

    <h1 class="admin-page-title"><i class="fas fa-plus" style="color: var(--admin-primary);"></i> Tambah Inventory Material</h1>
    <p class="admin-page-desc">Master stok material untuk mendukung proses penawaran RFQ.</p>

    <form action="{{ route('admin.inventory-materials.store') }}" method="POST" enctype="multipart/form-data" class="admin-card admin-card--padded w-full space-y-4">
        @csrf
        <div>
            <label class="admin-label">Kode material</label>
            <input type="text" name="code" value="{{ old('code') }}" required class="admin-input font-mono text-sm">
            @error('code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="admin-label">Nama material</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="admin-input">
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="admin-label">Spesifikasi</label>
            <textarea name="specification" rows="2" class="admin-input">{{ old('specification') }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div>
            <label class="admin-label">Gambar Material <span class="text-slate-400 font-normal">(opsional, maks 2MB)</span></label>
            <div class="mt-1 flex items-start gap-4">
                <div id="img-preview-wrap" class="w-24 h-24 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
                    <i class="fas fa-image text-slate-300 text-2xl" id="img-placeholder-icon"></i>
                    <img id="img-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                </div>
                <div class="flex-1 space-y-2">
                    <input
                        type="file"
                        name="image"
                        id="image-input"
                        accept="image/*"
                        class="admin-input py-2 text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer"
                    >
                    <p class="text-xs text-slate-400">Format: JPG, PNG, WEBP. Resolusi disarankan minimal 400×400px.</p>
                </div>
            </div>
            @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="admin-label">UoM</label>
                <input type="text" name="uom" value="{{ old('uom', 'kg') }}" required class="admin-input">
            </div>
            <div>
                <label class="admin-label">Biaya satuan</label>
                <input type="number" step="0.01" min="0" name="unit_cost" value="{{ old('unit_cost', 0) }}" required class="admin-input">
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="admin-label">Stok saat ini</label>
                <input type="number" step="0.01" min="0" name="current_stock" value="{{ old('current_stock', 0) }}" required class="admin-input">
            </div>
            <div>
                <label class="admin-label">Minimum stok</label>
                <input type="number" step="0.01" min="0" name="minimum_stock" value="{{ old('minimum_stock', 0) }}" required class="admin-input">
            </div>
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-slate-300">
            Material aktif (tampil di katalog publik)
        </label>
        <div class="flex flex-wrap gap-2 pt-2">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('admin.inventory-materials.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
        </div>
    </form>

    <script>
        document.getElementById('image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                const preview = document.getElementById('img-preview');
                const icon = document.getElementById('img-placeholder-icon');
                preview.src = ev.target.result;
                preview.classList.remove('hidden');
                icon.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-admin-layout>
