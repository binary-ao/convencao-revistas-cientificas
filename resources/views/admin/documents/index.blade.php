@extends('layouts.admin')

@section('title', 'Documentos')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Documentos</h2>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary btn-sm">Novo documento</a>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Ficheiro</th>
                    <th>Estado</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documents as $document)
                    <tr>
                        <td>{{ $document->title }}</td>
                        <td class="small" style="color: var(--color-muted);">{{ $categoryLabels[$document->category] ?? $document->category }}</td>
                        <td class="small">
                            <a href="{{ $document->fileUrl() }}" target="_blank">{{ $document->original_filename ?? 'ficheiro' }}</a>
                        </td>
                        <td>
                            <span class="status-badge {{ $document->status === 'published' ? 'status-badge--positive' : '' }}">
                                {{ $document->status === 'published' ? 'Publicado' : 'Rascunho' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover este documento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhum documento criado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
