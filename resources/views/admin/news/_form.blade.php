@php($news ??= null)

@csrf
@if ($news)
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label small">Título *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $news?->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small">Resumo</label>
            <input type="text" name="excerpt" class="form-control" value="{{ old('excerpt', $news?->excerpt) }}" maxlength="500">
        </div>
        <div class="mb-3">
            <label class="form-label small">Conteúdo *</label>
            <textarea name="content" rows="12" class="form-control" required>{{ old('content', $news?->content) }}</textarea>
            <div class="form-text">Texto simples ou HTML básico.</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label small">Estado *</label>
            <select name="status" class="form-select" required>
                <option value="rascunho" @selected(old('status', $news?->status ?? 'rascunho') === 'rascunho')>Rascunho</option>
                <option value="publicado" @selected(old('status', $news?->status) === 'publicado')>Publicado</option>
                <option value="agendado" @selected(old('status', $news?->status) === 'agendado')>Agendado</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label small">Data de publicação</label>
            <input type="datetime-local" name="published_at" class="form-control"
                value="{{ old('published_at', $news?->published_at?->format('Y-m-d\TH:i')) }}">
            <div class="form-text">Obrigatória se o estado for "Agendado".</div>
        </div>

        <label class="form-label small">Imagem de capa</label>
        @if ($news?->coverImageUrl())
            <div class="mb-2">
                <img src="{{ $news->coverImageUrl() }}" alt="" class="w-100" style="aspect-ratio: 16/9; object-fit: cover;">
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" name="remove_cover_image" id="remove_cover_image" class="form-check-input" value="1">
                <label for="remove_cover_image" class="form-check-label small">Remover imagem actual</label>
            </div>
        @endif
        <input type="file" name="cover_image" accept="image/*" class="form-control">
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
