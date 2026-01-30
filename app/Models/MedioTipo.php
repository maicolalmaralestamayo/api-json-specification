<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedioTipo extends Model
{
    use HasFactory;

    static $type = 'tipos-medio';

    static $attribs = [
        'tipo' => 'tipo',
        'abreviatura' => 'abreviatura',
        'descripcion' => 'descripcion',
        'observacion' => 'observacion',
    ];

    static $times = [
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
        'deleted_at' => 'deleted_at',
    ];

    static $hasMany = ['medios'];

    public function medios(): HasMany
    {
        return $this->hasMany(Medio::class);
    }
}
