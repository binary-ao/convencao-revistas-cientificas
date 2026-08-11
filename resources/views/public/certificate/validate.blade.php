@extends('layouts.public')

@section('title', 'Validar Certificado')

@section('content')

    <section class="py-5 py-lg-6">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="eyebrow">Autenticidade</div>
                    <h1 class="mb-4">Validar Certificado</h1>

                    <form method="POST" action="{{ route('certificate.validate.submit') }}" class="border p-4 mb-4"
                        style="border-color: var(--color-border);">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small">Código do certificado</label>
                            <input type="text" name="code" class="form-control" placeholder="CERT-AO-2026-000001"
                                value="{{ old('code') }}" required>
                        </div>
                        @error('code') <div class="text-danger small mb-3">{{ $message }}</div> @enderror
                        <button type="submit" class="btn btn-primary w-100">Validar</button>
                    </form>

                    @if ($notFound)
                        <div class="alert alert-warning">
                            Nenhum certificado válido foi encontrado com este código.
                        </div>
                    @endif

                    @if ($certificate)
                        <div class="border p-4" style="border-color: var(--color-primary);">
                            <div class="status-badge status-badge--positive mb-3">Certificado Válido</div>

                            <table class="table table-borderless small mb-0">
                                <tr>
                                    <td class="text-muted" style="width:40%;">Código</td>
                                    <td class="font-monospace">{{ $certificate->code }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Nome</td>
                                    <td>{{ $certificate->registration->participant->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Instituição</td>
                                    <td>{{ $certificate->registration->participant->institution?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Evento</td>
                                    <td>{{ $certificate->registration->event->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Emitido em</td>
                                    <td>{{ $certificate->issued_at?->format('d/m/Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
