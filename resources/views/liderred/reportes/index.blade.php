@extends('layouts.app')
@section('title', 'Informes recibidos')
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
            <h1 class="m-0">Reuniones de casas de paz: Año <?php echo date("Y"); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">              
              <li class="breadcrumb-item active">Reuniones de casas de paz</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">      
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-md-3">
            <form action="">                    
                <label for="">SELECCIONE LA SEMANA</label>
                <select name="week" class="form-control select2" style="width: 100%;" id="miselect">
                <?php                        
                    for($i=1; $i<=52; $i++){
                      $datetime = new DateTime();
                      $datetime->setISODate(date("Y"),date($i, strtotime(date('Y-m-d'))));
                      $result['start_date'] = $datetime->format('d-m-Y');
                      $datetime->modify('+6 days');
                      $result['end_date'] = $datetime->format('d-m-Y'); 
                      if($i==date('W')){
                        ?>
                        <option selected="selected" value="<?php echo $i; ?>"><?php echo $result['start_date'].' - '.$result['end_date']; ?></option>
                        <?php
                      }
                        ?>
                        <option value="<?php echo $i; ?>"><?php echo $result['start_date'].' - '.$result['end_date']; ?></option>
                        <?php
                    }
                ?>            
                </select>        
            </form>                
          </div>                      
          <div class="col-md-3" id="add_disciples">
            <label for="">OPCIONES</label>
            <a>
                <button  type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default" onclick="show_cdps()">Abrir informes</button>
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
            <h3 class="card-title">Listado de reuniones de casa de paz</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th hidden>CODIGO</th>
                  <th>CDP</th>
                  <th>FECHA</th>
                  <th>TEMA</th>
                  <th>OFRENDA</th>
                  <th>ASIS.</th>
                  <th>FALT.</th>
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
          <h4 class="modal-title">Agregar Casas de Paz</h4>              
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <input type="hidden" name="_token" value="{{ csrf_token()}}" id="{{ 'token' }}">
          <div class="modal-body">
            <div class="form-group">
              {!! Form::label('Seleccione las casas de paz a agregar') !!}
              <div class="select2-purple">
                <select class="select2" multiple="multiple" data-placeholder="Seleccione las casas de paz" data-dropdown-css-class="select2-purple" style="width: 100%;" id="miselect_cdps">
                </select>
              </div>
            </div>                        
          </div>                             
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="close">CERRAR</button>
            <button id="btnInsertar" type="submit" class="btn btn-sm btn-info float-left">AGREGAR CASA(S) DE PAZ</button>
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
    
    $('#miselect').on('change', function (){
      get_list();
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
    // LISTO OBTENER LISTA
    function get_list(){
      var week = $('#miselect').val();

      $('#example1').dataTable().fnClearTable();
      $('#example1').dataTable().fnDestroy();
      $('#example1').DataTable({
        "ajax":{
          "type": "POST",
          "url": "/informes/cpds/traer-registros",
          "data": {'week': week},
          "dataSrc": function(data){
            document.getElementById('falta').innerHTML = 'FALTAN ENVIAR '+data.foul+' CASA(S) DE PAZ';
            return data.cdps;
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
          {"data": "NumInf"},
          {"data": "CodCasPaz"},
          {"data": "FecInf"},
          {"data": "TemSem"},          
          {"data": "OfreReu"},
          {"data": "TotAsiReu"},
          {"data": "TotAusReu"},
          {"data": "Enviado"},
        ],
        "columnDefs": [
          { "targets": [0], "visible": false },
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
              return createManageBtn(row.NumInf, data)
            }
          }
        ],
      });
      var table = $('#example1').DataTable(); 
      $('div.dataTables_filter input', table.table().container()).focus();            
    }    
    // FIN LISTO OBTENER LISTA

    // LISTO CERRAR CDP
    function closeCdp(numinf){
      event.preventDefault();
      var week = $('#miselect').val();        
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/informes/cpds/cerrar-cdp',
          data: {
            "_token": "{{ csrf_token() }}",
            'numinf' : numinf,
            'week' : week
          },
          success:function(data) {            
            $('#miselect').trigger('change');
          }
      });
    }
    // FIN LISTO CERRAR CDP

    function openDiscipleship(numinf){
      event.preventDefault();
      var month = $('#miselect').val();        
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/informes/cpds/abrir-cdp',
          data: {
            "_token": "{{ csrf_token() }}",
            'numinf' : numinf,
          },
          success:function(data) {            
            $('#miselect').trigger('change');
          }
      });
    }    

    // LISTO MOSTRAR CDPS
    function show_cdps(){
      event.preventDefault();
      var week = $('#miselect').val();        
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/informes/cdps/mostrar-cpds-faltantes',
        data: {
          "_token": "{{ csrf_token() }}",
          'week' : week, 
        },
        success:function(data) {
          // console.log(data);
          $("#miselect_cdps").empty();
          $.each(data, function(idx, opt) {                
            $('#miselect_cdps').append(
              "<option value="+opt.CodCasPaz+">" + opt.CodCasPaz + ' - '+opt.ApeCon+' '+opt.NomCon + "</option>"
            );               
          });
        }
      });
    }
    // FIN LISTO MOSTRAR CDPS

</script>
<!-- LISTO INSERTAR DISCIPULADOS-->
<script>
  $("#btnInsertar").click(function(e){
    e.preventDefault();    
    let cdps = $("#miselect_cdps").select2("val") 
    var week = $('#miselect').val();       
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:'/informes/cpds/agregar',
      data:{
        "_token": "{{ csrf_token() }}",
        "cdps": cdps, 
        'week' : week   
      },
      success:function(data) {
        console.log(data);
        $('#miselect').trigger('change');
        document.getElementById('close').click();
        toastr.success("CASA(S) DE PAZ AGREGADO(S) CORRECTAMENTE");
      }, error:function(data){
        toastr.error("HUBO UN ERROR AL INSERTAR AL INSERTAR LAS CASAS DE PAZ - ERROR 500");
      }
    });
  })  
</script>
<!-- FIN LISTO INSERTAR DISCIPULADOS-->
<!-- LISTO BOTONES -->
<script type="text/javascript">
  function createManageBtn(numinf, enviado) {
    // return codcon+' '+numinf+' '+asistio;
    if(enviado == 0){        
      return '<button class="btn btn-warning btn-sm" onclick="closeCdp('+"'"+numinf+"'"+')">Cerrar</button>'              
    }else{                 
      var url = '{{ route("Liderred.cdps.reportDownload", ":numinf") }}';
      url = url.replace(':numinf', numinf);
      return '<button class="btn btn-success btn-sm" onclick="openDiscipleship('+"'"+numinf+"'"+')">abrir</button>'+
            '<a href="'+url+'" target="_blank"><button class="btn btn-danger btn-sm"><i class="far fa-file-pdf"></i></button></a>';
    }          
  }    
</script>
<!-- FIN LISTO BOTONES -->
@endsection