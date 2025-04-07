@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4" style="font-family: 'Arial Black', sans-serif; font-size: 2.5rem; color: #fff;">
        📅 Reservar Cancha
    </h2>

    <!-- Display error messages -->
    <!-- Display success messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Botón para ver mis reservas -->
    <div class="text-end mb-3">
        <a href="{{ route('reservas.misReservas') }}" class="btn btn-secondary">Ver Mis Reservas</a>
    </div>

    <div id="carrusel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($canchas as $index => $cancha)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $cancha->imagen) }}" class="d-block w-100 rounded border border-dark shadow-lg"
                        style="height: 400px; object-fit: cover;" 
                        alt="{{ $cancha->nombre }}">
                    
                    <div class="bg-dark bg-opacity-75 text-white text-center p-4 mt-2 rounded shadow-lg">
                        <h4 class="fw-bold" style="font-family: 'Georgia', serif; font-size: 1.8rem;">⚽ {{ $cancha->nombre }}</h4>
                        <p style="font-family: 'Times New Roman', serif; font-size: 1.2rem;">📍 Ubicación: {{ $cancha->ubicacion }}</p>
                        <p style="font-family: 'Times New Roman', serif; font-size: 1.2rem;">👥 Capacidad: {{ $cancha->capacidad }} personas</p>
                        <button class="btn btn-primary shadow-lg" data-bs-toggle="modal" data-bs-target="#modalReserva{{ $cancha->id }}">
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

    @foreach($canchas as $cancha)
    <div class="modal fade" id="modalReserva{{ $cancha->id }}" tabindex="-1" aria-labelledby="modalReservaLabel{{ $cancha->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reservar {{ $cancha->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('storage/' . $cancha->imagen) }}" alt="{{ $cancha->nombre }}" class="img-thumbnail mb-3" style="max-width: 100%; height: auto; border-radius: 10px; display: block; margin: auto;">

                    <h5 class="fw-bold text-dark">{{ $cancha->nombre }}</h5>
                    <p class="text-dark"><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
                    <p class="text-dark"><strong>Capacidad:</strong> {{ $cancha->capacidad }} personas</p>
                    <form action="{{ route('reservas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cancha_id" value="{{ $cancha->id }}">

                        <div class="mb-2">
                            <p class="text-dark"><strong>Selecciona la fecha:</strong></p>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <p class="text-dark"><strong>Selecciona la hora:</strong></p>
                            <select name="hora" class="form-control" required>
                                @foreach(range(12, 21) as $i)
                                    <option value="{{ $i }}:00">
                                        @if($i == 12)
                                            12:00 PM
                                        @elseif($i < 12)
                                            {{ $i }}:00 AM
                                        @else
                                            {{ $i - 12 }}:00 PM
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Confirmar Reserva</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
