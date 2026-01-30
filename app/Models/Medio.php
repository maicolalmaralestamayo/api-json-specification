<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medio extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $table = 'medios';

    static $type = 'medios'; //minúscula + plural

    static $attribs = [ //izq. = nombre del campo en la api, der. = nombre del campo en la tabla
        'inv' => 'inventario',
        'inv_viejo' => 'inventario_viejo',
        'serie' => 'serie',
        'ip' => 'ip',
    ];

    static $fk = [
        'red_id' => 'red_id', //izq. = nombre del campo en la api, der. = nombre del campo en la tabla
        'medio_tipo_id' => 'medio_tipo_id',
    ];

    static $times = [ //izq. = nombre del campo en la api, der. = nombre del campo en la tabla
        'creado' => 'created_at',
        'actualizado' => 'updated_at',
        'eliminado' => 'deleted_at',
    ];

    static $belongsTo = ['red', 'tipo'];    //minúscula + singular 

    public function red(): BelongsTo
    {
        return $this->belongsTo(Red::class, 'red_id', 'id');
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(MedioTipo::class, 'medio_tipo_id', 'id');
    }
}