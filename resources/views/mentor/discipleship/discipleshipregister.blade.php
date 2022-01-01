<?php
    date_default_timezone_set('America/Lima');
?>
@extends('layouts.app')
@section('title', 'Asistencia de discipulado')
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registro mensual de discipulado</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">              
              <li class="breadcrumb-item active">Asistencia de Discipulado</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Actividades</h3>
              </div>
              <!-- form start -->
              <?php
                $date = \Carbon\Carbon::now();
              ?>
              {!! Form::open(array('route' => 'mentor.discipulado.create_discipleship', 'role' => 'form', 'id' => "quickForm")) !!}
                <div class="card-body">
                    <div class="row">               
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('Fecha del discipulado') !!}
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input name="fecasi" type="text" class="form-control datetimepicker-input" data-target="#reservationdate" id="dateofday"/>
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tema</label>
                                <input name="tema" type="text" class="form-control" id="exampleInputPassword1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="offering">Ofrenda</label>
                                <div class="input-group">
                                    <input name="ofrenda" type="text" class="form-control" id="offering">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-coins"></i></div>
                                    </div>
                                </div>                                                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Crear asistencia</button>
                </div>
              {!! Form::close() !!}
              <!-- /.card-body -->
            </div>
            <!-- /.card -->            
          </div>          
            <!-- /.card -->            
          </div>
          <!-- /.col (left) -->
        </div>

      </div>
      <!-- /.container-fluid -->
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
<!-- Moments -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment-with-locales.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- MasskMoney -->
<script src="{{ asset('plugins/maskmoney/dist/jquery.maskMoney.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $('#quickForm').validate({
    rules: {      
      fecasi: {
        required: true,
      },      
      tema: {
        required: true,
      },      
      ofrenda: {
        required: true,
      },      
    },
    messages: {
      fecasi: {
        required: "Por favor ingrese la fecha del discipulado",
      },
      tema: {
        required: "Por favor ingrese el tema de la enseñanza",      
      },
      ofrenda: {
        required: "Por favor ingrese el monto de la ofrenda",
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
    
    $('#offering').maskMoney({thousands:'', decimal:'.', allowZero:true});
    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L',
        locale: 'es'
    });    

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    document.getElementById("menudiscipuladoopen").className += ' menu-open';    
    document.getElementById("menudiscipuladoactive").className += " active";    
    document.getElementById("discipulado").className += " active";    
  });
</script>
@endsection