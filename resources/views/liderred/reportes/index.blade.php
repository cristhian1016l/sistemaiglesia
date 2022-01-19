@extends('layouts.app')
@section('title', 'Reportes generales de red')
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
            <h1>Reportes de red</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Reportes de red</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Faltas al culto por casas de paz</h3>
              </div>
              <div class="card-body"> 
                <div class="form-group">
                  <!-- <label>Faltas consecutivas de discipulos al culto</label> -->
                  {!! Form::open(array('route' => 'liderred.faltasmiembros.FaultsOfMemberDownload', 'role' => 'form', 'id' => "quickForm")) !!}
                      <div class="form-row">
                          <div class="col-md-8">
                            <select name="culto" class="form-control select2" style="width: 100%;" id="miselect">       
                                @foreach($cultos as $culto)
                                    <option value="<?php echo $culto->CodAsi; ?>">{{ $culto->TipAsi.' - '.\Carbon\Carbon::parse($culto->FecAsi)->format('d-m-Y') }}</option>
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->            
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