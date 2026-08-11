@extends('layouts.admin')

@section('title', 'Destaques do Hero')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h5 mb-1">Destaques do Hero (carrossel da Home)</h2>
            <p class="small mb-0" style="color: var(--color-muted);">
                Sem destaques activos, a Home mostra o hero por omissão. Com um ou mais, aparecem em carrossel na ordem definida.
            </p>
        </div>
        <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary btn-sm">Novo destaque</a>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 72px;"></th>
                    <th>Título</th>
                    <th>Ordem</th>
                    <th>Estado</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($slides as $slide)
                    <tr>
                        <td>
                            @if ($slide->imageUrl())
                                <img src="{{ $slide->imageUrl() }}" alt="" width="56" height="36" style="object-fit: cover;">
                            @else
                                <div class="small" style="color: var(--color-muted);">sem imagem</div>
                            @endif
                        </td>
                        <td>{{ $slide->title }}</td>
                        <td class="font-monospace small">{{ $slide->sort_order }}</td>
                        <td>
                            <span class="status-badge {{ $slide->is_active ? 'status-badge--positive' : '' }}">
                                {{ $slide->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover este destaque?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhum destaque criado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
