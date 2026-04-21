<x-admin-layout>
    <x-slot name="title">Edit Profil</x-slot>

    <h1 class="admin-page-title">
        <i class="fas fa-user-edit text-[#0d7f7a]"></i> Edit Profil
    </h1>
    <p class="admin-page-desc">Kelola informasi akun, password, dan pengaturan lainnya.</p>

    <div class="space-y-6 max-w-2xl">
        <div class="admin-card admin-card--padded">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="admin-card admin-card--padded">
            @include('profile.partials.update-password-form')
        </div>

        <div class="admin-card admin-card--padded">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-admin-layout>
