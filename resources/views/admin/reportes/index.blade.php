@extends('layouts.app')
@section('title', 'Asistencias')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">  
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
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
            <h1>Realizar reportes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Realizar reportes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

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
        <div class="row">
          <div class="col-md-12">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Faltas consecutivas de discipulos al culto</h3>
              </div>
              <div class="card-body"> 
                <div class="form-group">
                  <!-- <label>Faltas consecutivas de discipulos al culto</label> -->
                  {!! Form::open(array('route' => 'admin.faltasdiscipulos.report', 'role' => 'form', 'id' => "quickForm")) !!}
                      <div class="form-row">
                          <div class="col-md-4">
                              <select name="faltas" class="form-control select2" style="width: 100%;" id="miselect">
                                <option value="2">2 CULTOS CONSECUTIVOS</option>
                                <option value="3">3 CULTOS CONSECUTIVOS</option>
                                <option value="4">4 CULTOS CONSECUTIVOS</option>
                                <option value="5">5 CULTOS CONSECUTIVOS</option>
                              </select>
                          </div>
                          <div class="col-md-4">
                              <a href="{{ route('admin.faltasdiscipulos.report') }}" target="_blank">
                                  <button type="submit" class='btn btn-secondary btn-block' target="_blank">
                                      Imprimir reporte
                                  </button>
                              </a>
                          </div>
                      </div>
                  {!! Form::close() !!}            
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->            
          </div>          
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Faltas a los discipulados mensuales</h3>                
              </div>
              <div class="card-body"> 
                <div class="form-group">
                  <!-- <label>Faltas a los discipulados</label> -->
                  <div class="form-row">                          
                      <div class="col-md-12">
                          <a href="{{ route('admin.faltasdiscipulados.report') }}" target="_blank">
                              <button type="submit" class='btn btn-secondary btn-block' target="_blank">
                                  Imprimir reporte
                              </button>
                          </a>
                      </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->            
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-12" id="accordion">
                <div class="card card-warning card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseOneAdmin">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                1. ¿Algunos discípulos no aparecen en la lista?
                            </h4>
                        </div>
                    </a>
                    <div id="collapseOneAdmin" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            La razón es porque no han faltado a los 3 últimos discipulados
                        </div>
                    </div>
                </div>
                <div class="card card-danger card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseTwoAdmin">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                2. ¿Que hacer si un mes no hay discipulado?
                            </h4>
                        </div>
                    </a>
                    <div id="collapseTwoAdmin" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Comunicar para solucionar el problema
                        </div>
                    </div>
                </div>
                <div class="card card-warning card-outline">
                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThreeAdmin">
                        <div class="card-header">
                            <h4 class="card-title w-100">
                                3. ¿Que pasa si un un discipulado solo tuvo una o dos reuniones?
                            </h4>
                        </div>
                    </a>
                    <div id="collapseThreeAdmin" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            El sistema cuenta las últimas 3 reuniones, por ende 
                            sólo se contará los discipulados dados y los demás aparecerá como falta,
                            se recomienda guiarse por la columna "total" que aparece en el reporte
                        </div>
                    </div>
                </div>
              </div>
            </div>  
          </div>
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
<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment-with-locales.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L',
        locale: 'es'
    });
    //Initialize Select2 Elements
    $('.select2').select2()

    document.getElementById("adminasistenciaactive").className += " active";    
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

<script>
    $(document).ready(function(){        
        $("#dateofday").on('input', function(){
            getActMes($(this).val());
        });
        $("#dateofday").on('input', function(){
          getPreviousAssistance($(this).val());
        });
    });

    function getActMes(act) {
      let actDia = act.slice(0,2);
      let actMes = act.slice(3,5);
      let actAnio = act.slice(6,10);
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/asistencia/'+actAnio+actMes+actDia,
          data:'_token = <?php echo csrf_token() ?>',
          success:function(data) {
            // $("#msg").html(data.msg);
            // console.log(data);
            $("#mitabla > tbody").empty();
            $.each(data, function(idx, opt) {                
              $('#mitabla').append(
                '<tr>' +
                  '<td>' + opt.DesAct + '</td>' +
                  '<td>' + opt.LugAct + '</td>' +
                  "<td>" +
                    "<a href='/administracion/asistencia/"+opt.CodActMes+"'>" +
                      "<button class='btn btn-success'>realizar registro</button>" +
                    "</a>" +
                  "</td>" +
                '</tr>'
              );               
            });
          }
      });
    }

</script>
@endsection