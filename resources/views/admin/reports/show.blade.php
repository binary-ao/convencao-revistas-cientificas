@extends('layouts.admin')

@section('title', $title)

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('admin.reports.index') }}" class="small d-block mb-2">&larr; Todos os relatórios</a>
            <h2 class="h5 mb-0">{{ $title }}</h2>
            <p class="small mb-0" style="color: var(--color-muted);">{{ count($rows) }} registo(s)</p>
        </div>
        <div>
            <a href="{{ route('admin.reports.export', [$type, 'xlsx']) }}" class="btn btn-outline-dark btn-sm">Excel</a>
            <a href="{{ route('admin.reports.export', [$type, 'csv']) }}" class="btn btn-outline-dark btn-sm">CSV</a>
            <a href="{{ route('admin.reports.export', [$type, 'pdf']) }}" class="btn btn-outline-dark btn-sm">PDF</a>
        </div>
    </div>

    <div class="bg-white border" style="border-color: var(--color-border); overflow-x: auto;">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    @foreach ($headers as $header)
                        <th class="text-nowrap">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td class="text-nowrap small">{{ $cell }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr><td colspan="{{ count($headers) }}" class="text-center py-4" style="color: var(--color-muted);">Sem dados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
