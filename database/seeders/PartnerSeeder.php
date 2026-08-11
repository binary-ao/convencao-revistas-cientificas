<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

/**
 * Organizações do Termo de Referência (secção "Proposta de Organizações
 * Internacionais a Convidar"). Todas entram como "proposto" — o Termo
 * apresenta-as como convites sugeridos, não como parcerias confirmadas.
 */
class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            'ciencia_politica' => [
                ['name' => 'UNESCO', 'description' => 'Liderança global em Ciência Aberta, políticas científicas e fortalecimento de sistemas nacionais de ciência.'],
                ['name' => 'International Science Council', 'description' => 'Integração entre ciência, ética, impacto social e governança científica.'],
                ['name' => 'OECD', 'description' => 'Referência em políticas de ciência, tecnologia e inovação.'],
                ['name' => 'African Union', 'description' => 'Alinhamento com a Agenda 2063 e políticas africanas de ciência e inovação.'],
            ],
            'edicao_indexacao' => [
                ['name' => 'DOAJ', 'description' => 'Referência mundial em revistas de acesso aberto e boas práticas editoriais.'],
                ['name' => 'Crossref', 'description' => 'Essencial para DOI, metadados e interoperabilidade das revistas.'],
                ['name' => 'Scopus', 'description' => 'Orientações sobre critérios de indexação e impacto científico.'],
                ['name' => 'Web of Science', 'description' => 'Critérios de qualidade, métricas e internacionalização.'],
            ],
            'ciencia_aberta' => [
                ['name' => 'OpenAIRE', 'description' => 'Infraestrutura líder em Ciência Aberta e políticas de acesso aberto.'],
                ['name' => 'LA Referencia', 'description' => 'Modelo de sucesso para redes nacionais de repositórios.'],
                ['name' => 'COAR', 'description' => 'Governança e interoperabilidade de repositórios científicos.'],
                ['name' => 'Creative Commons', 'description' => 'Licenças abertas e direitos autorais na publicação científica.'],
            ],
            'africa_lusofonia' => [
                ['name' => 'African Journals Online', 'description' => 'Principal plataforma de revistas científicas africanas.'],
                ['name' => 'CPLP', 'description' => 'Cooperação científica no espaço lusófono.'],
                ['name' => 'SciELO', 'description' => 'Modelo consolidado de indexação e profissionalização editorial.'],
                ['name' => 'Redalyc', 'description' => 'Alternativa não comercial para visibilidade e impacto das revistas.'],
            ],
        ];

        foreach ($partners as $category => $list) {
            foreach ($list as $index => $partner) {
                Partner::updateOrCreate(
                    ['name' => $partner['name']],
                    [
                        'description' => $partner['description'],
                        'category' => $category,
                        'status' => 'proposto',
                        'sort_order' => $index,
                    ]
                );
            }
        }
    }
}
