@php
    $navItems = [
        ['label' => 'Início', 'route' => 'home'],
        ['label' => 'Sobre', 'route' => 'about'],
        ['label' => 'Programa', 'route' => 'program'],
        ['label' => 'Oradores', 'route' => 'speakers.index'],
        ['label' => 'Workshops', 'route' => 'workshops.index'],
        ['label' => 'Parceiros', 'route' => 'partners.index'],
        ['label' => 'Notícias', 'route' => 'news.index'],
        ['label' => 'FAQ', 'route' => 'faq'],
    ];
@endphp

<header class="site-header is-sticky">
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if ($event?->logoUrl())
                    <img src="{{ $event->logoUrl() }}" alt="{{ $event->name }}" style="max-height: 40px; width: auto;">
                @else
                    CNRCA
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    @foreach ($navItems as $item)
                        <li class="nav-item">
                            <a class="nav-link @if ($item['route'] && request()->routeIs($item['route'])) fw-semibold @endif"
                                href="{{ $item['route'] ? route($item['route']) : '#' }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-primary" href="{{ route('registration.create') }}">Inscrever-me</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
