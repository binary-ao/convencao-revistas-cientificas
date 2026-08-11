<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;

/**
 * Instituições de EXEMPLO — nomes genéricos, sem correspondência a uma
 * instituição real específica, para não sugerir associação não confirmada.
 */
class InstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $institutions = [
            ['name' => 'Universidade Nacional de Angola', 'acronym' => 'UNA', 'type' => 'ies', 'city' => 'Luanda'],
            ['name' => 'Instituto Politécnico de Luanda', 'acronym' => 'IPL', 'type' => 'ies', 'city' => 'Luanda'],
            ['name' => 'Universidade do Planalto Central', 'acronym' => 'UPC', 'type' => 'ies', 'city' => 'Huambo'],
            ['name' => 'Instituto Superior de Ciências da Saúde', 'acronym' => 'ISCISA', 'type' => 'ies', 'city' => 'Benguela'],
            ['name' => 'Centro de Investigação Científica do Kwanza', 'acronym' => 'CICK', 'type' => 'centro_investigacao', 'city' => 'Sumbe'],
            ['name' => 'Biblioteca Nacional de Angola', 'acronym' => 'BNA', 'type' => 'orgao_governamental', 'city' => 'Luanda'],
            ['name' => 'Rede Angolana de Editores Científicos', 'acronym' => 'RAEC', 'type' => 'rede_cientifica', 'city' => 'Luanda'],
            ['name' => 'Revista Angolana de Ciência e Sociedade', 'acronym' => 'RACS', 'type' => 'revista_cientifica', 'city' => 'Lubango'],
        ];

        foreach ($institutions as $institution) {
            Institution::updateOrCreate(
                ['acronym' => $institution['acronym']],
                $institution + ['country' => 'Angola']
            );
        }
    }
}
