@extends('layouts.app')
@section('title', 'Actividades')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
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
            <h1>Actividades</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('finance.activity.getActivities') }}">Actividades</a></li>
              <li class="breadcrumb-item active">Lista de actividades</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-3">
                    <a href="{{ route('finance.activity.form') }}">
                        <button  type="button" class="btn btn-block btn-primary">Añadir nueva actividad</button>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Lista de actividades</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>ACTIVIDAD</th>
                                    <th>DESCRIPCIÓN</th>                                    
                                    <th>OPCIONES</th>                                    
                                </tr>
                            </thead>                   
                            <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td>{{ $activity->activity }}</td>
                                    <td>{{ $activity->description }}</td>                                    
                                    <td>
                                        <a href="#">
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" ata-placement="top">
                                                <i class="fas fa-trash"></i>
                                            </button>         
                                        </a>
                                    </td>
                                </tr>                                
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <!-- <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-md btn-info float-left">Agregar actividad</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a> -->
                </div> 
                <!-- /.card-footer -->
            </div>                
        </div><!-- /.container-fluid -->
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
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script>
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