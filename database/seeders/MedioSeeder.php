<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medio;

class MedioSeeder extends Seeder
{
    public function run(): void
    {
        Medio::factory()->count(50)->create();
    }
}
