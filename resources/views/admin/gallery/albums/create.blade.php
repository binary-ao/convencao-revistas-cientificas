@extends('layouts.admin')

@section('title', 'Novo álbum')

@section('content')

    <h2 class="h5 mb-4">Novo álbum</h2>

    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.gallery-albums.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label small">Título *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label small">Descrição</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label small">Imagem de capa</label>
                <input type="file" name="cover_image" accept="image/*" class="form-control">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_published" id="is_published" class="form-check-input" value="1" checked>
                <label for="is_published" class="form-check-label small">Publicado no website</label>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.gallery-albums.index') }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
    </div>

@endsection
