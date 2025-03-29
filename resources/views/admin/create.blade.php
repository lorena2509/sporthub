@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Cancha</h1>
    <form action="{{ route('admin.canchas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
        </div>
        <div class="form-group">
            <label for="capacidad">Capacidad</label>
            <input type="number" class="form-control" id="capacidad" name="capacidad" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
