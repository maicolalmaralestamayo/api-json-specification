<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RedSeeder::class,
            MedioTipoSeeder::class,
            MedioSeeder::class, 
        ]);
    }
}
