<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seccion;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
{
    
    public function run(): void
    {
        try {
            $secciones = Seccion::all();
            
            if ($secciones->isEmpty()) {
                throw new \Exception('Debes crear secciones antes de crear estudiantes');
            }

            $estudiantes = [
                ['name' => 'Carlos Eduardo Martínez', 'email' => 'carlos.martinez2024@example.com'],
                ['name' => 'Andrea Michelle López', 'email' => 'andrea.lopez98@example.com'],
                ['name' => 'José Alberto Ramírez', 'email' => 'jose.ramirez01@example.com'],
                ['name' => 'María Fernanda Castro', 'email' => 'mafe.castro99@example.com'],
                ['name' => 'Daniel Alexander Pérez', 'email' => 'daniel.perez02@example.com'],
                ['name' => 'Sofia Isabella Morales', 'email' => 'sofi.morales00@example.com'],
                ['name' => 'Luis Fernando González', 'email' => 'luisfer.gonzalez@example.com'],
                ['name' => 'Ana Gabriela Mendoza', 'email' => 'anagaby.mendoza@example.com'],
                ['name' => 'Diego Alejandro Torres', 'email' => 'diego.torres03@example.com'],
                ['name' => 'Valeria Nicole Flores', 'email' => 'vale.flores99@example.com'],
                ['name' => 'Roberto Carlos Santos', 'email' => 'roberto.santos01@example.com'],
                ['name' => 'Carmen Elena Rivas', 'email' => 'carmen.rivas02@example.com'],
                ['name' => 'Jorge Alberto Mejía', 'email' => 'jorge.mejia00@example.com'],
                ['name' => 'Patricia Alexandra Díaz', 'email' => 'paty.diaz99@example.com'],
                ['name' => 'Eduardo José Quintanilla', 'email' => 'eduardo.quintanilla@example.com'],
                ['name' => 'Katherine Michelle Renderos', 'email' => 'kathy.renderos@example.com'],
                ['name' => 'Bryan Alexander Portillo', 'email' => 'bryan.portillo01@example.com'],
                ['name' => 'Melissa Alejandra Zelaya', 'email' => 'mel.zelaya02@example.com'],
                ['name' => 'Kevin Ernesto Bonilla', 'email' => 'kevin.bonilla00@example.com'],
                ['name' => 'Gabriela María Recinos', 'email' => 'gaby.recinos99@example.com']
            ];

            // Crear estudiantes
            foreach ($estudiantes as $estudiante) {
                $usuario = User::create([
                    'name' => $estudiante['name'],
                    'email' => $estudiante['email'],
                    'password' => Hash::make('12345678'),
                    'email_verified_at' => now(),
                ]);

                // Asignar rol de estudiante
                $usuario->assignRole('Estudiante');


                Estudiante::create([
                    'id_usuario' => $usuario->id_usuario,   
                    'id_seccion' => $secciones->random()->id_seccion,
                    'porcentaje_completado' => rand(0, 100),
                    'horas_sociales_completadas' => rand(0, 500),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            $this->command->info('Estudiantes creados exitosamente.');

        } catch (\Exception $e) {
            $this->command->error("Error: " . $e->getMessage());
            throw $e;
        }
    }
}
