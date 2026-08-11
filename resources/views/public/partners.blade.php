@extends('layouts.public')

@section('title', 'Parceiros')

@php
    $statusVariant = [
        'proposto' => '', 'convidado' => 'status-badge--info',
        'confirmado' => 'status-badge--positive', 'recusou' => 'status-badge--negative',
    ];
@endphp

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Organizações</div>
            <h1 class="display-6 mb-0">Parceiros e Convidados</h1>
            <p class="mt-2 mb-0" style="color: var(--color-muted);">
                Organizações nacionais e internacionais propostas para a Convenção. O estado de cada uma reflecte
                a fase de contacto, não uma confirmação de participação.
            </p>
        </div>
    </section>

    @foreach ($partnersByCategory as $category => $partners)
        <section class="py-5" style="{{ $loop->iteration % 2 === 0 ? 'background: var(--color-surface);' : '' }}">
            <div class="container py-4">
                <div class="eyebrow">{{ $categoryLabels[$category] ?? $category }}</div>

                <div class="row g-0 border-top" style="border-color: var(--color-border);">
                    @foreach ($partners as $partner)
                        <div class="col-md-6">
                            <div class="border-bottom border-md-end p-4" style="border-color: var(--color-border);">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($partner->logoUrl())
                                            <img src="{{ $partner->logoUrl() }}" alt="{{ $partner->name }}" style="max-height: 28px; max-width: 90px;" loading="lazy">
                                        @endif
                                        <h2 class="h6 mb-0">{{ $partner->name }}</h2>
                                    </div>
                                    <span class="status-badge {{ $statusVariant[$partner->status] ?? '' }}">
                                        {{ ucfirst($partner->status) }}
                                    </span>
                                </div>
                                <p class="small mb-0" style="color: var(--color-muted);">{{ $partner->description }}</p>
                                @if ($partner->website_url)
                                    <a href="{{ $partner->website_url }}" class="small" target="_blank" rel="noopener">{{ $partner->website_url }}</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach

@endsection
