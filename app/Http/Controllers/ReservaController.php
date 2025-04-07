<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Estado;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionReserva;
use App\Mail\ReservaCancelada;

class ReservaController extends Controller
{
    public function index()
    {
        $canchas = Cancha::all();
        return view('reservas.index', compact('canchas'));
    }

    public function listarReservas() //Lista admin
    {
        // Obtener todas las reservas con la información del usuario y la cancha
        $reservas = Reserva::with('user', 'cancha')->orderBy('fecha', 'desc')->get();
        return view('admin.reservas', compact('reservas'));
    }

    public function finalizar($id) //Finalizar admin
    {
        $reserva = Reserva::findOrFail($id);
        $estadoFinalizado = Estado::where('name', 'Finalizado')->first();

        if ($estadoFinalizado) {
            $reserva->estado_id = $estadoFinalizado->id;
            $reserva->save();
        }
        return redirect()->back()->with('success', 'Reserva marcada como Finalizada.');
    }

    public function misReservas() //Lista reservas cliente
    {
        $reservas = Reserva::where('user_id', Auth::id())
                    // Carga los nombres de la cancha y el estado
                    ->orderBy('fecha', 'desc')
                    ->get();
        return view('reservas.mis_reservas', compact('reservas'));
    }

    public function destroy($id) //Eliminar reserva
    {
        Reserva::destroy($id);
        return redirect()->back()->with('success', 'Reserva eliminada correctamente.');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date_format:Y-m-d', // Ensure the date format is correct
            'hora' => 'required|date_format:H:i',
        ]);

        // Get the selected date and time
        $fechaReserva = Carbon::parse($request->fecha)->toDateString();
        $horaReserva = Carbon::parse($request->hora);
        $horaReservaConSegundos = $horaReserva->format('H:i:s');
        $horaFinReserva = $horaReserva->copy()->addHours(2)->format('H:i:s');
        
        // Check if the selected date and time are in the past
        $fechaActual = Carbon::now()->toDateString();
        $horaActual = Carbon::now()->format('H:i:s');

        if ($fechaReserva < $fechaActual || ($fechaReserva == $fechaActual && $horaReservaConSegundos < $horaActual)) {
            return redirect()->back()->with('error', 'No se puede reservar una fecha u hora pasada.');
        }

        // Check for existing reservations for the selected date and time
        $reservaExistente = Reserva::where('cancha_id', $request->cancha_id)
            ->where('fecha', $fechaReserva)
            ->where(function ($query) use ($horaReservaConSegundos, $horaFinReserva) {
                $query->where(function ($q) use ($horaReservaConSegundos, $horaFinReserva) {
                    $q->where('start_time', '<', $horaFinReserva)
                      ->where('end_time', '>', $horaReservaConSegundos);
                });
            })
            ->exists();

        if ($reservaExistente) {
            return redirect()->back()->with('error', 'No se puede realizar la reserva. Ya existe una reserva para esta cancha en el horario seleccionado.');
        }

        // Crear la nueva reserva
        $reserva = Reserva::create([
            'user_id' => Auth::id(),
            'cancha_id' => $request->cancha_id,
            'estado_id' => 1,
            'fecha' => $fechaReserva,
            'fecha_creada' => Carbon::now()->toDateTimeString(),
            'start_time' => $horaReservaConSegundos,
            'end_time' => $horaFinReserva,
        ]);
        
        // Enviar correo de confirmación
try {
    Mail::to(Auth::user()->email)->send(new ConfirmacionReserva($reserva));
} catch (\Exception $e) {
    // Log the error and notify the user
    \Log::error('Error sending confirmation email: ' . $e->getMessage());
    return redirect()->route('reservas.index')->with('error', 'Reserva realizada con éxito, pero hubo un problema al enviar el correo de confirmación.');
}
        
        return redirect()->route('reservas.index')->with('success', 'Reserva realizada con éxito');
    }

    public function cancelar($id)//Cancelar Reserva
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->estado_id = 2; // ID del estado "Cancelado"
        $reserva->save();
try {
    Mail::to($reserva->user->email)->send(new ReservaCancelada($reserva));
} catch (\Exception $e) {
    // Log the error and notify the user
    \Log::error('Error sending cancellation email: ' . $e->getMessage());
    return redirect()->back()->with('success', 'Reserva cancelada correctamente, pero hubo un problema al enviar el correo de cancelación.');
}

        return redirect()->back()->with('success', 'Reserva cancelada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date_format:Y-m-d', // Ensure the date format is correct
            'start_time' => 'required|date_format:H:i',
        ]);

        // Get the selected date and time
        $fechaReserva = Carbon::parse($request->fecha)->toDateString();
        $horaReserva = Carbon::parse($request->start_time);
        $horaReservaConSegundos = $horaReserva->format('H:i:s');
        $horaFinReserva = $horaReserva->copy()->addHours(2)->format('H:i:s');

        // Check if the selected date and time are in the past
        $fechaActual = Carbon::now()->toDateString();
        $horaActual = Carbon::now()->format('H:i:s');

        if ($fechaReserva < $fechaActual || ($fechaReserva == $fechaActual && $horaReservaConSegundos < $horaActual)) {
            return redirect()->back()->with('error', 'No se puede reservar una fecha u hora pasada.');
        }

        // Check for existing reservations for the selected date and time
        $reservaExistente = Reserva::where('cancha_id', $request->cancha_id)
            ->where('fecha', $fechaReserva)
            ->where(function ($query) use ($horaReservaConSegundos, $horaFinReserva) {
                $query->where(function ($q) use ($horaReservaConSegundos, $horaFinReserva) {
                    $q->where('start_time', '<', $horaFinReserva)
                      ->where('end_time', '>', $horaReservaConSegundos);
                });
            })
            ->where('id', '!=', $id) // Exclude the current reservation
            ->exists();

        if ($reservaExistente) {
            return redirect()->back()->with('error', 'No se puede realizar la reserva. Ya existe una reserva para esta cancha en el horario seleccionado.');
        }

        // Calcular el end_time sumando 2 horas al start_time
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->addHours(2);

        $reserva = Reserva::findOrFail($id);
        $reserva->update([
            'cancha_id' => $request->cancha_id,
            'fecha' => $request->fecha,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i:s'), // Formato de tiempo
        ]);

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    public function edit($id)
    {
        $reserva = Reserva::findOrFail($id); // Busca la reserva o lanza error 404
        $canchas = Cancha::all(); // Obtiene todas las canchas disponibles
        $estados = Estado::all(); // Obtiene todos los estados posibles

        return view('reservas.edit', compact('reserva', 'canchas', 'estados'));
    }
}
