@extends('layouts.app') {{-- Asegúrate de que el layout es el correcto --}}

@section('title', 'Gestión de Reservas')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">📅 Gestión de Reservas</h2>
    
    @if($reservas->isEmpty())
        <div class="text-center fw-bold fs-5 text-dark bg-light p-3 rounded-3 shadow-sm">
            <i class="fas fa-info-circle"></i> No hay reservas registradas en este momento.
        </div>
    @else
    <div class="table-responsive shadow-lg rounded-4 p-3 bg-white">
        <table class="table table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Cancha</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                <tr>
                    <td><strong>{{ $reserva->id }}</strong></td>
                    <td class="text-capitalize"><i class="fas fa-user"></i> {{ $reserva->user->name ?? 'N/A' }}</td>
                    <td class="fw-bold"><i class="fas fa-futbol"></i> {{ $reserva->cancha->nombre ?? 'N/A' }}</td>
                    <td class="text-primary"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                    <td class="text-success"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($reserva->start_time)->format('H:i') }}</td>
                    <td class="text-danger"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($reserva->end_time)->format('H:i') }}</td>
                    <td>
                        @if($reserva->estado->name == 'Reservado')
                            <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half"></i> Reservado</span>
                        @elseif($reserva->estado->name == 'Cancelado')
                            <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Cancelado</span>
                        @elseif($reserva->estado->name == 'Finalizado')
                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Finalizado</span>
                        @else
                            <span class="badge bg-secondary">{{ $reserva->estado->name ?? 'N/A' }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            @if($reserva->estado->name == 'Reservado')
                                <form action="{{ route('reservas.finalizar', $reserva->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-info text-white" onclick="return confirm('¿Marcar esta reserva como Finalizada?')">
                                        <i class="fas fa-check"></i> Finalizar
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta reserva?')">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <a href="{{ route('admin.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection