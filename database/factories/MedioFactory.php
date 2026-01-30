<?php

namespace Database\Factories;

use App\Models\Medio;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedioFactory extends Factory
{
    protected $model = Medio::class;

    public function definition()
    {
        return [
            'inventario' => $this->faker->unique()->regexify('[0-9]{5}'),
            'inventario_viejo' => $this->faker->unique()->regexify('[0-9]{4}/[0-9]{2}-[0-9]{5}'),
            'serie' => $this->faker->unique()->regexify('[a-z]{20}'),
            'ip' => $this->faker->unique()->ipv4(),
            'red_id' => rand(1, 3),
            'medio_tipo_id' => rand(1, 3),
        ];
    }
}
