<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function index()
    {
        $canchas = Cancha::all();
        return view('reservas.index', compact('canchas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date',
            'hora' => 'required'
        ]);

        Reserva::create([
            'user_id' => Auth::id(),
            'cancha_id' => $request->cancha_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora
        ]);

        return redirect()->route('reservas.index')->with('success', 'Reserva realizada con éxito');
    }
}
