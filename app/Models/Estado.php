<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estado'; // Nombre real de la tabla

    protected $fillable = ['nombre']; // Campos permitidos para asignación masiva
   
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
