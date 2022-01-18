@extends('layouts.app')
@section('title', 'Registro de asistencia a cultos')
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
            <h1 class="m-0">Registro de asistencia a los cultos</h1>            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Registro de asistencia</li>
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
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Miembros nuevos</h3>                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
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
                    <tr>                  
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
                        {{-- <a href="{{ route('admin.membership.toDown', $member->CodCon)}}"> --}}
                        <a>
                            <button class="btn btn-success btn-sm" onclick="getData('<?php echo $member->CodCon ?>')" title="Ver las últimas asistencias al culto">
                                <i class="fas fa-eye"></i>
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
@endsection

@section('js')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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

    moment.locale('es');
    localLocale.locale(false);
  });
</script>

<script>
  function getData(codcon){    
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/administracion/asistenciaCultos',
        data: {
          "_token": "{{ csrf_token() }}",
          'codcon' : codcon,
        },
        success:function(data) {console.log(data);
          $("#mitabla > tbody").empty();
          let contador = 1;
          $.each(data, function(idx, opt) {  
            document.getElementById('name').innerHTML = opt.Nombres;
            var asistencia
            switch(opt.EstAsi){
                case 'A':
                    asistencia = '<td><span class="badge bg-success">Asistió</span></td>'
                    break;
                case 'T':
                    asistencia = '<td><span class="badge bg-success">Asistió (Tarde)</span></td>'
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
    return age;
  }
</script>
@endsection