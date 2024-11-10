<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        // Asignar rol de administrador
        $admin->assignRole('Administrador');


         // Crear tutor
        $tutor = User::create([
            'name' => 'Juan Pérez',
            'email' => 'tutor@example.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        // Asignar rol de tutor
        $tutor->assignRole('Tutor');

        // Crear 10 estudiantes
        $estudiantes = [            [
                'name' => 'María García',
                'email' => 'maria@example.com',
            ],
            [
                'name' => 'Pedro López',
                'email' => 'pedro@example.com',
            ],
            [
                'name' => 'Ana Martínez',
                'email' => 'ana@example.com',
            ],
            [
                'name' => 'Carlos Rodríguez',
                'email' => 'carlos@example.com',
            ],
            [
                'name' => 'Laura Sánchez',
                'email' => 'laura@example.com',
            ],
            [
                'name' => 'Diego Ramírez',
                'email' => 'diego@example.com',
            ],
            [
                'name' => 'Sandra Torres',
                'email' => 'sandra@example.com',
            ],
            [
                'name' => 'Roberto Flores',
                'email' => 'roberto@example.com',
            ],
            [
                'name' => 'Patricia Gómez',
                'email' => 'patricia@example.com',
            ],
            [
                'name' => 'Miguel Herrera',
                'email' => 'miguel@example.com',
            ],
        ];

        foreach ($estudiantes as $estudiante) {
            $user = User::create([
                'name' => $estudiante['name'],
                'email' => $estudiante['email'],
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]);

            // Asignar rol de estudiante
            $user->assignRole('Estudiante');

        }

        //Datos de los coordinador
        $coordinadores = [
            ['name' => 'Lucy Irina Serrano de Alfaro', 'email' => 'lucy.Serrano@example.com'],
            ['name' => 'Nora Isabel Claros Campos', 'email' => 'nora.Claros@example.com'],
            ['name' => 'Rene Eduardo Arias Cisneros', 'email' => 'rene.Arias@example.com'],
            ['name' => 'José Luis Castro Cordero', 'email' => 'jose.Castro@example.com'],
            ['name' => 'Josselin Vanessa Márquez Argueta', 'email' => 'josselin.Marquez@example.com'],
            ['name' => 'Jesús Antonio Orellana Rodríguez', 'email' => 'jesus.Orellana@example.com'],
            ['name' => 'Henry Jeovanni Mata Lazo', 'email' => 'henry.Mata@example.com'],
            ['name' => 'Aurora Guadalupe Gutierrez de Márquez', 'email' => 'aurora.Gutierrez@example.com'],
            ['name' => 'Zoila Esperanza Somoza Zelaya', 'email' => 'zoila.Somoza@example.com'],
            ['name' => 'Ana Claribel Molina', 'email' => 'ana.Molina@example.com'],
            ['name' => 'María Adilia Morejon de Quintanilla', 'email' => 'maria.Morejon@example.com'],
            ['name' => 'Oscar Eduardo Pastore Majano', 'email' => 'oscar.Pastore@example.com'],
            ['name' => 'Kally Jissell Zuleta Paredes', 'email' => 'kally.Zuleta@example.com'],
            ['name' => 'Oscar René Barrera', 'email' => 'oscar.Barrera@example.com'],
            ['name' => 'Dinora Elizabeth Rosales Hernández', 'email' => 'dinora.Rosales@example.com'],
            ['name' => 'Lisseth Nohemy Saleh de Perla', 'email' => 'lisseth.Saleh@example.com'],
            ['name' => 'Carlos Luis Zelaya Flores', 'email' => 'carlos.Zelaya@example.com'],
            ['name' => 'Irma de La Paz Rivera Valencia', 'email' => 'irma.Rivera@example.com'],
            ['name' => 'Santiago Alberto Ulloa', 'email' => 'santiago.Ulloa@example.com'],
            ['name' => 'Telma Elizabeth Jimenez Murillo', 'email' => 'telma.Jimenez@example.com'],
            ['name' => 'Vilma Evelyn Gomez Zetino', 'email' => 'vilma.Gomez@example.com'],
            ['name' => 'Eladio Fabian Melgar Benítez', 'email' => 'eladio.Melgar@example.com'],
        ];
         // Crear coordinador
         foreach ($coordinadores as $coordinador) {
            $user = User::create([
                'name' => $coordinador['name'],
                'email' => $coordinador['email'],
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole('Coordinador'); 

        }
          
    }      
}