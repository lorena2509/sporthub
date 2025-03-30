@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Menú Principal</h1>
    
    <div class="list-group">
        <a href="{{ route('admin.canchasList') }}" class="list-group-item list-group-item-action">Administrar Canchas</a>
        <a href="{{ route('admin.user') }}" class="list-group-item list-group-item-action">Administrar Usuarios</a>
        <a href="{{ route('admin.reservas') }}" class="list-group-item list-group-item-action">Administrar Reservas</a>
    </div>
    <a href="{{ route('login') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection