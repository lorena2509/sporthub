@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded-4" style="background: rgba(255, 255, 255, 0.8); max-width: 500px; width: 100%;">
        <h1 class="text-center mb-4" style="font-family: 'Arial Black', sans-serif; font-size: 2rem; color: white;">
            ⚽ Crear una Cancha
        </h1>

        <form action="{{ route('admin.canchas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label fw-bold" style="color: #007bff;">🏟 Nombre</label>
                <input type="text" class="form-control rounded-3" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="ubicacion" class="form-label fw-bold" style="color: #007bff;">📍 Ubicación</label>
                <input type="text" class="form-control rounded-3" id="ubicacion" name="ubicacion" required>
            </div>

            <div class="mb-3">
                <label for="capacidad" class="form-label fw-bold" style="color: #007bff;">👥 Capacidad</label>
                <input type="number" class="form-control rounded-3" id="capacidad" name="capacidad" required>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label fw-bold" style="color: #007bff;">🖼 Imagen</label>
                <input type="file" class="form-control rounded-3" id="imagen" name="imagen">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.canchasList') }}" class="btn btn-secondary shadow-sm">⬅️ Volver</a>
                <button type="submit" class="btn btn-primary shadow-sm">✅ Crear</button>
            </div>
        </form>
    </div>
</div>
@endsection
