@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4" style="font-family: 'Arial Black', sans-serif; font-size: 2.5rem; color: #333;">
        🏅 Lista de Usuarios
    </h1>

    <table class="table table-hover shadow-lg rounded-4 border border-dark"> <!-- Aquí agregamos el borde negro -->
        <thead class="table-dark text-center">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Documento</th>
                <th>Teléfono</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody class="text-center align-middle">
            @foreach($usuarios as $usuario)
            <tr>
                <td class="fw-bold">{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->document }}</td>
                <td>{{ $usuario->phonenumber }}</td>
                <td>
                    <form action="{{ route('usuarios.updateRole', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="role_id" class="form-select text-center text-dark" onchange="this.form.submit()">
                            <option value="1" class="text-dark" {{ $usuario->role_id == 1 ? 'selected' : '' }}>🔧 Admin</option>
                            <option value="2" class="text-dark" {{ $usuario->role_id == 2 ? 'selected' : '' }}>👤 Cliente</option>
                        </select>
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

