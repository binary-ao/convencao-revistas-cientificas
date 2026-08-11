<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        // Nem todos os controllers passam $event (ex.: notícias, documentos,
        // galeria, políticas) — garantir que a variável existe evita
        // "Undefined variable" nos usos com ?-> mais abaixo.
        $event ??= null;
        $pageTitle = trim($__env->yieldContent('title')) ?: ($event->name ?? config('app.name'));
        $pageDescription = trim($__env->yieldContent('meta_description')) ?: ($event->short_description ?? '');
        $canonicalUrl = trim($__env->yieldContent('canonical')) ?: url()->current();
        $ogImage = trim($__env->yieldContent('og_image')) ?: $event?->coverImageUrl();
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $event->name ?? config('app.name') }}">
    <meta property="og:locale" content="pt_AO">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif

    <meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    @if ($ogImage)
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif

    @if ($event?->faviconUrl())
        <link rel="icon" href="{{ $event->faviconUrl() }}">
    @endif

    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="d-flex flex-column min-vh-100">
    @include('partials.public.header')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('partials.public.footer')

    @stack('scripts')
</body>
</html>
