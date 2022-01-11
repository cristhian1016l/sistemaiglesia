@extends('layouts.app')
@section('title', 'Permisos de miembros')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <style>
    th{
      font-size: 15px;
    }
    td{
      font-size: 14px;
    }
  </style>
@endsection
@section('contenido')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Lista de permisos</h1>
            <button class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-default" onclick="show_buttons()">Agregar nuevo permiso</button>                        
          </div>          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permisos</a></li>
              <li class="breadcrumb-item active">Permisos</li>
            </ol>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->    

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="card">
              <div class="card-header">
                <h3 class="card-title">Permisos</h3>                  
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>MIEMBRO</th>
                    <th>FECHA INICIO</th>
                    <th>FECHA FIN</th>
                    <th>MOTIVO</th>
                    <th>RED</th>
                    <th>ESTADO</th>
                  </tr>
                  </thead>
                  <tbody>             
                  @foreach($permissions as $perm)
                  <tr>                    
                    @if($perm->PerCon == true)
                      <td style=" color: red;">{{ $perm->ApeCon.' '.$perm->NomCon }}</td>                      
                      <td style=" color: red;">---</td>
                      <td style=" color: red;">---</td>
                      <td style=" color: red;">{{ $perm->Motivo }}</td>
                      @switch($perm->ID_Red)
                        @case(1)
                          <td style=" color: red;">EMANUEL</td>
                          @break
                        @case(2)
                          <td style=" color: red;">YESHUA</td>
                          @break
                        @case(4)
                          <td style=" color: red;">ADONAI</td>
                          @break
                        @case(5)
                          <td style=" color: red;">SHADAI</td>
                          @break
                      @endswitch                      
                      <td style=" font-weight: bold;">
                    @else
                      <?php
                        if($perm->FecFinReg < date("Y-m-d")){
                          ?>
                            <td style=" color: red; font-weight: bold">{{ $perm->ApeCon.' '.$perm->NomCon }}</td>
                          <?php
                        }else{
                          ?>
                            <td>{{ $perm->ApeCon.' '.$perm->NomCon }}</td>
                          <?php
                        }
                      ?>
                      <td>{{ $perm->FecIniReg }}</td>
                      <td>{{ $perm->FecFinReg }}</td>
                      <td>{{ $perm->Motivo }}</td>
                      @switch($perm->ID_Red)
                        @case(1)
                          <td>EMANUEL</td>
                          @break
                        @case(2)
                          <td>YESHUA</td>
                          @break
                        @case(4)
                          <td>ADONAI</td>
                          @break
                        @case(5)
                          <td>SHADAI</td>
                          @break
                      @endswitch                      
                      <td style=" font-weight: bold;">
                    @endif                                        
                      <?php
                      if($perm->Estado == true){
                          ?>
                        <a>
                          <button onclick="disablePermission(<?php echo $perm->NumReg ?>)" class="btn btn-success btn-sm" data-toggle="tooltip" ata-placement="top" title="Deshabilitar permiso">
                              <i class="fas fa-minus"></i>
                          </button>         
                        </a>                        
                        <a>
                          <button onclick="getPermission(<?php echo $perm->NumReg ?>)" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#modal-default" title="Editar permiso">
                              <i class="fas fa-pen"></i>
                          </button>         
                        </a>
                          <?php
                      }else{
                        ?>
                        <a>
                          <button onclick="enablePermission(<?php echo $perm->NumReg ?>)" class="btn btn-warning btn-sm" data-toggle="tooltip" ata-placement="top" title="Habilitar permiso">
                              <i class="far fa-check-circle"></i>
                          </button>         
                        </a>                          
                        <a>
                          <button onclick="deletePermission(<?php echo $perm->NumReg ?>)" class="btn btn-danger btn-sm" data-toggle="tooltip" ata-placement="top" title="Eliminar permiso">
                              <i class="fas fa-trash-alt"></i>
                          </button>         
                        </a>                 
                        <a>
                          <button onclick="getPermission(<?php echo $perm->NumReg ?>)" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#modal-default" title="Editar permiso">
                              <i class="fas fa-pen"></i>
                          </button>         
                        </a>                
                        <?php
                      }
                      ?>                      
                    </td>                    
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th style="font-size: 15px;">MIEMBRO</th>
                    <th style="font-size: 15px;">FECHA INICIO</th>
                    <th style="font-size: 15px;">FECHA FIN</th>
                    <th style="font-size: 15px;">MOTIVO</th>
                    <th style="font-size: 15px;">RED</th>
                    <th style="font-size: 15px;">ESTADO</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Agregar Permiso</h4>              
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="text" id="numreg" disabled style="display: none;">
        <input type="hidden" name="_token" value="{{ csrf_token()}}" id="{{ 'token' }}">
        <div class="modal-body">
          <div class="form-group">
            {!! Form::label('Seleccione el miembro') !!}
            <select name="codcon" id="codcon" class="form-control select2" style="width: 100%;" id="miselect">       
                @foreach($miembros as $miembro)
                <option value="<?php echo $miembro->CodCon ?>">{{ $miembro->ApeCon.' '.$miembro->NomCon }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="fecha">Desde (año/mes/día)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <?php $day = date('j'); ?>
                <input id="fecinireg" name="fecinireg" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
            </div>
          </div>
          <div class="form-group">
            <label for="fecha">Hasta (año/mes/día)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <?php $day = date('j'); ?>
                <input id="fecfinreg" name="fecfinreg" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
            </div>
          </div>
          <div class="form-group">
            <label for="motbaja">Motivo del permiso</label>
            <input type="text" name="motivo" id="motivo" class="form-control" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" placeholder="Ingrese el motivo del permiso">
          </div>
          <div class="form-group">            
            <div class="icheck-info d-inline">
              <input class="messageRadio" type="radio" name="r2" value="0" id="esporadico">
              <label for="esporadico">
                ESPORÁDICO
              </label>
            </div>
            <div class="icheck-success d-inline">
              <input class="messageRadio" type="radio" name="r2" value="1" id="constante">
              <label for="constante">
                CONSTANTE
              </label>
            </div>
          </div>
        </div>                             
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="close">CERRAR</button>
          <button id="btnInsertar" type="submit" class="btn btn-sm btn-info float-left">AGREGAR PERMISO</button>
          <button id="btnActualizar" type="submit" class="btn btn-sm btn-info float-left" style="display: none;">EDITAR PERMISO</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>  
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
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Moments -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment-with-locales.min.js') }}"></script>
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
      "buttons": ["excel", "pdf", "print"],
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ Permisos",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Permisos",
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
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');      

    //Initialize Select2 Elements
    $('.select2').select2()  

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
    $('[data-mask]').inputmask()

    document.getElementById("adminasistenciaactive").className += " active";
    var url = window.location;
    
    $('ul.nav-sidebar a').filter(function () {
        return this.href == url;
    }).addClass('active');

    // for sidebar menu and treeview
    $('ul.nav-treeview a').filter(function () {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview")
        .css({'display': 'block'})
        .addClass('menu-open').prev('a')
        .addClass('active');  
        
    moment.locale('es');
  });
</script>
<script>
function disablePermission(numreg){
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:'/administracion/permisos/deshabilitar-permiso',
    data:{
        "_token": "{{ csrf_token() }}",
        "numreg": numreg
      },
    success:function(data) {   
      if(data.code == 200){
        toastr.success(data.msg)
        getPermissions();
      }      
      if(data.code == 500){
        toastr.error(data.msg)
      }      
    }
  });
}

