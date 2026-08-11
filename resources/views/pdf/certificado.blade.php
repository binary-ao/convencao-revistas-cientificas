<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #14181A; margin: 0; }
        .frame { border: 2px solid #1F3B57; margin: 24px; padding: 48px 56px; height: 480px; position: relative; }
        .kicker { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #A8672E; font-weight: bold; text-align: center; }
        .brand { font-size: 14px; font-weight: bold; letter-spacing: 1px; color: #1F3B57; text-align: center; margin-top: 4px; }
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #5A6266; text-align: center; margin-top: 36px; }
        .name { font-size: 30px; font-weight: bold; color: #14181A; text-align: center; margin-top: 8px; border-bottom: 1px solid #DCE1E2; padding-bottom: 14px; }
        .body-text { font-size: 12.5px; color: #14181A; text-align: center; margin-top: 20px; line-height: 1.7; padding: 0 40px; }
        .event-name { font-weight: bold; color: #1F3B57; }
        table.footer-table { width: 100%; margin-top: 40px; }
        .footer-table td { vertical-align: bottom; font-size: 9px; color: #5A6266; }
        .code-block { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1F3B57; font-weight: bold; letter-spacing: .5px; }
    </style>
</head>
<body>
    <div class="frame">
        <div class="kicker">Certificado de Participação</div>
        <div class="brand">{{ strtoupper($certificate->registration->event->name) }}</div>

        <div class="label">Certifica-se que</div>
        <div class="name">{{ $certificate->registration->participant->full_name }}</div>

        <div class="body-text">
            participou na <span class="event-name">{{ $certificate->registration->event->name }}</span>
            @if ($certificate->registration->event->start_date)
                , realizada
                @if ($certificate->registration->event->venue_name)
                    em {{ $certificate->registration->event->venue_name }},
                @endif
                de {{ $certificate->registration->event->start_date->translatedFormat('d') }}
                a {{ $certificate->registration->event->end_date?->translatedFormat('d \d\e F \d\e Y') ?? $certificate->registration->event->start_date->translatedFormat('d \d\e F \d\e Y') }},
            @endif
            na modalidade {{ $certificate->registration->modality }}.
        </div>

        <table class="footer-table">
            <tr>
                <td style="width: 33%;">
                    <div class="code-block">{{ $certificate->code }}</div>
                    <div>Código de validação</div>
                </td>
                <td style="width: 34%; text-align: center;">
                    <div>Emitido em {{ $certificate->issued_at?->format('d/m/Y') }}</div>
                    <div>Validar em {{ config('app.url') }}/certificado/validar</div>
                </td>
                <td style="width: 33%; text-align: right;">
                    <img src="{{ $qrCodeDataUri }}" width="64" height="64">
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
