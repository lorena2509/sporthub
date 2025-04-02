@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4" style="font-family: 'Arial Black', sans-serif; font-size: 2.5rem; color: #333;">
        ⚽ Lista de Canchas
    </h1>
    
    <div class="mb-3">
        <a href="{{ route('admin.canchas.create') }}" class="btn btn-primary">➕ Agregar Cancha</a>
    </div>
    
    <table class="table table-hover shadow-lg rounded-4">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Capacidad</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="text-center align-middle">
            @foreach($canchas as $cancha)
            <tr>
                <td><strong>{{ $cancha->id }}</strong></td>
                <td class="fw-bold">{{ $cancha->nombre }}</td>
                <td>{{ $cancha->ubicacion }}</td>
                <td>{{ $cancha->capacidad }}</td>
                <td>
                    @if($cancha->imagen)
                        <img src="{{ asset('storage/' . $cancha->imagen) }}" alt="{{ $cancha->nombre }}" 
                             class="img-thumbnail border border-dark shadow-sm rounded-3" 
                             style="width: 120px; height: 80px; object-fit: cover;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.canchas.edit', $cancha->id) }}" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <form action="{{ route('admin.canchas.destroy', $cancha->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta cancha?')">
                            🗑️ Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">⬅️ Volver</a>
    </div>
</div>
@endsection
