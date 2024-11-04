<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Seeder\UserSeeder;
use App\Models\User;
use App\Models\Seccion;

use function Ramsey\Uuid\v1;

class SeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    ])->get()->pluck('id', 'email');


    $secciones = [
        [//secciones del depa de agronomia
            'nombre_seccion' => 'Agronomía',
            'id_departamento' => 1,
            'id_usuario' => $tutores['carlos.Zelaya@example.com']
        ],
        [//secciones del depa de economia
            'nombre_seccion' => 'Administración de Empresas',
            'id_departamento' => 2,
            'id_usuario' => $tutores['dinora.Rosales@example.com']
        ],
        [
            'nombre_seccion' => 'Contaduria Pública',
            'id_departamento' => 2, 
            'id_usuario' => $tutores['oscar.Barrera@example.com']
        ],
        [
            'nombre_seccion' => 'Mercadeo Internacional', 
            'id_departamento' => 2, 
            'id_usuario' => $tutores['lisseth.Saleh@example.com']
        ],
        //secciones del depa de humanidades
        [
            'nombre_seccion' => 'Educación',
            'id_departamento' => 3,
            'id_usuario' => $tutores['eladio.Melgar@example.com']
        ],
        [
            'nombre_seccion' => 'Idiomas',
            'id_departamento' => 3, 
            'id_usuario' => $tutores['lucy.Serrano@example.com']
        ],
        [
            'nombre_seccion' => 'Psicología',
            'id_departamento' => 3, 
            'id_usuario' => $tutores['kally.Zuleta@example.com']
        ],
        [
            'nombre_seccion' => 'Sociología',
            'id_departamento' => 3, 
            'id_usuario' => $tutores['oscar.Pastore@example.com']
        ],
        [
            'nombre_seccion' => 'Letras',
            'id_departamento' => 3,
            'id_usuario' => $tutores['maria.Morejon@example.com']
        ],
        //secciones del depa de ing y arquitectura
        [
            'nombre_seccion' => 'Arquitectura', 
            'id_departamento' => 4, 
            'id_usuario' => $tutores['rene.Arias@example.com']
        ],
        [    
            'nombre_seccion' => 'Ingeniería Civil',
            'id_departamento' => 4, 
            'id_usuario' => $tutores['jose.Castro@example.com']
        ],
        [
            'nombre_seccion' => 'Ingeniería de Sistemas Informáticos',
            'id_departamento' => 4,
            'id_usuario' => $tutores['josselin.Marquez@example.com']
        ],
        [
            'nombre_seccion' => 'Ingeniería Industrial',
            'id_departamento' => 4,
            'id_usuario' => $tutores['jesus.Orellana@example.com']
        ],
        [//del depa de jurisprudencia
            'nombre_seccion' => 'Jurisprudencia y Ciencias Sociales',
            'id_departamento' => 5,
            'id_usuario' => $tutores['irma.Rivera@example.com']
        ],
        [//secciones del depa de medicina
            'nombre_seccion' => 'Lic. en Laboratorio Clínico',
            'id_departamento' => 6,
            'id_usuario' => $tutores['aurora.Gutierrez@example.com']
        ],
        [
            'nombre_seccion' => 'Lic. en Anestesiología e Inhaloterapia',
            'id_departamento' => 6,
            'id_usuario' => $tutores['zoila.Somoza@example.com']
        ],
        [
            'nombre_seccion' => 'Lic. en Fisioterapia y Terapia Ocupacional',
            'id_departamento' => 6,
            'id_usuario' => $tutores['ana.Molina@example.com']
        ],
        //secciones del depa de ciencias naturales y matematica
        [
            'nombre_seccion' => 'Biología',
            'id_departamento' => 7, 
            'id_usuario' => $tutores['vilma.Gomez@example.com']
        ],
        [
            'nombre_seccion' => 'Física',
            'id_departamento' => 7,
            'id_usuario' => $tutores['telma.Jimenez@example.com']
        ],
        [
            'nombre_seccion' => 'Matemática',
            'id_departamento' => 7, 
            'id_usuario' => $tutores['santiago.Ulloa@example.com']
        ],
        [   //seccion de escuela de Carreras Técnicas. Sede Morazán
            'nombre_seccion' => 'Escuela de Carreras Técnicas de Morazán',
            'id_departamento' => 9, 
            'id_usuario' => $tutores['nora.Claros@example.com']
        ],
        [
            'nombre_seccion' => 'Doctorado en Medicina',
            'id_departamento' => 10, 
            'id_usuario' => $tutores['henry.Mata@example.com']
        ]
    ];

        foreach ($secciones as $seccionData) {
            Seccion::create($seccionData);
        }
    }
}


