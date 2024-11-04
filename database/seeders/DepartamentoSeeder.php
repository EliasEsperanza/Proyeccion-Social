<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::factory()->create([
            'nombre_departamento' => 'Ciencias Agronómicas', 
        ]);
        Departamento::factory()->create([
            'nombre_departamento' => 'Ciencias Económicas', 
        ]);
        Departamento::factory()->create([
            'nombre_departamento' => 'Ciencias y Humanidades',
        ]);
        Departamento::factory()->create([
            'nombre_departamento' => 'Ingeniería y Arquitectura',
        ]);
        Departamento::factory()->create([
            'nombre_departamento' => 'Jurisprudencia y Ciencias Sociales',
        ]);        
        Departamento::factory()->create([
            'nombre_departamento' => 'Medicina',
        ]);
        Departamento::factory()->create([
            'nombre_departamento' => 'Ciencias Naturales y Matemática',
        ]);
        Departamento::factory()->create([
            'nombre_departamento' => 'Química y Farmacia',
        ]);
        Departamento::factory()->create([ 
            'nombre_departamento' => 'Escuela de Carreras Técnicas. Sede Morazán',
        ]);
        Departamento::factory()->create([
            'nombre_departamento' => 'Escuela de Postgrado',
        ]);
        Departamento::factory()->create([
            'nombre_departamento' => 'Extensión La Unión',
        ]);
    }
}
