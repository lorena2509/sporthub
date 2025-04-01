<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_puede_ver_lista_Usuarios()
{
    // Crea un usuario en la base de datos
    $user = User::factory()->create();

    // Simula la autenticación del usuario
    $this->actingAs($user);
    $this->withoutMiddleware();
    // Realiza una solicitud GET para acceder a la lista de usuarios
    $response = $this->get(route('admin.user'));

    // Verifica que la respuesta sea exitosa y contenga la vista correcta
    $response->assertStatus(200);
    $response->assertViewIs('admin.user');
    $response->assertSee($user->name); // Verifica que el nombre del usuario esté en la vista
}
public function test_puede_actualizar_rol_usuario()
{
    // Crea un usuario en la base de datos
    $user = User::factory()->create();
    $role = Role::factory()->create(); // Asumiendo que tienes un modelo 'Role'

    // Simula la autenticación del usuario
    $this->actingAs($user);
    $this->withoutMiddleware();
    // Realiza una solicitud PUT para actualizar el rol del usuario
    $response = $this->put(route('usuarios.updateRole', $user->id), [
        'role_id' => $role->id,
    ]);

    // Verifica que el rol del usuario se haya actualizado
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'role_id' => $role->id,
    ]);

    // Verifica que la redirección se realice correctamente
    $response->assertRedirect();
    $response->assertSessionHas('success', 'Rol actualizado correctamente.');
}

}