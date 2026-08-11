<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Checkin;
use App\Models\Course;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Workshop;
use InvalidArgumentException;

/**
 * Ponto único de definição dos relatórios (secção 44 da arquitectura).
 * Cada relatório devolve título + cabeçalhos + linhas — reutilizado tanto
 * para visualização no ecrã como para exportação (Excel/CSV/PDF).
 */
class ReportService
{
    public const REPORTS = [
        'participants_general' => 'Lista Geral de Participantes',
        'participants_presencial' => 'Participantes Presenciais',
        'participants_online' => 'Participantes Online',
        'participants_by_province' => 'Participantes por Província',
        'participants_by_institution' => 'Participantes por Instituição',
        'participants_by_profile' => 'Participantes por Perfil',
        'workshop_registrations' => 'Inscritos em Workshops',
        'course_registrations' => 'Inscritos em Cursos',
        'checkins' => 'Check-in',
        'certificates' => 'Certificados',
    ];

    public function build(string $key): array
    {
        if (! array_key_exists($key, self::REPORTS)) {
            throw new InvalidArgumentException("Relatório desconhecido: {$key}");
        }

        $event = Event::current();

        return match ($key) {
            'participants_general' => $this->registrationsList($event, null),
            'participants_presencial' => $this->registrationsList($event, 'presencial'),
            'participants_online' => $this->registrationsList($event, 'online'),
            'participants_by_province' => $this->groupedByProvince($event),
            'participants_by_institution' => $this->groupedByInstitution($event),
            'participants_by_profile' => $this->groupedByProfile($event),
            'workshop_registrations' => $this->activityRegistrations($event, 'workshops'),
            'course_registrations' => $this->activityRegistrations($event, 'courses'),
            'checkins' => $this->checkinsReport($event),
            'certificates' => $this->certificatesReport($event),
        };
    }

    private function registrationsList(Event $event, ?string $modality): array
    {
        $query = Registration::where('event_id', $event->id)
            ->with(['participant.institution', 'participant.participantType']);

        if ($modality) {
            $query->where('modality', $modality);
        }

        $rows = $query->orderBy('id')->get()->map(fn (Registration $r) => [
            $r->code,
            $r->participant->full_name,
            $r->participant->email,
            $r->participant->phone,
            $r->participant->institution?->name ?? $r->participant->institution_name_other ?? '—',
            $r->participant->participantType?->label ?? $r->participant->participant_type_other ?? '—',
            $r->participant->province ?? '—',
            ucfirst($r->modality),
            ucfirst($r->status),
            $r->submitted_at?->format('d/m/Y H:i') ?? '—',
        ])->all();

        return [
            'title' => self::REPORTS[$modality ? "participants_{$modality}" : 'participants_general'],
            'headers' => ['Código', 'Nome', 'Email', 'Telefone', 'Instituição', 'Perfil', 'Província', 'Modalidade', 'Estado', 'Data'],
            'rows' => $rows,
        ];
    }

    private function groupedByProvince(Event $event): array
    {
        $rows = Registration::where('registrations.event_id', $event->id)
            ->join('participants', 'participants.id', '=', 'registrations.participant_id')
            ->selectRaw("COALESCE(participants.province, 'Não indicado') as label, count(*) as total")
            ->groupBy('label')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [$row->label, $row->total])
            ->all();

        return [
            'title' => self::REPORTS['participants_by_province'],
            'headers' => ['Província', 'Total'],
            'rows' => $rows,
        ];
    }

    private function groupedByInstitution(Event $event): array
    {
        $rows = Registration::where('registrations.event_id', $event->id)
            ->join('participants', 'participants.id', '=', 'registrations.participant_id')
            ->leftJoin('institutions', 'institutions.id', '=', 'participants.institution_id')
            ->selectRaw("COALESCE(institutions.name, participants.institution_name_other, 'Não indicado') as label, count(*) as total")
            ->groupBy('label')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [$row->label, $row->total])
            ->all();

        return [
            'title' => self::REPORTS['participants_by_institution'],
            'headers' => ['Instituição', 'Total'],
            'rows' => $rows,
        ];
    }

    private function groupedByProfile(Event $event): array
    {
        $rows = Registration::where('registrations.event_id', $event->id)
            ->join('participants', 'participants.id', '=', 'registrations.participant_id')
            ->join('participant_types', 'participant_types.id', '=', 'participants.participant_type_id')
            ->selectRaw('participant_types.label as label, count(*) as total')
            ->groupBy('label')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [$row->label, $row->total])
            ->all();

        return [
            'title' => self::REPORTS['participants_by_profile'],
            'headers' => ['Perfil', 'Total'],
            'rows' => $rows,
        ];
    }

    private function activityRegistrations(Event $event, string $type): array
    {
        $model = $type === 'workshops' ? Workshop::class : Course::class;

        $rows = collect();

        $model::where('event_id', $event->id)->get()->each(function ($activity) use ($type, $rows) {
            $activity->registrations()
                ->wherePivot('status', 'registered')
                ->with('participant')
                ->get()
                ->each(function (Registration $registration) use ($activity, $rows) {
                    $rows->push([
                        $activity->code ?? $activity->name,
                        $registration->code,
                        $registration->participant->full_name,
                        $registration->participant->email,
                        ucfirst($registration->status),
                    ]);
                });
        });

        return [
            'title' => self::REPORTS[$type === 'workshops' ? 'workshop_registrations' : 'course_registrations'],
            'headers' => [$type === 'workshops' ? 'Workshop' : 'Curso', 'Código Inscrição', 'Nome', 'Email', 'Estado'],
            'rows' => $rows->all(),
        ];
    }

    private function checkinsReport(Event $event): array
    {
        $rows = Checkin::whereHas('registration', fn ($q) => $q->where('event_id', $event->id))
            ->with(['registration.participant', 'operator'])
            ->orderByDesc('checked_in_at')
            ->get()
            ->map(fn (Checkin $c) => [
                $c->registration->code,
                $c->registration->participant->full_name,
                $c->checked_in_at->format('d/m/Y H:i'),
                ucfirst($c->method),
                $c->operator?->name ?? '—',
            ])->all();

        return [
            'title' => self::REPORTS['checkins'],
            'headers' => ['Código Inscrição', 'Nome', 'Data/Hora', 'Método', 'Operador'],
            'rows' => $rows,
        ];
    }

    private function certificatesReport(Event $event): array
    {
        $rows = Certificate::whereHas('registration', fn ($q) => $q->where('event_id', $event->id))
            ->with('registration.participant')
            ->orderByDesc('id')
            ->get()
            ->map(fn (Certificate $c) => [
                $c->code,
                $c->registration->code,
                $c->registration->participant->full_name,
                ucfirst($c->status),
                $c->issued_at?->format('d/m/Y') ?? '—',
                $c->sent_at ? 'Sim' : 'Não',
            ])->all();

        return [
            'title' => self::REPORTS['certificates'],
            'headers' => ['Código Certificado', 'Código Inscrição', 'Nome', 'Estado', 'Emitido em', 'Enviado'],
            'rows' => $rows,
        ];
    }
}
