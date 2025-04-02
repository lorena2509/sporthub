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

        $reservasPorMes = $this->getReservasPorMes(); // Get reservations by month

        return view('admin.estadisticas', compact('estadisticas', 'totalReservas', 'reservadas', 'canceladas', 'finalizadas', 'canchaNames', 'reservasPorMes'));
    }

    // New method to get total reservations
    public function getTotalReservas()
    {
        return Reserva::count(); // Returns the total number of reservations
    }

    // New method to get reservations by month
    public function getReservasPorMes()
    {
        $reservasPorMes = Reserva::selectRaw('YEAR(created_at) as year, MONTH(created_at) as mes, COUNT(*) as total')
            ->groupBy('year', 'mes')
            ->orderBy('mes')
            ->get();

        // Array of month names in Spanish
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        // Structure the data by month
        return $reservasPorMes->map(function ($reserva) use ($meses) {
            $reserva->mes = $meses[$reserva->mes]; // Convert month number to Spanish name
            return [
                'mes' => $reserva->mes,
                'total' => $reserva->total // Total reservations for the month
            ];
        });
    }

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
