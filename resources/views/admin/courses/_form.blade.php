@php($course ??= null)

@csrf
@if ($course)
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Código</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $course?->code) }}" placeholder="Curso 5">
            </div>
            <div class="col-sm-8 mb-3">
                <label class="form-label small">Nome *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $course?->name) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small">Descrição</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $course?->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label small">Formador</label>
            <select name="trainer_speaker_id" class="form-select">
                <option value="">—</option>
                @foreach ($speakers as $speaker)
                    <option value="{{ $speaker->id }}" @selected(old('trainer_speaker_id', $course?->trainer_speaker_id) == $speaker->id)>
                        {{ $speaker->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Data</label>
                <input type="date" name="date" class="form-control"
                    value="{{ old('date', $course?->date?->format('Y-m-d')) }}">
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Hora inicial</label>
                <input type="time" name="start_time" class="form-control"
                    value="{{ old('start_time', $course?->start_time ? \Illuminate\Support\Str::substr($course->start_time, 0, 5) : '') }}">
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Hora final</label>
                <input type="time" name="end_time" class="form-control"
                    value="{{ old('end_time', $course?->end_time ? \Illuminate\Support\Str::substr($course->end_time, 0, 5) : '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Sala</label>
                <input type="text" name="room" class="form-control" value="{{ old('room', $course?->room) }}">
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Modalidade *</label>
                <select name="modality" class="form-select" required>
                    <option value="presencial" @selected(old('modality', $course?->modality ?? 'presencial') === 'presencial')>Presencial</option>
                    <option value="online" @selected(old('modality', $course?->modality) === 'online')>Online</option>
                </select>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Capacidade *</label>
                <input type="number" name="capacity" min="0" class="form-control" value="{{ old('capacity', $course?->capacity ?? 0) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Ordem</label>
                <input type="number" name="sort_order" min="0" class="form-control" value="{{ old('sort_order', $course?->sort_order ?? 0) }}">
            </div>
            <div class="col-sm-4 mb-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                        @checked(old('is_active', $course?->is_active ?? true))>
                    <label for="is_active" class="form-check-label small">Activo</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
