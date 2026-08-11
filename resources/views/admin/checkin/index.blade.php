@extends('layouts.admin')

@section('title', 'Check-in')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 mb-0">Check-in</h2>
        <span class="status-badge status-badge--positive">{{ $todayCount }} check-ins hoje</span>
    </div>

    <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
        <form method="GET" action="{{ route('admin.checkin.index') }}">
            <label class="form-label small">Código, nome ou email</label>
            <div class="d-flex gap-2">
                <input type="text" name="q" id="checkinSearch" class="form-control" value="{{ $query }}"
                    placeholder="CNRC-AO-2026-000001, nome ou email" autofocus autocomplete="off">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
            <div class="form-text">
                Compatível com leitores de QR Code USB — o código lido é escrito neste campo como se fosse teclado.
            </div>
        </form>
    </div>

    @if ($query !== '')
        <div class="bg-white border" style="border-color: var(--color-border);">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Modalidade</th>
                        <th>Estado</th>
                        <th class="text-end">Acção</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($results as $registration)
                        <tr>
                            <td class="font-monospace small">{{ $registration->code }}</td>
                            <td>{{ $registration->participant->full_name }}</td>
                            <td class="small text-capitalize">{{ $registration->modality }}</td>
                            <td>
                                @if ($registration->checkin)
                                    <span class="status-badge status-badge--positive">
                                        Confirmado às {{ $registration->checkin->checked_in_at->format('H:i') }}
                                    </span>
                                @else
                                    <span class="status-badge">Por confirmar</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if (! $registration->checkin)
                                    <form method="POST" action="{{ route('admin.checkin.confirm', $registration) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Confirmar presença</button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.registrations.show', $registration) }}" class="btn btn-sm btn-outline-dark">Ver inscrição</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4" style="color: var(--color-muted);">Nenhuma inscrição encontrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

@endsection

@push('scripts')
<script>
    document.getElementById('checkinSearch')?.focus();
</script>
@endpush
