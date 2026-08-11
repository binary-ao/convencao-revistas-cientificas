@csrf
@if (isset($speaker))
    @method('PUT')
@endif

<div class="row g-4">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label small">Nome completo *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $speaker->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label small">Cargo / Função</label>
            <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $speaker->job_title ?? '') }}">
        </div>

        <div class="row">
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Instituição</label>
                <select name="institution_id" class="form-select">
                    <option value="">—</option>
                    @foreach ($institutions as $institution)
                        <option value="{{ $institution->id }}" @selected(old('institution_id', $speaker->institution_id ?? null) == $institution->id)>
                            {{ $institution->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label small">País</label>
                <input type="text" name="country" class="form-control" value="{{ old('country', $speaker->country ?? '') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small">Biografia</label>
            <textarea name="bio" rows="5" class="form-control">{{ old('bio', $speaker->bio ?? '') }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_published" id="is_published" class="form-check-input" value="1"
                @checked(old('is_published', $speaker->is_published ?? true))>
            <label for="is_published" class="form-check-label small">Publicado no website</label>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label small">Fotografia de perfil</label>

        @if (isset($speaker) && $speaker->photoUrl())
            <div class="mb-2">
                <img src="{{ $speaker->photoUrl() }}" alt="" style="width:100%; aspect-ratio:1/1; object-fit:cover;">
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" name="remove_photo" id="remove_photo" class="form-check-input" value="1">
                <label for="remove_photo" class="form-check-label small">Remover fotografia actual</label>
            </div>
        @else
            <div class="mb-2">
                <x-avatar-initials :name="$speaker->name ?? 'Novo Orador'" />
            </div>
        @endif

        <input type="file" name="photo" accept="image/*" class="form-control">
        <div class="form-text">JPG ou PNG, até 2MB. Sem fotografia, mostra-se um monograma com as iniciais.</div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.speakers.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
