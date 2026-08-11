@csrf
@if (isset($session))
    @method('PUT')
@endif

@php
    $typeLabels = [
        'opening' => 'Abertura', 'keynote' => 'Palestra Magna', 'panel' => 'Painel Temático',
        'roundtable' => 'Mesa Redonda', 'workshop' => 'Oficina', 'course' => 'Curso',
        'forum' => 'Fórum', 'break' => 'Pausa', 'lunch' => 'Almoço', 'debate' => 'Debate',
        'plenary' => 'Plenária', 'closing' => 'Encerramento', 'other' => 'Outro',
    ];
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Dia *</label>
                <select name="event_day_id" class="form-select" required>
                    @foreach ($days as $d)
                        <option value="{{ $d->id }}" @selected(old('event_day_id', $session->event_day_id ?? null) == $d->id)>
                            Dia {{ $d->day_number }} @if ($d->title) — {{ $d->title }} @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 mb-3">
                <label class="form-label small">Tipo *</label>
                <select name="type" class="form-select" required>
                    @foreach ($typeLabels as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $session->type ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small">Título *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $session->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label small">Descrição</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $session->description ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-sm-3 mb-3">
                <label class="form-label small">Hora inicial *</label>
                <input type="time" name="start_time" class="form-control"
                    value="{{ old('start_time', isset($session) ? \Illuminate\Support\Str::substr($session->start_time, 0, 5) : '') }}" required>
            </div>
            <div class="col-sm-3 mb-3">
                <label class="form-label small">Hora final</label>
                <input type="time" name="end_time" class="form-control"
                    value="{{ old('end_time', isset($session) && $session->end_time ? \Illuminate\Support\Str::substr($session->end_time, 0, 5) : '') }}">
            </div>
            <div class="col-sm-3 mb-3">
                <label class="form-label small">Sala</label>
                <input type="text" name="room_location" class="form-control" value="{{ old('room_location', $session->room_location ?? '') }}">
            </div>
            <div class="col-sm-3 mb-3">
                <label class="form-label small">Modalidade *</label>
                <select name="modality" class="form-select" required>
                    <option value="presencial" @selected(old('modality', $session->modality ?? 'presencial') === 'presencial')>Presencial</option>
                    <option value="online" @selected(old('modality', $session->modality ?? '') === 'online')>Online</option>
                    <option value="hibrido" @selected(old('modality', $session->modality ?? '') === 'hibrido')>Híbrido</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Workshop associado</label>
                <select name="workshop_id" class="form-select">
                    <option value="">—</option>
                    @foreach ($workshops as $workshop)
                        <option value="{{ $workshop->id }}" @selected(old('workshop_id', $session->workshop_id ?? null) == $workshop->id)>
                            {{ $workshop->code }} — {{ $workshop->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Curso associado</label>
                <select name="course_id" class="form-select">
                    <option value="">—</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id', $session->course_id ?? null) == $course->id)>
                            {{ $course->code }} — {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Moderador</label>
                <select name="moderator_speaker_id" class="form-select">
                    <option value="">—</option>
                    @foreach ($speakers as $speaker)
                        <option value="{{ $speaker->id }}" @selected(old('moderator_speaker_id', $session->moderator_speaker_id ?? null) == $speaker->id)>
                            {{ $speaker->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small">Ordem</label>
            <input type="number" name="sort_order" min="0" class="form-control" style="max-width: 150px;"
                value="{{ old('sort_order', $session->sort_order ?? 0) }}">
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.program-days.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
