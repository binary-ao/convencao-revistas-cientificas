@extends('layouts.admin')

@section('title', 'Oradores')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Oradores</h2>
        <a href="{{ route('admin.speakers.create') }}" class="btn btn-primary btn-sm">Novo orador</a>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 56px;"></th>
                    <th>Nome</th>
                    <th>Instituição</th>
                    <th>Estado</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($speakers as $speaker)
                    <tr>
                        <td>
                            @if ($speaker->photoUrl())
                                <img src="{{ $speaker->photoUrl() }}" alt="" width="40" height="40" style="object-fit: cover;">
                            @else
                                <x-avatar-initials :name="$speaker->name" style="width:40px;height:40px;" />
                            @endif
                        </td>
                        <td>{{ $speaker->name }}</td>
                        <td class="small" style="color: var(--color-muted);">{{ $speaker->institution?->acronym ?? '—' }}</td>
                        <td>
                            <span class="status-badge {{ $speaker->is_published ? 'status-badge--positive' : '' }}">
                                {{ $speaker->is_published ? 'Publicado' : 'Rascunho' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.speakers.edit', $speaker) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            <form action="{{ route('admin.speakers.destroy', $speaker) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover este orador?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhum orador criado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $speakers->links() }}</div>

@endsection