function enablePermission(numreg){
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:'/administracion/permisos/habilitar-permiso',
    data:{
        "_token": "{{ csrf_token() }}",
        "numreg": numreg
      },
    success:function(data) {   
      if(data.code == 200){
        toastr.success(data.msg)
        getPermissions();
      }      
      if(data.code == 500){
        toastr.error(data.msg)
      }      
    }
  });
}

function deletePermission(numreg){
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:'/administracion/permisos/eliminar-permiso',
    data:{
        "_token": "{{ csrf_token() }}",
        "numreg": numreg
      },
    success:function(data) {   
      if(data.code == 200){
        toastr.success(data.msg)
        getPermissions();
      }      
      if(data.code == 500){
        toastr.error(data.msg)
      }      
    }
  });
}

function getPermission(numreg){
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:'/administracion/permisos/obtener-permiso',
    data:{
        "_token": "{{ csrf_token() }}",
        "numreg": numreg
      },
    success:function(data) {
      console.log(data[0]);
      // $("#codcon").select2("val", data[0].CodCon);
      $("#codcon").prop("disabled", true);
      $("#codcon").val(data[0].CodCon).trigger('change');
      document.getElementById('fecinireg').value = data[0].FecIniReg;
      document.getElementById('fecfinreg').value = data[0].FecFinReg;
      document.getElementById('motivo').value = data[0].Motivo;
      document.getElementById('numreg').value = data[0].NumReg;
      let perCon = data[0].PerCon;
      console.log(perCon);
      if(perCon == 0){
        constante = document.getElementById("constante");
        constante.checked = false;
        esporadico = document.getElementById("esporadico");
        esporadico.checked = true;
      }
      if(perCon == 1){
        esporadico = document.getElementById("esporadico");
        esporadico.checked = false;
        constante = document.getElementById("constante");
        constante.checked = true;        
      }
      var btnInsertar = document.getElementById('btnInsertar');
      var btnActualizar = document.getElementById('btnActualizar');
        btnInsertar.style.display = 'none';
        btnActualizar.style.display = 'inline';
    }
  });
}
</script>

