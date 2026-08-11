<header class="d-flex align-items-center justify-content-between px-4 py-3 bg-white border-bottom"
    style="border-color: var(--color-border);">
    <h1 class="h5 mb-0">@yield('title', 'Dashboard')</h1>

    <div class="small text-end" style="color: var(--color-muted);">
        {{ auth()->user()->name }}
        <div class="text-uppercase" style="font-size: .7rem; letter-spacing: .05em;">
            {{ auth()->user()->getRoleNames()->first() ?? 'Sem perfil' }}
        </div>
    </div>
</header>
