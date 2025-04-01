<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Cancha;
use Tests\TestCase;
use App\Models\Estado; // Asegúrate de importar el modelo Estado
use App\Models\Reserva; // Asegúrate de importar el modelo Reserva

class CanchaTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_cancha()
{
    $user = User::factory()->create();  // Crea un usuario autenticado
    
    // Simular la autenticación del usuario
    $this->actingAs($user);
    
    // Crear una cancha usando la factory
    $cancha = Cancha::factory()->create([
        'nombre' => 'Cancha de Fútbol',
        'ubicacion' => 'Ubicación de prueba',
        'capacidad' => 20, // Proporciona un valor explícito para capacidad
      
    ]);
    $this->withoutMiddleware();
    // Enviar la solicitud POST para crear la cancha
    $response = $this->post(route('admin.canchas.store'), $cancha->toArray()); // Convertir el objeto a array

    
    // Verificar que la cancha ha sido guardada en la base de datos
    $this->assertDatabaseHas('canchas', [
        'nombre' => 'Cancha de Fútbol',
        'ubicacion' => 'Ubicación de prueba',
        'capacidad' => 20,
    ]);

    // Verificar que la redirección se realiza a la lista de canchas con un mensaje de éxito
    $response->assertRedirect(route('admin.canchas.index'));
    $response->assertSessionHas('success', 'Cancha creada exitosamente.');
}

    
    public function test_crear_cancha_validation()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $canchaData = [
            'nombre' => '',  // Dejar el nombre vacío para que falle la validación
            'ubicacion' => 'Ubicación de prueba',
            'capacidad' => 20,
            'imagen' => 'https://ennombredelftbol.wordpress.com/wp-content/uploads/2016/05/cesped-artificial.jpg', // Simular sin imagen

        ];

        $this->withoutMiddleware();
        // Intentar crear una cancha con datos incorrectos (falta 'nombre')
        $response = $this->post(route('admin.canchas.store'), $canchaData);
       

        // Verificar que la validación falló y redirige de vuelta
        $response->assertSessionHasErrors('nombre');
        $this->assertDatabaseMissing('canchas', [
            'nombre' => '',
            'ubicacion' => 'Ubicación de prueba',
            'capacidad' => 20,
        ]);
    }

    
    public function test_puede_editar_una_cancha()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Crear una cancha para actualizarla
        $cancha = Cancha::factory()->create([
            'nombre' => 'Cancha Original',
            'ubicacion' => 'Zona 1',
            'capacidad' => 100,
        ]);
    
        // Datos actualizados para la cancha
        $updatedData = [
            'nombre' => 'Cancha Editada',
            'ubicacion' => 'Zona 2',
            'capacidad' => 150,
        ];
        $this->withoutMiddleware();
        // Enviar la solicitud PUT para editar la cancha
        $response = $this->put(route('admin.canchas.update', $cancha->id), $updatedData);
    
        // Verificar que la cancha se haya actualizado en la base de datos
        
    
        // Verificar que la redirección sea a la página de listado de canchas
        $response->assertRedirect(route('admin.canchas.index'));
        $response->assertSessionHas('success', 'Cancha actualizada exitosamente.');
    }

    /** test */
    public function test_puede_eliminar_cancha()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Crear una cancha para eliminarla
        $cancha = Cancha::factory()->create([
            'nombre' => 'Cancha a Eliminar',
            'ubicacion' => 'Zona 3',
            'capacidad' => 200,
        ]);
        $this->withoutMiddleware();
        // Enviar la solicitud DELETE para eliminar la cancha
        $response = $this->delete(route('admin.canchas.destroy', $cancha->id));
    
        // Verificar que la cancha se haya eliminado de la base de datos
       
    
        // Verificar que la redirección sea a la página de listado de canchas
        $response->assertRedirect(route('admin.canchas.index'));
        $response->assertSessionHas('success', 'Cancha eliminada exitosamente.');
    }
        
}
