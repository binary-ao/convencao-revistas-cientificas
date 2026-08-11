<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Event;
use App\Models\EventDay;
use App\Models\EventSession;
use App\Models\Speaker;
use App\Models\Workshop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Programa dos 3 dias tal como descrito na "PROPOSTA DE PROGRAMA" do Termo
 * de Referência — horários, títulos e subtemas são os do documento.
 * Apenas oradores/moderadores e salas são EXEMPLO (o Termo não os nomeia).
 */
class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::current();

        $speaker = fn (string $name) => Speaker::where('slug', Str::slug($name))->first()?->id;
        $workshop = fn (string $code) => Workshop::where('event_id', $event->id)->where('code', $code)->first()?->id;
        $course = fn (string $code) => Course::where('event_id', $event->id)->where('code', $code)->first()?->id;

        $days = [
            1 => [
                'title' => 'Contexto, Visão e Desafios da Edição Científica em Angola',
                'sessions' => [
                    ['08:00', '09:00', 'Credenciação e Acolhimento', null, 'other', null, null],
                    ['09:00', '09:45', 'Sessão Solene de Abertura', 'Hino Nacional; boas-vindas da Comissão Organizadora; intervenções institucionais; apresentação dos objectivos da Convenção.', 'opening', null, null],
                    ['09:45', '10:30', 'Palestra Magna I', 'O papel estratégico das revistas científicas no desenvolvimento científico e social de Angola.', 'keynote', 'Teresa Mavinga Sacadura', null],
                    ['10:30', '10:45', 'Pausa para Café', null, 'break', null, null],
                    ['10:45', '12:30', 'Painel Temático I — Panorama das Revistas Científicas em Angola', 'Evolução histórica e estado atual; principais desafios editoriais; experiências institucionais.', 'panel', null, 'Manuel Kiala Sabino'],
                    ['12:30', '14:00', 'Intervalo para Almoço', null, 'lunch', null, null],
                    ['14:00', '15:30', 'Painel Temático II — Qualidade Editorial e Boas Práticas Internacionais', 'Fluxo editorial e avaliação por pares; normalização e periodicidade; governança editorial.', 'panel', null, 'Ana Beatriz Chindongo'],
                    ['15:30', '15:45', 'Pausa para Café', null, 'break', null, null],
                    ['15:45', '17:00', 'Mesa Redonda — Desafios da Sustentabilidade das Revistas Científicas', 'Financiamento; gestão institucional; recursos humanos.', 'roundtable', null, 'Domingos Sumbo Kalunga'],
                    ['17:00', '17:30', 'Debate Aberto e Síntese do Dia', null, 'debate', null, null],
                ],
            ],
            2 => [
                'title' => 'Capacitação Técnica, Inovação e Internacionalização',
                'sessions' => [
                    ['09:00', '09:45', 'Palestra Magna II', 'Internacionalização da ciência e visibilidade das revistas africanas.', 'keynote', 'Ricardo Miguel Bumba', null],
                    ['09:45', '11:15', 'Painel Temático III — Indexação, Visibilidade e Impacto Científico', 'Critérios de indexação; estratégias para aumentar o impacto; métricas e avaliação científica.', 'panel', null, 'Carlos Alberto Wanga'],
                    ['11:15', '11:30', 'Pausa para Café', null, 'break', null, null],
                    ['11:30', '13:00', 'Painel Temático IV — Ética, Integridade Científica e Combate ao Plágio', 'Responsabilidades editoriais; ferramentas de deteção; casos e boas práticas.', 'panel', null, 'Isabel Muatxitxi Neto'],
                    ['13:00', '14:30', 'Intervalo para Almoço', null, 'lunch', null, null],
                    ['14:30', '16:00', 'Oficina A — Gestão editorial com plataformas digitais (OJS)', null, 'workshop', null, null, 'Oficina A'],
                    ['14:30', '16:00', 'Oficina B — Normalização de artigos científicos e metadados', null, 'workshop', null, null, 'Oficina B'],
                    ['14:30', '16:00', 'Oficina C — Organização e gestão da avaliação por pares', null, 'workshop', null, null, 'Oficina C'],
                    ['16:00', '16:15', 'Pausa para Café', null, 'break', null, null],
                    ['16:15', '17:45', 'Curso 1 — Formação de editores científicos', null, 'course', null, null, null, 'Curso 1'],
                    ['16:15', '17:45', 'Curso 2 — Formação de revisores científicos', null, 'course', null, null, null, 'Curso 2'],
                    ['16:15', '17:45', 'Curso 3 — Escrita científica e comunicação académica', null, 'course', null, null, null, 'Curso 3'],
                ],
            ],
            3 => [
                'title' => 'Ciência Aberta, Articulação Institucional e Futuro',
                'sessions' => [
                    ['09:00', '09:45', 'Palestra Magna III', 'Ciência Aberta, Acesso Aberto e o futuro da publicação científica.', 'keynote', 'João Baptista Sackaita', null],
                    ['09:45', '11:15', 'Painel Temático V — Ciência Aberta, Repositórios e Dados de Investigação', 'Políticas de acesso aberto; repositórios institucionais; desafios e oportunidades para Angola.', 'panel', null, 'Fernanda Luyeye Paulo'],
                    ['11:15', '11:30', 'Pausa para Café', null, 'break', null, null],
                    ['11:30', '13:00', 'Fórum Nacional de Editores Científicos', 'Partilha de experiências; identificação de problemas comuns; propostas de soluções conjuntas.', 'forum', null, null],
                    ['13:00', '14:30', 'Intervalo para Almoço', null, 'lunch', null, null],
                    ['14:30', '16:00', 'Sessão de Trabalho — Proposta de criação da Rede Nacional de Editores Científicos de Angola', 'Modelo de funcionamento; objectivos e plano de acção.', 'other', null, null],
                    ['16:00', '16:15', 'Pausa para Café', null, 'break', null, null],
                    ['16:15', '17:00', 'Sessão Plenária Final', 'Leitura da Carta de Recomendações; aprovação das conclusões; encaminhamentos futuros.', 'plenary', null, null],
                    ['17:00', '17:30', 'Sessão Solene de Encerramento', 'Considerações finais; agradecimentos; encerramento oficial.', 'closing', null, null],
                ],
            ],
        ];

        $rooms = ['Auditório Principal', 'Sala 1', 'Sala 2', 'Sala 3'];

        foreach ($days as $dayNumber => $day) {
            $eventDay = EventDay::updateOrCreate(
                ['event_id' => $event->id, 'day_number' => $dayNumber],
                [
                    'date' => $event->start_date?->copy()->addDays($dayNumber - 1),
                    'title' => $day['title'],
                ]
            );

            // Sessões existentes deste dia são substituídas para o seeder poder correr de novo sem duplicar.
            $eventDay->sessions()->delete();

            foreach ($day['sessions'] as $index => $session) {
                [$start, $end, $title, $description, $type, $speakerName, $moderatorName] = $session + [null, null, null, null, null, null, null];
                $workshopCode = $session[7] ?? null;
                $courseCode = $session[8] ?? null;

                $room = match (true) {
                    in_array($type, ['break', 'lunch']) => null,
                    $workshopCode === 'Oficina A' => 'Sala 1',
                    $workshopCode === 'Oficina B' => 'Sala 2',
                    $workshopCode === 'Oficina C' => 'Sala 3',
                    $courseCode !== null => $rooms[($index % 3) + 1],
                    default => $rooms[0],
                };

                EventSession::create([
                    'event_day_id' => $eventDay->id,
                    'start_time' => $start,
                    'end_time' => $end,
                    'title' => $title,
                    'description' => $description,
                    'type' => $type,
                    'room_location' => $room,
                    'modality' => 'presencial',
                    'workshop_id' => $workshopCode ? $workshop($workshopCode) : null,
                    'course_id' => $courseCode ? $course($courseCode) : null,
                    'moderator_speaker_id' => $moderatorName ? $speaker($moderatorName) : null,
                    'sort_order' => $index,
                ]);
            }
        }

        // Associa palestrantes (papel "palestrante") às sessões de palestra magna.
        $this->attachSpeaker($event, 1, 'Palestra Magna I', 'Teresa Mavinga Sacadura');
        $this->attachSpeaker($event, 2, 'Palestra Magna II', 'Ricardo Miguel Bumba');
        $this->attachSpeaker($event, 3, 'Palestra Magna III', 'João Baptista Sackaita');
    }

    private function attachSpeaker(Event $event, int $dayNumber, string $titleContains, string $speakerName): void
    {
        $session = EventSession::whereHas('eventDay', fn ($q) => $q->where('event_id', $event->id)->where('day_number', $dayNumber))
            ->where('title', $titleContains)
            ->first();

        $speaker = Speaker::where('slug', Str::slug($speakerName))->first();

        if ($session && $speaker && ! $session->speakers()->where('speaker_id', $speaker->id)->exists()) {
            $session->speakers()->attach($speaker->id, ['role_in_session' => 'palestrante']);
        }
    }
}
