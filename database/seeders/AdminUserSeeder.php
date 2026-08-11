<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Cria a primeira conta de acesso ao /admin. Credenciais configuráveis via
 * .env para não ficar um utilizador previsível em ambientes partilhados.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@cnrca.ao');
        $password = env('ADMIN_PASSWORD', 'password');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrador CNRCA',
                'password' => $password,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        if (! $user->hasRole('super_admin')) {
            $user->assignRole('super_admin');
        }

        if ($password === 'password') {
            $this->command?->warn('AdminUserSeeder: a usar a password por omissão "password" — defina ADMIN_EMAIL/ADMIN_PASSWORD no .env antes de produção.');
        }
    }
}
