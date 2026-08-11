@extends('layouts.public')

@section('title', 'Oradores')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Oradores</div>
            <h1 class="display-6 mb-0">Palestrantes, moderadores e formadores</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row g-4">
                @foreach ($speakers as $speaker)
                    <div class="col-sm-6 col-lg-3">
                        <a href="{{ route('speakers.show', $speaker) }}" class="text-decoration-none text-reset d-block">
                            @if ($speaker->photoUrl())
                            <img src="{{ $speaker->photoUrl() }}" alt="{{ $speaker->name }}"
                                class="w-100 mb-3" style="aspect-ratio: 1/1; object-fit: cover;" loading="lazy">
                        @else
                            <x-avatar-initials :name="$speaker->name" class="mb-3" />
                        @endif
                            <h2 class="h6 mb-1">{{ $speaker->name }}</h2>
                            <p class="small mb-0" style="color: var(--color-muted);">
                                {{ $speaker->job_title }}
                                @if ($speaker->institution)
                                    <br>{{ $speaker->institution->acronym ?? $speaker->institution->name }}
                                @endif
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
