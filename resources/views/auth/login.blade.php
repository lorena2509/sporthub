@extends('layouts.app')

@section('title', 'Inicio de Sesión')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card">
                <div class="card2">
                    <h2 class="text-center">Iniciar Sesión</h2>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="field">
                            <input type="email" name="email" class="input-field" placeholder="Correo Electrónico" required>
                        </div>
                        <div class="field">
                            <input type="password" name="password" class="input-field" placeholder="Contraseña" required>
                        </div>
                        <button type="submit" class="button1">Iniciar Sesión</button>
                    </form>
                    <p class="mt-3 text-center">
                        ¿No tienes cuenta? <a href="{{ route('register') }}">Registrarse</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
