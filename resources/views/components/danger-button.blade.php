<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-red-700 hover:shadow-lg hover:shadow-red-500/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:scale-[0.98] transition-all duration-200']) }}>
    {{ $slot }}
</button>
