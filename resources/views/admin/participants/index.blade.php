@extends('layouts.admin')

@section('title', 'Participantes')

@section('content')

    <h2 class="h5 mb-4">Participantes</h2>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-sm-3">
            <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome" value="{{ request('name') }}">
        </div>
        <div class="col-sm-3">
            <input type="text" name="email" class="form-control form-control-sm" placeholder="Email" value="{{ request('email') }}">
        </div>
        <div class="col-sm-3">
            <select name="participant_type_id" class="form-select form-select-sm">
                <option value="">Todos os perfis</option>
                @foreach ($participantTypes as $type)
                    <option value="{{ $type->id }}" @selected(request('participant_type_id') == $type->id)>{{ $type->label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-outline-dark btn-sm">Filtrar</button>
            <a href="{{ route('admin.participants.index') }}" class="btn btn-link btn-sm">Limpar</a>
        </div>
    </form>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Instituição</th>
                    <th>Perfil</th>
                    <th>Inscrições</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($participants as $participant)
                    <tr>
                        <td>{{ $participant->full_name }}</td>
                        <td class="small">{{ $participant->email }}</td>
                        <td class="small" style="color: var(--color-muted);">
                            {{ $participant->institution?->acronym ?? $participant->institution_name_other ?? '—' }}
                        </td>
                        <td class="small">{{ $participant->participantType?->label }}</td>
                        <td class="small">{{ $participant->registrations->count() }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.participants.edit', $participant) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4" style="color: var(--color-muted);">Nenhum participante encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $participants->links() }}</div>

@endsection
