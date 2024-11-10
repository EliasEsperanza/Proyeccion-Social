<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
    class ProyectoSeeder extends Seeder
{
    public function run(): void 
    {
        $proyectos = [
            [
                'nombre_proyecto' => 'Reforestación Parque Nacional',
                'descripcion_proyecto' => 'Proyecto de reforestación y conservación ambiental en zonas afectadas del parque nacional.',
                'horas_requeridas' => 120,
                'estado' => 'activo',
                'periodo' => '2024-1',
                'lugar' => 'Parque Nacional Los Volcanes',
                'coordinador' => 1, // Asegúrate que este ID exista en la tabla users
                'fecha_inicio' => '2024-01-15',
                'fecha_fin' => '2024-06-15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre_proyecto' => 'Alfabetización Digital',
                'descripcion_proyecto' => 'Programa de capacitación en herramientas digitales básicas para adultos mayores.',
                'horas_requeridas' => 80,
                'estado' => 'activo',
                'periodo' => '2024-1',
                'lugar' => 'Centro Comunitario San Miguel',
                'coordinador' => 2, // Asegúrate que este ID exista en la tabla users
                'fecha_inicio' => '2024-02-01',
                'fecha_fin' => '2024-05-30',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre_proyecto' => 'Huerto Urbano Comunitario',
                'descripcion_proyecto' => 'Implementación de huertos urbanos para promover la agricultura sostenible.',
                'horas_requeridas' => 100,
                'estado' => 'planificado',
                'periodo' => '2024-2',
                'lugar' => 'Comunidad El Progreso',
                'coordinador' => 1, // Asegúrate que este ID exista en la tabla users
                'fecha_inicio' => '2024-07-01',
                'fecha_fin' => '2024-12-15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('proyectos')->insert($proyectos);
    }
}

