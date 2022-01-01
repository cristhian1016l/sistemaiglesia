<?php
    date_default_timezone_set('America/Lima');
    // \Carbon\Carbon::setLocale('es');
    \Carbon\Carbon::setLocale('es');
?>
@extends('layouts.app')
@section('title', 'Asistencia de discipulado')
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
          <div class="col-sm-6">
            <!-- <h1>Registro de asistencia</h1> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">            
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- MENSAJES DE ALERTA -->        
    @if(\Session::has('errors'))
      <div class="card-body">    
        <div class="alert alert-{{ Session::get('type-alert') }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Errores!</h5>
            @foreach ($errors->all() as $error)                        
                <li>{{ $error }}</li>
            @endforeach
        </div>
      </div>
    @endif        
    @if (\Session::has('msg'))
      <div class="card-body">
        <div class="alert alert-{{ Session::get('type-alert') }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Mensajes</h5>
            {{ Session::get('msg') }}
        </div>        
      </div>        
    @endif                
    <!-- FIN DE MENSAJES DE ALERTA -->
  
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">     
          <div class="row">
                <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">INFORME DEL {{ $desarea }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- form start -->              
                            <div class="card-body">
                                <div class="form-row">
                                    <input id="codasi" class="form-control" value="{{ $asistencia->codasi }}" readonly hidden>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Tema</label>
                                        <input id="tema" type="text" class="form-control" id="exampleInputPassword1" value="{{ $asistencia->tema }}" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                                    </div>                                    
                                    <div class="form-group col-md-3">
                                        <label for="fecha">Fecha (año/mes/día)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <?php $day = date('j'); ?>
                                            <input id="fecha" id="fecha" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="{{ $asistencia->anio.'-'.$asistencia->mes.'-'.$day  }}">
                                        </div>
                                        <!-- <label for="inputPassword4">Fecha</label>
                                        <input id="fecha" type="text" class="form-control" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($asistencia->fecasi)->toDateString() }}"> -->
                                    </div>                                    
                                    <div class="form-group col-md-3">
                                        <label for="ofrenda">Ofrenda</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                            </div>
                                            <input id="ofrenda" type="text" class="form-control" data-prefix="S/. " id="ofrenda" value="{{ $asistencia->ofrenda }}">
                                        </div>
                                        
                                    </div>
                                </div>                                
                                <div class="form-row">                                                                        
                                    <div class="form-group col-md-3">
                                        <label for="exampleInputPassword1">Total Faltas</label>                                
                                        <input id="faltas" type="text" class="form-control" id="exampleInputPassword1" value="{{ $asistencia->totfaltas }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="exampleInputPassword1">Total Asistencia</label>                                
                                        <input id="asistencia" type="text" class="form-control" id="exampleInputPassword1" value="{{ $asistencia->totasistencia }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="exampleInputPassword1">Mes</label>       
                                        <?php $meses = ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE']; ?>
                                        <input id="mes" type="text" class="form-control" id="exampleInputPassword1" value="{{ $meses[$asistencia->mes-1] }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="exampleInputPassword1">Año</label>                                
                                        <input id="anio" type="text" class="form-control" id="exampleInputPassword1" value="{{ $asistencia->anio }}" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputPassword1">Testimonios</label>
                                        <textarea id="testimonios" class="form-control" id="exampleFormControlTextarea1" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $asistencia->testimonios }}</textarea>
                                        <!-- <input id="desde" type="text" class="form-control" id="exampleInputPassword1" value="{{ $asistencia->ofrenda }}"> -->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputPassword1">Observaciones</label>
                                        <textarea id="observaciones" class="form-control" id="exampleFormControlTextarea1" rows="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">{{ $asistencia->observaciones }}</textarea>
                                        <!-- <input id="desde" type="text" class="form-control" id="exampleInputPassword1" value="{{ $asistencia->ofrenda }}"> -->
                                    </div>
                                </div>
                                <!-- <button class="btn btn-info btn-block" onclick="update_assistance()">ACTUALIZAR REGISTRO</button> -->
                            </div>                
                        </div>                        
                </div>      
          </div>
        <div class="row">          
            <!-- /.card -->            
                <div class="col-md-12">
                <section class="content">
                        <div class="container-fluid">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">LISTA DE DISCÍPULOS REGISTRADOS EN EL SISTEMA</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>CODIGO</th>
                                        <th>MIEMBROS</th>
                                        <th>ESTADO</th>
                                        <th>CHECK</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($discipulos as $dis)        
                                    <tr>
                                        <td>{{ $dis->codcon }}</td>
                                        <td>{{ $dis->nomapecon }}</td>                                        
                                        <td>
                                            <?php
                                            switch($dis->estasi){
                                                case 'A':
                                                    echo 'ASISTIO';
                                                    break;
                                                case 'F':
                                                    echo 'FALTO';
                                                    break;
                                                case 'T':
                                                    echo 'TARDE';
                                                    break;
                                            }
                                            ?>
                                        </td>                                        
                                        <!-- <td>{{ $dis->Asistio }}</td> -->
                                        <td style="text-align: center;">
                                        @if($dis->asistio)
                                          <button class='btn btn-danger btn-sm' onclick="removeRegisterMember('<?php echo $dis->codcon ?>','<?php echo $dis->codasi ?>', 0)">
                                              <i class="fas fa-minus-circle"></i>
                                          </button>
                                        @else
                                          <button class='btn btn-success btn-sm' onclick="updateRegisterMember('<?php echo $dis->codcon ?>','<?php echo $dis->codasi ?>', 0)">
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
                                        <th>ESTADO</th>
                                        <th>CHECK</th>
                                    </tr>
                                    </tfoot>
                                    </table>
                                </div>
                                <div class="row">
                                  <div class="col-md-8">
                                    <a>
                                      <button class="btn btn-success btn-block" style="height:60px;" onclick="send_report()">ENVIAR INFORME</button>
                                    </a>
                                  </div>
                                  <div class="col-md-4">
                                    <a href="{{ route('mentor.discipulado.index') }}">
                                      <button class="btn btn-danger btn-block" style="height:60px;">CANCELAR</button>
                                    </a>
                                  </div>
                                </div>                                
                            </div>
                        </div>
                </section>
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
<!-- MasskMoney -->
<script src="{{ asset('plugins/maskmoney/dist/jquery.maskMoney.js') }}" type="text/javascript"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
  $(function () {        
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      // "buttons": ["excel", "pdf", "print"],      
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ discípulos",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Discípulos",
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
      "columnDefs": [
        {"targets": [0], "searchable": false},
        {"targets": [2], "searchable": false},        
        {"targets": [3], "searchable": false},
      ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');    

    var table = $('#example1').DataTable(); 
    $('div.dataTables_filter input', table.table().container()).focus();

    $('#ofrenda').maskMoney({thousands:'', decimal:'.', allowZero:true});

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
    $('[data-mask]').inputmask()

    document.getElementById("menudiscipuladoopen").className += ' menu-open';    
    document.getElementById("menudiscipuladoactive").className += " active";    
    document.getElementById("discipulado").className += " active";    
        
  });  
</script>

<script>    
    miembros = [];
    function updateRegisterMember(Codcon, Codasi, time = 1) {            
      if(time == 0){
        miembros = <?= json_encode($discipulos) ?>;        
      }

      $('#example1').dataTable().fnClearTable();
      $('#example1').dataTable().fnDestroy();
      $('#example1').DataTable({
        "ajax":{
          "type": "POST",
          "url":"/mentor/discipulado/registrarAsistencia",
          "data": {'codcon': Codcon, "codasi" : Codasi, "miembros": miembros},          
          "dataSrc": function(data){
            val = data.error; 
            if(val === "500"){                              
              toastr.error("Ha ocurrido un error, no se puede registrar la asistencia del discipulo")
            }else{                
                toastr.options.positionClass = 'toast-bottom-right';
                miembros = data.miembros;
                toastr.success('Asistencia del discípulo registrada correctamente');                                    
                document.getElementById('faltas').value = data.detasi['totfaltas'];
                document.getElementById('asistencia').value = data.detasi['totasistencia'];
                return data.miembros;
            }            
          },
          "headers": {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        },
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "buttons": ["excel", "pdf", "print"],
        "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ discípulos",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Discípulos",
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
        "columns":[          
          {"data": "codcon"},
          {"data": "nomapecon"},
          {"data": "estasi"},          
          {"data": "asistio"},
        ],
        "columnDefs": [
          {"targets": [0], "visible": false, "searchable": false},
          {"targets": [1], "searchable": true},
          {
            "targets": [2],
            "searchable": false,
            render: function(data, type, row){
              switch(data){
                  case 'A':
                      return 'ASISTIO'
                      break;
                  case 'F':
                      return 'FALTO'
                      break;
                  case 'T':
                      return 'TARDE'
                      break;
              }              
            }
          },
          {
            "targets": [3],
            "searchable": false,
            render: function(data, type, row){
              return createManageBtn(row.codcon, row.codasi, data)
            }
          },
        ],
      });
      var table = $('#example1').DataTable(); 
      $('div.dataTables_filter input', table.table().container()).focus();
    }

    function removeRegisterMember(Codcon, Codasi, time = 1) {

      if(time == 0){
        miembros = <?= json_encode($discipulos) ?>;        
      }

      $('#example1').dataTable().fnClearTable();
      $('#example1').dataTable().fnDestroy();
      $('#example1').DataTable({
        "ajax":{
          "type": "POST",
          "url":"/mentor/discipulado/eliminarAsistencia",
          "data": {'codcon': Codcon, "codasi" : Codasi, "miembros": miembros},          
          "dataSrc": function(data){
            val = data.error;                
            if(val === "500"){
              toastr.error("Ha ocurrido un error, no se puede eliminar la asistencia del discípulo")
            }else{
              miembros = data.miembros;
              toastr.info('Asistencia de discípulo eliminada correctamente');
              document.getElementById('faltas').value = data.detasi['totfaltas'];
              document.getElementById('asistencia').value = data.detasi['totasistencia'];
              return data.miembros;                 
            }                  
          },
          "headers": {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        },
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "buttons": ["excel", "pdf", "print"],
        "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ discípulo",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Discípulos",
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
        "columns":[          
          {"data": "codcon"},
          {"data": "nomapecon"},
          {"data": "estasi"},          
          {"data": "asistio"},
        ],
        "columnDefs": [
          {"targets": [0], "visible": false, "searchable": false},
          {"targets": [1], "searchable": true},
          {
            "targets": [2],
            "searchable": false,
            render: function(data, type, row){
              switch(data){
                  case 'A':
                      return 'ASISTIO'
                      break;
                  case 'F':
                      return 'FALTO'
                      break;
                  case 'T':
                      return 'TARDE'
                      break;
              }              
            }
          },
          {
            "targets": [3],
            "searchable": false,
            render: function(data, type, row){
              return createManageBtn(row.codcon, row.codasi, data)
            }
          },
        ],
      });        
      var table = $('#example1').DataTable(); 
      $('div.dataTables_filter input', table.table().container()).focus();
    }

    function send_report(){
      var codasi = $('#codasi').val();
      var fecha = $('#fecha').val();
      var tema = $('#tema').val();
      var ofrenda = $('#ofrenda').val();
      var observaciones = $('#observaciones').val();
      var testimonios = $('#testimonios').val();
      $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/mentor/discipulado/actualizar_asistencia',
          data: {'codasi': codasi, 
                  "fecha" : fecha, "tema" : tema, 
                  "ofrenda" : ofrenda, "observaciones" : observaciones,
                  "testimonios" : testimonios},
          success:function(data) {
            if(data.code == 500){
              toastr.error(data.msg);
            }
            if(data.code == 200){
              toastr.success(data.msg);
              setTimeout(function() {window.location = "/mentor/discipulado/listado"; }, 5000);
            }
            console.log(data);
              // toastr.success(data);
          }, error:function(data){
            toastr.error("HUBO UN ERROR AL INSERTAR EL PERMISO, VERIFIQUE LA FECHA - ERROR 500");
          }
      });
    }
</script>
<script type="text/javascript">
    function createManageBtn(codcon, codasi, asistio) {
      // return codcon+' '+codasi+' '+asistio;
      if(asistio == 1){        
        return '<button class="btn btn-danger btn-sm" onclick="removeRegisterMember('+"'" + codcon + "'"+','+"'"+codasi+"',"+1+')"><i class="fas fa-minus-circle"></i></button>';
      }else{                 
        return '<button class="btn btn-success btn-sm" onclick="updateRegisterMember('+"'" + codcon + "'"+','+"'"+codasi+"',"+1+')"><i class="far fa-check-circle"></i></button>';
      }          
    }
</script>
@endsection
