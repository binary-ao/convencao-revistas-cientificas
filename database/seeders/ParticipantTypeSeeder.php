<?php

namespace Database\Seeders;

use App\Models\ParticipantType;
use Illuminate\Database\Seeder;

/**
 * As 13 categorias fixas do público-alvo (secção 21/29 do Termo) — usadas
 * como taxonomia fechada na Etapa 3 da inscrição, não texto livre.
 */
class ParticipantTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'editor_chefe' => 'Editor-chefe',
            'editor_associado' => 'Editor associado',
            'gestor_editorial' => 'Gestor editorial',
            'tecnico_plataforma' => 'Técnico de plataforma digital',
            'investigador' => 'Investigador',
            'docente_universitario' => 'Docente universitário',
            'bibliotecario' => 'Bibliotecário',
            'gestor_repositorio' => 'Gestor de repositório',
            'dirigente_ies' => 'Dirigente de IES',
            'estudante_pos_graduacao' => 'Estudante de pós-graduação',
            'representante_governamental' => 'Representante governamental',
            'agencia_fomento' => 'Agência de fomento',
            'outro' => 'Outro',
        ];

        foreach (array_values($types) as $index => $label) {
            ParticipantType::updateOrCreate(
                ['code' => array_keys($types)[$index]],
                ['label' => $label, 'sort_order' => $index, 'is_active' => true]
            );
        }
    }
}
