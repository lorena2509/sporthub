<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla de usuarios
            $table->foreignId('cancha_id')->constrained('canchas')->onDelete('cascade'); // Relación con la tabla de canchas
            $table->foreignId('estado_id')->constrained('estado')->onDelete('cascade'); // Relación con la tabla de estados
            $table->date('fecha'); // Fecha de la reserva
            $table->time('start_time'); // Hora de inicio de la reserva
            $table->time('end_time'); // Hora de finalización de la reserva
            $table->timestamp('fecha_creada')->useCurrent(); // Fecha en que se creó la reserva
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
};
