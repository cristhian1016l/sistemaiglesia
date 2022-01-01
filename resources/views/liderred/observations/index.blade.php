@extends('layouts.app')
@section('title', 'Observaciones de miembros')
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
            <h1 class="m-0">Lista de observaciones</h1>            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('liderred.observations.getObservations') }}">Observaciones</a></li>
              <li class="breadcrumb-item active">Observaciones</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- MENSAJES DE ALERTA -->        
    <div class="card-body" style="display: none;" id="refresh">
        <button class="btn btn-success" onclick="refresh()">Click aquí para ver los cambios</button>
    </div>

    <div class="card-body" id="error" style="display: none;">
      <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> No se pudo cambiar el estado, comuníquese con el administrador del sistema!</h5>          
      </div>
    </div>
    <div class="card-body" id="exito" style="display: none;">
      <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> Estado marcado como leído</h5>
      </div>        
    </div>        
    <!-- FIN DE MENSAJES DE ALERTA -->

    <!-- MENSAJES DE ALERTA -->            
    <div class="card-body" id="errorDelete" style="display: none;">
      <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i> No se pudo eliminar la observación, comuníquese con el administrador del sistema!</h5>
      </div>
    </div>
    <div class="card-body" id="exitoDelete" style="display: none;">
      <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-exclamation-triangle"></i>Se eliminó la observación correctamente</h5>
      </div>        
    </div>        
    <!-- FIN DE MENSAJES DE ALERTA -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="card">
              <div class="card-header">
                <h3 class="card-title">Reportes creados</h3>                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="font-size: 15px;">MIEMBRO</th>
                    <th style="font-size: 15px;">OBSERVACIÓN</th>
                    <th style="font-size: 15px;">LÍDER</th>
                    <th style="font-size: 15px;">CEL LÍDER</th>
                    <th style="font-size: 15px;">FECHA</th>
                    <th style="font-size: 15px;">ESTADO</th>            
                  </tr>
                  </thead>
                  <tbody>             
                  @foreach($observations as $observation)
                  <tr>                    
                    <td style="font-size: 14px;">{{ $observation->nomapecon }}</td>
                    <td style="font-size: 14px;">{{ $observation->description }}</td>
                    <td style="font-size: 14px;">{{ $observation->ApeCon.' '.$observation->NomCon }}</td>
                    <td style="font-size: 14px;">{{ $observation->NumCel }}</td>
                    <td style="font-size: 14px;"><?php echo \Carbon\Carbon::parse($observation->created_at)->diffForHumans(); ?></td>
                    <td style="font-size: 14px; font-weight: bold;">
                        <?php
                        if($observation->finished == 'leido'){
                            ?>                            
                                <p style="color: green;">Reporte visto</p>
                            <?php
                        }else{
                            ?>
                                <p style="color: blue;">Reporte no visto</p>
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
                    <th style="font-size: 15px;">OBSERVACIÓN</th>
                    <th style="font-size: 15px;">LÍDER</th>
                    <th style="font-size: 15px;">CEL LÍDER</th>
                    <th style="font-size: 15px;">FECHA</th>
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
  });
</script>
@endsection