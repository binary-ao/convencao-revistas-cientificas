@csrf
@if (isset($slide))
    @method('PUT')
@endif

<div class="row g-4">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label small">Eyebrow (rótulo curto acima do título)</label>
            <input type="text" name="eyebrow" class="form-control" value="{{ old('eyebrow', $slide->eyebrow ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label small">Título *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $slide->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label small">Subtítulo</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slide->subtitle ?? '') }}">
        </div>

        <div class="row">
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Texto do botão</label>
                <input type="text" name="cta_label" class="form-control" value="{{ old('cta_label', $slide->cta_label ?? '') }}">
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Link do botão</label>
                <input type="text" name="cta_url" class="form-control" value="{{ old('cta_url', $slide->cta_url ?? '') }}" placeholder="/programa">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Ordem</label>
                <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $slide->sort_order ?? 0) }}">
            </div>
            <div class="col-sm-6 mb-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                        @checked(old('is_active', $slide->is_active ?? true))>
                    <label for="is_active" class="form-check-label small">Activo no carrossel</label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label small">Imagem de fundo</label>

        @if (isset($slide) && $slide->imageUrl())
            <div class="mb-2">
                <img src="{{ $slide->imageUrl() }}" alt="" style="width:100%; aspect-ratio:16/9; object-fit:cover;">
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input" value="1">
                <label for="remove_image" class="form-check-label small">Remover imagem actual</label>
            </div>
        @endif

        <input type="file" name="image" accept="image/*" class="form-control">
        <div class="form-text">Sem imagem, o destaque usa o padrão gráfico institucional (linhas/grelha).</div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
