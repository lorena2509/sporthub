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

    <div id="canchasCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner text-center"> <!-- Se centra el contenido -->
            @foreach($canchas as $index => $cancha)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ $cancha->imagen }}" class="d-block mx-auto rounded" style="max-width: 80%; height: auto;" alt="{{ $cancha->nombre }}">
                
                <!-- Información debajo de la imagen -->
                <div class="mt-3 text-dark">
                    <h3>{{ $cancha->nombre }}</h3>
                    <p><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
                    <p><strong>Capacidad:</strong> {{ $cancha->capacidad }} personas</p>
                    
                    <!-- Botón de reservar -->
                    <button class="btn btn-primary" onclick="reservarCancha({{ $cancha->id }})">Reservar</button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#canchasCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#canchasCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>


    <!-- Modales para cada cancha -->
    @foreach($canchas as $cancha)
    <div class="modal fade" id="modalReserva{{ $cancha->id }}" tabindex="-1" aria-labelledby="modalReservaLabel{{ $cancha->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-dark" id="modalReservaLabel{{ $cancha->id }}">Reservar {{ $cancha->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Imagen pequeña -->
                    <img src="{{ $cancha->imagen }}" alt="{{ $cancha->nombre }}" class="img-thumbnail mb-3" style="max-width: 250px; border-radius: 10px;">

                    <!-- Información de la cancha con texto en negro -->
                    <h5 class="fw-bold text-dark">{{ $cancha->nombre }}</h5>
                    <p class="text-dark"><strong>Ubicación:</strong> {{ $cancha->ubicacion }}</p>
                    <p class="text-dark"><strong>Capacidad:</strong> {{ $cancha->capacidad }} personas</p>

                    <hr>

                    <!-- Formulario de reserva -->
                    <form action="{{ route('reservas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cancha_id" value="{{ $cancha->id }}">

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold text-dark">Fecha de Reserva:</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold text-dark">Hora de Reserva:</label>
                            <select name="hora" class="form-select" required>
                                @for ($i = 12; $i <= 22; $i++) <!-- Horarios desde las 6 AM hasta las 10 PM -->
                                    @php
                                        $hora24 = sprintf('%02d:00', $i);
                                        $hora12 = date('h:i A', strtotime($hora24));
                                    @endphp
                                    <option value="{{ $hora24 }}">{{ $hora12 }}</option>
                                @endfor
                            </select>
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