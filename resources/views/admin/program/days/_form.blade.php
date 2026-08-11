@csrf
@if (isset($day))
    @method('PUT')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="form-label small">Número do dia *</label>
                <input type="number" name="day_number" min="1" class="form-control" value="{{ old('day_number', $day->day_number ?? 1) }}" required>
            </div>
            <div class="col-sm-8 mb-3">
                <label class="form-label small">Data</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', optional($day->date ?? null)->format('Y-m-d')) }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label small">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $day->title ?? '') }}"
                placeholder="Ex.: Contexto, Visão e Desafios da Edição Científica em Angola">
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.program-days.index') }}" class="btn btn-outline-dark">Cancelar</a>
</div>
