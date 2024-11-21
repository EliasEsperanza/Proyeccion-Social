<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seccion;
use App\Models\User;


class TutorSeccionSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $secciones = Seccion::all();

            if ($secciones->isEmpty()) {
                throw new \Exception('Debes crear secciones antes de asignar tutores.');
            }

            $tutores = User::allTutores()->get();

            if ($tutores->isEmpty()) {
                throw new \Exception('Debes crear usuarios con el rol Tutor antes de asignarlos a secciones.');
            }

            foreach ($secciones as $seccion) {
                $tutor = $tutores->random();
                $seccion->tutores()->attach($tutor->id_usuario);
            }

            $this->command->info('Tutores asignados a secciones exitosamente.');
        } catch (\Exception $e) {
            $this->command->error("Error: " . $e->getMessage());
            throw $e;
        }
    }
}


