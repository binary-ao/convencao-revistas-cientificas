@extends('layouts.public')

@section('title', 'Galeria')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Registo Visual</div>
            <h1 class="display-6 mb-0">Galeria</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            @if ($albums->isEmpty())
                <p style="color: var(--color-muted);">Ainda não há álbuns publicados.</p>
            @else
                <div class="row g-4">
                    @foreach ($albums as $album)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('gallery.show', $album) }}" class="text-decoration-none text-reset d-block">
                                @if ($album->coverImageUrl())
                                    <img src="{{ $album->coverImageUrl() }}" alt="" class="w-100 mb-3" style="aspect-ratio: 4/3; object-fit: cover;" loading="lazy">
                                @else
                                    <div class="w-100 mb-3 d-flex align-items-center justify-content-center"
                                        style="aspect-ratio: 4/3; background: var(--color-surface); border: 1px solid var(--color-border);">
                                        <span class="small" style="color: var(--color-muted);">{{ $album->items_count }} itens</span>
                                    </div>
                                @endif
                                <h2 class="h6 mb-1">{{ $album->title }}</h2>
                                <p class="small mb-0" style="color: var(--color-muted);">{{ $album->items_count }} {{ \Illuminate\Support\Str::plural('item', $album->items_count) }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

@endsection
