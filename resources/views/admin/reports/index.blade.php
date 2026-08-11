@extends('layouts.admin')

@section('title', 'Relatórios')

@section('content')

    <h2 class="h5 mb-4">Relatórios</h2>

    <div class="row g-3">
        @foreach ($reports as $key => $title)
            <div class="col-md-6 col-lg-4">
                <div class="bg-white border p-4 h-100 d-flex flex-column" style="border-color: var(--color-border);">
                    <h3 class="h6 mb-3">{{ $title }}</h3>
                    <div class="mt-auto">
                        <a href="{{ route('admin.reports.show', $key) }}" class="btn btn-outline-dark btn-sm">Ver</a>
                        <a href="{{ route('admin.reports.export', [$key, 'xlsx']) }}" class="btn btn-outline-dark btn-sm">Excel</a>
                        <a href="{{ route('admin.reports.export', [$key, 'csv']) }}" class="btn btn-outline-dark btn-sm">CSV</a>
                        <a href="{{ route('admin.reports.export', [$key, 'pdf']) }}" class="btn btn-outline-dark btn-sm">PDF</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
