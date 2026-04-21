<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
            <i class="fa-solid fa-envelope-circle-check text-blue-500 text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Verifikasi Email</h2>
        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            Terima kasih sudah mendaftar! Silakan verifikasi email Anda dengan mengklik link yang baru saja kami kirimkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i>
            Link verifikasi baru telah dikirim ke email Anda.
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center py-3">
                <i class="fa-solid fa-paper-plane mr-2"></i>
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm text-gray-500 hover:text-[#0d7f7a] transition-colors flex items-center justify-center gap-1">
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                {{ __('Keluar') }}
            </button>
        </form>
    </div>
</x-guest-layout>
