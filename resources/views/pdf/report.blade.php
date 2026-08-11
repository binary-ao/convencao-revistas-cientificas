<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #14181A; font-size: 10px; }
        .kicker { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #A8672E; font-weight: bold; }
        h1 { font-size: 16px; margin: 2px 0 4px 0; color: #1F3B57; }
        .meta { font-size: 9px; color: #5A6266; margin-bottom: 16px; }
        table { border-collapse: collapse; width: 100%; }
        th { background: #EEF1F1; text-align: left; padding: 6px 8px; font-size: 8.5px; text-transform: uppercase; letter-spacing: .5px; border-bottom: 1px solid #1F3B57; }
        td { padding: 5px 8px; border-bottom: 1px solid #EEF1F1; }
        tr:nth-child(even) td { background: #FAFBFB; }
    </style>
</head>
<body>
    <div class="kicker">CNRCA — Relatório Administrativo</div>
    <h1>{{ $title }}</h1>
    <div class="meta">Gerado em {{ now()->format('d/m/Y H:i') }} &bull; {{ count($rows) }} registo(s)</div>

    <table>
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td colspan="{{ count($headers) }}">Sem dados.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
