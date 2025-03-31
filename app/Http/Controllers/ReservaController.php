<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Estado;



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
    
    public function store(Request $request) //Crear Reserva
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i'
        ]);
    
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('reservas.index')->with('error', 'Debes iniciar sesión para hacer una reserva.');
        }
    
        // Convertir la hora ingresada a formato Carbon
        $horaIngresada = Carbon::parse($request->hora);
    
        // Validar que la hora sea cerrada (ejemplo: 11:00, 12:00)
        if ($horaIngresada->minute != 0) {
            return redirect()->route('reservas.index')->with('error', 'Las reservas solo pueden hacerse en horas exactas (Ej: 11:00, 12:00).');
        }
    
        // Validar que la hora esté dentro del rango permitido (12 PM - 10 PM)
        $horaPermitidaMin = Carbon::createFromTime(12, 0, 0);  // 12:00 PM
        $horaPermitidaMax = Carbon::createFromTime(22, 0, 0);  // 10:00 PM
        if ($horaIngresada->lessThan($horaPermitidaMin) || $horaIngresada->greaterThanOrEqualTo($horaPermitidaMax)) {
            return redirect()->route('reservas.index')->with('error', 'Las reservas solo pueden hacerse entre 12:00 PM y 10:00 PM.');
        }
    
        // Definir el rango de ocupación (2 horas)
        $horaFin = $horaIngresada->copy()->addHours(2);
    
        // Verificar si la cancha ya está reservada en ese rango de tiempo
        $existeReserva = Reserva::where('cancha_id', $request->cancha_id)
            ->where('fecha', $request->fecha)
            ->where(function ($query) use ($horaIngresada, $horaFin) {
                $query->whereBetween('start_time', [$horaIngresada->format('H:i:s'), $horaFin->format('H:i:s')])
                      ->orWhereBetween('end_time', [$horaIngresada->format('H:i:s'), $horaFin->format('H:i:s')])
                      ->orWhere(function ($query) use ($horaIngresada, $horaFin) {
                          $query->where('start_time', '<', $horaIngresada->format('H:i:s'))
                                ->where('end_time', '>', $horaFin->format('H:i:s'));
                      });
            })
            ->exists();
    
        if ($existeReserva) {
            return redirect()->route('reservas.index')->with('error', 'Esta cancha ya está reservada en esta fecha y horario.');
        }
    
        // Crear la reserva
        Reserva::create([
            'user_id' => $userId,
            'cancha_id' => $request->cancha_id,
            'estado_id' => 1,
            'fecha' => $request->fecha,
            'fecha_creada' => Carbon::now()->toDateTimeString(),
            'start_time' => $horaIngresada->format('H:i:s'),
            'end_time' => $horaFin->format('H:i:s'),
        ]);
    
        return redirect()->route('reservas.index')->with('success', 'Reserva realizada con éxito.');
    }
    
    public function cancelar($id)//Cancelar Reserva
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->estado_id = 2; // ID del estado "Cancelado"
        $reserva->save();

        return redirect()->back()->with('success', 'Reserva cancelada correctamente.');
    }

    //No se esta usando
    public function update(Request $request, $id)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

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
