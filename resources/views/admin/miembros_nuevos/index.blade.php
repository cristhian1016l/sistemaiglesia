@extends('layouts.app')
@section('title', 'Miembros nuevos')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <style>    
    td:nth-child(1) {  
      text-align: center; 
      font-size: 20px
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
            <h1 class="m-0">Miembros nuevos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Miembros nuevos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
      <div class="row mb-2">
        <div class="col-md-3">
          <select name="miembro" class="form-control select2" style="width: 100%;" id="miselect">       
            @foreach($redes as $red)
            <option value="<?php echo $red->ID_RED ?>">{{ $red->NOM_RED }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">          
          <!-- admin.new_members.reporteAsistenciaCultos -->
          <a href="#" target="_blank" id="ruta">
              <button  type="button" class="btn btn-block btn-primary" onclick="imprimir()">Imprimir faltas
                <i class="nav-icon far fa-file-pdf"></i>
              </button>                
          </a>
        </div>
        <div class="col-md-6" style="width: 100%; text-align: center;">
          <div style="height: 35px; width: 100px; background-color: #48cf3c; text-align: center; line-height: 35px; display: inline-block">
            Virtual
          </div>
          <div style="height: 35px; width: 100px; background-color: #7f8cfa; text-align: center; line-height: 35px; display: inline-block;">
            Casa de Paz
          </div>
          <div style="height: 35px; width: 100px; background-color: orange; text-align: center; line-height: 35px; display: inline-block">
            Inconstante
          </div>
        </div>
      </div>
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Miembros nuevos</h3>                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                  <tr>
                    <th>PROCESO</th>
                    <th>NOMBRES</th>
                    <th>EDAD</th>
                    <th>REGISTRO</th>
                    <th>OPCIONES</th>
                  </tr>
                  </thead>
                  <tbody>             
                  @foreach($members as $member)
                    @switch($member->Estado)
                      @case('VIRTUAL')
                        <tr style="background-color: #48cf3c;">
                        @break
                      @case('CP')
                        <tr style="background-color: #7f8cfa;">
                        @break
                      @case('INCONSTANTE')
                        <tr style="background-color: orange;">
                        @break
                      @default
                        <tr>
                    @endswitch                    
                    <td>
                    @if($member->EstaEnProceso == 1)
                        <span class="badge badge-info">SI</span>
                    @else
                        <span class="badge badge-danger">NO</span>
                    @endif
                    </td>
                    <td>{{ $member->ApeCon. ' ' .$member->NomCon }}</td>
                    <td>
                        <?php
                            $edad = \Carbon\Carbon::parse($member->FecNacCon)->age;
                            if($edad == 0){
                                echo "------";
                            }else{
                                echo $edad. " años";
                            }                        
                        ?>                        
                    </td>
                    <td><?php echo \Carbon\Carbon::parse($member->FecReg)->diffForHumans(); ?></td>
                    <td>
                        <a>
                            <button class="btn btn-success btn-sm" onclick="getData('<?php echo $member->CodCon ?>')" title="Ver las últimas asistencias al culto">
                                <i class="fas fa-eye"></i>
                            </button>         
                        </a>
                        <a>
                            <button class="btn btn-info btn-sm" onclick="getInfo('<?php echo $member->CodCon ?>')" data-toggle="modal" data-target="#modal-default" title="Editar información">
                                <i class="fas fa-pen"></i>
                            </button>         
                        </a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>PROCESO</th>
                    <th>NOMBRES</th>
                    <th>EDAD</th>
                    <th>REGISTRO</th>
                    <th>OPCIONES</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Asistencia últimas semanas (CULTOS)</h3><br>
                <label id="name"></label>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped" id="mitabla">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Fecha</th>
                      <th style="width: 40px">Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.content-wrapper -->  

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">AGREGAR / ACTUALIZAR OBSERVACIÓN</h4>              
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <input type="text" id="codcon" disabled style="display: none;">
        <input type="text" id="id" disabled style="display: none;">
        <input type="hidden" name="_token" value="{{ csrf_token()}}" id="{{ 'token' }}">
        <div class="modal-body">
          <div class="form-group">
            <label for="motbaja">INGRESE LA OBSERVACIÓN</label>
            <input type="text" name="motivo" id="motivo" class="form-control" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" placeholder="Ingrese el motivo del permiso">
          </div>
          <div class="form-group">            
            <div class="icheck-info d-inline">
              <input class="messageRadio" type="radio" name="r2" value="0" id="virtual">
              <label for="virtual">
                VIRTUAL
              </label>
            </div>
            <div class="icheck-success d-inline">
              <input class="messageRadio" type="radio" name="r2" value="1" id="CP">
              <label for="CP">
                CASA DE PAZ
              </label>
            </div>
            <div class="icheck-danger d-inline">
              <input class="messageRadio" type="radio" name="r2" value="2" id="inconstante">
              <label for="inconstante">
                INCONSTANTE
              </label>
            </div>
          </div>
        </div>                             
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="close">CERRAR</button>
          <button id="btnInsertar" type="submit" class="btn btn-sm btn-info float-left">ACTUALIZAR OBSERVACIÒN</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
@endsection

@section('js')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Moments -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment-with-locales.min.js') }}"></script>
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
  $(function () {
    showTable();

    document.getElementById("adminmemberactive").className += " active";
    var url = window.location;
    // for single sidebar menu
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

    //Initialize Select2 Elements
    $('.select2').select2()  
    
    // moment.locale('es');
    // localLocale.locale(false);

    
  });
</script>

<script>

  function showTable(){    
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      var table = $('#example1').DataTable(); 
      $('div.dataTables_filter input', table.table().container()).focus();
  }
  
  function refreshTableAjax(){
    $('#example1').dataTable().fnClearTable();
    $('#example1').dataTable().fnDestroy();
    $('#example1').DataTable({
      "ajax":{
        "type": "POST",
        "url":"/administracion/obtener-miembros",
        "dataSrc": function(data){
          if(data.code == 200){
            toastr.success('TABLA ACTUALIZADA');
            return data.members;
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
        {"data": "EstaEnProceso"},
        {"data": "ApeCon"},
        {"data": "FecNacCon"},
        {"data": "FecReg"},      
        {"data": "CodCon"},
      ],
      "createdRow": function (row, data, index) {
        switch(data.Estado) {
          case 'VIRTUAL':
            $(row).css("background-color", "#48cf3c");
            break;
          case 'CP':
            $(row).css("background-color", "#7f8cfa");
            break;
          case 'INCONSTANTE':
            $(row).css("background-color", "orange");
            break;
          }
          
      },
      "columnDefs": [
        {
          "targets": [0],
          render: function(data, type, row){
            if(data == "1"){
              return '<span class="badge badge-info">SI</span>'
            }
            if(data == "0"){
              return '<span class="badge badge-danger">NO</span>'
            }          
          }
        },
        {
          "targets": [1], "searchable": true,
          render: function(data, type, row){
            return data+' '+row.NomCon;
          }},
        {"targets": [2], "searchable": false,
          render: function(data, type, row){
            return getAge(data);
          }},
        {"targets": [3], "searchable": false,
          render: function(data, type, row){
            moment.locale('es');
            return moment(data).fromNow();
          }},
        {
          "targets": [4],
          "searchable": false,
          render: function(data, type, row){
            return  '<a>'+
                        '<button class="btn btn-success btn-sm" onclick="getData('+"'" + data + "'"+')" title="Ver las últimas asistencias al culto">'+
                            '<i class="fas fa-eye"></i>'+
                        '</button>'+
                      '</a>'+
                      '<a>'+
                        '<button class="btn btn-info btn-sm" onclick="getInfo('+"'" + data + "'"+')" data-toggle="modal" data-target="#modal-default" title="Editar información">'+
                            '<i class="fas fa-pen"></i>'+
                        '</button>'+
                      '</a>'            
          }
        },
      ],
    });        
  }

  function imprimir(){
    var idred = $('#miselect').val();
    var url = '{{ route("admin.new_members.reporteAsistenciaCultos", ":id") }}'
    url = url.replace(':id', idred);
    window.open(
      url,
      "_blank"
    );    
  }

  function getData(codcon){    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/administracion/asistencia-cultos',
        data: {
          "_token": "{{ csrf_token() }}",
          'codcon' : codcon,
        },
        success:function(data) {
          $("#mitabla > tbody").empty();
          let contador = 1;
          $.each(data, function(idx, opt) {  
            document.getElementById('name').innerHTML = opt.Nombres;
            var asistencia
            switch(opt.EstAsi){
                case 'A':
                    asistencia = '<td><span class="badge bg-success">Asistió</span></td>'
                    break;
                case 'F':
                    asistencia = '<td><span class="badge bg-danger">No asistió</span></td>'
                    break;
                case 'P':
                    asistencia = '<td><span class="badge bg-primary">Permiso</span></td>'
                    break;
            }            
            $('#mitabla').append(
              '<tr>' +
                '<td>' + contador + '.'+'</td>' +
                '<td>' + moment(opt.Fecha).format('LL') + '</td>' +
                asistencia +
              '</tr>'
            );               
            contador++;
          });          
        }
    });      
  }

  function getInfo(codcon){
    document.getElementById('id').value = '';
    document.getElementById('codcon').value = '';
    document.getElementById('motivo').value = '';
    document.getElementById('virtual').checked = false;
    document.getElementById('CP').checked = false;
    document.getElementById('inconstante').checked = false;
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/administracion/obtener-observacion',
        data: {
          "_token": "{{ csrf_token() }}",
          'codcon' : codcon,
        },
        success:function(data) {          
          let Estado = '';
          if(data.code == 1){
            document.getElementById('id').value = data[0][0].id;
            document.getElementById('codcon').value = data[0][0].CodCon;
            document.getElementById('motivo').value = data[0][0].Observacion;
            Estado = data[0][0].Estado; 
          }
          if(data.code == 0){
            document.getElementById('id').value = '';
            document.getElementById('codcon').value = data[0][0].CodCon;
            document.getElementById('motivo').value = '';
          }
          
          if(Estado == 'VIRTUAL'){
            constante = document.getElementById("virtual");
            constante.checked = true;            
          }
          if(Estado == 'CP'){
            constante = document.getElementById("CP");
            constante.checked = true;            
          }
          if(Estado == 'INCONSTANTE'){
            constante = document.getElementById("inconstante");
            constante.checked = true;            
          }
        }
    });      
  }
</script>

<script>
  $("#btnInsertar").click(function(e){   
    e.preventDefault();    
    let id = document.getElementById('id').value;
    let codcon = document.getElementById('codcon').value;
    let motivo = document.getElementById('motivo').value;
    var chv;
    checkedValue = document.querySelector('.messageRadio:checked');    
    if(checkedValue != null){
      chv = checkedValue.value
    }else{
      chv = null;
      toastr.warning("DEBE DE SELECCIONAR EL ESTADO DEL MIEMBRO");
    }
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/administracion/actualizar-observacion',
        data: {
          "_token": "{{ csrf_token() }}",
          'id' : id,
          'motivo' : motivo,
          'codcon' : codcon,
          'checked' : chv
        },
        success:function(data) {
          document.getElementById('close').click();
          if(data.code == 200){
            toastr.success(data.msg);
            refreshTableAjax();     
          }
          if(data.code == 500){
            toastr.error(data.msg);
          }
        }
    });     
  })
</script>

<script type="text/javascript">
  function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age+' años';
  }
</script>
@endsection