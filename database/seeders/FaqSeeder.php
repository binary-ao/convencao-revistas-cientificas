<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Faq;
use Illuminate\Database\Seeder;

/**
 * FAQ de EXEMPLO — perguntas logísticas plausíveis. Não afirma valores de
 * inscrição (não definidos no Termo); a pergunta sobre custos fica em aberto
 * de propósito.
 */
class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::current();

        $faqs = [
            ['Como posso inscrever-me na Convenção?', 'A inscrição é feita online, na página de Inscrição. Não é necessário criar conta — no final do processo recebe um código único e o comprovativo por email.'],
            ['A inscrição tem custo?', 'Os valores de inscrição, quando aplicável, serão publicados nesta página antes da abertura oficial das inscrições.'],
            ['Posso participar apenas online?', 'Sim. A Convenção adopta um formato híbrido — pode optar por participação presencial ou online na etapa de Participação do formulário de inscrição.'],
            ['Como escolho os workshops e cursos?', 'A selecção de workshops e cursos é feita na etapa "Actividades" do formulário de inscrição, mostrando apenas as vagas ainda disponíveis.'],
            ['Vou receber um certificado de participação?', 'Sim. Os certificados são emitidos após a Convenção e disponibilizados para download; o código de cada certificado pode ser validado publicamente no site.'],
            ['Como obtenho o comprovativo da minha inscrição?', 'O comprovativo em PDF é enviado por email imediatamente após a inscrição e fica também disponível para download na página de sucesso.'],
            ['Perdi o meu comprovativo — como o recupero?', 'Utilize a página "Consultar Inscrição", indicando o código da inscrição e o email utilizado no registo.'],
        ];

        foreach ($faqs as $index => [$question, $answer]) {
            Faq::updateOrCreate(
                ['event_id' => $event->id, 'question' => $question],
                ['answer' => $answer, 'sort_order' => $index, 'is_published' => true]
            );
        }
    }
}
