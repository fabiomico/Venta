<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $fillable = [
        'id',
        'empresa_id',
        'nombre',
        'telefono',
        'email',
        'direccion',
        'ciudad',
        'departamento',
        'lat',
        'lng',
        'estado'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function almacenes()
    {
        return $this->hasMany(Almacen::class);
    }
}
