@extends('layouts.admin')

@section('title', 'Inscrição '.$registration->code)

@php
    $statusVariant = ['pending' => 'status-badge--info', 'confirmed' => 'status-badge--positive', 'cancelled' => 'status-badge--negative', 'draft' => ''];
@endphp

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <div class="eyebrow">Inscrição</div>
            <h2 class="h5 mb-0 font-monospace">{{ $registration->code }}</h2>
        </div>
        <span class="status-badge {{ $statusVariant[$registration->status] ?? '' }}">{{ ucfirst($registration->status) }}</span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                <div class="footer-heading">Participante</div>
                <table class="table table-borderless small mb-0">
                    <tr><td class="text-muted" style="width:35%;">Nome</td><td>{{ $registration->participant->full_name }}</td></tr>
                    <tr><td class="text-muted">Email</td><td>{{ $registration->participant->email }}</td></tr>
                    <tr><td class="text-muted">Telefone</td><td>{{ $registration->participant->phone }}</td></tr>
                    <tr><td class="text-muted">Instituição</td><td>{{ $registration->participant->institution?->name ?? $registration->participant->institution_name_other ?? '—' }}</td></tr>
                    <tr><td class="text-muted">Cargo</td><td>{{ $registration->participant->job_title ?? '—' }}</td></tr>
                    <tr><td class="text-muted">Perfil</td><td>{{ $registration->participant->participantType?->label }}</td></tr>
                </table>
                <a href="{{ route('admin.participants.edit', $registration->participant) }}" class="small">Editar dados do participante &rarr;</a>
            </div>

            <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                <div class="footer-heading">Participação</div>
                <table class="table table-borderless small mb-0">
                    <tr><td class="text-muted" style="width:35%;">Modalidade</td><td class="text-capitalize">{{ $registration->modality }}</td></tr>
                    <tr><td class="text-muted">Workshops</td><td>{{ $registration->workshops->pluck('name')->implode(', ') ?: '—' }}</td></tr>
                    <tr><td class="text-muted">Cursos</td><td>{{ $registration->courses->pluck('name')->implode(', ') ?: '—' }}</td></tr>
                    <tr><td class="text-muted">Data de submissão</td><td>{{ $registration->submitted_at?->format('d/m/Y H:i') }}</td></tr>
                    <tr><td class="text-muted">Check-in</td><td>{{ $registration->checkin_status === 'checked_in' ? 'Confirmado' : 'Por confirmar' }}</td></tr>
                    <tr><td class="text-muted">Certificado</td><td>{{ $registration->certificate_status === 'issued' ? 'Emitido' : 'Não emitido' }}</td></tr>
                </table>
                <a href="{{ route('admin.registrations.edit', $registration) }}" class="small">Editar modalidade/actividades &rarr;</a>
            </div>

            <div class="bg-white border p-4" style="border-color: var(--color-border);">
                <div class="footer-heading">Histórico de emails</div>
                <table class="table table-sm small mb-0">
                    <thead><tr><th>Tipo</th><th>Estado</th><th>Data</th></tr></thead>
                    <tbody>
                        @forelse ($registration->emailLogs->sortByDesc('id') as $log)
                            <tr>
                                <td>{{ ucfirst($log->type) }}</td>
                                <td>
                                    <span class="status-badge {{ $log->status === 'sent' ? 'status-badge--positive' : ($log->status === 'failed' ? 'status-badge--negative' : '') }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td style="color: var(--color-muted);">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="color: var(--color-muted);">Sem histórico.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white border p-4 mb-3" style="border-color: var(--color-border);">
                <div class="footer-heading">Acções</div>

                @if ($registration->status !== 'confirmed')
                    <form method="POST" action="{{ route('admin.registrations.confirm', $registration) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm w-100">Confirmar inscrição</button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.registrations.resend-proof', $registration) }}" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark btn-sm w-100">Reenviar comprovativo</button>
                </form>

                @if ($registration->pdf_path)
                    <a href="{{ route('registration.proof', $registration) }}?email={{ urlencode($registration->participant->email) }}"
                        class="btn btn-outline-dark btn-sm w-100 mb-2" target="_blank">
                        Baixar comprovativo
                    </a>
                @endif

                @if ($registration->status !== 'cancelled')
                    <form method="POST" action="{{ route('admin.registrations.cancel', $registration) }}" class="mt-3 pt-3 border-top"
                        style="border-color: var(--color-border);"
                        onsubmit="return confirm('Cancelar esta inscrição?');">
                        @csrf
                        <label class="form-label small">Motivo do cancelamento</label>
                        <textarea name="cancellation_reason" rows="2" class="form-control form-control-sm mb-2"></textarea>
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">Cancelar inscrição</button>
                    </form>
                @else
                    <div class="alert alert-secondary small mt-3 mb-0">
                        Cancelada em {{ $registration->cancelled_at?->format('d/m/Y H:i') }}
                        @if ($registration->cancellation_reason)
                            — {{ $registration->cancellation_reason }}
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
