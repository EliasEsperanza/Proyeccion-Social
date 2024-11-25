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
            'lucy.Serrano@ues.edu.sv',
            'nora.Claros@ues.edu.sv',
            'rene.Arias@ues.edu.sv',
            'jose.Castro@ues.edu.sv',
            'josselin.Marquez@ues.edu.sv',
            'jesus.Orellana@ues.edu.sv',
            'henry.Mata@ues.edu.sv',
            'aurora.Gutierrez@ues.edu.sv',
            'zoila.Somoza@ues.edu.sv',
            'ana.Molina@ues.edu.sv',
            'maria.Morejon@ues.edu.sv',
            'oscar.Pastore@ues.edu.sv',
            'kally.Zuleta@ues.edu.sv',
            'oscar.Barrera@ues.edu.sv',
            'dinora.Rosales@ues.edu.sv',
            'lisseth.Saleh@ues.edu.sv',
            'carlos.Zelaya@ues.edu.sv',
            'irma.Rivera@ues.edu.sv',
            'santiago.Ulloa@ues.edu.sv',
            'telma.Jimenez@ues.edu.sv',
            'vilma.Gomez@ues.edu.sv',
            'eladio.Melgar@ues.edu.sv',
        ])->get()->pluck('id_usuario', 'email');

        // Obtener todos los departamentos y organizar en un arreglo asociativo
        $departamentos = Departamento::all()->pluck('id_departamento', 'nombre_departamento');

        // Definir las secciones de los departamentos
        $secciones = [
            // Secciones del departamento de Ciencias Agronómicas
            [
                'nombre_seccion' => 'Agronomía',
                'id_departamento' => $departamentos['Ciencias Agronómicas'],
                'id_coordinador' => $tutores['carlos.Zelaya@ues.edu.sv'],
            ],

            // Secciones del departamento de Ciencias Económicas
            [
                'nombre_seccion' => 'Administración de Empresas',
                'id_departamento' => $departamentos['Ciencias Económicas'],
                'id_coordinador' => $tutores['dinora.Rosales@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Contaduría Pública',
                'id_departamento' => $departamentos['Ciencias Económicas'],
                'id_coordinador' => $tutores['oscar.Barrera@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Mercadeo Internacional',
                'id_departamento' => $departamentos['Ciencias Económicas'],
                'id_coordinador' => $tutores['lisseth.Saleh@ues.edu.sv'],
            ],

            // Secciones del departamento de Ciencias y Humanidades
            [
                'nombre_seccion' => 'Educación',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['eladio.Melgar@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Idiomas',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['lucy.Serrano@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Psicología',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['kally.Zuleta@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Sociología',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['oscar.Pastore@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Letras',
                'id_departamento' => $departamentos['Ciencias y Humanidades'],
                'id_coordinador' => $tutores['maria.Morejon@ues.edu.sv'],
            ],

            // Secciones del departamento de Ingeniería y Arquitectura
            [
                'nombre_seccion' => 'Arquitectura',
                'id_departamento' => $departamentos['Ingeniería y Arquitectura'],
                'id_coordinador' => $tutores['rene.Arias@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Ingeniería Civil',
                'id_departamento' => $departamentos['Ingeniería y Arquitectura'],
                'id_coordinador' => $tutores['jose.Castro@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Ingeniería de Sistemas Informáticos',
                'id_departamento' => $departamentos['Ingeniería y Arquitectura'],
                'id_coordinador' => $tutores['josselin.Marquez@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Ingeniería Industrial',
                'id_departamento' => $departamentos['Ingeniería y Arquitectura'],
                'id_coordinador' => $tutores['jesus.Orellana@ues.edu.sv'],
            ],

            // Sección del departamento de Jurisprudencia y Ciencias Sociales
            [
                'nombre_seccion' => 'Jurisprudencia y Ciencias Sociales',
                'id_departamento' => $departamentos['Jurisprudencia y Ciencias Sociales'],
                'id_coordinador' => $tutores['irma.Rivera@ues.edu.sv'],
            ],

            // Secciones del departamento de Medicina
            [
                'nombre_seccion' => 'Lic. en Laboratorio Clínico',
                'id_departamento' => $departamentos['Medicina'],
                'id_coordinador' => $tutores['aurora.Gutierrez@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Lic. en Anestesiología e Inhaloterapia',
                'id_departamento' => $departamentos['Medicina'],
                'id_coordinador' => $tutores['zoila.Somoza@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Lic. en Fisioterapia y Terapia Ocupacional',
                'id_departamento' => $departamentos['Medicina'],
                'id_coordinador' => $tutores['ana.Molina@ues.edu.sv'],
            ],

            // Secciones del departamento de Ciencias Naturales y Matemática
            [
                'nombre_seccion' => 'Biología',
                'id_departamento' => $departamentos['Ciencias Naturales y Matemática'],
                'id_coordinador' => $tutores['vilma.Gomez@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Física',
                'id_departamento' => $departamentos['Ciencias Naturales y Matemática'],
                'id_coordinador' => $tutores['telma.Jimenez@ues.edu.sv'],
            ],
            [
                'nombre_seccion' => 'Matemática',
                'id_departamento' => $departamentos['Ciencias Naturales y Matemática'],
                'id_coordinador' => $tutores['santiago.Ulloa@ues.edu.sv'],
            ],

            // Sección de la Escuela de Carreras Técnicas. Sede Morazán
            [
                'nombre_seccion' => 'Escuela de Carreras Técnicas de Morazán',
                'id_departamento' => $departamentos['Escuela de Carreras Técnicas. Sede Morazán'],
                'id_coordinador' => $tutores['nora.Claros@ues.edu.sv'],
            ],

            // Sección del Doctorado en Medicina
            [
                'nombre_seccion' => 'Doctorado en Medicina',
                'id_departamento' => $departamentos['Escuela de Postgrado'],
                'id_coordinador' => $tutores['henry.Mata@ues.edu.sv'],
            ]
        ];

        // Crear las secciones en la base de datos
        foreach ($secciones as $seccionData) {
            Seccion::create($seccionData);
        }
    }
}
