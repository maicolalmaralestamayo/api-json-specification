<?php

namespace Database\Seeders;

use App\Models\MedioTipo;
use Illuminate\Database\Seeder;

class MedioTipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['tipo' => 'Computadora de escritorio', 'abreviatura' => 'PC Desktop'],
            ['tipo' => 'Computadora portátil', 'abreviatura' => 'PC Laptop'],
            ['tipo' => 'Tableta', 'abreviatura' => 'tablet'],
        ];

        foreach ($tipos as $tipo) {
            MedioTipo::create($tipo);
        }
    }
}
