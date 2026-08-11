<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

/**
 * Destaques de EXEMPLO para o carrossel da Home. Sem imagens carregadas —
 * usam o padrão gráfico institucional por omissão. Substituíveis a qualquer
 * momento em /admin/hero-slides.
 */
class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::current();

        $slides = [
            [
                'eyebrow' => '1ª Convenção Nacional',
                'title' => 'de Revistas Científicas Angolanas',
                'subtitle' => 'Qualidade, ética, visibilidade e internacionalização da produção científica angolana.',
                'cta_label' => 'Ver Programa',
                'cta_url' => '/programa',
            ],
            [
                'eyebrow' => 'Palestras Magnas',
                'title' => 'O papel estratégico das revistas científicas em Angola',
                'subtitle' => 'Três palestras magnas sobre internacionalização, transformação digital e ciência aberta.',
                'cta_label' => 'Conhecer os oradores',
                'cta_url' => '/oradores',
            ],
            [
                'eyebrow' => 'Fórum Nacional de Editores Científicos',
                'title' => 'Rumo a uma Rede Nacional de Editores Científicos',
                'subtitle' => 'Um espaço aberto para partilha de experiências e construção colectiva de soluções.',
                'cta_label' => 'Saber mais',
                'cta_url' => '/sobre',
            ],
        ];

        foreach ($slides as $index => $slide) {
            HeroSlide::updateOrCreate(
                ['event_id' => $event->id, 'title' => $slide['title']],
                $slide + ['is_active' => true, 'sort_order' => $index]
            );
        }
    }
}
