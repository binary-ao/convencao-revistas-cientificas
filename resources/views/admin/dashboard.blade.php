@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-card__label">Total de Inscritos</div>
                <div class="kpi-card__value">{{ $kpis['total'] }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-card__label">Confirmados</div>
                <div class="kpi-card__value">{{ $kpis['confirmed'] }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-card__label">Pendentes</div>
                <div class="kpi-card__value">{{ $kpis['pending'] }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-card__label">Cancelados</div>
                <div class="kpi-card__value">{{ $kpis['cancelled'] }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-card__label">Presenciais</div>
                <div class="kpi-card__value" style="font-size: 1.5rem;">{{ $kpis['presencial'] }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-card__label">Online</div>
                <div class="kpi-card__value" style="font-size: 1.5rem;">{{ $kpis['online'] }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-card__label">Check-ins</div>
                <div class="kpi-card__value" style="font-size: 1.5rem;">{{ $kpis['checked_in'] }}</div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-card__label">Certificados</div>
                <div class="kpi-card__value" style="font-size: 1.5rem;">{{ $kpis['certificates'] }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="bg-white border p-4 h-100" style="border-color: var(--color-border);">
                <div class="footer-heading">Presencial vs Online</div>
                <x-admin.bar-list :items="[
                    ['label' => 'Presencial', 'value' => $kpis['presencial']],
                    ['label' => 'Online', 'value' => $kpis['online']],
                ]" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="bg-white border p-4 h-100" style="border-color: var(--color-border);">
                <div class="footer-heading">Inscrições por Perfil</div>
                <x-admin.bar-list :items="$byProfile->map(fn ($row) => ['label' => $row->label, 'value' => $row->total])->all()" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="bg-white border p-4 h-100" style="border-color: var(--color-border);">
                <div class="footer-heading">Inscrições por Workshop</div>
                <x-admin.bar-list :items="$byWorkshop->map(fn ($w) => ['label' => $w->code ?? $w->name, 'value' => $w->registrations_count])->all()" />
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-6">
            <div class="bg-white border p-4 h-100" style="border-color: var(--color-border);">
                <div class="footer-heading">Participantes por Instituição</div>
                <x-admin.bar-list :items="$byInstitution->map(fn ($row) => ['label' => $row->acronym ?? $row->name, 'value' => $row->total])->all()" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="bg-white border p-4 h-100" style="border-color: var(--color-border);">
                <div class="footer-heading">Estado do sistema</div>
                <table class="table table-borderless small mb-0">
                    <tr><td class="text-muted" style="width:50%;">Evento</td><td>{{ $event->name ?? '—' }}</td></tr>
                    <tr><td class="text-muted">Inscrições abertas</td><td>{{ $event?->registration_open ? 'Sim' : 'Não' }}</td></tr>
                    <tr><td class="text-muted">Contas administrativas</td><td>{{ $staffCount }}</td></tr>
                </table>
            </div>
        </div>
    </div>

@endsection
