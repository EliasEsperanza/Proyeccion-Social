<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        try {
            // Revisar si existen las secciones
            $secciones = Seccion::all();
            
            if ($secciones->isEmpty()) {
                throw new \Exception('Debes crear secciones antes de crear estudiantes');
            }

            // Creamos los estudiantes
            for ($i = 0; $i < 50; $i++) {
                // Crear usuario
                $usuario = User::create([
                    'name' => 'Estudiante ' . ($i + 1),
                    'email' => 'estudiante' . ($i + 1) . '@ejemplo.com',
                    'password' => bcrypt('password'),
                    'role' => 'estudiante'
                ]);
                
                
                Estudiante::create([
                    'id_usuario' => $usuario->id,
                    'id_seccion' => $secciones->random()->id_seccion,
                    'porcentaje_completado' => rand(0, 100),
                    'horas_sociales_completadas' => rand(0, 500)
                ]);
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}
