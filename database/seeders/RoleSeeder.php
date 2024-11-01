<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'ver Proyectos']);
        Permission::create(['name' => 'crear Proyectos']);
        Permission::create(['name' => 'editar Proyectos']);
        Permission::create(['name' => 'eliminar Proyectos']);
        Permission::create(['name' => 'asignar Proyectos']);
        Permission::create(['name' => 'asignar Tutor']);

        $rolAdmin = Role::create(['name' => 'Administrador']);
        $rolCoordinador = Role::create(['name' => 'Coordinador']);
        $rolTutor = Role::create(['name' => 'Tutor']);
        $rolEstudiante = Role::create(['name' => 'Estudiante']);

        $rolAdmin->givePermissionTo(Permission::all());

        $rolCoordinador->givePermissionTo([
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'ver Proyectos',
            'crear Proyectos',
            'editar Proyectos'
        ]);

        $rolTutor->givePermissionTo([
            'ver Proyectos',
            'editar Proyectos',
        ]);

        $rolEstudiante->givePermissionTo([
            'ver Proyectos'
        ]);
    }
}
