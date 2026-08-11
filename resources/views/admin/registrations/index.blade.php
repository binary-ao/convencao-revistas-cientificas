@extends('layouts.admin')

@section('title', 'Inscrições')

@php
    $statusVariant = ['pending' => 'status-badge--info', 'confirmed' => 'status-badge--positive', 'cancelled' => 'status-badge--negative', 'draft' => ''];
@endphp

@section('content')

    <h2 class="h5 mb-4">Inscrições</h2>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-sm-2">
            <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome" value="{{ request('name') }}">
        </div>
        <div class="col-sm-2">
            <input type="text" name="email" class="form-control form-control-sm" placeholder="Email" value="{{ request('email') }}">
        </div>
        <div class="col-sm-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">Todos os estados</option>
                @foreach (['pending' => 'Pendente', 'confirmed' => 'Confirmada', 'cancelled' => 'Cancelada'] as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2">
            <select name="modality" class="form-select form-select-sm">
                <option value="">Todas as modalidades</option>
                <option value="presencial" @selected(request('modality') === 'presencial')>Presencial</option>
                <option value="online" @selected(request('modality') === 'online')>Online</option>
            </select>
        </div>
        <div class="col-sm-2">
            <select name="workshop_id" class="form-select form-select-sm">
                <option value="">Todos os workshops</option>
                @foreach ($workshops as $workshop)
                    <option value="{{ $workshop->id }}" @selected(request('workshop_id') == $workshop->id)>{{ $workshop->code }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-outline-dark btn-sm">Filtrar</button>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-link btn-sm">Limpar</a>
        </div>
    </form>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Instituição</th>
                    <th>Modalidade</th>
                    <th>Estado</th>
                    <th>Data</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registrations as $registration)
                    <tr>
                        <td class="font-monospace small">{{ $registration->code }}</td>
                        <td>{{ $registration->participant->full_name }}</td>
                        <td class="small" style="color: var(--color-muted);">
                            {{ $registration->participant->institution?->acronym ?? '—' }}
                        </td>
                        <td class="small text-capitalize">{{ $registration->modality }}</td>
                        <td><span class="status-badge {{ $statusVariant[$registration->status] ?? '' }}">{{ ucfirst($registration->status) }}</span></td>
                        <td class="small">{{ $registration->submitted_at?->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.registrations.show', $registration) }}" class="btn btn-sm btn-outline-dark">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4" style="color: var(--color-muted);">Nenhuma inscrição encontrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $registrations->links() }}</div>

@endsection
