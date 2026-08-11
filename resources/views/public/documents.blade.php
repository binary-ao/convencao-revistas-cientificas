@extends('layouts.public')

@section('title', 'Documentos')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Recursos</div>
            <h1 class="display-6 mb-0">Documentos</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            @if ($documentsByCategory->isEmpty())
                <p style="color: var(--color-muted);">Ainda não há documentos publicados.</p>
            @else
                @foreach ($documentsByCategory as $category => $documents)
                    <div class="mb-5">
                        <div class="eyebrow">{{ $categoryLabels[$category] ?? $category }}</div>
                        <div class="border-top" style="border-color: var(--color-border);">
                            @foreach ($documents as $document)
                                <div class="d-flex align-items-center justify-content-between py-3 border-bottom"
                                    style="border-color: var(--color-border);">
                                    <div>
                                        <div class="fw-semibold">{{ $document->title }}</div>
                                        @if ($document->description)
                                            <div class="small" style="color: var(--color-muted);">{{ $document->description }}</div>
                                        @endif
                                    </div>
                                    <a href="{{ $document->fileUrl() }}" class="btn btn-outline-dark btn-sm" target="_blank">Descarregar</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

@endsection
