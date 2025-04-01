<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Limpia la base de datos después de cada prueba

    protected function setUp(): void
    {
        parent::setUp();

        // Inserta los roles necesarios
        Role::create(['id' => 1, 'name' => 'Admin']);
        Role::create(['id' => 2, 'name' => 'Cliente']);
    }

    /** @test */
    public function un_usuario_puede_registrarse()
    {
        $datos = [
            'name' => 'Usuario de Prueba',
            'email' => 'prueba@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'document' => '1234567890',
            'phonenumber' => '555-5555',
            'role_id' => '2',
        ];

        $response = $this->post(route('register.post'), $datos);

        $response->assertRedirect(route('login')); // Ajusta según tu lógica

        $this->assertDatabaseHas('users', [
            'email' => 'prueba@example.com'
        ]);
    }

    /** @test */
    public function test_un_usuario_puede_iniciar_sesion()
    {
        $user = User::factory()->create([
            'email' => 'prueba@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'prueba@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('reservas.index')); // Ajusta según tu aplicación
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_un_usuario_puede_cerrar_sesion()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect('/'); // Ajusta según la redirección después del logout
        $this->assertGuest();
    }
}
