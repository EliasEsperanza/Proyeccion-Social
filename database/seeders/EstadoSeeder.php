<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    public function run()
    {
        Estado::insert([
            ['nombre_estado' => 'Disponible'],
            ['nombre_estado' => 'Inscripción'],
            ['nombre_estado' => 'Anteproyecto'],
            ['nombre_estado' => 'Informe del 50%'],
            ['nombre_estado' => 'finalización (Memoria)'],
            ['nombre_estado' => 'Certificación'],
            ['nombre_estado' => 'Rechazado'],
            ['nombre_estado' => 'En Revisión'],
            ['nombre_estado' => 'Solicitud'],
            ['nombre_estado' => 'Aprobado'],
        ]);
    }
}

