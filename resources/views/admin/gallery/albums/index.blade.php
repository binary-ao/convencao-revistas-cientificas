@extends('layouts.admin')

@section('title', 'Galeria')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Galeria</h2>
        <a href="{{ route('admin.gallery-albums.create') }}" class="btn btn-primary btn-sm">Novo álbum</a>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Itens</th>
                    <th>Estado</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($albums as $album)
                    <tr>
                        <td>{{ $album->title }}</td>
                        <td class="small">{{ $album->items_count }}</td>
                        <td>
                            <span class="status-badge {{ $album->is_published ? 'status-badge--positive' : '' }}">
                                {{ $album->is_published ? 'Publicado' : 'Rascunho' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.gallery-albums.edit', $album) }}" class="btn btn-sm btn-outline-dark">Gerir</a>
                            <form action="{{ route('admin.gallery-albums.destroy', $album) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover este álbum e todas as suas fotos/vídeos?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4" style="color: var(--color-muted);">Nenhum álbum criado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
