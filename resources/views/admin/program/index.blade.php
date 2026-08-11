@extends('layouts.admin')

@section('title', 'Programa')

@php
    $typeLabels = [
        'opening' => 'Abertura', 'keynote' => 'Palestra Magna', 'panel' => 'Painel Temático',
        'roundtable' => 'Mesa Redonda', 'workshop' => 'Oficina', 'course' => 'Curso',
        'forum' => 'Fórum', 'break' => 'Pausa', 'lunch' => 'Almoço', 'debate' => 'Debate',
        'plenary' => 'Plenária', 'closing' => 'Encerramento', 'other' => 'Sessão',
    ];
@endphp

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Programa</h2>
        <div>
            <a href="{{ route('admin.program-sessions.create') }}" class="btn btn-outline-dark btn-sm">Nova sessão</a>
            <a href="{{ route('admin.program-days.create') }}" class="btn btn-primary btn-sm">Novo dia</a>
        </div>
    </div>

    @forelse ($days as $day)
        <div class="bg-white border mb-4" style="border-color: var(--color-border);">
            <div class="d-flex align-items-center justify-content-between p-3 border-bottom" style="border-color: var(--color-border);">
                <div>
                    <span class="fw-semibold">Dia {{ $day->day_number }}</span>
                    <span class="small ms-2" style="color: var(--color-muted);">{{ $day->title }}</span>
                    @if ($day->date)
                        <span class="small ms-2" style="color: var(--color-muted);">{{ $day->date->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div>
                    <a href="{{ route('admin.program-days.edit', $day) }}" class="btn btn-sm btn-outline-dark">Editar dia</a>
                    <form action="{{ route('admin.program-days.destroy', $day) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Remover este dia e todas as suas sessões?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                    </form>
                </div>
            </div>

            <table class="table mb-0 align-middle">
                <tbody>
                    @forelse ($day->sessions->sortBy('start_time') as $session)
                        <tr>
                            <td class="font-monospace small" style="width: 90px;">
                                {{ \Illuminate\Support\Str::substr($session->start_time, 0, 5) }}
                            </td>
                            <td class="small">
                                <span class="status-badge status-badge--info">{{ $typeLabels[$session->type] ?? $session->type }}</span>
                            </td>
                            <td>{{ $session->title }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.program-sessions.edit', $session) }}" class="btn btn-sm btn-outline-dark">Editar</a>
                                <form action="{{ route('admin.program-sessions.destroy', $session) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Remover esta sessão?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="text-center py-3" style="color: var(--color-muted);">Sem sessões neste dia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @empty
        <div class="bg-white border p-4 text-center" style="border-color: var(--color-border); color: var(--color-muted);">
            Nenhum dia criado.
        </div>
    @endforelse

@endsection
