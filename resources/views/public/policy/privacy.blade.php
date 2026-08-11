@extends('layouts.public')

@section('title', 'Política de Privacidade')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Protecção de Dados</div>
            <h1 class="display-6 mb-0">Política de Privacidade</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="callout-draft alert alert-secondary mb-4">
                        Minuta de referência, a rever pela organização/assessoria jurídica antes da publicação
                        oficial da Convenção.
                    </div>

                    <h2 class="h5 mt-4">Dados recolhidos</h2>
                    <p style="color: var(--color-muted);">
                        No processo de inscrição, recolhemos nome completo, email, telefone, província, país,
                        instituição, cargo/função, área científica e perfil de participação. Estes dados são
                        fornecidos directamente por si no formulário de inscrição.
                    </p>

                    <h2 class="h5 mt-4">Finalidade do tratamento</h2>
                    <p style="color: var(--color-muted);">
                        Os dados são utilizados exclusivamente para organizar a sua participação na Convenção:
                        emissão do comprovativo de inscrição, credenciamento, comunicações relacionadas com o
                        evento e, quando aplicável, emissão de certificado de participação.
                    </p>

                    <h2 class="h5 mt-4">Partilha de dados</h2>
                    <p style="color: var(--color-muted);">
                        Os seus dados não são vendidos nem partilhados com terceiros para fins comerciais. Podem
                        ser acedidos pela equipa organizadora da Convenção para os fins descritos acima.
                    </p>

                    <h2 class="h5 mt-4">Os seus direitos</h2>
                    <p style="color: var(--color-muted);">
                        Pode solicitar a qualquer momento o acesso, a correcção ou a eliminação dos seus dados,
                        contactando a organização através dos <a href="{{ route('contacts') }}">contactos</a> indicados no site.
                    </p>

                    <h2 class="h5 mt-4">Conservação</h2>
                    <p style="color: var(--color-muted);">
                        Os dados de inscrição são conservados pelo período necessário à organização da Convenção
                        e ao cumprimento de obrigações legais aplicáveis.
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection
