@extends('layouts.public')

@section('title', 'Termos de Utilização')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Legal</div>
            <h1 class="display-6 mb-0">Termos de Utilização</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="alert alert-secondary mb-4">
                        Minuta de referência, a rever pela organização/assessoria jurídica antes da publicação
                        oficial da Convenção.
                    </div>

                    <h2 class="h5 mt-4">Âmbito</h2>
                    <p style="color: var(--color-muted);">
                        Este website destina-se à divulgação da 1ª Convenção Nacional de Revistas Científicas
                        Angolanas e à inscrição de participantes. Ao utilizá-lo, aceita estes termos.
                    </p>

                    <h2 class="h5 mt-4">Inscrição</h2>
                    <p style="color: var(--color-muted);">
                        A inscrição não requer criação de conta. O participante é responsável pela exactidão dos
                        dados fornecidos no formulário de inscrição.
                    </p>

                    <h2 class="h5 mt-4">Alterações ao programa</h2>
                    <p style="color: var(--color-muted);">
                        A organização reserva-se o direito de alterar datas, horários, oradores ou actividades do
                        programa, comunicando as alterações através dos canais oficiais da Convenção.
                    </p>

                    <h2 class="h5 mt-4">Contacto</h2>
                    <p style="color: var(--color-muted);">
                        Para questões relacionadas com estes termos, contacte a organização através da
                        <a href="{{ route('contacts') }}">página de contactos</a>.
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection
