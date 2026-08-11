<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\Speaker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Oradores de EXEMPLO — nomes e biografias fictícios, sem correspondência a
 * pessoas reais identificáveis. Substituir pelos palestrantes confirmados
 * assim que forem conhecidos (ver "Pontos em aberto" da arquitectura).
 */
class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $una = Institution::where('acronym', 'UNA')->first();
        $ipl = Institution::where('acronym', 'IPL')->first();
        $upc = Institution::where('acronym', 'UPC')->first();
        $iscisa = Institution::where('acronym', 'ISCISA')->first();
        $cick = Institution::where('acronym', 'CICK')->first();
        $bna = Institution::where('acronym', 'BNA')->first();
        $raec = Institution::where('acronym', 'RAEC')->first();
        $racs = Institution::where('acronym', 'RACS')->first();

        $speakers = [
            ['name' => 'Manuel Kiala Sabino', 'job_title' => 'Editor-chefe', 'institution_id' => $racs?->id, 'bio' => 'Editor-chefe com percurso na coordenação editorial de publicações científicas angolanas.'],
            ['name' => 'Ana Beatriz Chindongo', 'job_title' => 'Docente universitária', 'institution_id' => $una?->id, 'bio' => 'Docente e investigadora com interesse em avaliação por pares e qualidade editorial.'],
            ['name' => 'Isabel Muatxitxi Neto', 'job_title' => 'Bibliotecária', 'institution_id' => $bna?->id, 'bio' => 'Responsável por serviços de informação científica e integridade editorial.'],
            ['name' => 'João Baptista Sackaita', 'job_title' => 'Investigador', 'institution_id' => $upc?->id, 'bio' => 'Investigador com trabalho em ciência aberta e acesso aberto ao conhecimento.'],
            ['name' => 'Carlos Alberto Wanga', 'job_title' => 'Técnico de plataformas digitais', 'institution_id' => $raec?->id, 'bio' => 'Especialista em plataformas de gestão editorial e indexação de revistas científicas.'],
            ['name' => 'Fernanda Luyeye Paulo', 'job_title' => 'Gestora editorial', 'institution_id' => $iscisa?->id, 'bio' => 'Gestora editorial dedicada à normalização de processos de publicação científica.'],
            ['name' => 'Domingos Sumbo Kalunga', 'job_title' => 'Dirigente de IES', 'institution_id' => $ipl?->id, 'bio' => 'Dirigente institucional com foco na sustentabilidade das revistas científicas.'],
            ['name' => 'Ricardo Miguel Bumba', 'job_title' => 'Investigador convidado', 'institution_id' => $cick?->id, 'bio' => 'Investigador convidado, com trabalho em métricas científicas e avaliação da produção académica.'],
            ['name' => 'Teresa Mavinga Sacadura', 'job_title' => 'Palestrante convidada', 'institution_id' => null, 'country' => 'Moçambique', 'bio' => 'Palestrante convidada internacional, com percurso em internacionalização da ciência africana.'],
            ['name' => 'Paulo Sérgio N\'Gunza', 'job_title' => 'Formador', 'institution_id' => $raec?->id, 'bio' => 'Formador em plataformas de gestão editorial digital, incluindo OJS.'],
        ];

        foreach ($speakers as $speaker) {
            Speaker::updateOrCreate(
                ['slug' => Str::slug($speaker['name'])],
                $speaker + ['country' => $speaker['country'] ?? 'Angola', 'is_published' => true]
            );
        }
    }
}
