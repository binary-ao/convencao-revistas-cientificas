@extends('layouts.admin')

@section('title', 'Cursos')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Cursos</h2>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">Novo curso</a>
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
                @forelse ($courses as $course)
                    <tr>
                        <td class="font-monospace small">{{ $course->code }}</td>
                        <td>{{ $course->name }}</td>
                        <td class="small" style="color: var(--color-muted);">{{ $course->trainer?->name ?? '—' }}</td>
                        <td class="small">{{ $course->registeredCount() }} / {{ $course->capacity }}</td>
                        <td>
                            <span class="status-badge {{ $course->is_active ? 'status-badge--positive' : '' }}">
                                {{ $course->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover este curso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4" style="color: var(--color-muted);">Nenhum curso criado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
