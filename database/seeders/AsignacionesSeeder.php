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
        // Obtener todos los estudiantes, proyectos y tutores
        $estudiantes = Estudiante::all();
        $proyectos = Proyecto::all();
        $tutores = User::role('Tutor')->get();
        
        // Verificar si hay datos en las tablas necesarias
        if ($estudiantes->isEmpty() || $proyectos->isEmpty() || $tutores->isEmpty()) {
            throw new \Exception('Probablemente no hay datos de Estudiantes, datos de Proyectos o datos de Tutor');
        }

        // Iterar sobre los estudiantes y asignarles un proyecto y tutor aleatorio
        foreach ($estudiantes as $estudiante) {
            Asignacion::create([
                'id_proyecto' => $proyectos->random()->id_proyecto, // Asumiendo que la columna se llama id_proyecto
                'id_estudiante' => $estudiante->id_estudiante, // Asumiendo que la columna se llama id_estudiante
                'id_tutor' => $tutores->random()->id_usuario, // Asumiendo que la columna se llama id_usuario
                'fecha_asignacion' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'), // Cambiado el formato de fecha
            ]);
        }
    }
}