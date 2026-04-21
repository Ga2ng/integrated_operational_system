<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 mx-auto rounded-2xl bg-teal-50 flex items-center justify-center mb-4">
            <i class="fa-solid fa-lock text-[#0d7f7a] text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Konfirmasi Password</h2>
        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            Ini adalah area yang aman. Konfirmasi password Anda sebelum melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full auth-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3">
                <i class="fa-solid fa-shield-halved mr-2"></i>
                {{ __('Konfirmasi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
