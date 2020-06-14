@extends('app')

@section('content')
  <form action="{{url('cita', ['id' => $cita->id])}}" method="POST" id="appointment">
    @csrf
    @method('put')
    <label for="curp">CURP del ciudadano: </label>
    <input id="curp" type="text" name="curp" value="{{$cita->curp}}">
    
    <label for="tramite">Tipo de Trámite</label>
    <select name="tramite_id" id="tramite-id" form="appointment">
        <option value="0" selected disabled>--- TIPO DE TRAMITE ---</option>
      @foreach($tramites as $tramite)
        <option value="{{$tramite->id}}">{{$tramite->nombre}}</option>
      @endforeach
    </select>
    
    <label for="modulo-atencion">Modulo de atención</label>
    <select name="modulo_atencion_id" id="modulo-atencion-id" form="appointment">
        <option value="0" selected disabled>--- SELECCIONA MODULO ---</option>
      @foreach($modulos_atencion as $modulo_atencion)
        <option value="{{$modulo_atencion->id}}">{{$modulo_atencion->nombre}}</option>
      @endforeach
    </select>
    <div class="margin-top-5">
      <label for="modulo-atencion">Fecha Cita:</label>
      <input type="text" name="fecha_cita" id="fecha-cita" class="datepicker"/>
      <label for="modulo-atencion">Hora Cita:</label>
      <input type="text" name="hora_cita" class="timepicker" />    
    </div>
    <button type="submit" class="margin-top-5">
      EDITAR CITA
    </button>
  </form>
@endsection