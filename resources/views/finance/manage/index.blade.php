@extends('layouts.app')
@section('title', 'Administración de las finanzas')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
            <h1 class="m-0">Lista de administración de las finanzas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('finance.activitymanage.getActivityManage') }}">Administración de las finanzas</a></li>
              <li class="breadcrumb-item active">Lista</li>
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
                <a href="{{ route('finance.activitymanage.create') }}">
                    <button  type="button" class="btn btn-block btn-primary">Crear nueva administración</button>
                </a>
            </div>
        </div>
        <div class="card">
            <!-- <div class="card-header">
            <h3 class="card-title">Miembros de casa de paz</h3>                
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>ACTIVIDAD</th>
                <th>MES</th>
                <th>AÑO</th>                    
                <th>OPCIONES</th>
                </tr>
                </thead>
                <tbody>           
                  @foreach($manages as $manage)
                    <?php
                      $months = array (1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembr',
                                      10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
                    ?>
                    <tr>
                      <td>{{ $manage->activity }}</td>
                      <td>{{ $months[$manage->month] }}</td>
                      <td>{{ $manage->year }}</td>
                      <td style="font-weight: bold;">
                        <a href="{{ route('finance.activitymanage.getDetailsActivityManage', $manage->id) }}">
                            <button class="btn btn-success btn-sm" data-toggle="tooltip" ata-placement="top" title="Administrar">
                              <i class="fas fa-edit"></i>
                            </button>         
                        </a>
                        <!-- <a href="#">
                            <button class="btn btn-warning btn-sm" data-toggle="tooltip" ata-placement="top" title="Editar">
                              <i class="fas fa-pen"></i>
                            </button>         
                        </a> -->
                        <a href="#">
                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" ata-placement="top" title="Eliminar">
                              <i class="fas fa-trash"></i>
                            </button>         
                        </a>                      
                      </td>
                    </tr>                
                  @endforeach                                      
                </tbody>
                <tfoot>
                <tr>
                <th>ACTIVIDAD</th>
                <th>MES</th>
                <th>AÑO</th>                    
                <th>OPCIONES</th>
                </tr>
                </tfoot>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
      </div><!--/. container-fluid -->
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
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
        "infoFiltered": "(Filtrado de _MAX_ registros)",
        "paginate": {
            "first": "primero",
            "last": "último",
            "next": "siguiente",
            "previous": "anterior"
        },
      },
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });

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
</script>
@endsection