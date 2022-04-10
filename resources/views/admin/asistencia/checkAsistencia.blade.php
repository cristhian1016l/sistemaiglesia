<?php
// date_default_timezone_set('America/Lima');
// \Carbon\Carbon::setLocale('es');
\Carbon\Carbon::setLocale('es');
?>
@extends('layouts.app')
@section('title', 'Asistencia')
@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<!-- SWEET ALERT -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endsection
@section('contenido')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-3">
          <h1>Registro anterior</h1>
        </div>
        <div class="col-sm-9">
          <ol class="breadcrumb float-sm-right">
            @if($asistencia->CodAct == '001')
            <a>
              <button class="btn btn-success mr-4" id="faultsDS" onclick="faultsProcessDS()">
                Procesar faltas [Discipulados]
              </button>
            </a>
            <a>
              <button class="btn btn-success mr-4" id="faultsCP" onclick="faultsProcessCP()">
                Procesar faltas [CDP]
              </button>
            </a>
            @endif
            @if($asistencia->CodAct == '002')
            <a>
              <button class="btn btn-success mr-4" id="prayerReport" onclick="prayerReport()">
                Procesar reporte de oración
              </button>
            </a>
            @endif
            <a href="{{ route('admin.asistencia.index') }}">
              <button class="btn btn-primary">
                Regresar
              </button>
            </a>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Actividad</h3>
            </div>
            <!-- form start -->
            <div class="card-body">
              <div class="form-group">
                <label for="asistencia">Asistencia</label>
                <input name="asistencia" class="form-control form-control-sm" id="asistencia" value="{{ $asistencia->CodAsi }}" readonly>
              </div>
              <div class="form-group">
                <label for="asistencia">Asistencia</label>
                <input name="asistencia" class="form-control form-control-sm" id="codact" value="{{ $asistencia->CodAct }}" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Fecha</label>
                <input name="fecha" type="text" class="form-control form-control-sm" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($asistencia->FecAsi)->toDateString() }}" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Actividad</label>
                <input name="actividad" type="text" class="form-control form-control-sm" id="exampleInputPassword1" value="{{ $asistencia->TipAsi }}" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Desde</label>
                <input name="desde" type="text" class="form-control form-control-sm" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($asistencia->HorDesde)->toTimeString() }}" readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Hasta</label>
                <input name="hasta" type="text" class="form-control form-control-sm" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($asistencia->HorHasta)->toTimeString() }}" readonly>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Asistentes</label>
                    <input name="hasta" type="text" class="form-control form-control-sm" id="TotAsistencias" value="{{ $asistentes }}" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Faltantes</label>
                    <input name="hasta" type="text" class="form-control form-control-sm" id="TotFaltas" value="{{ $faltantes }}" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
        <div class="col-md-9">
          <div class="col-md-12">
            <section class="content">
              <div class="container-fluid">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Lista de miembros registrados en {{ $asistencia->TipAsi }}</h3>
                  </div>
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>CODIGO</th>
                          <th>MIEMBROS</th>
                          <th>HORA</th>
                          <th>ESTADO</th>
                          <!-- <th>ASISTIO</th> -->
                          <th>CHECK</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($detasi as $miembro)
                        <tr>
                          <td>{{ $miembro->CodCon }}</td>
                          <td>{{ $miembro->NomApeCon }}</td>
                          <td>
                            <?php
                            if (isset($miembro->HorLlegAsi)) {
                              echo date("h:i:s A", strtotime($miembro->HorLlegAsi));
                            } else {
                              echo "";
                            }
                            ?>
                          </td>
                          <td>
                            <?php
                            switch ($miembro->EstAsi) {
                              case 'A':
                                echo 'ASISTIO';
                                break;
                              case 'F':
                                echo 'FALTO';
                                break;
                              case 'P':
                                echo 'PERMISO';
                                break;
                            }
                            ?>
                          </td>
                          <!-- <td>{{ $miembro->Asistio }}</td> -->
                          <td style="text-align: center;">
                            @if($miembro->Asistio)
                            <button class='btn btn-success btn-sm' onclick="deleteAssistanceMember('<?php echo $miembro->CodCon ?>','<?php echo $miembro->CodAsi ?>')">
                              <i class="fas fa-minus-circle"></i>
                            </button>
                            @else
                            <button class='btn btn-danger btn-sm' onclick="updateRegisterMember('<?php echo $miembro->CodCon ?>','<?php echo $miembro->CodAsi ?>')">
                              <i class="far fa-check-circle"></i>
                            </button>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>CODIGO</th>
                          <th>MIEMBROS</th>
                          <th>HORA</th>
                          <th>ESTADO</th>
                          <!-- <th>ASISTIO</th> -->
                          <th>CHECK</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
      <!-- /.col (left) -->
    </div>

