<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#0d7f7a] to-[#10a8a2] border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:opacity-90 hover:shadow-lg hover:shadow-[#0d7f7a]/20 focus:outline-none focus:ring-2 focus:ring-[#0d7f7a] focus:ring-offset-2 active:scale-[0.98] transition-all duration-200']) }}>
    {{ $slot }}
</button>
