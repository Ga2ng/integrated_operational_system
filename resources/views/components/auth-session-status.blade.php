@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-2 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium']) }}>
        <i class="fa-solid fa-circle-check text-green-500"></i>
        {{ $status }}
    </div>
@endif
