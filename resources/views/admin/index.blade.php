@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Hola, Admin</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Panel de Administración</h5>
            <p class="card-text">Bienvenido al panel de administración. Aquí puedes gestionar las reservas, usuarios e instalaciones.</p>
            
            
            <a href="{{ route('admin.user') }}" class="btn btn-secondary">Usuarios</a> <!-- Nuevo botón -->
            <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger mt-3">Cerrar Sesión</button>
    </form>
        </div>
    </div>
</div>
@endsection
