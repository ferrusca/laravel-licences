<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ModuloAtencion extends Model
{
    protected $table = 'modulos_atencion';
    protected $fillable = [
        'nombre', 'direccion',
    ];

    public function citas() {
        return $this->hasMany('App\Cita', 'modulo_atencion_id');
    }
}

