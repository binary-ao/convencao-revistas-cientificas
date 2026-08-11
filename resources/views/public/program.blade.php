@extends('layouts.public')

@section('title', 'Programa')

@php
    $typeLabels = [
        'opening' => 'Abertura', 'keynote' => 'Palestra Magna', 'panel' => 'Painel Temático',
        'roundtable' => 'Mesa Redonda', 'workshop' => 'Oficina', 'course' => 'Curso',
        'forum' => 'Fórum', 'break' => 'Pausa', 'lunch' => 'Almoço', 'debate' => 'Debate',
        'plenary' => 'Plenária', 'closing' => 'Encerramento', 'other' => 'Sessão',
    ];
@endphp

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Programa</div>
            <h1 class="display-6 mb-0">Programa da Convenção</h1>
            <p class="mt-2 mb-0" style="color: var(--color-muted);">
                Horários indicativos, sujeitos a confirmação pela organização.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">

            <ul class="nav nav-tabs mb-4" id="programTabs" role="tablist">
                @foreach ($days as $index => $day)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if ($index === 0) active @endif" id="dia{{ $day->day_number }}-tab"
                            data-bs-toggle="tab" data-bs-target="#dia{{ $day->day_number }}" type="button"
                            role="tab">
                            Dia {{ str_pad($day->day_number, 2, '0', STR_PAD_LEFT) }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="programTabsContent">
                @foreach ($days as $index => $day)
                    <div class="tab-pane fade @if ($index === 0) show active @endif"
                        id="dia{{ $day->day_number }}" role="tabpanel">

                        <h2 class="h4 mb-1">{{ $day->title }}</h2>
                        @if ($day->date)
                            <p class="small mb-4" style="color: var(--color-muted);">
                                {{ $day->date->translatedFormat('l, d \d\e F \d\e Y') }}
                            </p>
                        @endif

                        <div class="border-top" style="border-color: var(--color-border);">
                            @foreach ($day->sessions as $session)
                                <div class="row py-3 border-bottom" style="border-color: var(--color-border);">
                                    <div class="col-md-2">
                                        <span class="fw-semibold font-monospace">
                                            {{ \Illuminate\Support\Str::of($session->start_time)->substr(0, 5) }}
                                            @if ($session->end_time)
                                                &ndash; {{ \Illuminate\Support\Str::of($session->end_time)->substr(0, 5) }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="mb-1">
                                            <span class="status-badge status-badge--info">{{ $typeLabels[$session->type] ?? $session->type }}</span>
                                        </div>
                                        <h3 class="h6 mb-1">{{ $session->title }}</h3>
                                        @if ($session->description)
                                            <p class="small mb-1" style="color: var(--color-muted);">{{ $session->description }}</p>
                                        @endif

                                        @if ($session->speakers->isNotEmpty())
                                            <p class="small mb-0">
                                                Palestrante:
                                                @foreach ($session->speakers as $speaker)
                                                    <a href="{{ route('speakers.show', $speaker) }}">{{ $speaker->name }}</a>{{ $loop->last ? '' : ', ' }}
                                                @endforeach
                                            </p>
                                        @endif

                                        @if ($session->moderator)
                                            <p class="small mb-0">
                                                Moderação: <a href="{{ route('speakers.show', $session->moderator) }}">{{ $session->moderator->name }}</a>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-md-3 small" style="color: var(--color-muted);">
                                        @if ($session->room_location)
                                            <div>{{ $session->room_location }}</div>
                                        @endif
                                        <div class="text-capitalize">{{ $session->modality }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
