@extends('layouts.app')

@section('content')
<div class="container">
    @if(session()->has('error'))
        <div class="text-center fw-bold fs-5 text-white bg-danger p-3 rounded-3 shadow-sm">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif
    <h2 class="text-center my-4">Reservar Cancha</h2>

    <!-- Botón para ver mis reservas -->
    <div class="text-end mb-3">
        <a href="{{ route('reservas.misReservas') }}" class="btn btn-secondary">Ver Mis Reservas</a>
    </div>

    <div id="carrusel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($canchas as $index => $cancha)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $cancha->imagen) }}" class="d-block w-100" 
                        style="height: 400px; object-fit: cover;" 
                        alt="{{ $cancha->nombre }}">

                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 p-3 rounded">
                        <h5 class="text-white">{{ $cancha->nombre }}</h5>
                        <p class="text-white">Ubicación: {{ $cancha->ubicacion }}</p>
                        <p class="text-white">Capacidad: {{ $cancha->capacidad }} personas</p>
                        <!-- Botón para abrir el modal -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalReserva{{ $cancha->id }}">
                            Reservar
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carrusel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrusel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- Modales para cada cancha -->
    @foreach($canchas as $cancha)
    <div class="modal fade" id="modalReserva{{ $cancha->id }}" tabindex="-1" aria-labelledby="modalReservaLabel{{ $cancha->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReservaLabel{{ $cancha->id }}">Reservar {{ $cancha->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
                    <p><strong>Capacidad:</strong> {{ $cancha->capacidad }} personas</p>
                    
                    <form action="{{ route('reservas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cancha_id" value="{{ $cancha->id }}">

                        <div class="mb-2">
                            <label class="form-label">Fecha:</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Hora:</label>
                            <input type="time" name="hora" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Confirmar Reserva</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <a href="{{ route('login') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection