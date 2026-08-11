<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Speaker;
use App\Models\Workshop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * As 3 oficinas práticas efectivamente calendarizadas no programa de 3 dias
 * do Termo de Referência (secção 5.3 / Dia 2). Formador, sala e capacidade
 * são EXEMPLO.
 */
class WorkshopSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::current();

        $workshops = [
            [
                'code' => 'Oficina A',
                'name' => 'Gestão editorial com plataformas digitais (OJS)',
                'description' => 'Introdução prática à gestão de revistas científicas através do Open Journal Systems (OJS): fluxo editorial, submissão, avaliação por pares e publicação.',
                'trainer' => 'Paulo Sérgio N\'Gunza',
                'room' => 'Sala 1',
                'capacity' => 40,
            ],
            [
                'code' => 'Oficina B',
                'name' => 'Normalização de artigos científicos e metadados',
                'description' => 'Boas práticas de normalização de artigos científicos e estruturação de metadados para interoperabilidade e indexação.',
                'trainer' => 'Carlos Alberto Wanga',
                'room' => 'Sala 2',
                'capacity' => 35,
            ],
            [
                'code' => 'Oficina C',
                'name' => 'Organização e gestão da avaliação por pares',
                'description' => 'Modelos de avaliação por pares, selecção de revisores e gestão do processo editorial de avaliação científica.',
                'trainer' => 'Isabel Muatxitxi Neto',
                'room' => 'Sala 3',
                'capacity' => 35,
            ],
        ];

        foreach ($workshops as $index => $workshop) {
            $trainer = Speaker::where('slug', Str::slug($workshop['trainer']))->first();

            Workshop::updateOrCreate(
                ['event_id' => $event->id, 'code' => $workshop['code']],
                [
                    'name' => $workshop['name'],
                    'description' => $workshop['description'],
                    'trainer_speaker_id' => $trainer?->id,
                    'date' => $event->start_date?->copy()->addDay(),
                    'start_time' => '14:30',
                    'end_time' => '16:00',
                    'room' => $workshop['room'],
                    'modality' => 'presencial',
                    'capacity' => $workshop['capacity'],
                    'is_active' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }
}
