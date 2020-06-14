@extends('app')

@section('content')
  <table id="appointments-table">
    <tr>
      <th>CURP</th>
      <th>Tipo de Tramite</th>
      <th>Módulo Atención</th>
      <th>Horario</th>
    </tr>
  </table>

  <script>
    let table = document.getElementById('appointments-table');
    let citas = @json($citas);
    citas.forEach((cita, index) => {
      let row = table.insertRow(index+1)
      let curp = row.insertCell(0)
      let tipoTramite = row.insertCell(1)
      let moduloAtencion = row.insertCell(2)
      let horario = row.insertCell(3)
      curp.innerHTML = cita.curp
      tipoTramite.innerHTML = cita.tramite.nombre
      moduloAtencion.innerHTML = cita.modulo_atencion.nombre
      horario.innerHTML = cita.horario
    })
  </script>
@endsection