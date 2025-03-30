@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Mis Reservas</h2>
    @if($reservas->isEmpty())
        <div class="text-center fw-bold fs-5 text-dark bg-light p-3 rounded-3 shadow-sm">
            <i class="fas fa-info-circle"></i> No hay reservas registradas en este momento.
        </div>
    @else
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Cancha</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Hora de Inicio</th>
                <th>Hora de Fin</th>
                <th>Fecha Creada</th>
                <th>Acciones</th> <!-- Nueva columna -->
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->cancha->nombre ?? 'Desconocida' }}</td>  
                    <td>{{ $reserva->estado->name }}</td> 
                    <td>{{ $reserva->fecha }}</td>
                    <td class="text-success"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($reserva->start_time)->format('H:i') }}</td>
                    <td class="text-danger"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($reserva->end_time)->format('H:i') }}</td>
                    <td>{{ $reserva->fecha_creada }}</td>
                    <td>
                        @if($reserva->estado->name == 'Reservado')
                            <!-- Botón para cancelar la reserva -->
                            <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas cancelar esta reserva?');">
                                    Cancelar
                                </button>
                            </form>
                        @endif

                        <!-- Botón Eliminar -->
                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta reserva?');">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <a href="{{ route('reservas.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection