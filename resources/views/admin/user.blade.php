@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Lista de Usuarios</h2>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Documento</th>
                <th>Teléfono</th>
                <th>Rol</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->document }}</td>
                    <td>{{ $usuario->phonenumber }}</td>
                    <td>
                        <form action="{{ route('usuarios.updateRole', $usuario->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="role_id" class="form-select" onchange="this.form.submit()">
                                <option value="1" {{ $usuario->role_id == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ $usuario->role_id == 2 ? 'selected' : '' }}>Cliente</option>
                            </select>
                        </form>
                    </td>
                    <td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
