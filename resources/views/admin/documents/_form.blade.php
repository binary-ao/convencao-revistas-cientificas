@php($document ??= null)

@csrf
@if ($document)
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label small">Título *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $document?->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small">Descrição</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $document?->description) }}</textarea>
        </div>

        <div class="row">
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Categoria *</label>
                <select name="category" class="form-select" required>
                    @foreach ($categoryLabels as $value => $label)
                        <option value="{{ $value }}" @selected(old('category', $document?->category) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Estado *</label>
                <select name="status" class="form-select" required>
                    <option value="draft" @selected(old('status', $document?->status ?? 'draft') === 'draft')>Rascunho</option>
                    <option value="published" @selected(old('status', $document?->status) === 'published')>Publicado</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small">Ordem</label>
            <input type="number" name="sort_order" min="0" class="form-control" style="max-width: 150px;" value="{{ old('sort_order', $document?->sort_order ?? 0) }}">
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label small">Ficheiro {{ $document ? '' : '*' }}</label>
        @if ($document?->file_path)
            <div class="mb-2 small">
                Actual: <a href="{{ $document->fileUrl() }}" target="_blank">{{ $document->original_filename }}</a>
            </div>
        @endif
        <input type="file" name="file" class="form-control" {{ $document ? '' : 'required' }}>
        <div class="form-text">PDF, Word, Excel ou PowerPoint, até 10MB.</div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
