<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0d7f7a] focus:ring-offset-2 active:scale-[0.98] transition-all duration-200']) }}>
    {{ $slot }}
</button>
