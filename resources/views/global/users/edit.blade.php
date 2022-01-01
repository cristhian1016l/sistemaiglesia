@extends('layouts.app')
@section('title', 'Editar usuario')
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
                <h1>Cambiar mi contraseña</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('global.usuarios.edit') }}">Configuración</a></li>
                <li class="breadcrumb-item active">Cambiar mi contraseña</li>
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
                <!-- left column -->
                <div class="col-md-8">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Editar Usuario <small>{{ $user->email }}</small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::model($user, ['route' => ['global.usuarios.update'], 'id' => "quickForm"]) !!}
                        @include('global.users.form')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-footer">
                                    <a href="#"><button type="submit" class="btn btn-primary btn-block">Editar usuario</button></a>
                                </div>
                            </div>
                        </div>                     
                        {!! Form::close() !!}                    
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
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
<!-- Page specific script -->
<!-- jquery-validation -->
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>


<script>
$(function () {
  $('#quickForm').validate({
    rules: {      
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      email: {
        required: "Por favor ingrese un correo",
        email: "Por favor ingrese un email válido"
      },
      password: {
        required: "Por favor ingrese una contraseña",
        minlength: "Tu contraseña debe de tener al menos 5 caracteres"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
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