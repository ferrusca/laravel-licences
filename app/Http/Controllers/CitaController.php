<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\ModuloAtencion;
use App\Tramite;
use App\Horario;
use App\Cita;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Response;
use DateTimeZone;

class CitaController extends Controller
{
  
  static $timezone = 'America/Mexico_City'; 

  public function store(Request $request) {
    $appointment = (object) $request->validate([
      'curp' => ['required', 'size:18'],
      'modulo_atencion_id' => ['required'],
      'tramite_id' => ['required'],
      'fecha_cita' => ['required'],
      'hora_cita' => ['required'],
    ]);
    
    $horario_cita = new Carbon("$appointment->fecha_cita $appointment->hora_cita", self::$timezone);

    if (
      Cita::where('horario', $horario_cita)
      ->where('modulo_atencion_id', $appointment->modulo_atencion_id)
      ->first()
    ) {
      return redirect()->back()->withErrors([
        'Error' => 'El horario ya se encuentra ocupado en el modulo de atención seleccionado'
      ]);
    }

    $week_day_today = Carbon::now(new DateTimeZone(self::$timezone))->dayOfWeek;
    $week_start_date = Carbon::now(new DateTimeZone(self::$timezone))->subDays($week_day_today);
    $week_end_date = Carbon::now(new DateTimeZone(self::$timezone))->addDays(6-$week_day_today);

    if (
      Cita::where('curp', $appointment->curp)
        ->whereBetween('created_at', [$week_start_date, $week_end_date])
        ->first()
    ) {
      return redirect()->back()->withErrors(['Error' => 'Este CURP ya generó una cita durante la semana en curso']);
    }
    
    $cita = new Cita;
    $cita->curp = $appointment->curp;
    $cita->tramite_id = $appointment->tramite_id;
    $cita->modulo_atencion_id = $appointment->modulo_atencion_id;
    $cita->horario = $horario_cita;
    if (!$cita->save()) {
      return redirect()->back()->withErrors(['Error' => 'No se pudo guardar la cita']);
    }
    return redirect()->back()->withSuccess('Cita guardada exitosamente');
  }

  public function newAppointment()
  {
    $horario = Horario::where('tipo_dia', 'habil')->first();
    return view('nueva_cita', [
      'tramites' => Tramite::all(),
      'modulos_atencion' => ModuloAtencion::all(),
      'hora_inicio' => $horario->hora_inicio,
      'hora_fin' => $horario->hora_fin,
    ]);
  }
}