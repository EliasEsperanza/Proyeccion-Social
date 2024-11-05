<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Usuario; // Modelo de Usuario

class ProyectosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Asegurarse de que hay al menos 10 usuarios existentes
        $usuarios = Usuario::all();

        if ($usuarios->count() < 10) {
            $this->command->info('No hay suficientes usuarios en la tabla usuarios para ejecutar el seeder de proyectos.');
            return;
        }

        // Nuevos nombres de proyectos enfocados en la Universidad de El Salvador FMO
        $nombresProyectos = [
            'Investigación en Sistemas de Información',
            'Programa de Tutorías Académicas',
            'Mantenimiento de Infraestructura Tecnológica',
            'Desarrollo de Aplicaciones Web para Educación',
            'Capacitación en Tecnologías Emergentes',
            'Gestión de Bibliografía Académica',
            'Innovación en Ciencias Agrícolas',
            'Formación en Robótica Educativa',
            'Apoyo en Administración Universitaria',
            'Redacción y Difusión de Publicaciones Académicas'
        ];

        // Nuevas ubicaciones específicas dentro de la Universidad de El Salvador FMO
        $lugares = [
            'Facultad de Ciencias Económicas, Universidad de El Salvador FMO',
            'Biblioteca Central, Universidad de El Salvador FMO',
            'Laboratorio de Informática, Universidad de El Salvador FMO',
            'Centro de Investigaciones, Universidad de El Salvador FMO',
            'Aula Magna, Universidad de El Salvador FMO'
        ];

        // Insertar proyectos con lugares y coordinadores específicos
        foreach ($nombresProyectos as $nombre) {
            DB::table('proyectos')->insert([
                'nombre_proyecto' => $nombre,
                'estado' => collect(['Activo', 'Inactivo', 'En progreso'])->random(),
                'periodo' => '2024-2025',
                'lugar' => collect($lugares)->random(),
                'coordinador' => $usuarios->random()->id_usuario, // ID de usuario aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
