<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservaTest extends TestCase
{
    use RefreshDatabase; // Limpia la base de datos después de cada prueba

    /** @test */
    public function test_usuario_autenticado_puede_crear_reserva()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    
        $reserva = Reserva::factory()->create([
            'user_id' => $user->id,
            'fecha' => '2025-03-28',
            'hora' => '10:00'
        ]);
    
        $this->assertDatabaseHas('reservas', [
            'user_id' => $user->id,
            'fecha' => '2025-03-28',
            'hora' => '10:00'
        ]);
    }

    /** @test */
    public function test_un_usuario_no_autenticado_no_puede_crear_una_reserva()
    {
        $datosReserva = [
            'fecha' => now()->addDays(1)->toDateString(),
            'hora' => '10:00',
        ];

        $response = $this->post(route('reservas.store'), $datosReserva);

        $response->assertRedirect(route('login')); // Laravel lo redirige al login
    }
}
