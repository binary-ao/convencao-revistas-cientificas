@extends('layouts.public')

@section('title', 'Sobre a Convenção')

@php
    $objectives = [
        'Debater os desafios e as oportunidades da edição científica em Angola.',
        'Harmonizar boas práticas editoriais e padrões internacionais de publicação.',
        'Capacitar editores, gestores editoriais e equipas técnicas.',
        'Promover a ética, a integridade e a ciência aberta.',
        'Incentivar a indexação, a visibilidade e o impacto das revistas científicas.',
        'Criar um espaço permanente de diálogo e cooperação entre editores científicos angolanos.',
    ];

    $audience = [
        'Editores-chefes', 'Editores associados', 'Gestores editoriais', 'Técnicos de plataformas digitais',
        'Investigadores', 'Docentes universitários', 'Bibliotecários', 'Gestores de repositórios',
        'Dirigentes de IES', 'Estudantes de pós-graduação', 'Representantes governamentais', 'Agências de fomento',
    ];
@endphp

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Sobre a Convenção</div>
            <h1 class="display-6 mb-0">1ª Convenção Nacional de Revistas Científicas Angolanas</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="eyebrow">Enquadramento</div>
                    <p class="fs-5" style="color: var(--color-text);">
                        {{ $event->long_description }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" style="background: var(--color-surface);">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="eyebrow">Objectivo Geral</div>
                    <p class="fs-5 mb-0">
                        Promover o fortalecimento, a profissionalização e a internacionalização das revistas
                        científicas angolanas, através do diálogo, da capacitação técnica e da articulação
                        institucional entre os principais atores do sistema científico nacional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="eyebrow">Objectivos Específicos</div>
            <h2 class="mb-4">O que a Convenção se propõe alcançar</h2>

            <div class="row g-4">
                @foreach ($objectives as $index => $objective)
                    <div class="col-md-6 col-lg-4">
                        <div class="numbered-block">
                            <div class="numbered-block__index mb-2">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <p class="mb-0">{{ $objective }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5" style="background: var(--color-surface);">
        <div class="container py-4">
            <div class="eyebrow">Público-Alvo</div>
            <h2 class="mb-4">A quem se destina</h2>

            <div class="row g-0 border-top border-start" style="border-color: var(--color-border);">
                @foreach ($audience as $item)
                    <div class="col-6 col-md-3">
                        <div class="border-end border-bottom p-3" style="border-color: var(--color-border);">
                            {{ $item }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
