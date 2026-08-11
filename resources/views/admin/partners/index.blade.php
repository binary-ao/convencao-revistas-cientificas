@extends('layouts.admin')

@section('title', 'Parceiros')

@php
    $statusVariant = ['proposto' => '', 'convidado' => 'status-badge--info', 'confirmado' => 'status-badge--positive', 'recusou' => 'status-badge--negative'];
@endphp

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Parceiros</h2>
        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary btn-sm">Novo parceiro</a>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 56px;"></th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($partners as $partner)
                    <tr>
                        <td>
                            @if ($partner->logoUrl())
                                <img src="{{ $partner->logoUrl() }}" alt="" style="max-width: 40px; max-height: 40px;">
                            @endif
                        </td>
                        <td>{{ $partner->name }}</td>
                        <td class="small" style="color: var(--color-muted);">{{ $categoryLabels[$partner->category] ?? $partner->category }}</td>
                        <td><span class="status-badge {{ $statusVariant[$partner->status] ?? '' }}">{{ ucfirst($partner->status) }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Remover este parceiro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhum parceiro criado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
