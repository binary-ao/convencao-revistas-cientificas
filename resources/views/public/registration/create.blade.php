@extends('layouts.public')

@section('title', 'Inscrição')

@php
    $stepFields = [
        1 => ['full_name', 'email', 'phone', 'province', 'country'],
        2 => ['institution_id', 'institution_name_other', 'job_title', 'scientific_area'],
        3 => ['participant_type_id', 'participant_type_other'],
        4 => ['modality'],
        5 => ['workshop_ids', 'course_ids'],
        6 => ['privacy_policy', 'confirm_data'],
    ];
    $initialStep = 1;
    if ($errors->any()) {
        foreach ($stepFields as $step => $fields) {
            foreach ($fields as $field) {
                if ($errors->has($field) || $errors->has("{$field}.*")) {
                    $initialStep = $step;
                    break 2;
                }
            }
        }
    }
    $stepLabels = ['Dados Pessoais', 'Dados Profissionais', 'Perfil', 'Participação', 'Actividades', 'Confirmar'];
@endphp

@section('content')

    <section class="py-5 py-lg-6">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="eyebrow">Sem criação de conta</div>
                    <h1 class="mb-4">Inscrição</h1>

                    @if (session('duplicate_registration'))
                        <div class="alert alert-warning">
                            Já existe uma inscrição associada ao endereço <strong>{{ session('duplicate_email') }}</strong>.
                            <a href="{{ route('registration.lookup') }}" class="fw-semibold">Consultar Inscrição &rarr;</a>
                        </div>
                    @endif

                    <div class="d-none d-md-flex justify-content-between mb-4" id="wizardSteps">
                        @foreach ($stepLabels as $index => $label)
                            <div class="small text-center flex-fill wizard-step-label" data-step-label="{{ $index + 1 }}"
                                style="color: var(--color-muted); border-top: 2px solid var(--color-border); padding-top: 8px;">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}<br>{{ $label }}
                            </div>
                        @endforeach
                    </div>

                    <form method="POST" action="{{ route('registration.store') }}" id="registrationForm" novalidate>
                        @csrf
                        <input type="hidden" name="current_step_marker" id="currentStepMarker" value="1">

                        {{-- Etapa 1 — Dados pessoais --}}
                        <div class="wizard-step" data-step="1">
                            <h2 class="h5 mb-3">01 — Dados Pessoais</h2>
                            <div class="mb-3">
                                <label class="form-label small">Nome completo *</label>
                                <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                                @error('full_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label small">Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label small">Telefone *</label>
                                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required>
                                    @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label small">Província</label>
                                    <input type="text" name="province" class="form-control" value="{{ old('province') }}">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label small">País</label>
                                    <input type="text" name="country" class="form-control" value="{{ old('country', 'Angola') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Etapa 2 — Dados profissionais --}}
                        <div class="wizard-step d-none" data-step="2">
                            <h2 class="h5 mb-3">02 — Dados Profissionais</h2>
                            <div class="mb-3">
                                <label class="form-label small">Instituição</label>
                                <select name="institution_id" class="form-select" id="institutionSelect">
                                    <option value="">Seleccione ou indique abaixo</option>
                                    @foreach ($institutions as $institution)
                                        <option value="{{ $institution->id }}" @selected(old('institution_id') == $institution->id)>
                                            {{ $institution->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Outra instituição (se não está na lista)</label>
                                <input type="text" name="institution_name_other" class="form-control" value="{{ old('institution_name_other') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Cargo / Função *</label>
                                <input type="text" name="job_title" class="form-control" value="{{ old('job_title') }}" required>
                                @error('job_title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Área científica</label>
                                <input type="text" name="scientific_area" class="form-control" value="{{ old('scientific_area') }}">
                            </div>
                        </div>

                        {{-- Etapa 3 — Perfil --}}
                        <div class="wizard-step d-none" data-step="3">
                            <h2 class="h5 mb-3">03 — Perfil</h2>
                            <div class="mb-3">
                                <label class="form-label small">Qual destas opções melhor o(a) descreve? *</label>
                                <select name="participant_type_id" id="participantTypeSelect" class="form-select" required>
                                    <option value="">Seleccione uma opção</option>
                                    @foreach ($participantTypes as $type)
                                        <option value="{{ $type->id }}" data-code="{{ $type->code }}"
                                            @selected(old('participant_type_id') == $type->id)>
                                            {{ $type->label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('participant_type_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3 d-none" id="participantTypeOtherWrap">
                                <label class="form-label small">Especifique</label>
                                <input type="text" name="participant_type_other" id="participantTypeOtherInput"
                                    class="form-control" value="{{ old('participant_type_other') }}">
                            </div>
                        </div>

                        {{-- Etapa 4 — Participação --}}
                        <div class="wizard-step d-none" data-step="4">
                            <h2 class="h5 mb-3">04 — Participação</h2>
                            <div class="form-check mb-2">
                                <input type="radio" name="modality" value="presencial" id="modalityPresencial"
                                    class="form-check-input" @checked(old('modality', 'presencial') === 'presencial') required>
                                <label for="modalityPresencial" class="form-check-label">Presencial</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" name="modality" value="online" id="modalityOnline"
                                    class="form-check-input" @checked(old('modality') === 'online')>
                                <label for="modalityOnline" class="form-check-label">Online</label>
                            </div>
                            @error('modality') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- Etapa 5 — Workshops/Cursos --}}
                        <div class="wizard-step d-none" data-step="5">
                            <h2 class="h5 mb-3">05 — Actividades</h2>

                            <div id="activitiesOnlineNotice" class="alert alert-secondary d-none">
                                As oficinas e cursos desta edição decorrem apenas em modalidade presencial.
                                Sem actividades para seleccionar na participação online.
                            </div>

                            <div id="activitiesPresencialFields">
                                <div class="mb-4">
                                    <div class="footer-heading">Workshops</div>
                                    @foreach ($workshops as $workshop)
                                        @php $full = $workshop->isFull(); @endphp
                                        <div class="form-check mb-2">
                                            <input type="checkbox" name="workshop_ids[]" value="{{ $workshop->id }}"
                                                id="workshop{{ $workshop->id }}" class="form-check-input"
                                                @checked(in_array($workshop->id, old('workshop_ids', []))) @disabled($full)>
                                            <label for="workshop{{ $workshop->id }}" class="form-check-label">
                                                {{ $workshop->code }} — {{ $workshop->name }}
                                                <span class="status-badge {{ $full ? 'status-badge--negative' : 'status-badge--positive' }} ms-1">
                                                    {{ $full ? 'Esgotado' : $workshop->availableSpots().' vagas' }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <div class="footer-heading">Cursos</div>
                                    @foreach ($courses as $course)
                                        @php $full = $course->isFull(); @endphp
                                        <div class="form-check mb-2">
                                            <input type="checkbox" name="course_ids[]" value="{{ $course->id }}"
                                                id="course{{ $course->id }}" class="form-check-input"
                                                @checked(in_array($course->id, old('course_ids', []))) @disabled($full)>
                                            <label for="course{{ $course->id }}" class="form-check-label">
                                                {{ $course->code }} — {{ $course->name }}
                                                <span class="status-badge {{ $full ? 'status-badge--negative' : 'status-badge--positive' }} ms-1">
                                                    {{ $full ? 'Esgotado' : $course->availableSpots().' vagas' }}
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Etapa 6 — Confirmação --}}
                        <div class="wizard-step d-none" data-step="6">
                            <h2 class="h5 mb-3">06 — Confirmação</h2>

                            <table class="table table-borderless small mb-4" style="background: var(--color-surface);">
                                <tr><td class="text-muted" style="width: 35%;">Nome</td><td id="summaryName">—</td></tr>
                                <tr><td class="text-muted">Email</td><td id="summaryEmail">—</td></tr>
                                <tr><td class="text-muted">Instituição</td><td id="summaryInstitution">—</td></tr>
                                <tr><td class="text-muted">Perfil</td><td id="summaryProfile">—</td></tr>
                                <tr><td class="text-muted">Modalidade</td><td id="summaryModality">—</td></tr>
                                <tr><td class="text-muted">Workshops</td><td id="summaryWorkshops">—</td></tr>
                                <tr><td class="text-muted">Cursos</td><td id="summaryCourses">—</td></tr>
                            </table>

                            <div class="form-check mb-2">
                                <input type="checkbox" name="privacy_policy" value="1" id="privacyPolicy"
                                    class="form-check-input" @checked(old('privacy_policy')) required>
                                <label for="privacyPolicy" class="form-check-label small">
                                    Aceito a <a href="{{ route('privacy') }}" target="_blank">Política de Privacidade</a>
                                    e autorizo o tratamento dos meus dados para fins relacionados com a organização da Convenção.
                                </label>
                            </div>
                            @error('privacy_policy') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                            <div class="form-check mb-3">
                                <input type="checkbox" name="confirm_data" value="1" id="confirmData"
                                    class="form-check-input" @checked(old('confirm_data')) required>
                                <label for="confirmData" class="form-check-label small">
                                    Confirmo que os dados fornecidos estão correctos.
                                </label>
                            </div>
                            @error('confirm_data') <div class="text-danger small mb-3">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top" style="border-color: var(--color-border);">
                            <button type="button" class="btn btn-outline-dark px-4" id="wizardBack">Voltar</button>
                            <button type="button" class="btn btn-primary px-4" id="wizardNext">Seguinte</button>
                            <button type="submit" class="btn btn-primary px-4 d-none" id="wizardSubmit">Finalizar Inscrição</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('registrationForm');
    const steps = Array.from(form.querySelectorAll('.wizard-step'));
    const totalSteps = steps.length;
    let currentStep = {{ $initialStep }};

    const backBtn = document.getElementById('wizardBack');
    const nextBtn = document.getElementById('wizardNext');
    const submitBtn = document.getElementById('wizardSubmit');
    const marker = document.getElementById('currentStepMarker');

    function showStep(n) {
        steps.forEach(step => {
            step.classList.toggle('d-none', parseInt(step.dataset.step, 10) !== n);
        });
        backBtn.classList.toggle('d-none', n === 1);
        nextBtn.classList.toggle('d-none', n === totalSteps);
        submitBtn.classList.toggle('d-none', n !== totalSteps);
        marker.value = n;

        document.querySelectorAll('[data-step-label]').forEach(el => {
            const isActive = parseInt(el.dataset.stepLabel, 10) === n;
            el.style.color = isActive ? 'var(--color-primary)' : 'var(--color-muted)';
            el.style.borderTopColor = isActive ? 'var(--color-primary)' : 'var(--color-border)';
        });

        if (n === totalSteps) {
            updateSummary();
        }

        window.scrollTo({ top: form.offsetTop - 100, behavior: 'smooth' });
    }

    function validateCurrentStep() {
        const currentStepEl = steps.find(step => parseInt(step.dataset.step, 10) === currentStep);
        const fields = Array.from(currentStepEl.querySelectorAll('input, select, textarea'));
        const firstInvalid = fields.find(field => !field.checkValidity());

        if (firstInvalid) {
            // reportValidity() num campo concreto (visível) mostra a bolha nativa
            // do browser correctamente — ao contrário de form.reportValidity(),
            // que falha silenciosamente quando o campo inválido está noutra
            // etapa, ainda escondida com d-none (e por isso "not focusable").
            firstInvalid.reportValidity();
            return false;
        }

        return true;
    }

    nextBtn.addEventListener('click', function () {
        if (!validateCurrentStep()) {
            return;
        }
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });

    backBtn.addEventListener('click', function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // O <form> tem novalidate (necessário para o Next não disparar a
    // validação nativa do form inteiro), por isso a submissão final tem
    // de ser validada aqui manualmente — senão os required da etapa 6
    // (privacy_policy, confirm_data) deixam de ter qualquer efeito.
    form.addEventListener('submit', function (e) {
        if (!validateCurrentStep()) {
            e.preventDefault();
        }
    });

    // Etapa 3 — mostrar campo "Outro" apenas quando aplicável
    const participantTypeSelect = document.getElementById('participantTypeSelect');
    const otherWrap = document.getElementById('participantTypeOtherWrap');
    const otherInput = document.getElementById('participantTypeOtherInput');

    function toggleParticipantTypeOther() {
        const selected = participantTypeSelect.selectedOptions[0];
        const isOther = selected && selected.dataset.code === 'outro';
        otherWrap.classList.toggle('d-none', !isOther);
        otherInput.required = isOther;
    }
    participantTypeSelect.addEventListener('change', toggleParticipantTypeOther);
    toggleParticipantTypeOther();

    // Etapa 4/5 — esconder actividades quando participação é online
    const onlineNotice = document.getElementById('activitiesOnlineNotice');
    const presencialFields = document.getElementById('activitiesPresencialFields');

    function toggleActivities() {
        const isOnline = document.getElementById('modalityOnline').checked;
        onlineNotice.classList.toggle('d-none', !isOnline);
        presencialFields.classList.toggle('d-none', isOnline);
        presencialFields.querySelectorAll('input[type=checkbox]').forEach(cb => {
            if (isOnline) cb.checked = false;
        });
    }
    document.querySelectorAll('input[name=modality]').forEach(radio => radio.addEventListener('change', toggleActivities));
    toggleActivities();

    // Etapa 6 — resumo
    function updateSummary() {
        document.getElementById('summaryName').textContent = form.full_name.value || '—';
        document.getElementById('summaryEmail').textContent = form.email.value || '—';

        const institutionSelect = document.getElementById('institutionSelect');
        const institutionOther = form.institution_name_other.value;
        const institutionSelected = institutionSelect.selectedOptions[0];
        document.getElementById('summaryInstitution').textContent =
            (institutionSelected && institutionSelected.value ? institutionSelected.textContent : institutionOther) || '—';

        const profileSelected = participantTypeSelect.selectedOptions[0];
        document.getElementById('summaryProfile').textContent = (profileSelected && profileSelected.value ? profileSelected.textContent : '—');

        const modalityChecked = document.querySelector('input[name=modality]:checked');
        document.getElementById('summaryModality').textContent = modalityChecked ? modalityChecked.value : '—';

        const workshopLabels = Array.from(document.querySelectorAll('input[name="workshop_ids[]"]:checked'))
            .map(cb => cb.closest('.form-check').querySelector('label').textContent.trim());
        document.getElementById('summaryWorkshops').textContent = workshopLabels.join(', ') || '—';

        const courseLabels = Array.from(document.querySelectorAll('input[name="course_ids[]"]:checked'))
            .map(cb => cb.closest('.form-check').querySelector('label').textContent.trim());
        document.getElementById('summaryCourses').textContent = courseLabels.join(', ') || '—';
    }

    showStep(currentStep);
})();
</script>
@endpush
