<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'curp', 'modulo_atencion_id', 'tramite_id', 'horario'
    ];
    
    public function moduloAtencion() {
        return $this->belongsTo('App\ModuloAtencion');
    }
    
    public function tramite() {
        return $this->belongsTo('App\Tramite');
    }
}
