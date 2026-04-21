<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-50 flex items-center justify-center mb-4">
            <i class="fa-solid fa-key text-amber-500 text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Lupa Password</h2>
        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full auth-input" type="email" name="email" :value="old('email')" required autofocus placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3">
                <i class="fa-solid fa-paper-plane mr-2"></i>
                {{ __('Kirim Link Reset') }}
            </x-primary-button>
        </div>

        <div class="mt-5 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#0d7f7a] transition-colors inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke login
            </a>
        </div>
    </form>
</x-guest-layout>
