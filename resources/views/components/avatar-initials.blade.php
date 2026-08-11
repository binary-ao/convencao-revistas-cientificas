@props(['name'])

@php
    // Sem fotografias de stock: enquanto não há fotografia real carregada,
    // mostra-se um monograma tipográfico — honesto sobre ser um placeholder.
    $palette = ['#1F3B57', '#14293C', '#A8672E', '#3A6E86', '#5A6266'];
    $parts = collect(explode(' ', trim($name)))->filter()->values();
    $initials = $parts->count() > 1
        ? mb_strtoupper(mb_substr($parts->first(), 0, 1)).mb_strtoupper(mb_substr($parts->last(), 0, 1))
        : mb_strtoupper(mb_substr($parts->first() ?? '', 0, 2));
    $bg = $palette[crc32($name) % count($palette)];
@endphp

<svg viewBox="0 0 100 100" role="img" aria-label="Iniciais de {{ $name }}"
    {{ $attributes->merge(['class' => 'avatar-initials']) }}>
    <rect width="100" height="100" fill="{{ $bg }}" />
    <text x="50" y="54" text-anchor="middle" dominant-baseline="middle"
        font-family="Inter Variable, -apple-system, Segoe UI, Arial, sans-serif"
        font-size="36" font-weight="600" fill="#ffffff">{{ $initials }}</text>
</svg>
