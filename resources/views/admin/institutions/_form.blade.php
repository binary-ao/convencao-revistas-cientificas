@csrf
@if (isset($institution))
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label small">Nome *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $institution->name ?? '') }}" required>
        </div>
        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Sigla</label>
                <input type="text" name="acronym" class="form-control" value="{{ old('acronym', $institution->acronym ?? '') }}">
            </div>
            <div class="col-sm-8 mb-3">
                <label class="form-label small">Tipo *</label>
                <select name="type" class="form-select" required>
                    @foreach (['ies' => 'IES', 'centro_investigacao' => 'Centro de Investigação', 'orgao_governamental' => 'Órgão Governamental', 'rede_cientifica' => 'Rede Científica', 'revista_cientifica' => 'Revista Científica', 'outro' => 'Outro'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $institution->type ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Cidade</label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $institution->city ?? '') }}">
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label small">País</label>
                <input type="text" name="country" class="form-control" value="{{ old('country', $institution->country ?? 'Angola') }}">
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.institutions.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
