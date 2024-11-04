<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsignacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('asignaciones')->insert([
            [
                'id_proyecto' => 1,
                'id_estudiante' => 1,
                'id_tutor' => 1,
                'fecha_asignacion' => Carbon::create(2024, 1, 10)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 2,
                'id_estudiante' => 2,
                'id_tutor' => 2,
                'fecha_asignacion' => Carbon::create(2024, 2, 15)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 3,
                'id_estudiante' => 3,
                'id_tutor' => 1,
                'fecha_asignacion' => Carbon::create(2024, 3, 20)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 4,
                'id_estudiante' => 4,
                'id_tutor' => 2,
                'fecha_asignacion' => Carbon::create(2024, 4, 25)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 5,
                'id_estudiante' => 5,
                'id_tutor' => 1,
                'fecha_asignacion' => Carbon::create(2024, 5, 30)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 6,
                'id_estudiante' => 6,
                'id_tutor' => 2,
                'fecha_asignacion' => Carbon::create(2024, 6, 5)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 7,
                'id_estudiante' => 7,
                'id_tutor' => 1,
                'fecha_asignacion' => Carbon::create(2024, 7, 10)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 8,
                'id_estudiante' => 8,
                'id_tutor' => 2,
                'fecha_asignacion' => Carbon::create(2024, 8, 15)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 9,
                'id_estudiante' => 9,
                'id_tutor' => 1,
                'fecha_asignacion' => Carbon::create(2024, 9, 20)->format('Y-m-d'),
            ],
            [
                'id_proyecto' => 10,
                'id_estudiante' => 10,
                'id_tutor' => 2,
                'fecha_asignacion' => Carbon::create(2024, 10, 25)->format('Y-m-d'),
            ]
        ]);
    }
}

