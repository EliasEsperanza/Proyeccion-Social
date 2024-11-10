<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados')->insert([
            ['nombre_estado' => 'INSCRIPCION'],
            ['nombre_estado' => 'EJECUCION'],
            ['nombre_estado' => 'INFORME'],
            ['nombre_estado' => 'FINALIZACION (MEMORIA)'],
            ['nombre_estado' => 'CERTIFICACION'],
        ]);
    }
}
