<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cancha;
use App\Models\Reserva;

class EstadisticasController extends Controller
{
    public function index()
    {
        $estadisticas = Cancha::withCount([
            'reservas as total_reservas',
            'reservas as veces_reservada' => function ($query) {
                $query->where('estado_id', 1);
            },
            'reservas as veces_cancelada' => function ($query) {
                $query->where('estado_id', 2);
            },
            'reservas as veces_finalizada' => function ($query) {
                $query->where('estado_id', 3);
            }
        ])->get();

        $totalReservas = $estadisticas->pluck('total_reservas');
        $reservadas = $estadisticas->pluck('veces_reservada');
        $canceladas = $estadisticas->pluck('veces_cancelada');
        $finalizadas = $estadisticas->pluck('veces_finalizada');
        $canchaNames = $estadisticas->pluck('nombre');

        return view('admin.estadisticas', compact('estadisticas', 'totalReservas', 'reservadas', 'canceladas', 'finalizadas', 'canchaNames'));
    }

    // New method to get total reservations
    public function getTotalReservas()
    {
        return Reserva::count(); // Returns the total number of reservations
    }

    // Define other methods as needed
    public function getReservadas()
    {
        return Reserva::where('estado_id', 1)->count(); // Count of reserved
    }

    public function getCanceladas()
    {
        return Reserva::where('estado_id', 2)->count(); // Count of canceled
    }

    public function getFinalizadas()
    {
        return Reserva::where('estado_id', 3)->count(); // Count of finalized
    }
}
