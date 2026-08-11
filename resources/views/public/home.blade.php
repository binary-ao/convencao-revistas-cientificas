@extends('layouts.public')

@section('title', ($event->name ?? config('app.name')).' — Website Oficial')
@section('meta_description', $event->short_description ?? '')

@php
    $themes = [
        ['title' => 'Panorama das Revistas Científicas em Angola', 'description' => 'Estado atual, avanços, desafios e perspetivas futuras.'],
        ['title' => 'Qualidade Editorial e Boas Práticas Internacionais', 'description' => 'Fluxo editorial, avaliação por pares e padronização.'],
        ['title' => 'Indexação, Visibilidade e Impacto Científico', 'description' => 'Estratégias para bases nacionais, regionais e internacionais.'],
        ['title' => 'Ética, Integridade e Combate ao Plágio', 'description' => 'Normas, responsabilidades editoriais e casos práticos.'],
        ['title' => 'Ciência Aberta, Acesso Aberto e Repositórios Institucionais', 'description' => 'Políticas, desafios e oportunidades para Angola.'],
    ];
@endphp

@section('content')

    @php
        $hasCustomSlides = $heroSlides->isNotEmpty();
        $slides = $hasCustomSlides ? $heroSlides : collect([null]);
    @endphp

    <div id="heroCarousel" class="carousel slide hero-carousel border-bottom" data-bs-ride="carousel"
        style="border-color: var(--color-border);">

        @if ($slides->count() > 1)
            <div class="carousel-indicators">
                @foreach ($slides as $index => $slide)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                        @class(['active' => $index === 0]) aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                @endforeach
            </div>
        @endif

        <div class="carousel-inner">
            @foreach ($slides as $index => $slide)
                <div class="carousel-item @if ($index === 0) active @endif">
                    <section class="hero py-5 py-lg-6 @if ($slide?->imageUrl()) hero--image @endif"
                        @if ($slide?->imageUrl()) style="background-image: url('{{ $slide->imageUrl() }}');" @endif>

                        @unless ($slide?->imageUrl())
                            <x-hero-pattern />
                        @endunless

                        <div class="container py-4 hero-content">
                            <div class="row">
                                <div class="col-lg-9">
                                    @if ($slide)
                                        @if ($slide->eyebrow)
                                            <div class="eyebrow">{{ $slide->eyebrow }}</div>
                                        @endif
                                        <h1 class="display-5 mb-3">{{ $slide->title }}</h1>
                                        @if ($slide->subtitle)
                                            <p class="fs-5 mb-4">{{ $slide->subtitle }}</p>
                                        @endif
                                        <div class="d-flex gap-3">
                                            <a href="{{ route('registration.create') }}" class="btn btn-primary px-4 py-2">Inscrever-me</a>
                                            @if ($slide->cta_label)
                                                <a href="{{ $slide->cta_url ?? '#' }}" class="btn btn-outline-dark px-4 py-2 @if ($slide->imageUrl()) border-white text-white @endif">{{ $slide->cta_label }}</a>
                                            @endif
                                        </div>
                                    @else
                                        <div class="eyebrow">1ª Convenção Nacional</div>
                                        <h1 class="display-5 mb-3">de Revistas Científicas Angolanas</h1>
                                        <p class="fs-5 mb-4" style="color: var(--color-muted);">
                                            Qualidade &bull; Ética &bull; Visibilidade &bull; Internacionalização
                                        </p>

                                        <div class="row g-3 mb-4">
                                            <div class="col-sm-4">
                                                <div class="small footer-heading mb-1">Data</div>
                                                <div>{{ $event?->start_date?->translatedFormat('d \d\e F \d\e Y') ?? 'A definir' }}</div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="small footer-heading mb-1">Local</div>
                                                <div>{{ $event?->venue_name ?? 'A definir' }}{{ $event?->city ? ', '.$event->city : '' }}</div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="small footer-heading mb-1">Formato</div>
                                                <div class="text-capitalize">{{ $event?->format ?? 'A definir' }}</div>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-3">
                                            <a href="{{ route('registration.create') }}" class="btn btn-primary px-4 py-2">Inscrever-me</a>
                                            <a href="{{ route('program') }}" class="btn btn-outline-dark px-4 py-2">Ver Programa</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endforeach
        </div>

        @if ($slides->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        @endif
    </div>

    <section class="py-4" style="background: var(--color-surface); border-bottom: 1px solid var(--color-border);">
        <div class="container py-3">
            <div class="row align-items-center g-4">
                <div class="col-lg-5">
                    <div class="eyebrow">Quando</div>
                    <h2 class="h4 mb-1">
                        @if ($event?->start_date)
                            {{ $event->start_date->translatedFormat('d') }}
                            @if ($event->end_date && ! $event->end_date->equalTo($event->start_date))
                                a {{ $event->end_date->translatedFormat('d \d\e F \d\e Y') }}
                            @else
                                de {{ $event->start_date->translatedFormat('F \d\e Y') }}
                            @endif
                        @else
                            Data a definir
                        @endif
                    </h2>
                    <p class="small mb-0" style="color: var(--color-muted);">
                        {{ $event?->venue_name ?? 'Local a definir' }}{{ $event?->city ? ', '.$event->city : '' }}
                    </p>
                </div>
                <div class="col-lg-7">
                    @if ($event?->start_date)
                        <div class="countdown" id="eventCountdown" data-target="{{ $event->start_date->format('Y-m-d') }}T00:00:00">
                            <div class="countdown__unit">
                                <div class="countdown__value" data-unit="days">&mdash;</div>
                                <div class="countdown__label">Dias</div>
                            </div>
                            <div class="countdown__unit">
                                <div class="countdown__value" data-unit="hours">&mdash;</div>
                                <div class="countdown__label">Horas</div>
                            </div>
                            <div class="countdown__unit">
                                <div class="countdown__value" data-unit="minutes">&mdash;</div>
                                <div class="countdown__label">Minutos</div>
                            </div>
                            <div class="countdown__unit">
                                <div class="countdown__value" data-unit="seconds">&mdash;</div>
                                <div class="countdown__label">Segundos</div>
                            </div>
                        </div>
                    @else
                        <p class="mb-0" style="color: var(--color-muted);">
                            A contagem decrescente será activada assim que a data for confirmada.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 py-lg-6">
        <div class="container py-4">
            <div class="row align-items-end">
                <div class="col-lg-7">
                    <div class="eyebrow">Enquadramento</div>
                    <h2 class="mb-3">Um espaço estratégico para a edição científica angolana</h2>
                    <p style="color: var(--color-muted);">
                        {{ \Illuminate\Support\Str::limit($event->long_description, 340) }}
                    </p>
                    <a href="{{ route('about') }}" class="fw-semibold">Saber mais sobre a Convenção &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 py-lg-6" style="background: var(--color-surface);">
        <div class="container py-4">
            <div class="row mb-4">
                <div class="col-lg-7">
                    <div class="eyebrow">Painéis Temáticos</div>
                    <h2>Temas da Convenção</h2>
                </div>
            </div>

            <div class="row g-0 border-top" style="border-color: var(--color-border);">
                @foreach ($themes as $index => $theme)
                    <div class="col-lg-12">
                        <div class="row align-items-baseline py-4 border-bottom" style="border-color: var(--color-border);">
                            <div class="col-lg-1">
                                <span class="fs-3 fw-semibold" style="color: var(--color-secondary);">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <h3 class="h5 mb-0">{{ $theme['title'] }}</h3>
                            </div>
                            <div class="col-lg-5">
                                <p class="mb-0" style="color: var(--color-muted);">{{ $theme['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 py-lg-6">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="numbered-block h-100">
                        <div class="eyebrow">Programa</div>
                        <h3 class="h5 mb-2">3 dias de sessões</h3>
                        <p class="small mb-3" style="color: var(--color-muted);">Painéis, palestras magnas, oficinas práticas e o Fórum Nacional de Editores Científicos.</p>
                        <a href="{{ route('program') }}" class="small fw-semibold">Ver programa completo &rarr;</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="numbered-block h-100">
                        <div class="eyebrow">Oradores</div>
                        <h3 class="h5 mb-2">Editores e investigadores</h3>
                        <p class="small mb-3" style="color: var(--color-muted);">Palestrantes, moderadores e formadores nacionais e convidados.</p>
                        <a href="{{ route('speakers.index') }}" class="small fw-semibold">Conhecer os oradores &rarr;</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="numbered-block h-100">
                        <div class="eyebrow">Formação</div>
                        <h3 class="h5 mb-2">Workshops e cursos</h3>
                        <p class="small mb-3" style="color: var(--color-muted);">Oficinas práticas e cursos de curta duração, com vagas limitadas.</p>
                        <a href="{{ route('workshops.index') }}" class="small fw-semibold">Ver workshops &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
(function () {
    const el = document.getElementById('eventCountdown');
    if (!el) return;

    const target = new Date(el.dataset.target).getTime();
    const daysEl = el.querySelector('[data-unit="days"]');
    const hoursEl = el.querySelector('[data-unit="hours"]');
    const minutesEl = el.querySelector('[data-unit="minutes"]');
    const secondsEl = el.querySelector('[data-unit="seconds"]');

    let timer;

    function pad(n) {
        return String(n).padStart(2, '0');
    }

    function tick() {
        const diff = target - Date.now();

        if (diff <= 0) {
            el.innerHTML = '<p class="mb-0 fw-semibold">A Convenção já está a decorrer ou terminou.</p>';
            clearInterval(timer);
            return;
        }

        daysEl.textContent = Math.floor(diff / 86400000);
        hoursEl.textContent = pad(Math.floor((diff % 86400000) / 3600000));
        minutesEl.textContent = pad(Math.floor((diff % 3600000) / 60000));
        secondsEl.textContent = pad(Math.floor((diff % 60000) / 1000));
    }

    tick();
    timer = setInterval(tick, 1000);
})();
</script>
@endpush

@if ($event?->start_date)
    @push('head')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Event",
            "name": {!! json_encode($event->name) !!},
            "description": {!! json_encode($event->short_description ?? '') !!},
            "startDate": {!! json_encode($event->start_date->format('Y-m-d')) !!},
            @if ($event->end_date)
            "endDate": {!! json_encode($event->end_date->format('Y-m-d')) !!},
            @endif
            "eventAttendanceMode": "https://schema.org/{{ $event->format === 'online' ? 'OnlineEventAttendanceMode' : ($event->format === 'hibrido' ? 'MixedEventAttendanceMode' : 'OfflineEventAttendanceMode') }}",
            "eventStatus": "https://schema.org/EventScheduled",
            "location": {
                "@@type": "Place",
                "name": {!! json_encode($event->venue_name ?? 'A definir') !!},
                "address": {!! json_encode(trim(($event->address ?? '').' '.($event->city ?? '').' '.($event->country ?? ''))) !!}
            }
        }
    </script>
    @endpush
@endif
