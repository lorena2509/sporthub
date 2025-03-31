@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Canchas</h1>
    <a href="{{ route('admin.canchas.create') }}" class="btn btn-primary">Agregar Cancha</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Capacidad</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($canchas as $cancha)
            <tr>
                <td>{{ $cancha->id }}</td>
                <td>{{ $cancha->nombre }}</td>
                <td>{{ $cancha->ubicacion }}</td>
                <td>{{ $cancha->capacidad }}</td>
                <td>
                    @if($cancha->imagen)
                        <img src="{{ $cancha->imagen }}" alt="{{ $cancha->nombre }}" class="img-thumbnail" style="width: 100px; height: auto;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.canchas.edit', $cancha->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('admin.canchas.destroy', $cancha->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta reserva?')">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
