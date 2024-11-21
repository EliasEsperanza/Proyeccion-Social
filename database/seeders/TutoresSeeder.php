<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Seccion;

class TutoresSeeder extends Seeder
{
    
    public function run(): void
    {
        try {
            // Verificar si existen secciones
            $secciones = Seccion::all();
            
            if ($secciones->isEmpty()) {
                throw new \Exception('Debes crear secciones antes de crear tutores');
            }

            // Lista de tutores
            $tutores = [
                ['name' => 'Julio César Hernández', 'email' => 'julio.hernandez24@gmail.com'],
                ['name' => 'Mónica Beatriz Figueroa', 'email' => 'monica.figueroa97@gmail.com'],
                ['name' => 'Ricardo Antonio Sánchez', 'email' => 'ricardo.sanchez01@gmail.com'],
                ['name' => 'Carolina Isabel Morales', 'email' => 'caro.morales98@gmail.com'],
                ['name' => 'Francisco Javier Castillo', 'email' => 'francisco.castillo@gmail.com'],
                ['name' => 'Claudia Marcela López', 'email' => 'claudia.lopez00@gmail.com'],
                ['name' => 'Oscar David Guzmán', 'email' => 'oscar.guzman@gmail.com'],
                ['name' => 'Verónica Elizabeth Cruz', 'email' => 'vero.cruz01@gmail.com'],
                ['name' => 'Carlos Andrés Flores', 'email' => 'carlos.flores@gmail.com'],
                ['name' => 'Paola Andrea Jiménez', 'email' => 'paola.jimenez99@gmail.com'],
                ['name' => 'Fernando Manuel Vega', 'email' => 'fernando.vega02@gmail.com'],
                ['name' => 'Natalia Isabel Ramos', 'email' => 'natalia.ramos00@gmail.com'],
                ['name' => 'Héctor Alejandro Rojas', 'email' => 'hector.rojas@gmail.com'],
                ['name' => 'Lorena Patricia Aguilar', 'email' => 'lorena.aguilar@gmail.com'],
                ['name' => 'Mario Alberto Cruz', 'email' => 'mario.cruz03@gmail.com'],
                ['name' => 'Stephanie Nicole Castillo', 'email' => 'stephanie.castillo@gmail.com'],
                ['name' => 'Miguel Ángel Pineda', 'email' => 'miguel.pineda01@gmail.com'],
                ['name' => 'Daniela Alejandra Espinoza', 'email' => 'daniela.espinoza02@gmail.com'],
                ['name' => 'Javier Eduardo López', 'email' => 'javier.lopez99@gmail.com'],
                ['name' => 'Camila Sofía Alvarado', 'email' => 'camila.alvarado@gmail.com']
            ];

            // Crear tutores
            foreach ($tutores as $tutor) {
                $usuario = User::create([
                    'name' => $tutor['name'],
                    'email' => $tutor['email'],
                    'password' => Hash::make('12345678'),
                    'email_verified_at' => now(),
                ]);

                // Asignar rol de estudiante
                $usuario->assignRole('Tutor');
            }

            $this->command->info('tutores creados exitosamente.');

        } catch (\Exception $e) {
            $this->command->error("Error: " . $e->getMessage());
            throw $e;
        }
    }
}
