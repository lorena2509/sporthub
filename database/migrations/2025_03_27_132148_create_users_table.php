<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('document')->unique(); // Asegúrate de que esta línea está presente
    $table->string('phonenumber');
            $table->unsignedBigInteger('role_id'); // Debe ser unsigned
            $table->timestamps();
        
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        
    }
  
    public function down()
    {
        Schema::dropIfExists('users');
    }
};