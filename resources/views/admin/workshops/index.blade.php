@extends('layouts.admin')

@section('title', 'Workshops')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Workshops</h2>
        <a href="{{ route('admin.workshops.create') }}" class="btn btn-primary btn-sm">Novo workshop</a>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Formador</th>
                    <th>Vagas</th>
                    <th>Estado</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($workshops as $workshop)
                    <tr>
                        <td class="font-monospace small">{{ $workshop->code }}</td>
                        <td>{{ $workshop->name }}</td>
                        <td class="small" style="color: var(--color-muted);">{{ $workshop->trainer?->name ?? '—' }}</td>
                        <td class="small">{{ $workshop->registeredCount() }} / {{ $workshop->capacity }}</td>
                        <td>
                            <span class="status-badge {{ $workshop->is_active ? 'status-badge--positive' : '' }}">
                                {{ $workshop->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.workshops.edit', $workshop) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            <form action="{{ route('admin.workshops.destroy', $workshop) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover este workshop?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4" style="color: var(--color-muted);">Nenhum workshop criado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
