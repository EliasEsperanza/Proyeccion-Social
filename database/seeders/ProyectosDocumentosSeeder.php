<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProyectosDocumentosSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Asumiendo que tienes al menos 10 proyectos y 10 documentos en tu base de datos
        for ($i = 0; $i < 50; $i++) {
            DB::table('proyectos_documentos')->insert([
                'id_documento' => $faker->numberBetween(1, 10), // Ajusta según la cantidad de documentos disponibles
                'id_proyecto' => $faker->numberBetween(1, 10),  // Ajusta según la cantidad de proyectos disponibles
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
