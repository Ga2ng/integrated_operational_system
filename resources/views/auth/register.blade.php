<x-guest-layout>
    {{-- Header --}}
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar untuk mulai menggunakan platform</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full auth-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full auth-input" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full auth-input"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full auth-input"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3">
                <i class="fa-solid fa-user-plus mr-2"></i>
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        <div class="mt-5 text-center">
            <span class="text-sm text-gray-500">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-sm font-semibold text-[#0d7f7a] hover:text-[#0a5f5b] ml-1 transition-colors">
                Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
