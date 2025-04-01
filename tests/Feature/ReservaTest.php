<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Reserva;
use App\Models\Cancha; 
use App\Models\Estado; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReservaTest extends TestCase
{
    use RefreshDatabase; // Limpia la base de datos después de cada prueba

    /** @test */
    public function test_usuario_autenticado_puede_crear_reserva()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
 

        $cancha = Cancha::factory()->create([
            'nombre' => 'Cancha de Fútbol',
            'ubicacion' => 'Ubicación de prueba',
            'capacidad' => 20, // Proporciona un valor explícito para capacidad
        ]);

        $estado = Estado::factory()->create([
            'name' => 'Reservado', // Cambiado a 'nombre' para coincidir con la migración para coincidir con la migración
        ]);

        $reserva = Reserva::factory()->create([
            'user_id' => $user->id,
            'cancha_id' => $cancha->id, // Relaciona la reserva con la cancha creada
            'estado_id' => $estado->id, // Relaciona la reserva con un estado válido
            'fecha' => '2025-03-28',
            'start_time' => '10:00:00', // Usa el formato correctocto
            'end_time' => '11:00:00',   // Proporciona un valor para la hora de finalizaciónión
        ]);

        $this->assertDatabaseHas('reservas', [
            'user_id' => $user->id,
            'cancha_id' => $cancha->id,
            'estado_id' => $estado->id,
            'fecha' => '2025-03-28',
            'start_time' => '10:00:00', // Verifica la columna correctacta
            'end_time' => '11:00:00',   // Verifica la hora de finalizaciónión
        ]);
    }

    /** @test */
    public function test_un_usuario_no_autenticado_no_puede_crear_una_reserva()
    {
           $datosReserva = [
            'cancha_id' => 1, // Asegúrate de que exista una cancha con este ID en la base de datos> 1, // Asegúrate de que exista una cancha con este ID en la base de datos
            'fecha' => now()->addDays(1)->toDateString(),
            'start_time' => '10:00:00', // Usa el formato correcto0:00:00', // Usa el formato correcto
        ];

        $response = $this->post(route('reservas.store'), $datosReserva);

        $response->assertRedirect(route('login')); // Laravel lo redirige al login
    }

    public function test_usuario_autenticado_puede_cancelar_una_reserva()
    {
        $user = User::factory()->create();
    
        $estadoReservado = Estado::factory()->create(['id' => 1, 'name' => 'Reservado']);
        $estadoCancelado = Estado::factory()->create(['id' => 2, 'name' => 'Cancelado']);
    
        $reserva = Reserva::factory()->create([
            'user_id' => $user->id,
            'estado_id' => $estadoReservado->id,
        ]);
    
        // Desactivar middleware
        $this->withoutMiddleware();
    
        // Simular usuario autenticado y cancelar reserva
        $response = $this->actingAs($user)->post(route('reservas.cancelar', $reserva->id));
    
        // Refrescar modelo antes de verificar la base de datos
        $reserva->refresh();
    
        $this->assertEquals(2, $reserva->estado_id);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Reserva cancelada correctamente.');
    }
    public function test_reserva_no_puede_ser_hecha_menos_de_30_minutos_antes()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create();

        // Crear una cancha
        $cancha = Cancha::factory()->create();

        // Crear una fecha de reserva que es menos de 30 minutos antes
        $fechaHoraReserva = Carbon::now()->addMinutes(20); // 20 minutos después de la hora actual
        $this->withoutMiddleware();
    
        // Actuar como el usuario y tratar de hacer la reserva
        $response = $this->actingAs($user)->post(route('reservas.store'), [
            'cancha_id' => $cancha->id,
            'fecha' => $fechaHoraReserva->format('Y-m-d'),
            'hora' => $fechaHoraReserva->format('H:i'),
        ]);

        // Verificar que la respuesta es la que esperamos (mensaje de error)
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Solo puedes reservar con al menos 30 minutos de anticipación.');
    }
 
    public function test_reserva_no_puede_ser_hecha_para_una_fecha_pasada()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create();

        // Crear una cancha
        $cancha = Cancha::factory()->create();

        // Crear una fecha de reserva en el pasado
        $fechaHoraReserva = Carbon::now()->subMinutes(10); // 10 minutos antes de la hora actual
        $this->withoutMiddleware();
    
        // Actuar como el usuario y tratar de hacer la reserva
        $response = $this->actingAs($user)->post(route('reservas.store'), [
            'cancha_id' => $cancha->id,
            'fecha' => $fechaHoraReserva->format('Y-m-d'),
            'hora' => $fechaHoraReserva->format('H:i'),
        ]);

        // Verificar que la respuesta es la que esperamos (mensaje de error)
        $response->assertRedirect();
        $response->assertSessionHas('error', 'No puedes reservar para una fecha u hora pasada.');
    }
    
    public function test_reserva_no_puede_ser_hecha_si_ya_existe_una_reserva_en_el_horario()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create();

        // Crear una cancha
        $cancha = Cancha::factory()->create();
        $estado = Estado::factory()->create([
            'name' => 'Reservado', // Cambiado a 'nombre' para coincidir con la migración para coincidir con la migración
        ]);
        // Crear una reserva existente para la misma cancha y horario
        $fechaHoraReserva = Carbon::now()->addMinutes(60);
        Reserva::create([
            'user_id' => $user->id,
            'cancha_id' => $cancha->id,
            'estado_id' =>$estado->id,
            'fecha' => $fechaHoraReserva->format('Y-m-d'),
            'start_time' => $fechaHoraReserva->format('H:i:s'),
            'end_time' => $fechaHoraReserva->addHours(2)->format('H:i:s'),
        ]);
        $this->withoutMiddleware();
        // Tratar de hacer otra reserva para el mismo horario
        $response = $this->actingAs($user)->post(route('reservas.store'), [
            'cancha_id' => $cancha->id,
            'fecha' => $fechaHoraReserva->format('Y-m-d'),
            'hora' => $fechaHoraReserva->format('H:i'),
        ]);

        // Verificar que la respuesta es la que esperamos (mensaje de error)
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Ya existe una reserva para esta cancha en el horario seleccionado.');
    }
    public function test_reserva_no_puede_ser_hecha_para_el_mismo_dia()
    {
        // Crear un usuario autenticado
        $user = User::factory()->create();

        // Crear una cancha
        $cancha = Cancha::factory()->create();

        // Crear una fecha de reserva para el mismo día
        $fechaHoraReserva = Carbon::now()->addMinutes(20); // 20 minutos después de la hora actual
        $this->withoutMiddleware();
    
        // Actuar como el usuario y tratar de hacer la reserva
        $response = $this->actingAs($user)->post(route('reservas.store'), [
            'cancha_id' => $cancha->id,
            'fecha' => $fechaHoraReserva->format('Y-m-d'),
            'hora' => $fechaHoraReserva->format('H:i'),
        ]);

        // Verificar que la respuesta es la que esperamos (mensaje de error)
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Solo puedes reservar con al menos 30 minutos de anticipación.');
    }
 
    /** @test */
    public function test_usuario_autenticado_puede_ver_mis_reservas()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear una reserva para el usuario
        $reserva = Reserva::factory()->create([
            'user_id' => $user->id,
            'fecha' => now()->addDays(1)->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        // Desactivar middleware
        $this->withoutMiddleware();

        // Realizar la solicitud GET para ver las reservas
        $response = $this->get(route('reservas.misReservas'));

        // Verificar que la respuesta sea exitosa y contenga la reserva
        $response->assertStatus(200);
       
        $response->assertSee($reserva->fecha);
    } 
    
    

}

