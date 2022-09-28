<?php

namespace Database\Factories;

use App\Models\Cargaimagene;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CargaimageneFactory extends Factory
{
    protected $model = Cargaimagene::class;

    public function definition()
    {
        return [
			'nombreimagen' => $this->faker->name,
			'imagen' => $this->faker->name,
        ];
    }
}
