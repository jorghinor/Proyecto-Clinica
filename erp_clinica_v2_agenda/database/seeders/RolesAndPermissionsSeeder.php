<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear Roles
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleMedico = Role::create(['name' => 'Medico']);
        $roleRecepcionista = Role::create(['name' => 'Recepcionista']);

        // Crear Permisos (Ejemplos)
        Permission::create(['name' => 'ver pacientes']);
        Permission::create(['name' => 'editar pacientes']);
        Permission::create(['name' => 'ver historia clinica']);
        Permission::create(['name' => 'editar historia clinica']);
        Permission::create(['name' => 'ver facturacion']);

        // Asignar permisos a roles
        $roleMedico->givePermissionTo(['ver pacientes', 'editar pacientes', 'ver historia clinica', 'editar historia clinica']);
        $roleRecepcionista->givePermissionTo(['ver pacientes', 'editar pacientes', 'ver facturacion']);

        // Admin tiene todo (usaremos Gate::before en AuthServiceProvider para dar super-admin)
    }
}
