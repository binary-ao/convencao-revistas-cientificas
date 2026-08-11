<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Institution;
use App\Models\Participant;
use App\Models\ParticipantType;
use App\Models\Registration;
use App\Models\User;
use Database\Seeders\EventSeeder;
use Database\Seeders\InstitutionSeeder;
use Database\Seeders\ParticipantTypeSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CheckinAndCertificateTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Registration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Mail::fake();

        $this->seed([EventSeeder::class, InstitutionSeeder::class, ParticipantTypeSeeder::class, RolesAndPermissionsSeeder::class]);

        $this->admin = User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@test.local',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        $this->admin->assignRole('super_admin');

        $participant = Participant::create([
            'full_name' => 'Carla Mendes',
            'email' => 'carla@example.test',
            'phone' => '+244 923 111 111',
            'institution_id' => Institution::first()->id,
            'job_title' => 'Bibliotecária',
            'participant_type_id' => ParticipantType::where('code', 'bibliotecario')->value('id'),
            'privacy_policy_accepted_at' => now(),
        ]);

        $this->registration = Registration::create([
            'event_id' => Event::current()->id,
            'participant_id' => $participant->id,
            'code' => 'CNRC-AO-2026-000001',
            'status' => 'confirmed',
            'modality' => 'presencial',
            'submitted_at' => now(),
            'source' => 'admin',
        ]);
    }

    public function test_admin_can_confirm_checkin(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.checkin.confirm', $this->registration));

        $response->assertRedirect();
        $this->assertSame('checked_in', $this->registration->fresh()->checkin_status);
        $this->assertNotNull($this->registration->fresh()->checkin);
    }

    public function test_checkin_is_idempotent(): void
    {
        $this->actingAs($this->admin)->post(route('admin.checkin.confirm', $this->registration));
        $firstCheckinTime = $this->registration->fresh()->checkin->checked_in_at;

        $this->actingAs($this->admin)->post(route('admin.checkin.confirm', $this->registration));

        $this->assertSame(1, $this->registration->fresh()->checkin()->count());
        $this->assertEquals($firstCheckinTime, $this->registration->fresh()->checkin->checked_in_at);
    }

    public function test_admin_can_issue_certificate_and_it_becomes_publicly_valid(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.certificates.issue', $this->registration))
            ->assertRedirect();

        $certificate = $this->registration->fresh()->certificate;

        $this->assertNotNull($certificate);
        $this->assertSame('issued', $certificate->status);
        Storage::disk('local')->assertExists($certificate->pdf_path);

        $response = $this->post('/certificado/validar', ['code' => $certificate->code]);

        $response->assertOk()->assertSee('Carla Mendes')->assertSee($certificate->code);
    }

    public function test_unissued_certificate_code_does_not_validate(): void
    {
        $response = $this->post('/certificado/validar', ['code' => 'CERT-AO-2026-999999']);

        $response->assertOk()->assertDontSee('Certificado Válido');
    }
}
