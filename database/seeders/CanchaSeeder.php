<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CanchaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('canchas')->insert([
            [
                'nombre' => 'Cancha de Fútbol',
                'ubicacion' => 'Cancha 1',
                'capacidad' => 100,
                'imagen' => 'https://ennombredelftbol.wordpress.com/wp-content/uploads/2016/05/cesped-artificial.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Cancha de Baloncesto',
                'ubicacion' => 'Cancha 2',
                'capacidad' => 50,
                'imagen' => 'https://blog.marti.mx/wp-content/uploads/2023/08/Cancha_basquet_Header.webp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Cancha de Tenis',
                'ubicacion' => 'Cancha 3',
                'capacidad' => 30,
                'imagen' => 'https://civideportes.com.co/wp-content/uploads/2020/08/asphalt-tennis-court-5354328_640.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}