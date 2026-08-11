@extends('layouts.admin')

@section('title', 'Notícias')

@php
    $statusVariant = ['publicado' => 'status-badge--positive', 'agendado' => 'status-badge--info', 'rascunho' => ''];
@endphp

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Notícias</h2>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">Nova notícia</a>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Estado</th>
                    <th>Data</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($newsItems as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td class="small" style="color: var(--color-muted);">{{ $item->author?->name ?? '—' }}</td>
                        <td><span class="status-badge {{ $statusVariant[$item->status] ?? '' }}">{{ ucfirst($item->status) }}</span></td>
                        <td class="small">{{ $item->published_at?->format('d/m/Y') ?? '—' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover esta notícia?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhuma notícia criada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $newsItems->links() }}</div>

@endsection
