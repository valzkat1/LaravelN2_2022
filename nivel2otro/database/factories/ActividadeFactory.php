<?php

namespace Database\Factories;

use App\Models\Actividade;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ActividadeFactory extends Factory
{
    protected $model = Actividade::class;

    public function definition()
    {
        return [
			'descripcion' => $this->faker->name,
			'fechaActividad' => $this->faker->name,
			'area' => $this->faker->name,
			'idEmpleado' => $this->faker->name,
        ];
    }
}
