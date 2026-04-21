<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('Setelah akun dihapus, semua data akan dihapus secara permanen. Pastikan Anda sudah mengunduh data yang ingin disimpan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <i class="fa-solid fa-trash mr-1"></i> {{ __('Hapus Akun') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                {{ __('Konfirmasi Hapus Akun') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                {{ __('Setelah akun dihapus, semua data akan dihapus secara permanen. Masukkan password Anda untuk mengkonfirmasi penghapusan.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button>
                    <i class="fa-solid fa-trash mr-1"></i> {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
