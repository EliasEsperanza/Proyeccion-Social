<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(SeccionSeeder::class);
        $this->call(TutoresSeeder::class);
        $this->call(EstudianteSeeder::class);
        $this->call(ProyectoSeeder::class);
        $this->call(DocumentosSeeder::class);
        $this->call(AsignacionesSeeder::class);
        $this->call(ProyectosEstudiantesSeeder::class);
        $this->call(TutorSeccionSeeder::class);
    }
}
