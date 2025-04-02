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

    public function getReservasPorMes() 
    {
        // Obtener las reservas agrupadas por año y mes
        $reservasPorMes = Reserva::selectRaw('YEAR(fecha) as year, MONTH(fecha) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Nombres de los meses en español
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        // Inicializar un array para almacenar los totales por mes
        $totalesPorMes = array_fill_keys(array_keys($meses), ['mes' => '', 'total' => 0]);

        // Llenar el array con los totales por mes
        foreach ($reservasPorMes as $reserva) {
            $mesKey = $reserva->month; // Obtener el mes
            $totalesPorMes[$mesKey] = [
                'mes' => $meses[$mesKey] . " " . $reserva->year, // Formato "Mes Año"
                'total' => $reserva->total // Total de reservas para ese mes
            ];
        }

        // Asegurarse de que todos los meses estén presentes en el resultado
        foreach ($meses as $key => $nombre) {
            if ($totalesPorMes[$key]['mes'] === '') {
                $totalesPorMes[$key] = [
                    'mes' => $nombre . " " . date('Y'), // Usar el año actual
                    'total' => 0 // Si no hay reservas, el total es 0
                ];
            }
        }

        // Ordenar el array por mes
        ksort($totalesPorMes);

        return array_values($totalesPorMes); // Retornar solo los valores
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
