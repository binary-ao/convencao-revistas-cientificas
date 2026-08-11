@extends('layouts.public')

@section('title', 'Inscrição realizada com sucesso')

@section('content')

    <section class="py-5 py-lg-6">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="eyebrow">Inscrição confirmada</div>
                    <h1 class="display-6 mb-3">Inscrição realizada com sucesso</h1>
                    <p class="fs-5 mb-4" style="color: var(--color-muted);">
                        Obrigado pela sua inscrição na {{ $registration->event->name }}.
                    </p>

                    <div class="border p-4 mb-4" style="border-color: var(--color-primary);">
                        <div class="small text-uppercase" style="letter-spacing: .06em; color: var(--color-muted);">Código da inscrição</div>
                        <div class="display-6 my-1" style="color: var(--color-primary); font-family: monospace;">{{ $registration->code }}</div>
                    </div>

                    <p class="mb-4" style="color: var(--color-muted);">
                        O comprovativo foi enviado para <strong>{{ $registration->participant->email }}</strong>.
                        Se não o encontrar, verifique a pasta de spam ou descarregue-o abaixo.
                    </p>

                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('registration.proof', $registration) }}?email={{ urlencode($registration->participant->email) }}"
                            class="btn btn-primary px-4 py-2" target="_blank">
                            Baixar Comprovativo PDF
                        </a>
                        <a href="{{ route('registration.lookup') }}" class="btn btn-outline-dark px-4 py-2">
                            Consultar Inscrição
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
