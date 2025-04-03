@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-card-style.css') }}">
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 75vh; position: relative; background: transparent;">
    <div class="card" style="width: 80%; height: 100%; padding: 20px; position: absolute; z-index: 0; background: transparent; border: none; box-shadow: none;"></div>
    <h1 class="text-center my-4 title" style="color: white; font-size: 3rem; position: relative; z-index: 1;">Menú Principal</h1>
    <div class="row w-100 d-flex justify-content-center gap-4" style="margin-top: 30px; position: relative; z-index: 1;">
        <!-- Tarjeta: Administrar Canchas -->
        <div class="col-md-3">
            <a href="{{ route('admin.canchasList') }}" class="text-decoration-none">
                <div class="e-card playing">
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="infotop">
                        <h5 class="card-title text-primary fw-bold" style="font-size: 2rem;">⚽ Administrar Canchas</h5>
                    </div>
                </div>
            </a>
        </div>
        <!-- Tarjeta: Administrar Usuarios -->
        <div class="col-md-3">
            <a href="{{ route('admin.user') }}" class="text-decoration-none">
                <div class="e-card playing">
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="infotop">
                        <h5 class="card-title text-primary fw-bold" style="font-size: 2rem;">👥 Administrar Usuarios</h5>
                    </div>
                </div>
            </a>
        </div>
        <!-- Tarjeta: Administrar Reservas -->
        <div class="col-md-3">
            <a href="{{ route('admin.reservas') }}" class="text-decoration-none">
                <div class="e-card playing">
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="infotop">
                        <h5 class="card-title text-primary fw-bold" style="font-size: 2rem; color: black;">📅 Administrar Reservas</h5>
                    </div>
                </div>
            </a>
        </div>
        <!-- Tarjeta: Ver Estadísticas -->
        <div class="col-md-3">
            <a href="{{ route('admin.estadisticas') }}" class="text-decoration-none">
                <div class="e-card playing">
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="infotop">
                        <h5 class="card-title text-success fw-bold" style="font-size: 2rem; color: black;">📊 Ver Estadísticas</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
