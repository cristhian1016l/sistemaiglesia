<?php
    date_default_timezone_set('America/Lima');
?>
@extends('layouts.app')
@section('title', 'Asistencia Diaria')
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
            <h1>Registro diario de asistencia</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.asistencia.index') }}">Asistencia</a></li>
              <li class="breadcrumb-item active">Registro diario de asistencia</li>
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
              {!! Form::open(array('route' => 'admin.asistencia.registerAssistance', 'role' => 'form', 'id' => "quickForm")) !!}
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Asistencia</label>
                            <input class="form-control" id="exampleInputEmail1" value="{{ $date->format('dmYhi') }}" readonly>
                            <input name="codactmes" class="form-control" id="exampleInputEmail1" value="{{ $CodAct }}" hidden=true readonly>
                        </div>                        
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Fecha</label>
                            <input name="fecha" type="text" class="form-control" id="exampleInputPassword1" value="{{ $activities->FecAct }}" readonly>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Actividad</label>
                                <input name="actividad" type="text" class="form-control" id="exampleInputPassword1" value="{{ $activities->DesAct }}" readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Desde</label>
                                <input name="desde" type="text" class="form-control" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($activities->HorIni)->toTimeString()  }}" readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hasta</label>
                                <?php
                                    $new_date_format = date('s', $activities->MinTol);
                                ?>
                                <input name="hasta" type="text" class="form-control" id="exampleInputPassword1" value="{{ \Carbon\Carbon::parse($activities->HorIni)->addMinutes($new_date_format)->toTimeString() }}" readonly>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Llenar lista de oración</button>
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
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    document.getElementById("menuasistenciaopen").className += ' menu-open';    
    document.getElementById("adminasistenciaactive").className += " active";    
    document.getElementById("assistance").className += " active";    
  });
</script>
@endsection