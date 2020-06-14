<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'nombre', 'direccion',
    ];

    public function citas() {
        return $this->hasMany('App\Cita', 'modulo_atencion_id');
    }
}

