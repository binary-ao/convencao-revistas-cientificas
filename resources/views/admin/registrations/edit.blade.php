@extends('layouts.admin')

@section('title', 'Editar inscrição')

@section('content')

    <h2 class="h5 mb-4">Editar inscrição <span class="font-monospace">{{ $registration->code }}</span></h2>

    <div class="bg-white border p-4" style="border-color: var(--color-border);">
        <form method="POST" action="{{ route('admin.registrations.update', $registration) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label small">Modalidade *</label>
                <select name="modality" class="form-select" required style="max-width: 250px;">
                    <option value="presencial" @selected($registration->modality === 'presencial')>Presencial</option>
                    <option value="online" @selected($registration->modality === 'online')>Online</option>
                </select>
            </div>

            @php $selectedWorkshops = $registration->workshops->pluck('id')->all(); @endphp
            <div class="mb-3">
                <div class="footer-heading">Workshops</div>
                @foreach ($workshops as $workshop)
                    <div class="form-check">
                        <input type="checkbox" name="workshop_ids[]" value="{{ $workshop->id }}"
                            id="w{{ $workshop->id }}" class="form-check-input" @checked(in_array($workshop->id, $selectedWorkshops))>
                        <label for="w{{ $workshop->id }}" class="form-check-label small">{{ $workshop->code }} — {{ $workshop->name }}</label>
                    </div>
                @endforeach
            </div>

            @php $selectedCourses = $registration->courses->pluck('id')->all(); @endphp
            <div class="mb-3">
                <div class="footer-heading">Cursos</div>
                @foreach ($courses as $course)
                    <div class="form-check">
                        <input type="checkbox" name="course_ids[]" value="{{ $course->id }}"
                            id="c{{ $course->id }}" class="form-check-input" @checked(in_array($course->id, $selectedCourses))>
                        <label for="c{{ $course->id }}" class="form-check-label small">{{ $course->code }} — {{ $course->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label class="form-label small">Notas administrativas</label>
                <textarea name="admin_notes" rows="3" class="form-control">{{ old('admin_notes', $registration->admin_notes) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.registrations.show', $registration) }}" class="btn btn-outline-dark">Cancelar</a>
        </form>
    </div>

@endsection
