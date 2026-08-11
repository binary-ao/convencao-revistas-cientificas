@extends('layouts.admin')

@section('title', 'Certificados')

@section('content')

    <h2 class="h5 mb-4">Certificados</h2>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-sm-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">Todos os estados</option>
                <option value="issued" @selected(request('status') === 'issued')>Emitidos</option>
                <option value="not_issued" @selected(request('status') === 'not_issued')>Não emitidos</option>
            </select>
        </div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-outline-dark btn-sm">Filtrar</button>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-link btn-sm">Limpar</a>
        </div>
    </form>

    <div class="bg-white border" style="border-color: var(--color-border);">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Código Inscrição</th>
                    <th>Nome</th>
                    <th>Certificado</th>
                    <th>Estado</th>
                    <th class="text-end">Acções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registrations as $registration)
                    <tr>
                        <td class="font-monospace small">{{ $registration->code }}</td>
                        <td>{{ $registration->participant->full_name }}</td>
                        <td class="font-monospace small">{{ $registration->certificate?->code ?? '—' }}</td>
                        <td>
                            @if ($registration->certificate?->status === 'issued')
                                <span class="status-badge status-badge--positive">Emitido</span>
                                @if ($registration->certificate->sent_at)
                                    <span class="status-badge status-badge--info">Enviado</span>
                                @endif
                            @else
                                <span class="status-badge">Não emitido</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.certificates.issue', $registration) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-dark">
                                    {{ $registration->certificate?->status === 'issued' ? 'Reemitir' : 'Emitir' }}
                                </button>
                            </form>
                            @if ($registration->certificate?->status === 'issued')
                                <form action="{{ route('admin.certificates.send', $registration->certificate) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-dark">Enviar</button>
                                </form>
                                <a href="{{ route('admin.certificates.download', $registration->certificate) }}" class="btn btn-sm btn-outline-dark" target="_blank">Download</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhuma inscrição encontrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $registrations->links() }}</div>

@endsection
