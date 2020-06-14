<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    // protected $table = 'tramites';

    protected $fillable = [
        'nombre',
        'prioridad'
    ];
    
    public function citas() {
        return $this->hasMany('App\Cita', 'tramite_id');
    }
}
