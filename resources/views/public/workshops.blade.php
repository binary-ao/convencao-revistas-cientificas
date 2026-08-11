@extends('layouts.public')

@section('title', 'Workshops')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Oficinas Práticas</div>
            <h1 class="display-6 mb-0">Workshops</h1>
            <p class="mt-2 mb-0" style="color: var(--color-muted);">
                Escolha da actividade feita na inscrição — vagas limitadas por oficina.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row g-4">
                @foreach ($workshops as $workshop)
                    <div class="col-md-6 col-lg-4">
                        <div class="border h-100 p-4 d-flex flex-column" style="border-color: var(--color-border);">
                            <div class="eyebrow">{{ $workshop->code }}</div>
                            <h2 class="h5 mb-2">{{ $workshop->name }}</h2>
                            <p class="small flex-grow-1" style="color: var(--color-muted);">{{ $workshop->description }}</p>

                            <ul class="list-unstyled small mb-3">
                                @if ($workshop->trainer)
                                    <li class="mb-1">Formador: <a href="{{ route('speakers.show', $workshop->trainer) }}">{{ $workshop->trainer->name }}</a></li>
                                @endif
                                @if ($workshop->date)
                                    <li class="mb-1">{{ $workshop->date->translatedFormat('d \d\e F') }}, {{ \Illuminate\Support\Str::of($workshop->start_time)->substr(0, 5) }}&ndash;{{ \Illuminate\Support\Str::of($workshop->end_time)->substr(0, 5) }}</li>
                                @endif
                                @if ($workshop->room)
                                    <li class="mb-1">{{ $workshop->room }}</li>
                                @endif
                            </ul>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="status-badge status-badge--positive">
                                    {{ $workshop->availableSpots() }} vagas
                                </span>
                                <span class="small text-capitalize" style="color: var(--color-muted);">{{ $workshop->modality }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
