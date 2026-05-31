@props(['active' => false, 'icon'])

@php
$classes = ($active ?? false)
            ? 'bg-[#143d24] text-white group flex items-center px-4 py-3 text-sm font-semibold rounded-lg transition-all shadow-inner'
            : 'text-green-100/70 hover:bg-[#143d24] hover:text-white group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="fa-solid {{ $icon }} mr-3 {{ $active ? 'text-green-400' : 'opacity-50' }}"></i>
    {{ $slot }}
</a>