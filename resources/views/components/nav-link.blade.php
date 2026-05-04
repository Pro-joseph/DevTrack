@props(['active' => false, 'icon' => ''])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-3 py-2.5 bg-primary text-white rounded-lg shadow-sm transition-all transform hover:scale-[1.02]'
            : 'flex items-center gap-3 px-3 py-2.5 text-outline hover:bg-surface-container hover:text-primary rounded-lg transition-all transform hover:translate-x-1';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span class="material-symbols-outlined text-xl">{{ $icon }}</span>
    @endif
    <span class="font-semibold">{{ $slot }}</span>
</a>
