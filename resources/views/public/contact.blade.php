@extends('layouts.public')

@section('title', 'Contactos')

@section('content')

    <section class="py-5 border-bottom" style="border-color: var(--color-border);">
        <div class="container py-4">
            <div class="eyebrow">Fale Connosco</div>
            <h1 class="display-6 mb-0">Contactos</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="footer-heading">Email</div>
                    <p><a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email ?? 'A definir' }}</a></p>
                </div>
                <div class="col-md-4">
                    <div class="footer-heading">Telefone</div>
                    <p>{{ $event->contact_phone ?? 'A definir' }}</p>
                </div>
                <div class="col-md-4">
                    <div class="footer-heading">Local</div>
                    <p>
                        {{ $event->venue_name ?? 'A definir' }}
                        @if ($event->address)<br>{{ $event->address }}@endif
                        @if ($event->city)<br>{{ $event->city }}, {{ $event->country }}@endif
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection
