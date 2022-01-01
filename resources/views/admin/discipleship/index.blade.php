@extends('layouts.app')
@section('title', 'Administración de reunión de discipulados')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">  
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Reuniones de discipulados</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">              
              <li class="breadcrumb-item active">Listado de reuniones de discipulados</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- MENSAJES DE ERROR -->    
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
  <!-- TERMINO DE MENSAJES DE ERROR -->

    <!-- Main content -->
    <section class="content">      
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-3">
                <form action="">                    
                    <label for="">SELECCIONE EL AÑO</label>
                    <select name="month" class="form-control select2" style="width: 100%;" id="miselectyear">
                        <?php 
                            for($i = date('Y') ; $i >= 2021 ; $i--){
                                ?>
                                    <option value="<?php echo $i; ?>">{{ $i }}</option>
                                <?php
                            }
                        ?>
                    </select>
                </form>                
            </div>
            <div class="col-md-3">
                <form action="">
                    <?php 
                      $meses = ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE']; 
                      $i = 1;
                    ?>
                    <label for="">SELECCIONE EL MES</label>
                    <select name="month" class="form-control select2" style="width: 100%;" id="miselect">
                        @foreach($meses as $mes)                            
                            <option value="{{ $i }}">{{ $mes }}</option>
                            <?php $i++; ?>
                        @endforeach
                    </select>
                </form>                
            </div>
            <div class="col-md-3" id="add_disciples">
              <label for="">OPCIONES</label>
              <a>
                  <button  type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default" onclick="show_discipleships()">Añadir discipulados a esta fecha</button>
              </a>                
            </div>          
            <div class="col-md-3" style="display: none;" id="close_discipleship">
              <label for="">OPCIONES</label>
              <a href="#">
                  <button  type="button" class="btn btn-block btn-warning" onclick="close_all_discipleship()">Cerrar todos los discipulados</button>
              </a>                
            </div>            
        </div>
        <div class="row mb-2">
          <div class="col-md-3">
            <label style="color: red" id="falta"></label>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Listado de reuniones de discipulados</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th hidden>CODIGO</th>
                  <th>DESCRIPCIÓN</th>
                  <th>FECHA</th>
                  <th>TEMA</th>
                  <th>OFRENDA</th>
                  <th>ASISTENCIAS</th>
                  <th>FALTAS</th>
                  <th>OPCIONES</th>
                </tr>
              </thead>
              <tbody>               
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>            
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Agregar Discipulados</h4>              
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <input type="hidden" name="_token" value="{{ csrf_token()}}" id="{{ 'token' }}">
          <div class="modal-body">
            <div class="form-group">
              {!! Form::label('Seleccione los discipulados') !!}
              <div class="select2-purple">
                <select class="select2" multiple="multiple" data-placeholder="Seleccione los discipulados" data-dropdown-css-class="select2-purple" style="width: 100%;" id="miselect_discipleships">
                </select>
              </div>
            </div>                        
          </div>                             
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="close">CERRAR</button>
            <button id="btnInsertar" type="submit" class="btn btn-sm btn-info float-left">AGREGAR DISCIPULADOS</button>
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
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
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
$(function(){
  $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      "buttons": ["excel", "pdf", "print", {extend: 'colvis', text: 'Columnas Visibles'}],
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ discipulados",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Discipulados",
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

    $('#miselectyear').on('change', function (){
      get_discipleship_list();
    });

    $('#miselect').on('change', function (){
      get_discipleship_list();
    });

    $('#miselect').trigger('change');

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
})
</script>

<script>
    function get_discipleship_list(){

      var year = $('#miselectyear').val();
      var month = $('#miselect').val();        
      // alert(select_year+' '+select_month);
      
      $('#example1').dataTable().fnClearTable();
      $('#example1').dataTable().fnDestroy();
      $('#example1').DataTable({
        "ajax":{
          "type": "POST",
          "url": "/administracion/discipulado/traer-registros",
          "data": {'mes': month, "anio" : year},
          "dataSrc": function(data){
            if(data.discipleship.length === 0){
              var y = document.getElementById("close_discipleship");
              y.style.display = "none";              
            }else{              
              $( "#close_discipleship" ).slideDown( "slow", function() {});
              document.getElementById('falta').innerHTML = 'FALTAN ENVIAR '+data.foul+' DISCIPULADOS';
            }
            return data.discipleship;
          },
          "headers": {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        },
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "buttons": ["excel", "pdf", "print"],
        "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ discipulados",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Discipulados",
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
          {"data": "codasi"},
          {"data": "DesArea"},
          // {"data": "mes"},
          {"data": "fecasi"},
          {"data": "tema"},          
          {"data": "ofrenda"},
          {"data": "totasistencia"},
          {"data": "totfaltas"},
          {"data": "activo"},
        ],
        "columnDefs": [
          // {
          //   "targets": [1],
          //   render: function(data){
          //     var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
          //     return meses[data - 1];
          //   }            
          // },
          { "targets": [0], "visible": false, "searchable": false },
          { "targets": [1], "searchable": true },
          { 
            "targets": [4], 
            "searchable": false,
            render: function(data){
              if(data!==null){
                return 'S/.'+data;
              }else{
                return '';
              }
            }
          },
          { "targets": [5], "searchable": false },
          { "targets": [6], "searchable": false },          
          {
            "targets": [7],
            "searchable": false,
            render: function(data, type, row){
              return createManageBtn(row.codasi, data)
            }
          }
        ],
      });
      var table = $('#example1').DataTable(); 
      $('div.dataTables_filter input', table.table().container()).focus();            
    }    

    function close_all_discipleship(){
      event.preventDefault();
      var year = $('#miselectyear').val();
      var month = $('#miselect').val();        
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/discipulado/cerrar-discipulados-total',
          data: {
            "_token": "{{ csrf_token() }}",
            'month' : month, 
            'year': year
          },
          success:function(data) {            
            $('#miselect').trigger('change');
          }
      });
    }

    function closeDiscipleship(codasi){
      event.preventDefault();
      var year = $('#miselectyear').val();
      var month = $('#miselect').val();        
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/discipulado/cerrar-discipulado',
          data: {
            "_token": "{{ csrf_token() }}",
            'codasi' : codasi,
            'month' : month, 
            'year': year
          },
          success:function(data) {            
            $('#miselect').trigger('change');
          }
      });
    }

    function openDiscipleship(codasi){
      event.preventDefault();
      var year = $('#miselectyear').val();
      var month = $('#miselect').val();        
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/discipulado/abrir-discipulado',
          data: {
            "_token": "{{ csrf_token() }}",
            'codasi' : codasi,
            'month' : month, 
            'year': year
          },
          success:function(data) {            
            $('#miselect').trigger('change');
          }
      });
    }    

    function show_discipleships(){
      event.preventDefault();
      var year = $('#miselectyear').val();
      var month = $('#miselect').val();        
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/administracion/discipulado/mostrar-discipulados-faltantes',
        data: {
          "_token": "{{ csrf_token() }}",
          'month' : month, 
          'year': year
        },
        success:function(data) {
          $("#miselect_discipleships").empty();
          $.each(data, function(idx, opt) {                
            $('#miselect_discipleships').append(
              "<option value="+opt.CodArea+">" + opt.DesArea + "</option>"
            );               
          });
        }
      });
    }
</script>
<script>
  $("#btnInsertar").click(function(e){    
    e.preventDefault();    
    let discipulados = $("#miselect_discipleships").select2("val") 
    var month = $('#miselect').val();        
    var year = $('#miselectyear').val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:'/administracion/discipulado/agregar',
      data:{
        "_token": "{{ csrf_token() }}",
        "discipulados": discipulados, 
        'month' : month, 
        'year': year       
      },
      success:function(data) {
        $('#miselect').trigger('change');
        document.getElementById('close').click();
        toastr.success("DISCIPULADO(S) AGREGADO CORRECTAMENTE");
      }, error:function(data){
        toastr.error("HUBO UN ERROR AL INSERTAR AL INSERTAR LOS DISCIPULADOS - ERROR 500");
      }
    });
  })  
</script>
<script type="text/javascript">
  function createManageBtn(codasi, activo) {
    // return codcon+' '+codasi+' '+asistio;
    if(activo == 1){        
      return '<button class="btn btn-warning btn-sm" onclick="closeDiscipleship('+"'"+codasi+"'"+')">Cerrar</button>'              
    }else{                 
      var url = '{{ route("admin.discipulado.reportDownload", ":codasi") }}';
      url = url.replace(':codasi', codasi);
      return '<button class="btn btn-success btn-sm" onclick="openDiscipleship('+"'"+codasi+"'"+')">abrir</button>'+
            '<a href="'+url+'" target="_blank"><button class="btn btn-danger btn-sm"><i class="far fa-file-pdf"></i></button></a>';
    }          
  }    
</script>
@endsection