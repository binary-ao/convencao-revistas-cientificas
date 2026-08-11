@extends('layouts.public')

@section('title', $speaker->name)
@section('meta_description', $speaker->bio ? \Illuminate\Support\Str::limit($speaker->bio, 160) : ($speaker->job_title ?? ''))
@if ($speaker->photoUrl())
    @section('og_image', $speaker->photoUrl())
@endif

@section('content')

    <section class="py-5">
        <div class="container py-4">
            <a href="{{ route('speakers.index') }}" class="small d-inline-block mb-4">&larr; Todos os oradores</a>

            <div class="row g-5">
                <div class="col-md-4 col-lg-3">
                    @if ($speaker->photoUrl())
                        <img src="{{ $speaker->photoUrl() }}" alt="{{ $speaker->name }}"
                            class="w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                    @else
                        <x-avatar-initials :name="$speaker->name" />
                    @endif
                </div>
                <div class="col-md-8 col-lg-9">
                    <h1 class="mb-1">{{ $speaker->name }}</h1>
                    <p class="fs-5 mb-1" style="color: var(--color-muted);">{{ $speaker->job_title }}</p>
                    <p class="small mb-4" style="color: var(--color-muted);">
                        @if ($speaker->institution)
                            {{ $speaker->institution->name }} &bull;
                        @endif
                        {{ $speaker->country }}
                    </p>

                    @if ($speaker->bio)
                        <p class="mb-4">{{ $speaker->bio }}</p>
                    @endif

                    @if ($speaker->sessions->isNotEmpty())
                        <div class="hr-thin"></div>
                        <div class="eyebrow">Sessões associadas</div>
                        <ul class="list-unstyled">
                            @foreach ($speaker->sessions as $session)
                                <li class="py-2 border-bottom" style="border-color: var(--color-border);">
                                    <a href="{{ route('program') }}" class="fw-semibold text-reset text-decoration-none">
                                        {{ $session->title }}
                                    </a>
                                    <div class="small" style="color: var(--color-muted);">
                                        Dia {{ $session->eventDay->day_number }}
                                        &bull; {{ \Illuminate\Support\Str::of($session->start_time)->substr(0, 5) }}
                                        &bull; {{ ucfirst($session->pivot->role_in_session) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
