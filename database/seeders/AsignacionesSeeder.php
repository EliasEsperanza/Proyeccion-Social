<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Estudiante;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\Asignacion;
class AsignacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $estudiantes = Estudiante::all();
        $proyectos = Proyecto::all();
        $tutores = User::role('Tutor')->get();
        foreach ($estudiantes as $estudiante) {
            try {
                $proyecto = $proyectos->random();
                $tutor = $tutores->random();

                Asignacion::create([
                    'id_proyecto' => $proyecto->id_proyecto,
                    'id_estudiante' => $estudiante->id_estudiante,
                    'id_tutor' => $tutor->id_usuario,
                    'fecha_asignacion' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
                ]);
            } catch (\Exception $e) {
                $this->command->error("Error al crear asignación para estudiante {$estudiante->id_estudiante}: " . $e->getMessage());
            }
        }
    }
}