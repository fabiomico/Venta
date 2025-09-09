<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $fillable = [
        'id',
        'sucursal_id',
        'nombre',
        'tipo',
        'direccion',
        'estado'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function empresa()
    {
        // acceso conveniente
        return $this->hasOneThrough(Empresa::class, Sucursal::class, 'id', 'id', 'sucursal_id', 'empresa_id');
    }
}
