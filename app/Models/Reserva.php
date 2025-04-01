<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reserva extends Model
{
    use HasFactory;
    protected $table = 'reservas'; // Asegura que el nombre de la tabla sea correcto

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id', 
        'cancha_id', 
        'estado_id', 
        'fecha', 
        'start_time', 
        'end_time', 
        'fecha_creada'
    ];

    // Relación con la tabla de usuarios
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relación con la tabla de canchas
    public function cancha() {
        return $this->belongsTo(Cancha::class);
    }

    // Relación con la tabla de estado
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    // Accesor para obtener la fecha en formato legible
    public function getFechaFormateadaAttribute() {
        return Carbon::parse($this->fecha)->format('d/m/Y');
    }

    // Accesor para obtener la hora de inicio formateada
    public function getHoraInicioFormateadaAttribute() {
        return Carbon::parse($this->start_time)->format('H:i');
    }

    // Accesor para obtener la hora de finalización formateada
    public function getHoraFinFormateadaAttribute() {
        return Carbon::parse($this->end_time)->format('H:i');
    }
}
