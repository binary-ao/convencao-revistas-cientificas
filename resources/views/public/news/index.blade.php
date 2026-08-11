@extends('layouts.public')

@section('title', 'Notícias')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Actualidade</div>
            <h1 class="display-6 mb-0">Notícias</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            @if ($newsItems->isEmpty())
                <p style="color: var(--color-muted);">Ainda não há notícias publicadas.</p>
            @else
                <div class="row g-4">
                    @foreach ($newsItems as $item)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('news.show', $item) }}" class="text-decoration-none text-reset d-block h-100">
                                @if ($item->coverImageUrl())
                                    <img src="{{ $item->coverImageUrl() }}" alt="" class="w-100 mb-3" style="aspect-ratio: 16/9; object-fit: cover;" loading="lazy">
                                @else
                                    <div class="w-100 mb-3 d-flex align-items-center justify-content-center"
                                        style="aspect-ratio: 16/9; background: var(--color-surface); border: 1px solid var(--color-border);">
                                        <span class="small" style="color: var(--color-muted);">CNRCA</span>
                                    </div>
                                @endif
                                <div class="small mb-1" style="color: var(--color-muted);">
                                    {{ $item->published_at?->translatedFormat('d \d\e F \d\e Y') }}
                                </div>
                                <h2 class="h6 mb-0">{{ $item->title }}</h2>
                                @if ($item->excerpt)
                                    <p class="small mt-1 mb-0" style="color: var(--color-muted);">{{ $item->excerpt }}</p>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5">{{ $newsItems->links() }}</div>
            @endif
        </div>
    </section>

@endsection
