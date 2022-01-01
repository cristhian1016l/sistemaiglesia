@extends('layouts.app')
@section('title', 'Crear nueva administración')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">  
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                <h1>Crear administración</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('finance.activitymanage.getActivityManage') }}">Listar Administraciones</a></li>
                <li class="breadcrumb-item active">Crear Administración</li>
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
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Crear Usuario</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::open(array('route' => 'finance.activitymanage.createActivityManage', 'role' => 'form', 'id' => "quickForm")) !!}
                        @include('finance.manage.formCreate')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-block">Crear administración</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-footer">
                                    <a href="{{ route('finance.activitymanage.getActivityManage') }}">
                                        <button type="button" class="btn btn-danger btn-block">Cancelar</button>
                                    </a>
                                </div>
                            </div>
                        </div>                     
                        {!! Form::close() !!}
                    
                    <!-- <form id="quickForm">
                        <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="form-group mb-0">
                            <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                            <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
                            </div>
                        </div>
                        </div>
                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form> -->
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
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<!-- jquery-validation -->
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('mm/yyyy', { 'placeholder': 'mm/yyyy' })
    $('[data-mask]').inputmask()
  })
</script>

<script>
$(function () {
  $('#quickForm').validate({
    rules: {      
      activity: {
          required: true
      },
      date: {
        required: true,
        minlength: 6
        // email: true,
      },
    },
    messages: {
      activity: {
        required: "Por favor seleccione la actividad"
      },
      date: {
        required: "Por favor ingrese el mes y el año",
        minlength: "Ingrese la fecha completa"
        // email: "Por favor ingrese un email válido"
      },
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

    document.getElementById("tesoreroactivitiesopen").className += ' menu-open';    
    document.getElementById("tesoreroactivitiesactive").className += " active";    
    document.getElementById("tesoreromanage").className += " active";    
});
</script>

@endsection