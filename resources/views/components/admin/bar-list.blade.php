@props(['items'])

@php
    $max = collect($items)->max('value') ?: 1;
@endphp

<div class="bar-list">
    @forelse ($items as $item)
        <div class="d-flex align-items-center mb-2">
            <div class="small" style="width: 40%; color: var(--color-text);">{{ $item['label'] }}</div>
            <div class="flex-grow-1 mx-2" style="background: var(--color-surface); height: 10px;">
                <div style="width: {{ $max > 0 ? round(($item['value'] / $max) * 100) : 0 }}%; height: 10px; background: var(--color-primary);"></div>
            </div>
            <div class="small font-monospace text-end" style="width: 32px;">{{ $item['value'] }}</div>
        </div>
    @empty
        <p class="small mb-0" style="color: var(--color-muted);">Sem dados ainda.</p>
    @endforelse
</div>
