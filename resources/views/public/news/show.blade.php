@extends('layouts.public')

@section('title', $news->title)
@section('meta_description', $news->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($news->content), 160))
@if ($news->coverImageUrl())
    @section('og_image', $news->coverImageUrl())
@endif

@section('content')

    <section class="py-5">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <a href="{{ route('news.index') }}" class="small d-inline-block mb-4">&larr; Todas as notícias</a>

                    <div class="eyebrow">{{ $news->published_at?->translatedFormat('d \d\e F \d\e Y') }}</div>
                    <h1 class="mb-4">{{ $news->title }}</h1>

                    @if ($news->coverImageUrl())
                        <img src="{{ $news->coverImageUrl() }}" alt="" class="w-100 mb-4" style="aspect-ratio: 16/9; object-fit: cover;">
                    @endif

                    <div class="fs-6" style="color: var(--color-text); line-height: 1.8;">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    @if ($related->isNotEmpty())
                        <div class="hr-thin"></div>
                        <div class="eyebrow">Ver também</div>
                        <ul class="list-unstyled">
                            @foreach ($related as $item)
                                <li class="py-2 border-bottom" style="border-color: var(--color-border);">
                                    <a href="{{ route('news.show', $item) }}">{{ $item->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@push('head')
<script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "NewsArticle",
        "headline": {!! json_encode($news->title) !!},
        "datePublished": {!! json_encode($news->published_at?->toIso8601String()) !!},
        "dateModified": {!! json_encode($news->updated_at->toIso8601String()) !!}
        @if ($news->coverImageUrl())
        , "image": [{!! json_encode($news->coverImageUrl()) !!}]
        @endif
    }
</script>
@endpush
