<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Cancha;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'cancha_id' => Cancha::factory(),
            'fecha' => $this->faker->date(),
            'hora' => $this->faker->time(),
        ];
    }
    
}
