@extends('layouts.app')
@section('title', 'Miembros de CP')
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
            <h1 class="m-0">Lista de miembros {{ $cdp }}</h1>            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('lidercdp.getcdp') }}">Ver Casas de Paz</a></li>
              <li class="breadcrumb-item active">Lista de miembros</li>
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
      <div class="card">
              <div class="card-header">
                <h3 class="card-title">Miembros de casa de paz</h3>                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>PROCESO</th>
                    <th>NOMBRES</th>
                    <th>EDAD</th>
                    <th>DIRECCIÓN</th>
                    <th>CELULAR</th>
                    <th>TIPO</th>
                    <th>OPCIONES</th>
                  </tr>
                  </thead>
                  <tbody>             
                  @foreach($members as $member)
                  @if($member->finished == null)
                    <tr>
                  @else
                    <tr style="background-color: #DC3545; color: #fff">
                  @endif
                    <td style="text-align: center; font-size: 20px">
                    @if($member->EstaEnProceso == 1)
                        <span class="badge badge-info">SI</span>
                    @else
                        <span class="badge badge-danger">NO</span>
                    @endif
                    </td>
                    <td>{{ $member->ApeCon. ' ' .$member->NomCon }}</td>
                    <td style="text-align: center">
                        <?php
                            $edad = \Carbon\Carbon::parse($member->FecNacCon)->age;
                            if($edad == 0){
                                echo "------";
                            }else{
                                echo $edad. " años";
                            }                        
                        ?>                        
                    </td>
                    <td>{{ $member->DirCon }}</td>
                    <td>{{ $member->NumCel }}</td>
                    <td>{{ $member->TipCon }}</td>
                    <td style="font-weight: bold;">
                        @if($member->finished == null)
                          <!-- <a href="{{ route('lidercdp.observations.reportMember', [$member->CodCon, $cdp]) }}">
                            <button class="btn btn-warning btn-sm" data-toggle="tooltip" ata-placement="top" title="reportar a <?php echo $member->NomCon ?>">
                                <i class="fas fa-pen-nib"></i>
                            </button>         
                          </a> -->
                        @endif                       
                        <a href="{{ route('lidercdp.members.show', 'MCDP'.$member->CodCon) }}">
                          <button class="btn btn-success btn-sm" data-toggle="tooltip" ata-placement="top" title="Ver detalles <?php echo $member->NomCon ?>">
                              <i class="fas fa-eye fa-sm"></i>
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
                    <th>DIRECCIÓN</th>
                    <th>CELULAR</th>
                    <th>TIPO</th>
                    <th>OPCIONES</th>
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
    
    document.getElementById("menucdpopen").className += ' menu-open';    
    document.getElementById("menucdpactive").className += " active";    
    document.getElementById("showcdp").className += " active";    
  });
  
</script>
@endsection
