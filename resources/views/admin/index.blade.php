@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Hola, Admin</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Panel de Administración</h5>
            <p class="card-text">Bienvenido al panel de administración. Aquí puedes gestionar las reservas, usuarios e instalaciones.</p>
            
            <a href="{{ route('admin.reservas') }}" class="btn btn-primary">Ver Todas las Reservas</a> <!-- Nuevo botón -->
            <a href="{{ route('admin.user') }}" class="btn btn-secondary">Usuarios</a> <!-- Botón existente -->
            
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</div>
@endsection
