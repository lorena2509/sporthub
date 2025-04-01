<?php

namespace Database\Factories;

use App\Models\Cancha;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanchaFactory extends Factory
{
    protected $model = Cancha::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'ubicacion' => $this->faker->address,
            'capacidad' => $this->faker->numberBetween(1, 100), // Proporciona un valor para capacidad
        ];
    }
}
