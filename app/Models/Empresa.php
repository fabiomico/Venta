<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $fillable = [
        'nombre',
        'logo',
        'telefono',
        'correo',
        'direccion',
        'nit',
        'id_user'
    ];

    public function sucursales()
    {
        return $this->hasMany(Sucursal::class);
    }

    
}
