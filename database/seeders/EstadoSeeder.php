<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado')->insert([
            ['id' => 1, 'name' => 'Reservado'],
            ['id' => 2, 'name' => 'Cancelado'], 
            ['id' => 3, 'name' => 'Finalizado'],
        ]);
    }
}
