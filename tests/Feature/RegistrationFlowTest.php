<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Institution;
use App\Models\ParticipantType;
use App\Models\Registration;
use App\Models\Workshop;
use Database\Seeders\EventSeeder;
use Database\Seeders\InstitutionSeeder;
use Database\Seeders\ParticipantTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Mail::fake();

        $this->seed([EventSeeder::class, InstitutionSeeder::class, ParticipantTypeSeeder::class]);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Ana Paula Sousa',
            'email' => 'ana.sousa@example.test',
            'phone' => '+244 923 000 000',
            'institution_id' => Institution::first()->id,
            'job_title' => 'Investigadora',
            'participant_type_id' => ParticipantType::where('code', 'investigador')->value('id'),
            'modality' => 'presencial',
            'privacy_policy' => '1',
            'confirm_data' => '1',
        ], $overrides);
    }

    public function test_a_visitor_can_register_without_creating_an_account(): void
    {
        $response = $this->post('/inscricao', $this->validPayload());

        $registration = Registration::first();

        $this->assertNotNull($registration);
        $this->assertSame('Ana Paula Sousa', $registration->participant->full_name);
        $this->assertMatchesRegularExpression('/^CNRC-AO-\d{4}-\d{6}$/', $registration->code);
        $response->assertRedirect(route('registration.success', $registration));

        // Nenhuma conta/participante fica autenticado — é um fluxo sem login.
        $this->assertGuest();
    }

    public function test_registration_generates_pdf_and_sends_confirmation_email(): void
    {
        $this->post('/inscricao', $this->validPayload());

        $registration = Registration::first();

        $this->assertNotNull($registration->pdf_path);
        Storage::disk('local')->assertExists($registration->pdf_path);
        $this->assertSame('CNRC-AO-'.now()->year.'-000001', $registration->code);

        Mail::assertSent(\App\Mail\RegistrationConfirmationMail::class, fn ($mail) => $mail->hasTo($registration->participant->email)
        );

        $this->assertDatabaseHas('email_logs', [
            'registration_id' => $registration->id,
            'type' => 'confirmation',
            'status' => 'sent',
        ]);
    }

    public function test_duplicate_email_is_blocked_instead_of_creating_a_second_registration(): void
    {
        $this->post('/inscricao', $this->validPayload());
        $this->post('/inscricao', $this->validPayload(['full_name' => 'Outro Nome']));

        $this->assertSame(1, Registration::count());
    }

    public function test_workshop_capacity_is_enforced(): void
    {
        $event = Event::current();
        $workshop = Workshop::create([
            'event_id' => $event->id,
            'code' => 'Oficina Teste',
            'name' => 'Workshop de Teste',
            'modality' => 'presencial',
            'capacity' => 1,
            'is_active' => true,
        ]);

        $this->post('/inscricao', $this->validPayload(['workshop_ids' => [$workshop->id]]));
        $this->assertSame(0, $workshop->fresh()->availableSpots());
        $this->assertSame(1, $workshop->fresh()->registeredCount());

        $this->post('/inscricao', $this->validPayload([
            'email' => 'segundo.participante@example.test',
            'workshop_ids' => [$workshop->id],
        ]));

        // Workshop lotado: a segunda inscrição inteira é rejeitada (transação
        // revertida), não apenas a selecção do workshop.
        $this->assertSame(1, Registration::count());
        $this->assertSame(0, $workshop->fresh()->availableSpots());
    }

    public function test_missing_required_fields_are_rejected(): void
    {
        $response = $this->post('/inscricao', $this->validPayload(['full_name' => '']));

        $response->assertSessionHasErrors('full_name');
        $this->assertSame(0, Registration::count());
    }

    public function test_registration_requires_privacy_policy_acceptance(): void
    {
        $response = $this->post('/inscricao', $this->validPayload(['privacy_policy' => null]));

        $response->assertSessionHasErrors('privacy_policy');
        $this->assertSame(0, Registration::count());
    }

    public function test_lookup_finds_registration_by_code_and_email(): void
    {
        $this->post('/inscricao', $this->validPayload());
        $registration = Registration::first();

        $response = $this->post('/inscricao/consultar', [
            'code' => $registration->code,
            'email' => $registration->participant->email,
        ]);

        $response->assertOk()->assertSee($registration->code);
    }

    public function test_lookup_does_not_leak_registration_with_wrong_email(): void
    {
        $this->post('/inscricao', $this->validPayload());
        $registration = Registration::first();

        $response = $this->post('/inscricao/consultar', [
            'code' => $registration->code,
            'email' => 'wrong@example.test',
        ]);

        // O código continua a aparecer como placeholder de exemplo no formulário —
        // o que não pode aparecer é o NOME do participante (dado pessoal real).
        $response->assertOk()
            ->assertSee('Não foi encontrada nenhuma inscrição')
            ->assertDontSee($registration->participant->full_name);
    }

    public function test_proof_download_requires_matching_email(): void
    {
        $this->post('/inscricao', $this->validPayload());
        $registration = Registration::first();

        $this->get(route('registration.proof', $registration).'?email=wrong@example.test')
            ->assertForbidden();

        $this->get(route('registration.proof', $registration).'?email='.urlencode($registration->participant->email))
            ->assertOk();
    }
}
