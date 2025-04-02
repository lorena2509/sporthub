@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 75vh;">
    <h1 class="text-center my-4" style="font-family: 'Arial Black', sans-serif; font-size: 4.5rem; color: #2c3e50;">
         Menú Principal
    </h1>

    <!-- Añadí margen superior para separar el título de las tarjetas -->
    <div class="row w-100 d-flex justify-content-center gap-4" style="margin-top: 70px;">
        <!-- Tarjeta: Administrar Canchas -->
        <div class="col-md-3">
            <a href="{{ route('admin.canchasList') }}" class="text-decoration-none">
                <div class="card text-center shadow-lg p-4 rounded-4 border-0"
                     style="background: rgba(200, 200, 200, 0.8); transition: transform 0.3s ease; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold" style="font-size: 2rem;">⚽ Administrar Canchas</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta: Administrar Usuarios -->
        <div class="col-md-3">
            <a href="{{ route('admin.user') }}" class="text-decoration-none">
                <div class="card text-center shadow-lg p-4 rounded-4 border-0"
                     style="background: rgba(200, 200, 200, 0.8); transition: transform 0.3s ease; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold" style="font-size: 2rem;">👥 Administrar Usuarios</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta: Administrar Reservas -->
        <div class="col-md-3">
            <a href="{{ route('admin.reservas') }}" class="text-decoration-none">
                <div class="card text-center shadow-lg p-4 rounded-4 border-0"
                     style="background: rgba(200, 200, 200, 0.8); transition: transform 0.3s ease; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold" style="font-size: 2rem;">📅 Administrar Reservas</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tarjeta: Ver Estadísticas -->
        <div class="col-md-3">
            <a href="{{ route('admin.estadisticas') }}" class="text-decoration-none">
                <div class="card text-center shadow-lg p-4 rounded-4 border-0"
                     style="background: rgba(200, 200, 200, 0.8); transition: transform 0.3s ease; width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title text-success fw-bold" style="font-size: 2rem;">📊 Ver Estadísticas</h5>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>
@endsection
