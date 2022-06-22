@extends('layouts.app')
@section('title', 'Dashboard')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
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
            <h1 class="m-0">Tablero de control - {{ Auth::user()->tabredes->NOM_RED }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('panel.liderred')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">      
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Casas de Paz</span>
                <span class="info-box-number">
                  {{ $CDPs }}
                  <small>Casas de paz</small>
                </span>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-friends"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Usuario registrados</span>
                <span class="info-box-number">
                  {{ $users }}
                  <small>Usuarios</small>
                </span>                
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Miembros en su red</span>
                <span class="info-box-number">{{ $miembros }}</span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bullseye"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Meta de membresía</span>
                <span class="info-box-number">{{ $red->META_RED }}</span>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <div class="progress-group">
          <strong>Meta de membresía</strong>
          <?php $percentage = ($miembros/$red->META_RED)*100 ?>
          <span class="float-right"><b>{{ $miembros }}</b>/{{$red->META_RED}} ({{ $percentage }}%)</span>
          <div class="progress progress-sm">            
            <div class="progress-bar bg-primary" style="width: <?php echo $percentage; ?>%"></div>
          </div>
        </div>
        <br>
        <div class="row">
          <!-- <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Faltas al culto por casas de paz general para visitas</h3>
              </div>
              <div class="card-body"> 
                <div class="form-group">                  
                  {!! Form::open(array('route' => 'liderred.faltasmiembros.FaultsOfMemberDownload', 'role' => 'form', 'id' => "quickForm")) !!}
                    <div class="form-row">
                      <div class="col-md-8">
                        <select name="culto" class="form-control select2" style="width: 100%;" id="miselect">       
                          @foreach($cultos as $culto)
                            <option value="<?php echo $culto->FecAsi; ?>">{{ 'CULTO GENERAL'.' '.\Carbon\Carbon::parse($culto->FecAsi)->format('d-m-Y') }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <a target="_blank">
                          <button type="submit" class='btn btn-success btn-block'>
                              Imprimir reporte
                          </button>
                        </a>
                      </div>
                    </div>
                  {!! Form::close() !!}            
                </div>
              </div>              
            </div>              
          </div>           -->
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Faltas de miembros (Reporte)</h3>
              </div>
              <div class="card-body"> 
                <div class="form-group">

                  <div class="form-row">
                    <div class="col-md-4">
                      <select name="culto" class="form-control select2" style="width: 100%;" id="miselectcdp">       
                        @foreach($cdps as $cdp)
                          <option value="<?php echo $cdp->CodCasPaz; ?>">{{ $cdp->CodCasPaz }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-8">
                      <a href="#">
                        <button type="button" class="btn btn-outline-info btn-block btn-flat" onclick="imprimirAsistencias()">
                          <i class="fas fa-file-pdf"></i> Descargar reporte de asistencia
                        </button>
                      </a> 
                    </div>
                  </div>

                </div>
              </div>            
            </div>
          </div>          
        </div>   
        <div class="row">
          <!-- <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Informe semanal de casas de paz</h3>
              </div>
              <div class="card-body"> 
                <div class="form-group">
                  <div class="form-row">                    
                    <div class="col-md-12">
                      <a >
                        <button type="button" class="btn btn-outline-info btn-block btn-flat" onclick="imprimirReportesCDP()">
                          <i class="fas fa-file-pdf"></i> Descargar reporte semanal de casa de paz
                        </button>
                      </a> 
                    </div>
                  </div>
                </div>
              </div>
            </div>              
          </div>           -->
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js')

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script> -->
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

    $('.select2').select2();
    $('#miselectcdp').trigger('change');
  });  


  function imprimirAsistencias(){

    var codcaspaz = $('#miselectcdp').val();
    var url = '{{ route("liderred.dashboard.reportAsisCultXCDPDownload", ":id") }}'
    url = url.replace(':id', codcaspaz);
    window.open(
      url,
      "_blank"
    );    
  }

  function imprimirReportesCDP(){   

    var url = '{{ route("liderred.dashboard.weekReportCDP") }}'
    window.open(
      url,
      "_blank"
    );        
  }

</script>
@endsection