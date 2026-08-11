<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 28px 36px; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #14181A; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; }
        .header-table td { vertical-align: top; }
        .brand { font-size: 13px; font-weight: bold; letter-spacing: 1px; color: #1F3B57; }
        .kicker { font-size: 8px; text-transform: uppercase; letter-spacing: 1px; color: #A8672E; font-weight: bold; margin-bottom: 4px; }
        h1 { font-size: 17px; margin: 0 0 2px 0; color: #14181A; }
        .subtitle { font-size: 10px; color: #5A6266; margin-bottom: 18px; }
        .rule { border-top: 1px solid #DCE1E2; margin: 14px 0; }
        .code-box { border: 1px solid #1F3B57; padding: 10px 14px; text-align: center; margin: 14px 0; }
        .code-box .label { font-size: 8px; text-transform: uppercase; letter-spacing: 1px; color: #5A6266; }
        .code-box .code { font-size: 18px; font-weight: bold; color: #1F3B57; letter-spacing: 1px; }
        .field-table td { padding: 5px 0; border-bottom: 1px solid #EEF1F1; font-size: 10.5px; }
        .field-table td.label { width: 38%; color: #5A6266; text-transform: uppercase; font-size: 8px; letter-spacing: .5px; }
        .status { display: inline-block; border: 1px solid #2F6F4E; color: #2F6F4E; padding: 2px 8px; font-size: 9px; text-transform: uppercase; }
        .footer { margin-top: 24px; font-size: 8.5px; color: #5A6266; }
        .section-title { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #A8672E; font-weight: bold; margin: 16px 0 6px 0; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 70%;">
                <div class="kicker">Comprovativo de Inscrição</div>
                <div class="brand">CNRCA</div>
            </td>
            <td style="width: 30%; text-align: right;">
                <img src="{{ $qrCodeDataUri }}" width="88" height="88">
            </td>
        </tr>
    </table>

    <div class="rule"></div>

    <h1>{{ $registration->event->name }}</h1>
    <div class="subtitle">
        @if ($registration->event->start_date)
            {{ $registration->event->start_date->translatedFormat('d \d\e F') }}
            @if ($registration->event->end_date && ! $registration->event->end_date->equalTo($registration->event->start_date))
                &ndash; {{ $registration->event->end_date->translatedFormat('d \d\e F \d\e Y') }}
            @else
                de {{ $registration->event->start_date->format('Y') }}
            @endif
            @if ($registration->event->venue_name)
                &bull; {{ $registration->event->venue_name }}
            @endif
        @endif
    </div>

    <div class="code-box">
        <div class="label">Código de Inscrição</div>
        <div class="code">{{ $registration->code }}</div>
    </div>

    <div class="section-title">Identificação do Participante</div>
    <table class="field-table">
        <tr><td class="label">Nome</td><td>{{ $registration->participant->full_name }}</td></tr>
        <tr><td class="label">Email</td><td>{{ $registration->participant->email }}</td></tr>
        <tr><td class="label">Telefone</td><td>{{ $registration->participant->phone }}</td></tr>
        <tr>
            <td class="label">Instituição</td>
            <td>{{ $registration->participant->institution?->name ?? $registration->participant->institution_name_other ?? '—' }}</td>
        </tr>
        <tr><td class="label">Cargo / Função</td><td>{{ $registration->participant->job_title ?? '—' }}</td></tr>
        <tr>
            <td class="label">Categoria</td>
            <td>{{ $registration->participant->participantType->label ?? $registration->participant->participant_type_other }}</td>
        </tr>
    </table>

    <div class="section-title">Participação</div>
    <table class="field-table">
        <tr><td class="label">Modalidade</td><td style="text-transform: capitalize;">{{ $registration->modality }}</td></tr>
        <tr>
            <td class="label">Workshops</td>
            <td>{{ $registration->workshops->pluck('name')->implode('; ') ?: '—' }}</td>
        </tr>
        <tr>
            <td class="label">Cursos</td>
            <td>{{ $registration->courses->pluck('name')->implode('; ') ?: '—' }}</td>
        </tr>
        <tr><td class="label">Data da inscrição</td><td>{{ $registration->submitted_at?->translatedFormat('d/m/Y H:i') }}</td></tr>
        <tr>
            <td class="label">Estado</td>
            <td><span class="status">{{ ucfirst($registration->status) }}</span></td>
        </tr>
    </table>

    <div class="footer">
        Este documento comprova a inscrição na {{ $registration->event->name }}. Em caso de dúvida, contacte
        {{ $registration->event->contact_email ?? 'a organização' }}. Consulte esta inscrição a qualquer momento em
        {{ config('app.url') }}/inscricao/consultar, utilizando o código acima e o email de registo.
    </div>

</body>
</html>
