<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectosEstudiantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proyectos_estudiantes')->insert([
            ['id_proyecto' => 1, 'id_estudiante' => 1],
            ['id_proyecto' => 2, 'id_estudiante' => 2],
            ['id_proyecto' => 3, 'id_estudiante' => 3],     
        ]);
    }
}
