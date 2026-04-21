<x-guest-layout>
    {{-- Header --}}
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
        <p class="text-sm text-gray-500 mt-1">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full auth-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full auth-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#0d7f7a] shadow-sm focus:ring-[#0d7f7a]" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-[#0d7f7a] hover:text-[#0a5f5b] font-medium transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3">
                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <div class="mt-5 text-center">
            <span class="text-sm text-gray-500">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-sm font-semibold text-[#0d7f7a] hover:text-[#0a5f5b] ml-1 transition-colors">
                Daftar sekarang
            </a>
        </div>
    </form>
</x-guest-layout>
