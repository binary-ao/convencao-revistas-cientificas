<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_admin_can_log_in_with_correct_credentials(): void
    {
        $user = User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@test.local',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        $user->assignRole('super_admin');

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.local',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@test.local',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.local',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_deactivated_account_cannot_log_in(): void
    {
        User::create([
            'name' => 'Ex-funcionário',
            'email' => 'inactive@test.local',
            'password' => Hash::make('password123'),
            'is_active' => false,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'inactive@test.local',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_deactivating_a_user_mid_session_immediately_logs_them_out(): void
    {
        $user = User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@test.local',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        $user->assignRole('super_admin');

        $this->actingAs($user)->get('/admin')->assertOk();

        $user->update(['is_active' => false]);

        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_user_without_permission_cannot_manage_speakers(): void
    {
        $user = User::create([
            'name' => 'Operador Check-in',
            'email' => 'checkin@test.local',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);
        $user->assignRole('checkin_operator');

        $this->actingAs($user)->get('/admin/speakers')->assertForbidden();
    }
}
