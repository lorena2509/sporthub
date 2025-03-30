@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card">
        <div class="card2">
            <form class="form" action="{{ route('register.post') }}" method="POST">
                @csrf
                <p id="heading">Registro</p>

                <div class="field">
                    <input type="text" name="name" class="input-field" placeholder="Nombre" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input type="email" name="email" class="input-field" placeholder="Correo Electrónico" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input type="password" name="password" class="input-field" placeholder="Contraseña" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input type="password" name="password_confirmation" class="input-field" placeholder="Confirmar Contraseña" required>
                </div>

                <div class="field">
                    <input type="text" name="document" class="input-field" placeholder="Documento" value="{{ old('document') }}" required>
                    @error('document')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input type="text" name="phonenumber" class="input-field" placeholder="Teléfono" value="{{ old('phonenumber') }}" required>
                    @error('phonenumber')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="btn">
                    <button type="submit" class="button1">Registrarse</button>
                </div>

                <p class="text-center">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection