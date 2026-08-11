@extends('layouts.public')

@section('title', $album->title)

@section('content')

    <section class="py-5">
        <div class="container py-4">
            <a href="{{ route('gallery.index') }}" class="small d-inline-block mb-4">&larr; Toda a galeria</a>

            <div class="eyebrow">Álbum</div>
            <h1 class="mb-2">{{ $album->title }}</h1>
            @if ($album->description)
                <p class="mb-4" style="color: var(--color-muted);">{{ $album->description }}</p>
            @endif

            @if ($album->items->isEmpty())
                <p style="color: var(--color-muted);">Ainda não há fotografias ou vídeos neste álbum.</p>
            @else
                <div class="row g-3">
                    @foreach ($album->items as $item)
                        <div class="col-6 col-md-4 col-lg-3">
                            @if ($item->type === 'photo' && $item->fileUrl())
                                <img src="{{ $item->fileUrl() }}" alt="{{ $item->caption }}" class="w-100" style="aspect-ratio: 4/3; object-fit: cover;" loading="lazy">
                            @elseif ($item->type === 'video' && $item->video_url)
                                <a href="{{ $item->video_url }}" target="_blank" rel="noopener"
                                    class="d-flex align-items-center justify-content-center text-decoration-none"
                                    style="aspect-ratio: 4/3; background: var(--color-surface); border: 1px solid var(--color-border);">
                                    <span class="small">Ver vídeo &rarr;</span>
                                </a>
                            @endif
                            @if ($item->caption)
                                <p class="small mt-1 mb-0" style="color: var(--color-muted);">{{ $item->caption }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

@endsection
