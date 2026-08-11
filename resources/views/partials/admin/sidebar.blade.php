@php
    $modules = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard'],
        ['label' => 'Participantes', 'route' => 'admin.participants.index', 'match' => 'admin.participants.*'],
        ['label' => 'Inscrições', 'route' => 'admin.registrations.index', 'match' => 'admin.registrations.*'],
        ['label' => 'Programa', 'route' => 'admin.program-days.index', 'match' => 'admin.program-days.*|admin.program-sessions.*'],
        ['label' => 'Instituições', 'route' => 'admin.institutions.index', 'match' => 'admin.institutions.*'],
        ['label' => 'Oradores', 'route' => 'admin.speakers.index', 'match' => 'admin.speakers.*'],
        ['label' => 'Destaques (Hero)', 'route' => 'admin.hero-slides.index', 'match' => 'admin.hero-slides.*'],
        ['label' => 'Workshops', 'route' => 'admin.workshops.index', 'match' => 'admin.workshops.*'],
        ['label' => 'Cursos', 'route' => 'admin.courses.index', 'match' => 'admin.courses.*'],
        ['label' => 'Check-in', 'route' => 'admin.checkin.index', 'match' => 'admin.checkin.*'],
        ['label' => 'Certificados', 'route' => 'admin.certificates.index', 'match' => 'admin.certificates.*'],
        ['label' => 'Notícias', 'route' => 'admin.news.index', 'match' => 'admin.news.*'],
        ['label' => 'Documentos', 'route' => 'admin.documents.index', 'match' => 'admin.documents.*'],
        ['label' => 'Galeria', 'route' => 'admin.gallery-albums.index', 'match' => 'admin.gallery-albums.*'],
        ['label' => 'Parceiros', 'route' => 'admin.partners.index', 'match' => 'admin.partners.*'],
        ['label' => 'Comunicação', 'route' => null],
        ['label' => 'Relatórios', 'route' => 'admin.reports.index', 'match' => 'admin.reports.*'],
        ['label' => 'Utilizadores', 'route' => null],
        ['label' => 'Configurações', 'route' => 'admin.event-settings.edit', 'match' => 'admin.event-settings.*'],
        ['label' => 'Logs', 'route' => 'admin.logs.index', 'match' => 'admin.logs.*'],
    ];
@endphp

<aside class="admin-sidebar d-flex flex-column">
    <div class="px-3 py-4 border-bottom" style="border-color: rgba(255,255,255,.12);">
        <span class="fw-semibold">CNRCA</span>
        <div class="small" style="color: rgba(255,255,255,.55);">Painel Administrativo</div>
    </div>

    <nav class="flex-grow-1 py-2" style="overflow-y: auto;">
        <ul class="list-unstyled mb-0">
            @foreach ($modules as $module)
                @php $isActive = $module['route'] && request()->routeIs(...explode('|', $module['match'] ?? $module['route'])); @endphp
                <li>
                    <a href="{{ $module['route'] ? route($module['route']) : '#' }}"
                       class="d-block px-3 py-2 small text-decoration-none {{ $isActive ? 'fw-semibold' : '' }}"
                       style="color: {{ $isActive ? '#fff' : 'rgba(255,255,255,.65)' }};">
                        {{ $module['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="px-3 py-3 border-top" style="border-color: rgba(255,255,255,.12);">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light w-100">Sair</button>
        </form>
    </div>
</aside>
