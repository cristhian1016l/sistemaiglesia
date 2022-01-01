<?php
  \Carbon\Carbon::setlocale(config('app.locale'));
?>
@extends('layouts.app')
@section('title', 'Asistencia de discipulado')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">  
@endsection
@section('contenido')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de registro de discipulados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Lista de discipulados</li>
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
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Últimos 5 discipulados tenidos</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mt-4">            
                  <div class="col-sm-12">         
                    <label for="">Seleccione registrar o ver algún registro</label>
                    <table class="table table-responsive" id="mitabla">
                      <thead>
                        <tr>
                          <th hidden>CodAsi</th>
                          <th>Mes</th>
                          <th>Tema</th>
                          <th>Fecha</th>
                          <th>Ofrendas</th>
                          <th>Asistencias</th>
                          <th>Faltas</th>
                          <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $meses = ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE']; ?>
                      @foreach($discipleship as $dis)
                      <tr>
                        <td>{{ $meses[$dis->mes-1] }}</td>
                        <td hidden>{{ $dis->codasi }}</td>
                        <td>{{ $dis->tema }}</td>                
                        @if($dis->fecasi)
                          <td>{{ \Carbon\Carbon::parse($dis->fecasi)->format('d-m-Y') }}</td>
                        @else
                          <td>----</td>
                        @endif                        
                        <td>S/.{{ $dis->ofrenda }}</td>
                        <td>{{ $dis->totasistencia }}</td>               
                        <td>{{ $dis->totfaltas }}</td>               
                        <td>
                          <?php
                            if($dis->activo == 1){
                              ?>
                                <a href="{{ route('mentor.discipulado.create', $dis->codasi) }}">
                                    <button class="btn btn-success">
                                        Registrar
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                              <?php
                            }else{
                              ?>
                                <!-- <button class="btn btn-info" onclick="show_assistance('<?php echo $dis->codasi ?>')">
                                    Ver asistencia
                                    <i class="fas fa-eye"></i>
                                </button>                         -->
                                <p style="color: green;">Informe cerrado y/o enviado</p>
                              <?php                              
                            }
                          ?>
                        </td>
                      </tr>
                      @endforeach
                      </tbody>
                    </table>                                        
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('js')
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
  <script>
    $(document).ready(function(){                
        
    });
  </script>
  <script>
    $(function () {

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
@endsection