@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="text-center">
    <h2>Bienvenido, {{ auth()->user()->name }}!</h2>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger mt-3">Cerrar Sesión</button>
    </form>
</div>
@endsection
