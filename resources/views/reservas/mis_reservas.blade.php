@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Mis Reservas</h2>

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
                    <td>{{ $reserva->estado->name}}</td> 
                    <td>{{ $reserva->fecha }}</td>
                    <td>{{ $reserva->start_time }}</td>
                    <td>{{ $reserva->end_time }}</td>
                    <td>{{ $reserva->fecha_creada }}</td>
                    <td>
                        <!-- Botón Modificar -->
                        <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-warning btn-sm">Modificar</a>

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
</div>
@endsection
