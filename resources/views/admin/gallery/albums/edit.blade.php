@extends('layouts.admin')

@section('title', 'Editar álbum')

@section('content')

    <h2 class="h5 mb-4">Editar álbum</h2>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                <div class="footer-heading">Dados do álbum</div>
                <form method="POST" action="{{ route('admin.gallery-albums.update', $album) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small">Título *</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $album->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Descrição</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $album->description) }}</textarea>
                    </div>

                    @if ($album->coverImageUrl())
                        <div class="mb-2">
                            <img src="{{ $album->coverImageUrl() }}" alt="" style="max-width: 100%; max-height: 120px;">
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label small">Imagem de capa</label>
                        <input type="file" name="cover_image" accept="image/*" class="form-control">
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_published" id="is_published" class="form-check-input" value="1"
                            @checked(old('is_published', $album->is_published))>
                        <label for="is_published" class="form-check-label small">Publicado no website</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.gallery-albums.index') }}" class="btn btn-outline-dark">Voltar</a>
                </form>
            </div>

            <div class="bg-white border p-4" style="border-color: var(--color-border);">
                <div class="footer-heading">Adicionar item</div>
                <form method="POST" action="{{ route('admin.gallery-items.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="gallery_album_id" value="{{ $album->id }}">

                    <div class="mb-3">
                        <label class="form-label small">Tipo *</label>
                        <select name="type" id="itemType" class="form-select" required>
                            <option value="photo">Fotografia</option>
                            <option value="video">Vídeo (link)</option>
                        </select>
                    </div>
                    <div class="mb-3" id="fileField">
                        <label class="form-label small">Ficheiro</label>
                        <input type="file" name="file" accept="image/*" class="form-control">
                    </div>
                    <div class="mb-3 d-none" id="videoField">
                        <label class="form-label small">Link do vídeo</label>
                        <input type="text" name="video_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Legenda</label>
                        <input type="text" name="caption" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Adicionar</button>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="bg-white border p-4" style="border-color: var(--color-border);">
                <div class="footer-heading">Itens ({{ $album->items->count() }})</div>
                <div class="row g-2">
                    @forelse ($album->items as $item)
                        <div class="col-6">
                            <div class="border" style="border-color: var(--color-border);">
                                @if ($item->type === 'photo' && $item->fileUrl())
                                    <img src="{{ $item->fileUrl() }}" alt="" class="w-100" style="aspect-ratio: 4/3; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center small"
                                        style="aspect-ratio: 4/3; background: var(--color-surface); color: var(--color-muted);">
                                        Vídeo
                                    </div>
                                @endif
                                <div class="p-2 d-flex align-items-center justify-content-between">
                                    <span class="small text-truncate">{{ $item->caption ?? '—' }}</span>
                                    <form action="{{ route('admin.gallery-items.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Remover este item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">&times;</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="small mb-0" style="color: var(--color-muted);">Nenhum item neste álbum.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.getElementById('itemType')?.addEventListener('change', function () {
        const isVideo = this.value === 'video';
        document.getElementById('videoField').classList.toggle('d-none', !isVideo);
        document.getElementById('fileField').classList.toggle('d-none', isVideo);
    });
</script>
@endpush
