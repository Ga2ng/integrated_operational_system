@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-200 rounded-xl shadow-sm focus:border-[#0d7f7a] focus:ring-[#0d7f7a] text-sm placeholder-gray-400 transition-all duration-200']) !!}>
