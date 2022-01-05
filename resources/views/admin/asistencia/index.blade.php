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
  <!-- SWEET ALERT -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
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
            <h1>Registro de asistencia</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.asistencia.index') }}">Asistencias</a></li>
              <li class="breadcrumb-item active">Registro de asistencia</li>
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
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Actividades</h3>
              </div>
              <div class="card-body">              
                <table class="table table bordered" id="mitabla">
                  <thead>
                    <tr>
                      <th>Actividad</th>
                      <th>Lugar</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card --> 
            <div class="card" id="card_hidden" style="display: none;">
              <div class="card-header">
                <h3 class="card-title">Mentores que aún no registran la oración de sus discípulos</h3>                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 600px;">
                <table class="table table-head-fixed text-nowrap" id="table-prayer">
                  <thead>
                    <tr>
                      <th>CÓDIGO</th>
                      <th>DISCIPULADO</th>
                    </tr>
                  </thead>
                  <tbody>                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>           
          </div>
          <!-- /.col (left) -->
          <div class="col-md-3">
          <!-- /.card -->
            <div class="form-group">
              <label>Registros anteriores</label>
                {!! Form::open(array('route' => 'admin.asistencia.getDetailsDetAsi', 'role' => 'form', 'id' => "quickForm")) !!}
                  <select name="CodAsi" class="form-control select2" style="width: 100%;" id="miselect">
                  </select>
                  <a href="{{ route('admin.asistencia.getDetailsDetAsi') }}">
                    <button type="submit" class='btn btn-success btn-block'>
                        Ir a asistencia anterior
                    </button>
                  </a>
                {!! Form::close() !!}            
            </div>
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Fecha</h3>
              </div>
              <div class="card-body">
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Seleccione la fecha</label>
                    <!-- Date -->
                    <div class="form-group">
                      <!-- <label>Date:</label> -->
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" id="dateofday"/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.form group -->

              </div>
              <!-- /.card-body -->
            </div>        
            <a href="{{ route('admin.imprimir_oracion') }}" target="_blank">
              <button type="submit" class="btn btn-block btn-primary">Generar PDF de oración</button>
            </a>
          </div>
          <!-- /.col (right) -->          
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
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
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

        $("#dateofday").on('input', function(){
          getFaults($(this).val());
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
<script>
  function getPreviousAssistance(act) {
      let actDia = act.slice(0,2);
      let actMes = act.slice(3,5);
      let actAnio = act.slice(6,10);
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/asistenciaAnterior/'+actAnio+actMes+actDia,
          data:'_token = <?php echo csrf_token() ?>',
          success:function(data) {            
            $("#miselect").empty();
            $.each(data, function(idx, opt) {                
              $('#miselect').append(
                "<option value="+opt.CodAsi+">" + opt.TipAsi + "</option>"
              );               
            });
          }
      });
    }
</script>
<script>
  function getFaults(act) {
    let actDia = act.slice(0,2);
    let actMes = act.slice(3,5);
    let actAnio = act.slice(6,10);
    var card = document.getElementById("card_hidden");
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/administracion/asistencia/faltas/'+actAnio+actMes+actDia,
        data:'_token = <?php echo csrf_token() ?>',
        success:function(data) {
          if(data.cod == 1){
            $("#table-prayer > tbody").empty();
            // toastr.danger(data.msg);
            card.style.display = "none";
          }else{
            card.style.display = "block";
            $("#table-prayer > tbody").empty();
            $.each(data.datos, function(idx, opt) {
              $('#table-prayer').append(
                '<tr>' +
                  '<td>' + opt.CodArea + '</td>' +
                  '<td>' + opt.DesArea + '</td>' +                
                '</tr>'
              );               
            });
          }                    
            
        }, error:function(data){
          $("#table-prayer > tbody").empty();
          card.style.display = "none";
          // toastr.error("NO HAY NINGÚN REGISTRO EN LA FECHA SELECCIONADA");
        }
    });
  }
</script>
@endsection