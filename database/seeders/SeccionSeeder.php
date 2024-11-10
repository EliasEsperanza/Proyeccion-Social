<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seccion;

class SeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los tutores por su correo electrónico
        $tutores = User::whereIn('email', [
            'lucy.Serrano@example.com',
            'nora.Claros@example.com',
            'rene.Arias@example.com',
            'jose.Castro@example.com',
            'josselin.Marquez@example.com',
            'jesus.Orellana@example.com',
            'henry.Mata@example.com',
            'aurora.Gutierrez@example.com',
            'zoila.Somoza@example.com',
            'ana.Molina@example.com',
            'maria.Morejon@example.com',
            'oscar.Pastore@example.com',
            'kally.Zuleta@example.com',
            'oscar.Barrera@example.com',
            'dinora.Rosales@example.com',
            'lisseth.Saleh@example.com',
            'carlos.Zelaya@example.com',
            'irma.Rivera@example.com',
            'santiago.Ulloa@example.com',
            'telma.Jimenez@example.com',
            'vilma.Gomez@example.com',
            'eladio.Melgar@example.com',
        ])->get()->pluck('id_usuario', 'email');

        // Obtener todos los departamentos y organizar en un arreglo asociativo
        $departamentos = Departamento::all()->pluck('id_departamento', 'nombre_departamento');

        // Definir las secciones de los departamentos
        $secciones = [
            // Secciones del departamento de Ciencias Agronómicas
            [
                'nombre_seccion' => 'Agronomía',
                'id_departamento' => $departamentos['Ciencias Agronómicas'],
                'id_coordinador' => $tutores['carlos.Zelaya@example.com'],
            ],

            // Secciones del departamento de Ciencias Económicas
            [
                'nombre_seccion' => 'Administración de Empresas',
                'id_departamento' => $departamentos['Ciencias Económicas'],
                'id_coordinador' => $tutores['dinora.Rosales@example.com'],
            ],
            [
                'nombre_seccion' => 'Contaduría Pública',
                'id_departamento' => $departamentos['Ciencias Económicas'],
                'id_coordinador' => $tutores['oscar.Barrera@example.com'],
            ],
            [
                'nombre_seccion' => 'Mercadeo Internacional',
                'id_departamento' => $departamentos['Ciencias Económicas'],
                'id_coordinador' => $tutores['lisseth.Saleh@example.com'],
            ],

            // Secciones del departamento de Ciencias y Humanidades
            [
                'nombre_seccion' => 'Educación',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['eladio.Melgar@example.com'],
            ],
            [
                'nombre_seccion' => 'Idiomas',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['lucy.Serrano@example.com'],
            ],
            [
                'nombre_seccion' => 'Psicología',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['kally.Zuleta@example.com'],
            ],
            [
                'nombre_seccion' => 'Sociología',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['oscar.Pastore@example.com'],
            ],
            [
                'nombre_seccion' => 'Letras',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['maria.Morejon@example.com'],
            ],

            // Secciones del departamento de Ingeniería y Arquitectura
            [
                'nombre_seccion' => 'Arquitectura',
                'id_departamento' => $departamentos['Ingeniería y Arquitectura'],
                'id_coordinador' => $tutores['rene.Arias@example.com'],
            ],
            [
                'nombre_seccion' => 'Ingeniería Civil',
                'id_departamento' => $departamentos['Ingeniería y Arquitectura'],
                'id_coordinador' => $tutores['jose.Castro@example.com'],
            ],
            [
                'nombre_seccion' => 'Ingeniería de Sistemas Informáticos',
                'id_departamento' => $departamentos['Ingeniería y Arquitectura'],
                'id_coordinador' => $tutores['josselin.Marquez@example.com'],
            ],
            [
                'nombre_seccion' => 'Ingeniería Industrial',
                'id_departamento' => $departamentos['Ingeniería y Arquitectura'],
                'id_coordinador' => $tutores['jesus.Orellana@example.com'],
            ],

            // Sección del departamento de Jurisprudencia y Ciencias Sociales
            [
                'nombre_seccion' => 'Jurisprudencia y Ciencias Sociales',
                'id_departamento' => $departamentos['Jurisprudencia y Ciencias Sociales'],
                'id_coordinador' => $tutores['irma.Rivera@example.com'],
            ],

            // Secciones del departamento de Medicina
            [
                'nombre_seccion' => 'Lic. en Laboratorio Clínico',
                'id_departamento' => $departamentos['Medicina'],
                'id_coordinador' => $tutores['aurora.Gutierrez@example.com'],
            ],
            [
                'nombre_seccion' => 'Lic. en Anestesiología e Inhaloterapia',
                'id_departamento' => $departamentos['Medicina'],
                'id_coordinador' => $tutores['zoila.Somoza@example.com'],
            ],
            [
                'nombre_seccion' => 'Lic. en Fisioterapia y Terapia Ocupacional',
                'id_departamento' => $departamentos['Medicina'],
                'id_coordinador' => $tutores['ana.Molina@example.com'],
            ],

            // Secciones del departamento de Ciencias Naturales y Matemática
            [
                'nombre_seccion' => 'Biología',
                'id_departamento' => $departamentos['Ciencias Naturales y Matemática'],
                'id_coordinador' => $tutores['vilma.Gomez@example.com'],
            ],
            [
                'nombre_seccion' => 'Física',
                'id_departamento' => $departamentos['Ciencias Naturales y Matemática'],
                'id_coordinador' => $tutores['telma.Jimenez@example.com'],
            ],
            [
                'nombre_seccion' => 'Matemática',
                'id_departamento' => $departamentos['Ciencias Naturales y Matemática'],
                'id_coordinador' => $tutores['santiago.Ulloa@example.com'],
            ],

            // Sección de la Escuela de Carreras Técnicas. Sede Morazán
            [
                'nombre_seccion' => 'Escuela de Carreras Técnicas de Morazán',
                'id_departamento' => $departamentos['Escuela de Carreras Técnicas. Sede Morazán'],
                'id_coordinador' => $tutores['nora.Claros@example.com'],
            ],

            // Sección del Doctorado en Medicina
            [
                'nombre_seccion' => 'Doctorado en Medicina',
                'id_departamento' => $departamentos['Escuela de Postgrado'],
                'id_coordinador' => $tutores['henry.Mata@example.com'],
            ]
        ];

        // Crear las secciones en la base de datos
        foreach ($secciones as $seccionData) {
            Seccion::create($seccionData);
        }
    }
}
