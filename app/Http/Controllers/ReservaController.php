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
    public function misReservas()
    {
        $reservas = Reserva::where('user_id', Auth::id())
                    // Carga los nombres de la cancha y el estado
                    ->orderBy('fecha', 'desc')
                    ->get();
              
   
        return view('reservas.mis_reservas', compact('reservas'));
    }
    public function destroy($id)
    {
        Reserva::destroy($id); // Usa el método estático correctamente
    
        return redirect()->back()->with('success', 'Reserva eliminada correctamente.');
    }
    
    public function store(Request $request)
{
    $request->validate([
        'cancha_id' => 'required|exists:canchas,id',
        'fecha' => 'required|date',
        'hora' => 'required'
    ]);

    // Asegurar que user_id tenga un valor válido
    $userId = Auth::id(); // Obtiene el ID del usuario autenticado

    if (!$userId) {
        return redirect()->route('reservas.index')->with('error', 'Debe estar autenticado para hacer una reserva.');
    }

    Reserva::create([
        'user_id' => $userId,  // Ahora tomamos el ID del usuario autenticado
        'cancha_id' => $request->cancha_id,
        'estado_id' => 1, // Estado fijo en 1
        'fecha' => $request->fecha,
        'fecha_creada' => Carbon::now()->toDateTimeString(), // Fecha y hora actual
        'start_time' => $request->hora,
        'end_time' => Carbon::parse($request->hora)->addHours(2)->format('H:i:s'), // Suma 2 horas
    ]);

    return redirect()->route('reservas.index')->with('success', 'Reserva realizada con éxito');
}


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
