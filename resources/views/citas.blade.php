@extends('app')

@section('content')
  <table>
    <tr>
      <th>CURP</th>
      <th>Tipo de Tramite</th>
      <th>Módulo Atención</th>
      <th>Horario</th>
      <th>Acciones</th>
    </tr>
    @foreach ($citas as $cita)
      <tr>
        <td>{{$cita->curp}}</td>
        <td>{{$cita->tramite->nombre}}</td>
        <td>{{$cita->moduloAtencion->nombre}}</td>
        <td>{{$cita->horario}}</td>
        <td>
          <form action="{{url('editar-cita', ['id' => $cita->id])}}" method="GET">
            <button type="submit">Editar Cita</button>
          </form>
          <form action="{{ url('cita', ['id' => $cita->id]) }}" method="post">
            @method('delete')
            @csrf
            <button type="submit">Borrar Cita</a>
          </form>
        </td>
      </tr>
    @endforeach
  </table>
@endsection