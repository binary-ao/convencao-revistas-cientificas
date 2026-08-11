@extends('layouts.admin')

@section('title', 'Configurações do Evento')

@section('content')

    <h2 class="h5 mb-4">Configurações do Evento</h2>

    <form method="POST" action="{{ route('admin.event-settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">

                <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                    <div class="footer-heading">Identificação</div>

                    <div class="mb-3">
                        <label class="form-label small">Nome do evento *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Descrição curta</label>
                        <input type="text" name="short_description" class="form-control" value="{{ old('short_description', $event->short_description) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Descrição longa (Enquadramento)</label>
                        <textarea name="long_description" rows="5" class="form-control">{{ old('long_description', $event->long_description) }}</textarea>
                    </div>
                </div>

                <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                    <div class="footer-heading">Data e local</div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Data inicial</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ old('start_date', optional($event->start_date)->format('Y-m-d')) }}">
                            <div class="form-text">Alimenta a contagem decrescente e o bloco "Quando" na Home.</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Data final</label>
                            <input type="date" name="end_date" class="form-control"
                                value="{{ old('end_date', optional($event->end_date)->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Local</label>
                        <input type="text" name="venue_name" class="form-control" value="{{ old('venue_name', $event->venue_name) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Endereço</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $event->address) }}">
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label class="form-label small">Cidade</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $event->city) }}">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label small">País</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $event->country) }}">
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label small">Formato *</label>
                            <select name="format" class="form-select" required>
                                <option value="presencial" @selected(old('format', $event->format) === 'presencial')>Presencial</option>
                                <option value="online" @selected(old('format', $event->format) === 'online')>Online</option>
                                <option value="hibrido" @selected(old('format', $event->format) === 'hibrido')>Híbrido</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                    <div class="footer-heading">Contacto</div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $event->contact_email) }}">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Telefone</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $event->contact_phone) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Website</label>
                        <input type="text" name="website_url" class="form-control" value="{{ old('website_url', $event->website_url) }}">
                    </div>
                </div>

                <div class="bg-white border p-4" style="border-color: var(--color-border);">
                    <div class="footer-heading">Inscrições</div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="registration_open" id="registration_open" class="form-check-input" value="1"
                            @checked(old('registration_open', $event->registration_open))>
                        <label for="registration_open" class="form-check-label small">Inscrições abertas</label>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Abertura das inscrições</label>
                            <input type="datetime-local" name="registration_opens_at" class="form-control"
                                value="{{ old('registration_opens_at', optional($event->registration_opens_at)->format('Y-m-d\TH:i')) }}">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label small">Encerramento das inscrições</label>
                            <input type="datetime-local" name="registration_closes_at" class="form-control"
                                value="{{ old('registration_closes_at', optional($event->registration_closes_at)->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small">Limite geral de participantes</label>
                        <input type="number" name="participant_limit" min="1" class="form-control" style="max-width: 200px;"
                            value="{{ old('participant_limit', $event->participant_limit) }}">
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                    <div class="footer-heading">Estado</div>
                    <select name="status" class="form-select" required>
                        <option value="draft" @selected(old('status', $event->status) === 'draft')>Rascunho</option>
                        <option value="published" @selected(old('status', $event->status) === 'published')>Publicado</option>
                        <option value="archived" @selected(old('status', $event->status) === 'archived')>Arquivado</option>
                    </select>
                </div>

                <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                    <div class="footer-heading">Logótipo</div>
                    @if ($event->logoUrl())
                        <img src="{{ $event->logoUrl() }}" alt="" class="mb-2" style="max-width: 100%; max-height: 80px;">
                    @endif
                    <input type="file" name="logo" accept="image/*" class="form-control form-control-sm">
                </div>

                <div class="bg-white border p-4 mb-4" style="border-color: var(--color-border);">
                    <div class="footer-heading">Favicon</div>
                    @if ($event->faviconUrl())
                        <img src="{{ $event->faviconUrl() }}" alt="" class="mb-2" style="max-width: 48px;">
                    @endif
                    <input type="file" name="favicon" accept="image/*" class="form-control form-control-sm">
                </div>

                <div class="bg-white border p-4" style="border-color: var(--color-border);">
                    <div class="footer-heading">Imagem principal</div>
                    @if ($event->coverImageUrl())
                        <img src="{{ $event->coverImageUrl() }}" alt="" class="mb-2 w-100" style="aspect-ratio: 16/9; object-fit: cover;">
                    @endif
                    <input type="file" name="cover_image" accept="image/*" class="form-control form-control-sm">
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>

@endsection
