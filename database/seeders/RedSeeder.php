<?php

namespace Database\Seeders;

use App\Models\Red;
use Illuminate\Database\Seeder;

class RedSeeder extends Seeder
{
    public function run(): void
    {
        $redes = [
            ['red' => 'Red de Comunicaciones Privadas para la Defensa', 'abreviatura' => 'RCPD'],
            ['red' => 'Red Interna de Servicios', 'abreviatura' => 'RIS'],
            ['red' => 'Red de de Desarrollo', 'abreviatura' => 'RD'],
        ];

        foreach ($redes as $red) {
            Red::create($red);
        }
    }
}
