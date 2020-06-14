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

  public function index() {
    return view('citas', [
      'citas' => Cita::with(['moduloAtencion', 'tramite'])->get()
    ]);
  }

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

  public function editAppointment($id) {
    $cita = Cita::find($id);
    $horario = Horario::where('tipo_dia', 'habil')->first();
    return view('editar_cita', [
      'cita' => $cita,
      'tramites' => Tramite::all(),
      'modulos_atencion' => ModuloAtencion::all(),
      'hora_inicio' => $horario->hora_inicio,
      'hora_fin' => $horario->hora_fin,
    ]);
  }

  public function update(Request $request, $id) {
    $request->validate([
      'curp' => ['required', 'size:18'],
      'modulo_atencion_id' => ['required'],
      'tramite_id' => ['required'],
      'fecha_cita' => ['required'],
      'hora_cita' => ['required'],
    ]);
    $updated = Cita::find($id)->update([
      'curp' =>  $request->curp,
      'modulo_atencion_id' => $request->modulo_atencion_id,
      'tramite_id' => $request->tramite_id,
      'horario' => new Carbon("$request->fecha_cita $request->hora_cita", self::$timezone)
    ]);
    if (!$updated) {
      return redirect()->back()->withErrors(['Error' => 'No se pudo editar la cita']);
    }
    return redirect()->back()->withSuccess("La cita $id fue editada correctamente");
  }
    
  public function destroy($id) {
    if (!$cita = Cita::find($id)) {
      return redirect()->back()->withErrors(['Error' => 'No se pudo encontrar la cita']);
    }
    if (!$cita->delete()) {
      return redirect()->back()->withErrors(['Error' => 'No se pudo eliminar la cita']);
    }
    return redirect()->back()->withSuccess("La cita $id fue eliminada");
  } 
}