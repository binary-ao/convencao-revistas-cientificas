@php($partner ??= null)

@csrf
@if ($partner)
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label small">Nome *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $partner?->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small">Descrição</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $partner?->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label small">Website</label>
            <input type="text" name="website_url" class="form-control" value="{{ old('website_url', $partner?->website_url) }}">
        </div>

        <div class="row">
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Categoria *</label>
                <select name="category" class="form-select" required>
                    @foreach ($categoryLabels as $value => $label)
                        <option value="{{ $value }}" @selected(old('category', $partner?->category) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Estado *</label>
                <select name="status" class="form-select" required>
                    @foreach (['proposto' => 'Proposto', 'convidado' => 'Convidado', 'confirmado' => 'Confirmado', 'recusou' => 'Recusou'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $partner?->status ?? 'proposto') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="form-text">Reflecte a fase de contacto — não implica confirmação real de parceria.</div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small">Ordem</label>
            <input type="number" name="sort_order" min="0" class="form-control" style="max-width: 150px;" value="{{ old('sort_order', $partner?->sort_order ?? 0) }}">
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label small">Logótipo</label>
        @if ($partner?->logoUrl())
            <div class="mb-2">
                <img src="{{ $partner->logoUrl() }}" alt="" style="max-width: 100%; max-height: 120px;">
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" name="remove_logo" id="remove_logo" class="form-check-input" value="1">
                <label for="remove_logo" class="form-check-label small">Remover logótipo actual</label>
            </div>
        @endif
        <input type="file" name="logo" accept="image/*" class="form-control">
        <div class="form-text">Sem logótipo, o parceiro aparece apenas com o nome (bloco tipográfico).</div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
