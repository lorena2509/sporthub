@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center">Registro</h2>
        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="document" class="form-label">Documento</label>
                <input type="text" name="document" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phonenumber" class="form-label">Teléfono</label>
                <input type="text" name="phonenumber" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Rol</label>
                <select name="role_id" class="form-control" required>
                    <option value="1">Admin</option>
                    <option value="2">Usuario</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>
        <p class="mt-3 text-center">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
        </p>
    </div>
</div>
@endsection
