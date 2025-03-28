@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Reservar Cancha</h2>

    <!-- Botón para ver mis reservas -->
    <div class="text-end mb-3">
        <a href="{{ route('reservas.misReservas') }}" class="btn btn-secondary">Ver Mis Reservas</a>
    </div>

    <div id="carrusel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($canchas as $index => $cancha)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ $cancha->imagen }}" class="d-block w-100" 
                        style="height: 400px; object-fit: cover;" 
                        alt="{{ $cancha->nombre }}">

                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 p-3 rounded">
                        <h5 class="text-white">{{ $cancha->nombre }}</h5>

                        <form action="{{ route('reservas.store') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="cancha_id" value="{{ $cancha->id }}">

                            <div class="mb-2">
                                <label class="form-label text-white">Fecha:</label>
                                <input type="date" name="fecha" class="form-control" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-white">Hora:</label>
                                <input type="time" name="hora" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Reservar</button>
                        </form>
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
</div>
@endsection
