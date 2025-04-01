<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Cancha;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'cancha_id' => Cancha::factory(),
            'estado_id' => Estado::factory(), // Relaciona con la fábrica de Estado
            'fecha' => $this->faker->date(),
            'start_time' => $this->faker->time(), // Usa start_time
            'end_time' => $this->faker->time(),   // Usa end_time
        ];
    }
    
}