<script>
function getPermissions() {
  $('#example1').dataTable().fnClearTable();
  $('#example1').dataTable().fnDestroy();
  $('#example1').DataTable({
    "ajax":{
      "type": "POST",
      "url":"/administracion/permisos/obtener-permisos",      
      "dataSrc": function(data){
        console.log(data.permissions);
        return data.permissions;        
      },
      "headers": {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    },
    "responsive": true, "lengthChange": true, "autoWidth": false,
    "buttons": ["excel", "pdf", "print"],
    "language": {
      "search": "Buscar:",
      "lengthMenu": "Mostrar _MENU_ permisos",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Permisos",
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
      {"data": "ApeCon"},
      {"data": "FecIniReg"},
      {"data": "FecFinReg"},
      {"data": "Motivo"},      
      {"data": "ID_Red"},
      {"data": "Estado"},
    ],
    "columnDefs": [
      {
        "targets": [0],
        render: function(data, type, row){
          var today = new Date();
          var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
          if(row.PerCon == false && row.FecFinReg < date){
            return '<p style="color: red; font-weight: bold">'+data+' '+row.NomCon+'</p>';
          }else{
            if(row.PerCon == true){
              return '<p style="color: red;">'+data+' '+row.NomCon+'</p>';
            }else{
              return '<p>'+data+' '+row.NomCon+'</p>';
            }          
          }                    
        }
      },
      {
        "targets": [1], "searchable": false,
        render: function(data, type, row){
          if(row.PerCon == true){
            return '<p style="color: red;">'+data+'</p>';
          }else{
            return '<p>'+data+'</p>';
          }          
        }},
      {"targets": [2], "searchable": false,
        render: function(data, type, row){
          if(row.PerCon == true){
            return '<p style="color: red;">'+data+'</p>';
          }else{
            return '<p>'+data+'</p>';
          }          
        }},
      {"targets": [3], "searchable": false,
        render: function(data, type, row){
          if(row.PerCon == true){
            return '<p style="color: red;">'+data+'</p>';
          }else{
            return '<p>'+data+'</p>';
          }          
        }},
      {"targets": [4], "searchable": true,
        render: function(data, type, row){
          switch(data){
            case "1":
              return '<td style=" color: red;">EMANUEL</td>';
              break;
            case "2":
              return '<td style=" color: red;">YESHUA</td>';
              break;
            case "4":
              return '<td style=" color: red;">ADONAI</td>';
              break;
            case "5":
              return '<td style=" color: red;">SHADAI</td>';
              break;
            default:
            return '<td></td>';

          }          
        }},
      {
        "targets": [5],
        "searchable": false,
        render: function(data, type, row){
          if(data == true){
            return  '<a>'+
                      '<button onclick="disablePermission('+"'" + row.NumReg + "'"+')" class="btn btn-success btn-sm" data-toggle="tooltip" ata-placement="top" title="Deshabilitar permiso">'+
                          '<i class="fas fa-minus"></i>'+
                      '</button>'+
                    '</a>'+
                    '<a>'+
                      '<button onclick="getPermission('+"'" + row.NumReg + "'"+')" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#modal-default" title="Editar permiso">'+
                          '<i class="fas fa-pen"></i>'+
                      '</button>'+
                    '</a>'
          }
          if(data == false){
            return  '<a>'+
                      '<button onclick="enablePermission('+"'" + row.NumReg + "'"+')" class="btn btn-warning btn-sm" data-toggle="tooltip" ata-placement="top" title="Habilitar permiso">'+
                          '<i class="far fa-check-circle"></i>'+
                      '</button>'+
                    '</a>'+
                    '<a>'+
                      '<button onclick="deletePermission('+"'" + row.NumReg + "'"+')" class="btn btn-danger btn-sm" data-toggle="tooltip" ata-placement="top" title="Eliminar permiso">'+
                          '<i class="fas fa-trash-alt"></i>'+
                      '</button>'+
                    '</a>'+
                    '<a>'+
                      '<button onclick="getPermission('+"'" + row.NumReg + "'"+')" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#modal-default" title="Editar permiso">'+
                          '<i class="fas fa-pen"></i>'+
                      '</button>'+
                    '</a>'
          }
        }
      },
    ],
  });        
  }
</script>
<script>

  $("#btnInsertar").click(function(e){   
    e.preventDefault();    
    let codcon = document.getElementById('codcon').value;
    let fecinireg = document.getElementById('fecinireg').value;
    let fecfinreg = document.getElementById('fecfinreg').value;
    let motivo = document.getElementById('motivo').value;
    var checkedValue = document.querySelector('.messageRadio:checked').value;
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:'/administracion/permisos/agregar-permiso',
      data:{
        "_token": "{{ csrf_token() }}",
        "codcon": codcon,
        "fecinireg": fecinireg,
        "fecfinreg": fecfinreg,
        "motivo": motivo,
        "checked": checkedValue
      },
      success:function(data) {      
        if(data.code == 300){
          toastr.warning(data.msg);
        }
        if(data.code == 500){
          toastr.error(data.msg);
        }
        if(data.code == 200){
          toastr.success(data.msg);
          document.getElementById('codcon').value = '';
          document.getElementById('fecinireg').value = '';
          document.getElementById('fecfinreg').value = '';
          document.getElementById('motivo').value = '';
          document.getElementById('close').click();
          getPermissions();
        }        
      }, error:function(data){
        toastr.error("HUBO UN ERROR AL INSERTAR EL PERMISO, VERIFIQUE LAS FECHAS - ERROR 500");
      }
    });
  })  

  $("#btnActualizar").click(function(e){   
    e.preventDefault();    
    let numreg = document.getElementById('numreg').value;
    let fecinireg = document.getElementById('fecinireg').value;
    let fecfinreg = document.getElementById('fecfinreg').value;
    let motivo = document.getElementById('motivo').value;
    var checkedValue = document.querySelector('.messageRadio:checked').value;

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:'/administracion/permisos/editar-permiso',
      data:{
        "_token": "{{ csrf_token() }}",
        "numreg": numreg,
        "fecinireg": fecinireg,
        "fecfinreg": fecfinreg,
        "motivo": motivo,
        "checked": checkedValue
      },
      success:function(data) {      
        if(data.code == 300){
          toastr.warning(data.msg);
        }
        if(data.code == 500){
          toastr.error(data.msg);
        }
        if(data.code == 200){
          toastr.success(data.msg);
          document.getElementById('codcon').value = '';
          document.getElementById('fecinireg').value = '';
          document.getElementById('fecfinreg').value = '';
          document.getElementById('motivo').value = '';
          document.getElementById('close').click();
          getPermissions();
        }        
      }, error:function(data){
        toastr.error("HUBO UN ERROR AL INSERTAR EL PERMISO, VERIFIQUE LAS FECHAS - ERROR 500");
      }
    });
  })  

  function show_buttons(){
    $("#codcon").prop("disabled", false);
    document.getElementById("esporadico").setAttribute("checked", true);
    document.getElementById('codcon').value = '';
    document.getElementById('fecinireg').value = '';
    document.getElementById('fecfinreg').value = '';
    document.getElementById('motivo').value = '';
    var btnInsertar = document.getElementById('btnInsertar');
    var btnActualizar = document.getElementById('btnActualizar');
      btnInsertar.style.display = 'inline';
      btnActualizar.style.display = 'none';
  }
</script>
@endsection