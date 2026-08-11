<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Semeia os módulos administrativos como permissões e agrupa-os nos 5 perfis
 * definidos na secção I da arquitectura. Roles/permissões continuam
 * editáveis depois via /admin/roles — isto é apenas o ponto de partida.
 */
class RolesAndPermissionsSeeder extends Seeder
{
    private const MODULES = [
        'program',        // dias, sessões, oradores, workshops, cursos, instituições
        'participants',
        'registrations',
        'checkin',
        'certificates',
        'content',         // notícias, documentos, galeria, faq
        'partners',
        'communications',
        'reports',
        'users',
        'settings',
        'logs',
    ];

    private const ROLE_PERMISSIONS = [
        'super_admin' => ['*'],
        'event_manager' => ['program.view', 'program.manage', 'participants.view', 'registrations.view', 'partners.view', 'partners.manage', 'reports.view', 'settings.manage'],
        'registrations_manager' => ['participants.view', 'participants.manage', 'registrations.view', 'registrations.manage', 'checkin.view', 'checkin.manage', 'certificates.view', 'certificates.manage', 'communications.manage', 'reports.view', 'reports.manage'],
        'content_editor' => ['content.view', 'content.manage', 'partners.view'],
        'checkin_operator' => ['participants.view', 'registrations.view', 'checkin.view', 'checkin.manage'],
    ];

    public function run(): void
    {
        $permissions = collect();

        foreach (self::MODULES as $module) {
            foreach (['view', 'manage'] as $action) {
                $permissions->push("{$module}.{$action}");
            }
        }

        $permissions->push('registrations.cancel', 'registrations.resend');

        $permissions->each(fn (string $name) => Permission::findOrCreate($name, 'web'));

        foreach (self::ROLE_PERMISSIONS as $roleName => $rolePermissions) {
            $role = Role::findOrCreate($roleName, 'web');

            if ($rolePermissions === ['*']) {
                $role->syncPermissions(Permission::where('guard_name', 'web')->get());

                continue;
            }

            $role->syncPermissions($rolePermissions);
        }
    }
}
