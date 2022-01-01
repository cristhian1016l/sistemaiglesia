@extends('layouts.app')
@section('title', 'Usuarios mentores')
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Mentores</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.usuarios.getusers') }}">Usuarios</a></li>
              <li class="breadcrumb-item active">Lista de usuarios mentores</li>
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
                <a href="{{ route('admin.usuarios.form') }}">
                    <button  type="button" class="btn btn-block btn-primary">Añadir nuevo usuario</button>
                </a>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Usuarios mentores</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Email</th>
                      <th>Nombres</th>
                      <th>¿Activo?</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <tr>                      
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->ApeCon.' '.$user->NomCon }}</td>
                      @if($user->active == 1)
                        <td>
                            <a href="{{ route('admin.usuarios.desactivate', $user->id) }}">
                                <button class="btn btn-danger">
                                    Desactivar
                                    <i class="fas fa-user-minus"></i>
                                </button>                        
                            </a> 
                            <a href="{{ route('admin.usuarios.edit', $user->id) }}">
                                <button class="btn btn-info">
                                    Editar
                                    <i class="fas fa-edit"></i>
                                </button>                        
                            </a>
                        </td>
                      @else
                        <td>
                            <a href="{{ route('admin.usuarios.activate', $user->id) }}">
                                <button class="btn btn-success">
                                    Activar
                                    <i class="fas fa-user-minus"></i>
                                </button>                        
                            </a>
                            <a href="{{ route('admin.usuarios.edit', $user->id) }}">
                                <button class="btn btn-info">
                                    Editar
                                    <i class="fas fa-edit"></i>
                                </button>                        
                            </a>
                        </td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
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
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
$(function(){
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
})
</script>
@endsection