</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      // "buttons": ["excel", "pdf", "print"],
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ miembros",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Miembros",
        "infoFiltered": "(Filtrado de _MAX_ registros)",
        "zeroRecords": "No se encontraron resultados",
        "emptyTable": "Ningún dato disponible en esta tabla",
        "paginate": {
          "first": "primero",
          "last": "último",
          "next": "siguiente",
          "previous": "anterior"
        },
      },
      "columnDefs": [{
          "targets": [0],
          "visible": false,
          "searchable": false
        },
        {
          "targets": [2],
          "searchable": false
        },
        {
          "targets": [3],
          "searchable": false
        },
        {
          "targets": [4],
          "searchable": false
        },
      ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    var table = $('#example1').DataTable();
    $('div.dataTables_filter input', table.table().container()).focus();
  });

  document.getElementById("menuasistenciaopen").className += ' menu-open';    
  document.getElementById("adminasistenciaactive").className += " active";    
  document.getElementById("assistance").className += " active";   

</script>

<!-- ADMINISTRACION -->
<script>
  function updateRegisterMember(Codcon, Codasi) {
    var codact = $('#codact').val();
    $('#example1').dataTable().fnClearTable();
    $('#example1').dataTable().fnDestroy();
    $('#example1').DataTable({
      "ajax": {
        "type": "POST",
        "url": "/administracion/registrarAsistencia",
        "data": {
          'codcon': Codcon,
          "codasi": Codasi,
          "codact": codact
        },
        "dataSrc": function(data) {
          val = data.error;
          if (val === "500") {
            // toastr.error("Ha ocurrido un error, no se puede registrar la asistencia del miembro")
            toastr.error(data.msg);
          } else {
            if (data.state === "OK") {
              // alert("El usuario ya está registrado, intenta recargando la página");
              location.reload();
            } else {
              toastr.options.positionClass = 'toast-bottom-right';
              miembros = data.miembros;
              toastr.success('Asistencia de miembro registrada correctamente');
              getDetailsNumbers(Codasi);
              return data.miembros;
            }
          }
        },
        "headers": {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      },
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["excel", "pdf", "print"],
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ miembros",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Miembros",
        "infoFiltered": "(Filtrado de _MAX_ registros)",
        "zeroRecords": "No se encontraron resultados",
        "emptyTable": "Ningún dato disponible en esta tabla",
        "paginate": {
          "first": "primero",
          "last": "último",
          "next": "siguiente",
          "previous": "anterior"
        },
      },
      "columns": [{
          "data": "CodCon"
        },
        {
          "data": "NomApeCon"
        },
        {
          "data": "HorLlegAsi"
        },
        {
          "data": "EstAsi"
        },
        {
          "data": "Asistio"
        },
      ],
      "columnDefs": [{
          "targets": [0],
          "visible": false,
          "searchable": false
        },
        {
          "targets": [2],
          "searchable": false
        },
        {
          "targets": [3],
          "searchable": false,
          render: function(data, type, row) {
            switch (data) {
              case 'A':
                return 'ASISTIO'
                break;
              case 'T':
                return 'TARDE'
                break;
              case 'F':
                return 'FALTO'
                break;
              case 'P':
                return 'PERMISO'
                break;
            }
          }
        },
        {
          "targets": [4],
          "searchable": false,
          render: function(data, type, row) {
            return createManageBtn(row.CodCon, row.CodAsi, data)
          }
        },
      ],
    });
    var table = $('#example1').DataTable();
    $('div.dataTables_filter input', table.table().container()).focus();
  }

  function getDetailsNumbers(Codasi) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '/administracion/getNumbers/' + Codasi,
      data: '_token = <?php echo csrf_token() ?>',
      success: function(data) {
        console.log(data.numbers);
        var asistencias = document.getElementById('TotAsistencias');
        var faltas = document.getElementById('TotFaltas');
        asistencias.value = data.numbers[0].TotAsistencia;
        faltas.value = data.numbers[0].TotFaltas;
      }
    });
  }

  function faultsProcessDS() {
    document.getElementById('faultsDS').disabled = true;
    var codasi = $('#asistencia').val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '/administracion/asistencia/procesar-faltas/' + codasi,
      data: '_token = <?php echo csrf_token() ?>',
      success: function(data) {
        if (data.code == 200) {
          Swal.fire({
            title: 'Faltas de discipulos procesados!',
            text: 'Ve a la aplicación de escritorio e imprime las faltas',
            imageUrl: "{{ asset('dist/img/FaltasDS.PNG') }}",
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
          })
        }
        if (data.code == 500) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Algo salió mal!!',
            footer: 'Comuníquese con el administrador'
          })
        }
        document.getElementById('faultsDS').disabled = false;
      }
    });
  }

  function faultsProcessCP() {
    document.getElementById('faultsCP').disabled = true;
    var codasi = $('#asistencia').val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '/administracion/asistencia/procesar-faltas-CP/' + codasi,
      data: '_token = <?php echo csrf_token() ?>',
      success: function(data) {
        if (data.code == 200) {
          Swal.fire({
            title: 'Faltas de discipulos procesados!',
            text: 'Ve a la aplicación de escritorio e imprime las faltas',
            imageUrl: "{{ asset('dist/img/FaltasCP.PNG') }}",
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
          })
        }
        if (data.code == 500) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Algo salió mal!!',
            footer: 'Comuníquese con el administrador'
          })
        }
        document.getElementById('faultsCP').disabled = false;
      }
    });
  }

  function prayerReport() {
    document.getElementById('prayerReport').disabled = true;
    var codasi = $('#asistencia').val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '/administracion/asistencia/procesar-oracion/' + codasi,
      data: '_token = <?php echo csrf_token() ?>',
      success: function(data) {
        console.log(data);
        if (data.code == 200) {
          Swal.fire({
            icon: 'success',
            title: 'Éxito...',
            text: 'Reporte de oración procesado!!',
            footer: 'Ve a la aplicación de escritorio e imprime el reporte'
          })
        }
        if (data.code == 500) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Algo salió mal!!',
            footer: 'Comuníquese con el administrador'
          })
        }
        document.getElementById('prayerReport').disabled = false;
      }
    });
  }

  function deleteAssistanceMember(Codcon, Codasi) {
    var codact = $('#codact').val();
    $('#example1').dataTable().fnClearTable();
    $('#example1').dataTable().fnDestroy();
    $('#example1').DataTable({
      "ajax": {
        "type": "POST",
        "url": "/administracion/eliminarAsistencia",
        "data": {
          'codcon': Codcon,
          "codasi": Codasi,
          "codact": codact
        },
        "dataSrc": function(data) {
          val = data.error;
          if (val === "500") {
            toastr.error("Ha ocurrido un error, no se puede eliminar la asistencia del miembro")
          } else {
            if (data.state == "OK") {
              // alert("Ya ha sido eliminada la asistencia del miembro, intenta a recargar la página");
              location.reload();
            } else {
              miembros = data.miembros;
              toastr.info('Asistencia de miembro eliminada correctamente');
              getDetailsNumbers(Codasi);
              return data.miembros;
            }
          }
        },
        "headers": {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      },
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["excel", "pdf", "print"],
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ miembros",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Miembros",
        "infoFiltered": "(Filtrado de _MAX_ registros)",
        "zeroRecords": "No se encontraron resultados",
        "emptyTable": "Ningún dato disponible en esta tabla",
        "paginate": {
          "first": "primero",
          "last": "último",
          "next": "siguiente",
          "previous": "anterior"
        },
      },
      "columns": [{
          "data": "CodCon"
        },
        {
          "data": "NomApeCon"
        },
        {
          "data": "HorLlegAsi"
        },
        {
          "data": "EstAsi"
        },
        {
          "data": "Asistio"
        },
      ],
      "columnDefs": [{
          "targets": [0],
          "visible": false,
          "searchable": false
        },
        {
          "targets": [2],
          "searchable": false
        },
        {
          "targets": [3],
          "searchable": false,
          render: function(data, type, row) {
            switch (data) {
              case 'A':
                return 'ASISTIO'
                break;
              case 'T':
                return 'TARDE'
                break;
              case 'F':
                return 'FALTO'
                break;
              case 'P':
                return 'PERMISO'
                break;
            }
          }
        },
        {
          "targets": [4],
          "searchable": false,
          render: function(data, type, row) {
            return createManageBtn(row.CodCon, row.CodAsi, data)
          }
        },
      ],
    });
    var table = $('#example1').DataTable();
    $('div.dataTables_filter input', table.table().container()).focus();
  }
</script>

<script type="text/javascript">
  function createManageBtn(codcon, codasi, asistio) {
    // return codcon+' '+codasi+' '+asistio;
    if (asistio == 1) {
      return '<button class="btn btn-success btn-sm" onclick="deleteAssistanceMember(' + "'" + codcon + "'" + ',' + "'" + codasi + "'," + 1 + ')"><i class="fas fa-minus-circle"></i></button>';
    } else {
      return '<button class="btn btn-danger btn-sm" onclick="updateRegisterMember(' + "'" + codcon + "'" + ',' + "'" + codasi + "'," + 1 + ')"><i class="far fa-check-circle"></i></button>';
    }
  }
</script>
@endsection