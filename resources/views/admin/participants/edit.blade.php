@extends('layouts.admin')

@section('title', 'Editar participante')

@section('content')

    <h2 class="h5 mb-4">Editar participante</h2>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bg-white border p-4" style="border-color: var(--color-border);">
                <form method="POST" action="{{ route('admin.participants.update', $participant) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small">Nome completo *</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $participant->full_name) }}" required>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $participant->email) }}" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Telefone *</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $participant->phone) }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Província</label>
                            <input type="text" name="province" class="form-control" value="{{ old('province', $participant->province) }}">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">País</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $participant->country) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Instituição</label>
                        <select name="institution_id" class="form-select">
                            <option value="">—</option>
                            @foreach ($institutions as $institution)
                                <option value="{{ $institution->id }}" @selected(old('institution_id', $participant->institution_id) == $institution->id)>
                                    {{ $institution->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Outra instituição</label>
                        <input type="text" name="institution_name_other" class="form-control" value="{{ old('institution_name_other', $participant->institution_name_other) }}">
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Cargo / Função</label>
                            <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $participant->job_title) }}">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Área científica</label>
                            <input type="text" name="scientific_area" class="form-control" value="{{ old('scientific_area', $participant->scientific_area) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Perfil *</label>
                        <select name="participant_type_id" class="form-select" required>
                            @foreach ($participantTypes as $type)
                                <option value="{{ $type->id }}" @selected(old('participant_type_id', $participant->participant_type_id) == $type->id)>
                                    {{ $type->label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Especificação de "Outro"</label>
                        <input type="text" name="participant_type_other" class="form-control" value="{{ old('participant_type_other', $participant->participant_type_other) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.participants.index') }}" class="btn btn-outline-dark">Cancelar</a>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white border p-4" style="border-color: var(--color-border);">
                <div class="footer-heading">Inscrições</div>
                @forelse ($participant->registrations as $registration)
                    <div class="py-2 border-bottom" style="border-color: var(--color-border);">
                        <a href="{{ route('admin.registrations.show', $registration) }}" class="fw-semibold font-monospace small">
                            {{ $registration->code }}
                        </a>
                        <div class="small" style="color: var(--color-muted);">
                            {{ $registration->event->name }} — {{ ucfirst($registration->status) }}
                        </div>
                    </div>
                @empty
                    <p class="small mb-0" style="color: var(--color-muted);">Sem inscrições.</p>
                @endforelse
            </div>
        </div>
    </div>

@endsection
