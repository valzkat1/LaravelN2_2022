<?php

namespace Database\Factories;

use App\Models\Clientes2;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class Clientes2Factory extends Factory
{
    protected $model = Clientes2::class;

    public function definition()
    {
        return [
			'nombre' => $this->faker->name,
			'apellidos' => $this->faker->name,
			'direccion' => $this->faker->name,
			'email' => $this->faker->name,
        ];
    }
}
