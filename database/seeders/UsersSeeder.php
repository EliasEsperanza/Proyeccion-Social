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
            'email' => 'admin@ues.edu.sv',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        // Asignar rol de administrador
        $admin->assignRole('Administrador');

        //Datos de los coordinador
        $coordinadores = [
            ['name' => 'Lucy Irina Serrano de Alfaro', 'email' => 'lucy.Serrano@ues.edu.sv'],
            ['name' => 'Nora Isabel Claros Campos', 'email' => 'nora.Claros@ues.edu.sv'],
            ['name' => 'Rene Eduardo Arias Cisneros', 'email' => 'rene.Arias@ues.edu.sv'],
            ['name' => 'José Luis Castro Cordero', 'email' => 'jose.Castro@ues.edu.sv'],
            ['name' => 'Josselin Vanessa Márquez Argueta', 'email' => 'josselin.Marquez@ues.edu.sv'],
            ['name' => 'Jesús Antonio Orellana Rodríguez', 'email' => 'jesus.Orellana@ues.edu.sv'],
            ['name' => 'Henry Jeovanni Mata Lazo', 'email' => 'henry.Mata@ues.edu.sv'],
            ['name' => 'Aurora Guadalupe Gutierrez de Márquez', 'email' => 'aurora.Gutierrez@ues.edu.sv'],
            ['name' => 'Zoila Esperanza Somoza Zelaya', 'email' => 'zoila.Somoza@ues.edu.sv'],
            ['name' => 'Ana Claribel Molina', 'email' => 'ana.Molina@ues.edu.sv'],
            ['name' => 'María Adilia Morejon de Quintanilla', 'email' => 'maria.Morejon@ues.edu.sv'],
            ['name' => 'Oscar Eduardo Pastore Majano', 'email' => 'oscar.Pastore@ues.edu.sv'],
            ['name' => 'Kally Jissell Zuleta Paredes', 'email' => 'kally.Zuleta@ues.edu.sv'],
            ['name' => 'Oscar René Barrera', 'email' => 'oscar.Barrera@ues.edu.sv'],
            ['name' => 'Dinora Elizabeth Rosales Hernández', 'email' => 'dinora.Rosales@ues.edu.sv'],
            ['name' => 'Lisseth Nohemy Saleh de Perla', 'email' => 'lisseth.Saleh@ues.edu.sv'],
            ['name' => 'Carlos Luis Zelaya Flores', 'email' => 'carlos.Zelaya@ues.edu.sv'],
            ['name' => 'Irma de La Paz Rivera Valencia', 'email' => 'irma.Rivera@ues.edu.sv'],
            ['name' => 'Santiago Alberto Ulloa', 'email' => 'santiago.Ulloa@ues.edu.sv'],
            ['name' => 'Telma Elizabeth Jimenez Murillo', 'email' => 'telma.Jimenez@ues.edu.sv'],
            ['name' => 'Vilma Evelyn Gomez Zetino', 'email' => 'vilma.Gomez@ues.edu.sv'],
            ['name' => 'Eladio Fabian Melgar Benítez', 'email' => 'eladio.Melgar@ues.edu.sv'],
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