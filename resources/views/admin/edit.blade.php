@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cancha</h1>
    <form action="{{ route('admin.canchas.update', $cancha->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cancha->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ $cancha->ubicacion }}" required>
        </div>
        <div class="form-group">
            <label for="capacidad">Capacidad</label>
            <input type="number" class="form-control" id="capacidad" name="capacidad" value="{{ $cancha->capacidad }}" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
            <img src="{{ asset('storage/' . $cancha->imagen) }}" alt="{{ $cancha->nombre }}" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.canchasList') }}" class="btn btn-secondary mt-3">Volver</a>
    </form>
</div>
@endsection
