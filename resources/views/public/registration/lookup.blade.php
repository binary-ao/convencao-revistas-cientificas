@extends('layouts.public')

@section('title', 'Consultar Inscrição')

@section('content')

    <section class="py-5 py-lg-6">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="eyebrow">Sem conta necessária</div>
                    <h1 class="mb-4">Consultar Inscrição</h1>

                    <form method="POST" action="{{ route('registration.lookup.submit') }}" class="border p-4 mb-4"
                        style="border-color: var(--color-border);">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small">Código da inscrição</label>
                            <input type="text" name="code" class="form-control" placeholder="CNRC-AO-2026-000001"
                                value="{{ old('code') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        @error('code') <div class="text-danger small mb-3">{{ $message }}</div> @enderror
                        @error('email') <div class="text-danger small mb-3">{{ $message }}</div> @enderror
                        <button type="submit" class="btn btn-primary w-100">Consultar</button>
                    </form>

                    @if ($notFound)
                        <div class="alert alert-warning">
                            Não foi encontrada nenhuma inscrição com este código e email.
                        </div>
                    @endif

                    @if ($registration)
                        <div class="border p-4" style="border-color: var(--color-border);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <div class="small text-uppercase" style="color: var(--color-muted);">Código</div>
                                    <div class="fw-semibold font-monospace">{{ $registration->code }}</div>
                                </div>
                                <span class="status-badge {{ $registration->status === 'confirmed' ? 'status-badge--positive' : 'status-badge--info' }}">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </div>

                            <table class="table table-borderless small mb-3">
                                <tr>
                                    <td class="text-muted" style="width:40%;">Nome</td>
                                    <td>{{ $registration->participant->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Instituição</td>
                                    <td>{{ $registration->participant->institution?->name ?? $registration->participant->institution_name_other ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Modalidade</td>
                                    <td class="text-capitalize">{{ $registration->modality }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Workshops</td>
                                    <td>{{ $registration->workshops->pluck('name')->implode(', ') ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Cursos</td>
                                    <td>{{ $registration->courses->pluck('name')->implode(', ') ?: '—' }}</td>
                                </tr>
                            </table>

                            <a href="{{ route('registration.proof', $registration) }}?email={{ urlencode($registration->participant->email) }}"
                                class="btn btn-outline-dark btn-sm" target="_blank">
                                Baixar Comprovativo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
