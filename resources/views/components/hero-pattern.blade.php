{{-- Textura editorial discreta para o Hero — grelha fina + marcadores de dados,
     em vez de fotografia de stock (secção 18 da arquitectura). --}}
<svg class="hero-pattern" viewBox="0 0 960 480" preserveAspectRatio="xMidYMid slice" role="presentation"
    aria-hidden="true" {{ $attributes }}>
    <defs>
        <pattern id="hero-grid" width="48" height="48" patternUnits="userSpaceOnUse">
            <path d="M 48 0 L 0 0 0 48" fill="none" stroke="currentColor" stroke-width="0.5" opacity="0.35" />
        </pattern>
    </defs>

    <rect width="960" height="480" fill="url(#hero-grid)" />

    <line x1="0" y1="96" x2="960" y2="96" stroke="currentColor" stroke-width="1" opacity="0.5" />
    <line x1="720" y1="0" x2="720" y2="480" stroke="currentColor" stroke-width="1" opacity="0.35" />

    <circle cx="720" cy="96" r="4" fill="currentColor" opacity="0.9" />
    <circle cx="864" cy="192" r="3" fill="currentColor" opacity="0.6" />
    <circle cx="624" cy="288" r="3" fill="currentColor" opacity="0.5" />
    <circle cx="912" cy="336" r="2.5" fill="currentColor" opacity="0.4" />

    <polyline points="720,96 864,192 624,288 912,336" fill="none" stroke="currentColor" stroke-width="1"
        opacity="0.3" />
</svg>
