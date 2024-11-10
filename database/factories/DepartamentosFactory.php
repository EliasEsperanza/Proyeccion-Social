<?php
namespace Database\Factories;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartamentosFactory extends Factory
{
    protected $model = Departamento::class;

    public function definition()
    {
        return [
            'nombre_departamento' => $this->faker->unique()->word(),
        ];
    }
}
