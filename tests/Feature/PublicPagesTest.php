<?php

namespace Tests\Feature;

use Database\Seeders\EventSeeder;
use Database\Seeders\FaqSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([EventSeeder::class, FaqSeeder::class]);
    }

    /**
     * @dataProvider publicRoutesProvider
     */
    public function test_public_page_loads_successfully(string $route): void
    {
        $this->get($route)->assertOk();
    }

    public static function publicRoutesProvider(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/sobre'],
            'program' => ['/programa'],
            'speakers' => ['/oradores'],
            'workshops' => ['/workshops'],
            'courses' => ['/cursos'],
            'partners' => ['/parceiros'],
            'news' => ['/noticias'],
            'documents' => ['/documentos'],
            'gallery' => ['/galeria'],
            'faq' => ['/faq'],
            'contacts' => ['/contactos'],
            'registration form' => ['/inscricao'],
            'registration lookup' => ['/inscricao/consultar'],
            'privacy policy' => ['/politica-de-privacidade'],
            'terms' => ['/termos'],
            'certificate validation' => ['/certificado/validar'],
        ];
    }

    public function test_home_page_does_not_show_fake_countdown_when_date_is_missing(): void
    {
        $event = \App\Models\Event::current();
        $event->update(['start_date' => null, 'end_date' => null]);

        // O script de contagem decrescente é sempre incluído no HTML (referencia
        // o id "eventCountdown" no próprio código-fonte JS), por isso a garantia
        // real é a mensagem de fallback — não a ausência literal do id no HTML.
        $this->get('/')->assertOk()->assertSee('A contagem decrescente será activada');
    }

    public function test_admin_area_redirects_guests_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }
}
