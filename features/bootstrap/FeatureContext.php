<?php

use Behat\Behat\Context\Context;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Facade;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    use RefreshDatabase; // Limpia la base de datos después de cada prueba
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response; // Declaración explícita de la propiedad

    /**
     * @var string
     */
    private $authToken; // Declaración explícita de la propiedad

    public function __construct()
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        Facade::setFacadeApplication($app);

        // Desactiva el middleware de CSRF para las pruebas

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        \Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
    }

    /**
     * @Given que soy un usuario autenticado
     */
    public function queSoyUnUsuarioAutenticado()
    {
        // Obtén o crea el rol de cliente usando el modelo Role
        $role = \App\Models\Role::firstOrCreate(['name' => 'Cliente'], [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crea un usuario con el rol de cliente
        $user = User::factory()->create([
            'name' => 'Lorena',
            'email' => 'lorena' . uniqid() . '@example.com',
            'password' => Hash::make('password'),
            'role_id' => $role->id, // Asigna el rol al usuario
        ]);

        // Crea una reserva asociada al usuario
        \App\Models\Reserva::factory()->create([
            'user_id' => $user->id,
            'cancha_id' => \App\Models\Cancha::factory()->create()->id, // Crea una cancha asociada
            'estado_id' => \App\Models\Estado::firstOrCreate(['name' => 'Reservado'])->id, // Crea un estado si no existe
            'fecha' => now()->format('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
        ]);

        // Simula la autenticación
        auth()->login($user);

        // Genera un token de autenticación
        $this->authToken = $user->createToken('TestToken')->plainTextToken;
    }

    /**
     * @When voy a la página de mis reservas
     */
    public function voyALaPaginaDeMisReservas()
    {
        $client = new Client(['base_uri' => 'http://127.0.0.1:8000']);
        $response = $client->get('/mis-reservas', [
            'headers' => [
                'Accept' => 'application/json', // Solicita una respuesta JSON
                'Authorization' => 'Bearer ' . $this->authToken, // Envía el token de autenticación
            ],
        ]);

        // Guarda la respuesta para usarla en otros pasos
        $this->response = $response;
    }

    /**
     * @Then debería ver la lista de mis reservas
     */
    public function deberiaVerLaListaDeMisReservas()
    {
        // Decodifica la respuesta JSON
        $body = json_decode((string) $this->response->getBody(), true);

        // Muestra el contenido del JSON para depuración
        var_dump($body); // Imprime el contenido del JSON
      

        // Verifica que la respuesta sea un array
        if (!is_array($body)) {
            throw new Exception('La respuesta no es un JSON válido.');
        }

        // Verifica que haya al menos una reserva en la respuesta
        if (empty($body)) {
            throw new Exception('No se encontraron reservas en la respuesta.');
        }

        // Verifica que la primera reserva tenga los campos esperados
        if (!isset($body[0]['id']) || !isset($body[0]['fecha']) || !isset($body[0]['cancha_id'])) {
            throw new Exception('La estructura de la reserva no es la esperada.');
        }
    }
  

}
