@extends('layouts.public')

@section('title', 'Cursos')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Cursos de Curta Duração</div>
            <h1 class="display-6 mb-0">Cursos</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row g-4">
                @foreach ($courses as $course)
                    <div class="col-md-6">
                        <div class="border h-100 p-4 d-flex flex-column" style="border-color: var(--color-border);">
                            <div class="eyebrow">{{ $course->code }}</div>
                            <h2 class="h5 mb-2">{{ $course->name }}</h2>
                            <p class="small flex-grow-1" style="color: var(--color-muted);">{{ $course->description }}</p>

                            <ul class="list-unstyled small mb-3">
                                @if ($course->trainer)
                                    <li class="mb-1">Formador: <a href="{{ route('speakers.show', $course->trainer) }}">{{ $course->trainer->name }}</a></li>
                                @endif
                                @if ($course->date)
                                    <li class="mb-1">{{ $course->date->translatedFormat('d \d\e F') }}, {{ \Illuminate\Support\Str::of($course->start_time)->substr(0, 5) }}&ndash;{{ \Illuminate\Support\Str::of($course->end_time)->substr(0, 5) }}</li>
                                @else
                                    <li class="mb-1" style="color: var(--color-muted);">Horário a confirmar</li>
                                @endif
                                @if ($course->room)
                                    <li class="mb-1">{{ $course->room }}</li>
                                @endif
                            </ul>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="status-badge status-badge--positive">
                                    {{ $course->availableSpots() }} vagas
                                </span>
                                <span class="small text-capitalize" style="color: var(--color-muted);">{{ $course->modality }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
