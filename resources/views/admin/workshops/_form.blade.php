@php($workshop ??= null)

@csrf
@if ($workshop)
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Código</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $workshop?->code) }}" placeholder="Oficina D">
            </div>
            <div class="col-sm-8 mb-3">
                <label class="form-label small">Nome *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $workshop?->name) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small">Descrição</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $workshop?->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label small">Formador</label>
            <select name="trainer_speaker_id" class="form-select">
                <option value="">—</option>
                @foreach ($speakers as $speaker)
                    <option value="{{ $speaker->id }}" @selected(old('trainer_speaker_id', $workshop?->trainer_speaker_id) == $speaker->id)>
                        {{ $speaker->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Data</label>
                <input type="date" name="date" class="form-control"
                    value="{{ old('date', $workshop?->date?->format('Y-m-d')) }}">
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Hora inicial</label>
                <input type="time" name="start_time" class="form-control"
                    value="{{ old('start_time', $workshop?->start_time ? \Illuminate\Support\Str::substr($workshop->start_time, 0, 5) : '') }}">
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Hora final</label>
                <input type="time" name="end_time" class="form-control"
                    value="{{ old('end_time', $workshop?->end_time ? \Illuminate\Support\Str::substr($workshop->end_time, 0, 5) : '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Sala</label>
                <input type="text" name="room" class="form-control" value="{{ old('room', $workshop?->room) }}">
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Modalidade *</label>
                <select name="modality" class="form-select" required>
                    <option value="presencial" @selected(old('modality', $workshop?->modality ?? 'presencial') === 'presencial')>Presencial</option>
                    <option value="online" @selected(old('modality', $workshop?->modality) === 'online')>Online</option>
                </select>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Capacidade *</label>
                <input type="number" name="capacity" min="0" class="form-control" value="{{ old('capacity', $workshop?->capacity ?? 0) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Ordem</label>
                <input type="number" name="sort_order" min="0" class="form-control" value="{{ old('sort_order', $workshop?->sort_order ?? 0) }}">
            </div>
            <div class="col-sm-4 mb-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                        @checked(old('is_active', $workshop?->is_active ?? true))>
                    <label for="is_active" class="form-check-label small">Activo</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.workshops.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
