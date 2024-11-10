<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\DepartamentosFactory;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::create([
            'nombre_departamento' => 'Ciencias Agronómicas', 
        ]);
        Departamento::create([
            'nombre_departamento' => 'Ciencias Económicas', 
        ]);
        Departamento::create([
            'nombre_departamento' => 'Ciencias y Humanidades',
        ]);
        Departamento::create([
            'nombre_departamento' => 'Ingeniería y Arquitectura',
        ]);
        Departamento::create([
            'nombre_departamento' => 'Jurisprudencia y Ciencias Sociales',
        ]);        
        Departamento::create([
            'nombre_departamento' => 'Medicina',
        ]);
        Departamento::create([
            'nombre_departamento' => 'Ciencias Naturales y Matemática',
        ]);
        Departamento::create([
            'nombre_departamento' => 'Química y Farmacia',
        ]);
        Departamento::create([ 
            'nombre_departamento' => 'Escuela de Carreras Técnicas. Sede Morazán',
        ]);
        Departamento::create([
            'nombre_departamento' => 'Escuela de Postgrado',
        ]);
        Departamento::create([
            'nombre_departamento' => 'Extensión La Unión',
        ]);
    }
}
