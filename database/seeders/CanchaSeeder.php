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
                'imagen' => 'https://recreasport.com/wp-content/uploads/2017/04/SAM_0191-2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Cancha de Baloncesto',
                'ubicacion' => 'Cancha 2',
                'capacidad' => 50,
                'imagen' => 'https://phantom-marca-us.uecdn.es/7eda3affb954508ac147a152da00b8e7/f/webp/assets/multimedia/imagenes/2022/03/21/16478751905102.jpg',
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