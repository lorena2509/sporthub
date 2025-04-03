@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4" style="font-family: 'Arial Black', sans-serif; font-size: 2.5rem; color: white;">
        Editar Cancha
    </h1>
    <form action="{{ route('admin.canchas.update', $cancha->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="nombre" class="fw-bold" style="color: #007bff;">Nombre</label>
            <input type="text" class="form-control rounded-3" id="nombre" name="nombre" value="{{ $cancha->nombre }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ubicacion" class="fw-bold" style="color: #007bff;">Ubicación</label>
            <input type="text" class="form-control rounded-3" id="ubicacion" name="ubicacion" value="{{ $cancha->ubicacion }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="capacidad" class="fw-bold" style="color: #007bff;">Capacidad</label>
            <input type="number" class="form-control rounded-3" id="capacidad" name="capacidad" value="{{ $cancha->capacidad }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="imagen" class="fw-bold" style="color: #007bff;">Imagen</label>
            <input type="file" class="form-control rounded-3" id="imagen" name="imagen">
            @if($cancha->imagen)
                <img src="{{ $cancha->imagen }}" alt="{{ $cancha->nombre }}" class="img-thumbnail" style="width: 100px; height: auto;">
            @else
                <span class="text-muted">No Image</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.canchasList') }}" class="btn btn-secondary mt-3">Volver</a>
    </form>
</div>
@endsection
