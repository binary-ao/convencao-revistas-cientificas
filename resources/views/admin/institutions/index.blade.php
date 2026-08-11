@extends('layouts.admin')

@section('title', 'Instituições')

@php
    $typeLabels = [
        'ies' => 'IES', 'centro_investigacao' => 'Centro de Investigação', 'orgao_governamental' => 'Órgão Governamental',
        'rede_cientifica' => 'Rede Científica', 'revista_cientifica' => 'Revista Científica', 'outro' => 'Outro',
    ];
@endphp

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Instituições</h2>
        <a href="{{ route('admin.institutions.create') }}" class="btn btn-primary btn-sm">Nova instituição</a>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sigla</th>
                    <th>Tipo</th>
                    <th>Cidade</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($institutions as $institution)
                    <tr>
                        <td>{{ $institution->name }}</td>
                        <td class="font-monospace small">{{ $institution->acronym ?? '—' }}</td>
                        <td class="small">{{ $typeLabels[$institution->type] ?? $institution->type }}</td>
                        <td class="small" style="color: var(--color-muted);">{{ $institution->city ?? '—' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.institutions.edit', $institution) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            <form action="{{ route('admin.institutions.destroy', $institution) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover esta instituição?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhuma instituição criada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $institutions->links() }}</div>

@endsection
