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
       
    ];
<<<<<<< HEAD

    public function sucursales()
    {
        return $this->hasMany(Sucursal::class);
    }

=======
>>>>>>> 7c87a1ed22870e3111cdee707d67068228a7f5a1
    
}
