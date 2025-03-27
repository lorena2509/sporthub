<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Contraseña por defecto
            'document' => $this->faker->numerify('##########'), // Número aleatorio de 10 dígitos
            'phonenumber' => $this->faker->phoneNumber,
            'role_id' => Role::firstOrCreate(['id' => 2], ['name' => 'Usuario'])->id, // Asegura que el rol 2 exista
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
   
}
