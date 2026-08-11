@extends('layouts.public')

@section('title', 'Perguntas Frequentes')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Ajuda</div>
            <h1 class="display-6 mb-0">Perguntas Frequentes</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $faq)
                            <div class="accordion-item" style="border-color: var(--color-border);">
                                <h2 class="accordion-header">
                                    <button class="accordion-button @if (! $loop->first) collapsed @endif" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="faq{{ $faq->id }}" class="accordion-collapse collapse @if ($loop->first) show @endif"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body" style="color: var(--color-muted);">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
