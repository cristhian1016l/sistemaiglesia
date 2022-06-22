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
          <h1>REGISTRO POR CÓDIGO DE BARRAS</h1>
        </div>
        <div class="col-sm-9">
          <ol class="breadcrumb float-sm-right">
            @if($asistencia->CodAct == '001' || $asistencia->CodAct == '012')
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

    <div class="date">
        <span id="weekDay" class="weekDay" hidden></span>
        <span id="day" class="day" hidden></span>
        <span id="month" class="month" hidden></span>
        <span id="year" class="year" hidden></span>
    </div>
    

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <button id="modal" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default" hidden></button>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">REGISTRO EN {{ $asistencia->TipAsi }}</h3>
            </div>
            <!-- form start -->
            <div class="card-body">

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="asistencia">Asistencia</label>
                    <input name="asistencia" class="form-control form-control-lg" id="asistencia" value="{{ $asistencia->CodAsi }}" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="asistencia">Actividad</label>
                    <input name="asistencia" class="form-control form-control-lg" id="codact" value="{{ $asistencia->CodAct }}" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Fecha</label>
                    <input name="fecha" type="text" class="form-control form-control-lg" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($asistencia->FecAsi)->toDateString() }}" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Desde</label>
                    <input name="desde" type="text" class="form-control form-control-lg" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($asistencia->HorDesde)->toTimeString() }}" readonly>
                  </div>                  
                </div>
                <div class="col-md-4" style="text-align: center;">
                  <div class="clock">
                    <span id="hours" class="hours" style="font-size: 100px;"></span>
                    <span style="font-size: 100px;">:</span>
                    <span id="minutes" class="minutes" style="font-size: 100px;"></span>
                    <span style="font-size: 100px;">:</span>
                    <span id="seconds" class="seconds" style="font-size: 100px;"></span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Hasta</label>
                    <input name="hasta" type="text" class="form-control form-control-lg" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($asistencia->HorHasta)->toTimeString() }}" readonly>
                  </div>
                </div>
              </div>              
              
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="form-group">
                      <label for="QrCode">CÓDIGO DE BARRAS</label>
                      <input name="QrCode" class="form-control form-control-lg" id="QrCode" oninput="if(document.getElementById('QrCode').value.length == 6) { registerAssistance() }">
                    </div>
                </div>
                <div class="col-md-2"></div>
              </div>

              <div class="row">
                <div class="col-md-12" style="text-align: center;">
                  <div class="form-group">
                      <label id="name" style="font-size: 60px"></label>
                    </div>
                </div>
              </div>
                               
              <div class="row">
                <div class="col-md-6" style="text-align: center">
                  <span style="font-size: 80px; color: green;" id="TotAsistencias">{{ $asistentes }}</span></br>
                  <span style="font-size: 50px;">Asistencias</span>
                </div>
                <div class="col-md-6" style="text-align: center">
                  <span style="font-size: 80px; color: red;" id="TotFaltas">{{ $faltantes }}</span></br>          
                  <span style="font-size: 50px;">Faltas</span>                
                </div>
              </div>
              
            </div>
          </div>
          <!-- /.card -->
        </div>        
      </div>      
    </div>
  </section>

</div>
<!-- /.container-fluid -->

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">REGISTRO MANUAL</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>CODIGO</th>
                <th>MIEMBROS</th>
                <th>HORA</th>
                <th>ESTADO</th>
                <th>CHECK</th>
              </tr>
            </thead>
            <tbody>            
            </tbody>
            <tfoot>
              <tr>
                <th>CODIGO</th>
                <th>MIEMBROS</th>
                <th>HORA</th>
                <th>ESTADO</th>                
                <th>CHECK</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

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
<!-- Clock Js -->
<script src="{{ asset('plugins/clock/clock.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->

<!-- ADMINISTRACION -->
<script>

$(document).bind('keyup', function(e){
  if(e.which==115) {    
    var Codasi = $('#asistencia').val();
    $('#example1').dataTable().fnClearTable();
    $('#example1').dataTable().fnDestroy();
    $("#example1").DataTable({
      "ajax": {
      "type": "POST",
      "url": "/administracion/detalleAsistenciaAjax",
      "data": {
        "codasi": Codasi,          
      },
      "dataSrc": function(data) {
        console.log(data);
        return data.miembros;
      },
      "headers": {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      },
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
    document.getElementById("modal").click();
  }    
});

$(function(){
    $("#QrCode").on("change", function(){
        // var a = $("#sifre_text").val();
        // var b = $("#sifre_tekrar_text").val();
        // if(a == b)
        //     $("#sifre_check").css("background-color", "yellow");     
        console.log("first");
    });
})

  // setTimeout(function() {
  //   // document.querySelector(".continuebutton a").click();
  //   console.log("Continue Clicked");
  // }, 50); 

  document.getElementById("menuasistenciaopen").className += ' menu-open';    
  document.getElementById("adminasistenciaactive").className += " active";    
  document.getElementById("assistance").className += " active";   

  function updateRegisterMemberBarcode(codbarras) {    
    var codasi = document.getElementById("asistencia").value;
    var codact = $('#codact').val();

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '/administracion/registrarAsistenciaQR',
      data: {
          'codbarras': codbarras,
          "codasi": codasi,
          "codact": codact
          },      
      success: function(data) {
        console.log(data);
        val = data.error;
        if (val === "500") {
          // toastr.error("Ha ocurrido un error, no se puede registrar la asistencia del miembro")
          toastr.error(data.msg);
          let name = document.getElementById('name');
          name.innerHTML = "";
        } else {
          if (data.state === "OK") {
            // alert("El usuario ya está registrado, intenta recargando la página");
            // location.reload();
            let name = document.getElementById('name');          
            name.innerHTML = "EL MIEMBRO YA ESTÁ REGISTRADO";
            name.style.color = "blue";
            toastr.info(data.msg);
          } else {
            toastr.options.positionClass = 'toast-bottom-right';
            miembros = data.miembros;
            toastr.success('Asistencia de miembro registrada correctamente');
            getDetailsNumbers(codasi);            
            let estado = data.estado;
            let name = document.getElementById('name');
            console.log(estado)
            name.innerHTML = data.msg;

            if(estado == 'A'){
              name.style.color = "green";
            }

            if(estado == 'T'){
              name.style.color = "red";
            }            
            
          }
        }        
      }
    });
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
        asistencias.textContent = data.numbers.totAsistencias;
        faltas.textContent = data.numbers.TotFaltas;
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

  function registerAssistance(){
    var barcode = document.getElementById("QrCode").value;
    console.log(barcode.length + " dsd");
    updateRegisterMemberBarcode(barcode);
    document.getElementById("QrCode").value = '';
  }  

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