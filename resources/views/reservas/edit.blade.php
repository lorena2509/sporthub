@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Modificar Reserva</h2>

    <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Cancha</label>
            <select name="cancha_id" class="form-control">
                @foreach($canchas as $cancha)
                    <option value="{{ $cancha->id }}" {{ $reserva->cancha_id == $cancha->id ? 'selected' : '' }}>
                        {{ $cancha->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $reserva->fecha }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Hora de Inicio</label>
            <input type="time" name="start_time" class="form-control" value="{{ $reserva->start_time }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
