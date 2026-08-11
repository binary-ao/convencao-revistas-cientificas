<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

/**
 * Semeia a Convenção. Conteúdo institucional (nome, enquadramento, temas) vem
 * do Termo de Referência; data, local, contactos e formato são EXEMPLO —
 * pedido explícito do cliente para o site não parecer vazio antes dos dados
 * oficiais existirem. Tudo isto é editável em /admin/event-settings.
 */
class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::updateOrCreate(
            ['slug' => '1a-convencao-nacional-revistas-cientificas-angolanas'],
            [
                'name' => '1ª Convenção Nacional de Revistas Científicas Angolanas',
                'short_description' => 'Qualidade, ética, visibilidade e internacionalização das revistas científicas angolanas.',
                'long_description' => 'A produção e a disseminação do conhecimento científico em Angola têm registado avanços '
                    .'significativos na última década, com o surgimento e consolidação de revistas científicas nas '
                    .'Instituições de Ensino Superior (IES) e centros de investigação. Contudo, persistem desafios '
                    .'relacionados com qualidade editorial, indexação internacional, ética em publicação científica, '
                    .'sustentabilidade, digitalização e cooperação interinstitucional. Neste contexto, a 1ª Convenção '
                    .'Nacional de Revistas Científicas Angolanas surge como um espaço estratégico de reflexão, '
                    .'capacitação, articulação e construção coletiva, reunindo editores, gestores editoriais, '
                    .'revisores, investigadores, bibliotecários, decisores institucionais e parceiros nacionais e '
                    .'internacionais.',

                // --- Exemplo, a confirmar pela organização ---
                'start_date' => '2026-11-25',
                'end_date' => '2026-11-27',
                'venue_name' => 'Centro de Convenções de Talatona',
                'address' => 'Via A6, Talatona',
                'city' => 'Luanda',
                'country' => 'Angola',
                'contact_email' => 'convencao@exemplo.org',
                'contact_phone' => '+244 900 000 000',

                'format' => 'presencial',
                'status' => 'published',
                'registration_open' => true,
                'is_current' => true,
            ]
        );
    }
}
