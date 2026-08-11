<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Os 4 cursos de curta duração do Termo (secção 5.4). Os 3 primeiros estão
 * calendarizados no programa de 3 dias (Dia 2); o 4º ainda não tem horário
 * atribuído no Termo, por isso fica sem data/sala — fiel à fonte, não a uma
 * omissão nossa. Formador, sala e capacidade dos 3 primeiros são EXEMPLO.
 */
class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::current();

        $courses = [
            [
                'code' => 'Curso 1',
                'name' => 'Formação de editores científicos',
                'description' => 'Competências essenciais para a função de editor científico: gestão do fluxo editorial, relação com autores e revisores, e decisões editoriais.',
                'trainer' => 'Manuel Kiala Sabino',
                'room' => 'Sala 1',
                'scheduled' => true,
            ],
            [
                'code' => 'Curso 2',
                'name' => 'Formação de revisores científicos',
                'description' => 'Princípios e prática da avaliação por pares: critérios de qualidade, ética na revisão e elaboração de pareceres construtivos.',
                'trainer' => 'Ana Beatriz Chindongo',
                'room' => 'Sala 2',
                'scheduled' => true,
            ],
            [
                'code' => 'Curso 3',
                'name' => 'Escrita científica e comunicação académica',
                'description' => 'Estrutura e estilo do artigo científico, comunicação clara de resultados de investigação e boas práticas de escrita académica.',
                'trainer' => 'Domingos Sumbo Kalunga',
                'room' => 'Sala 3',
                'scheduled' => true,
            ],
            [
                'code' => 'Curso 4',
                'name' => 'Métricas científicas e avaliação da produção académica',
                'description' => 'Indicadores bibliométricos, índices de citação e o seu papel na avaliação da produção científica institucional e individual.',
                'trainer' => 'Ricardo Miguel Bumba',
                'room' => null,
                'scheduled' => false,
            ],
        ];

        foreach ($courses as $index => $course) {
            $trainer = Speaker::where('slug', Str::slug($course['trainer']))->first();

            Course::updateOrCreate(
                ['event_id' => $event->id, 'code' => $course['code']],
                [
                    'name' => $course['name'],
                    'description' => $course['description'],
                    'trainer_speaker_id' => $trainer?->id,
                    'date' => $course['scheduled'] ? $event->start_date?->copy()->addDay() : null,
                    'start_time' => $course['scheduled'] ? '16:15' : null,
                    'end_time' => $course['scheduled'] ? '17:45' : null,
                    'room' => $course['room'],
                    'modality' => 'presencial',
                    'capacity' => 30,
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }
}
