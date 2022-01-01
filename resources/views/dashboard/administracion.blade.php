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
            <h1 class="m-0">Tablero de control - ADMINISTRACIÓN</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('panel.admin')}}">Dashboard</a></li>
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
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-house-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Casas de Paz en Total</span>
                <span class="info-box-number">
                  {{ $CDPs }}
                </span>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Reporte de hoy</span>
                <span class="info-box-number">
                  <?php echo isset($asis) ? 'CREADO' : 'FALTA REALIZAR' ?>
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Membresía Total</span>
                <span class="info-box-number">{{ $members }} activos </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- solid sales graph -->
        <div class="card bg-gradient-info">
          <div class="card-header border-0">
            <h3 class="card-title">
              <i class="fas fa-th mr-1"></i>
              Gráfico de asistencias de oración en los últimos 7 días
            </h3>

            <div class="card-tools">              
              <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="row">
                  <div class="col-md-4">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title mt-1">ASISTENCIA A LOS CULTOS POR REDES</h3>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row">
                      <div class="col-md-6">
                        <select name="miembro" class="form-control select2" style="width: 100%;" id="miselect">       
                          @foreach($cultos as $culto)
                          <option value="<?php echo $culto->CodAsi ?>">{{ $culto->TipAsi.' - '.\Carbon\Carbon::parse($culto->FecAsi)->format('d-m-Y') }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                        <a href="#">
                          <button type="button" class="btn btn-outline-info btn-block btn-flat" onclick="imprimirAsistencias()">
                            <i class="fas fa-file-pdf"></i> Imprimir Asistencias por CDP's 
                          </button>
                        </a>                        
                      </div>
                    </div>                    
                  </div>
                </div>                
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg" id="total"></span>
                    <span>ASISTENCIA TOTAL AL CULTO</span>
                  </p>
                  <!-- <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p> -->
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-success"></i> Asistentes
                  </span>

                  <span class="mr-2">
                    <i class="fas fa-square text-danger"></i> Faltantes
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Permiso
                  </span>
                  
                </div>
              </div>
            </div>
          <!-- /.card -->
          </div>
        </div>        
        <div class="row">
          <div class="col-md-6">
            <div class="card bg-gradient-success">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Gráfico de asistencias a los cultos las últimas 3 semanas
                </h3>

                <div class="card-tools">              
                  <button type="button" class="btn bg-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart-cultos" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title mt-1">TOTAL DE MIEMBROS POR REDES</h3>
              </div>
              </div>
              <div class="card-body">                
                <div class="position-relative mb-4">
                  <canvas id="sales-chart-red" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square" style="color: #22a0bd;"></i> Red Emanuel
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-square" style="color: #7e3791;"></i> Red Yeshua
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-square" style="color: #a61b1b;"></i> Red Adonai
                  </span>
                  <span>
                    <i class="fas fa-square" style="color: #1f24ad;"></i> Red Shadai
                  </span>                  
                </div>
              </div>
            </div>
          </div>
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
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
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
<!-- <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script> -->

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
        getGraphicAssistance();
        getGraphicAssistanceCultos();        
        getGraphicNetworksMembers();

        $('#miselect').on('change', function (){
          getGraphicNetworks();
        });

        $('#miselect').trigger('change');
  });
  //Initialize Select2 Elements
  $('.select2').select2()  
</script>
@role('administrador')
<script>

  function imprimirAsistencias(){
    var codasi = $('#miselect').val();
    var url = '{{ route("admin.dashboard.reportAsisCultDownload", ":id") }}'
    url = url.replace(':id', codasi);
    window.open(
      url,
      "_blank"
    );    
  }

    function getGraphicAssistance() {
      var dia = [];
      var cantidad = [];
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/obtenerAsistenciasGraficas',
          data:'_token = <?php echo csrf_token() ?>',
          success:function(data) {
            // console.log(data);
            var arreglo = JSON.parse(data)
            // console.log(arreglo);
            for(var x=0;x<arreglo.length;x++){
              const f = new Date(arreglo[x].FecAsi);
              console.log(arreglo[x].FecAsi+' '+f.getDay());
              dia.push(arreglo[x].FecAsi+' '+convertir(f.getDay()));
              // dia.push(arreglo[x].mes);
              cantidad.push(arreglo[x].TotAsistencia);
            }            
            showGraphicData(dia, cantidad);            
            // console.log(arreglo);
            
            // console.log(dia);
            // console.log(cantidad)
          }
      });
    }

    function getGraphicAssistanceCultos() {
      var dia = [];
      var cantidad = [];
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/obtenerAsistenciasGraficasCultos',
          data:'_token = <?php echo csrf_token() ?>',
          success:function(data) {
            // console.log(data);
            var arreglo = JSON.parse(data)
            // console.log(arreglo);
            for(var x=0;x<arreglo.length;x++){
              const f = new Date(arreglo[x].FecAsi);
              console.log(arreglo[x].FecAsi+' '+f.getDay());
              dia.push(arreglo[x].FecAsi+' '+convertir(f.getDay()));
              // dia.push(arreglo[x].mes);
              cantidad.push(arreglo[x].TotAsistencia);
            }            
            showGraphicDataCultos(dia, cantidad);
            // console.log(arreglo);
            
            // console.log(dia);
            // console.log(cantidad)
          }
      });
    }

    function getGraphicNetworks() {
      var codasi = $('#miselect').val();
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/obtenerAsistenciasCultoXRed',
          data: {
            '_token' : '{{ csrf_token() }}', 
            'codasi': codasi},
          success:function(data) {
            console.log(data);            
            document.getElementById('total').innerHTML = data.asistencia+' MIEMBROS ASISTIERON Y '+data.falta+' FALTARON';
            showGraphicNetworksData(data);
          }
      });
    }

    function getGraphicNetworksMembers() {
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/obtenerMiembrosXRed',
          data: {
            '_token' : '{{ csrf_token() }}', 
          },
          success:function(data) {
            console.log(data);            
            showNetworkMembers(data);
          }
      });
    }

    function showGraphicData(dia, cantidad){
      // Sales graph chart
      var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
      // $('#revenue-chart').get(0).getContext('2d');

      var salesGraphChartData = {
        labels: dia.reverse(),
        datasets: [
          {
            label: 'Total de asistencias',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#efefef',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#efefef',
            pointBackgroundColor: '#efefef',
            data: cantidad.reverse()
          }
        ]
      }

      var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            ticks: {
              fontColor: '#efefef'
            },
            gridLines: {
              display: false,
              color: '#efefef',
              drawBorder: false
            }
          }],
          yAxes: [{
            ticks: {
              stepSize: 5000,
              fontColor: '#efefef'
            },
            gridLines: {
              display: true,
              color: '#efefef',
              drawBorder: false
            }
          }]
        }
      }

      // This will get the first returned node in the jQuery collection.
      // eslint-disable-next-line no-unused-vars
      var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
      })
    }

    function showGraphicDataCultos(dia, cantidad){
      // Sales graph chart
      var salesGraphChartCanvas = $('#line-chart-cultos').get(0).getContext('2d')
      // $('#revenue-chart').get(0).getContext('2d');

      var salesGraphChartData = {
        labels: dia.reverse(),
        datasets: [
          {
            label: 'Total de asistencias',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#efefef',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#efefef',
            pointBackgroundColor: '#efefef',
            data: cantidad.reverse()
          }
        ]
      }

      var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            ticks: {
              fontColor: '#efefef'
            },
            gridLines: {
              display: false,
              color: '#efefef',
              drawBorder: false
            }
          }],
          yAxes: [{
            ticks: {
              stepSize: 5000,
              fontColor: '#efefef'
            },
            gridLines: {
              display: true,
              color: '#efefef',
              drawBorder: false
            }
          }]
        }
      }

      // This will get the first returned node in the jQuery collection.
      // eslint-disable-next-line no-unused-vars
      var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
      })
    }

    function showGraphicNetworksData(data){

      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }

      var $salesChart = $('#sales-chart')
      // eslint-disable-next-line no-unused-vars
      var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
          labels: ['RED ADONAI', 'RED YESHUA', 'RED EMANUEL', 'RED SHADAI'],
          datasets: [
            {
              backgroundColor: '#218838',
              borderColor: '#218838',
              data: [data.asistencias[0].asistencia_adonai, data.asistencias[0].asistencia_yeshua, data.asistencias[0].asistencia_emanuel, data.asistencias[0].asistencia_shadai]
            },          
            {
              backgroundColor: '#C82333',
              borderColor: '#C82333',
              data: [data.asistencias[0].ausencia_adonai-data.permisos[0].permisos_adonai, data.asistencias[0].ausencia_yeshua-data.permisos[0].permisos_yeshua, data.asistencias[0].ausencia_emanuel-data.permisos[0].permisos_emanuel, data.asistencias[0].ausencia_shadai-data.permisos[0].permisos_shadai]
            },          
            {
              backgroundColor: '#6C757D',
              borderColor: '#6C757D',
              data: [data.permisos[0].permisos_adonai, data.permisos[0].permisos_yeshua, data.permisos[0].permisos_emanuel, data.permisos[0].permisos_shadai]
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: 'index',
            intersect: true
          },
          hover: {
            mode: 'index',
            intersect: true
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                  if (value >= 1000) {
                    value /= 1000
                    value += 'k'
                  }

                  // return '$' + value
                  return value
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    }

    function showNetworkMembers(data){

      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }

      var $salesChart = $('#sales-chart-red')
      // eslint-disable-next-line no-unused-vars
      var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
          labels: ['CANTIDAD DE MIEMBROS POR REDES'],
          datasets: [
            {
              backgroundColor: '#22a0bd',
              borderColor: '#22a0bd',
              data: [data.miembros[0].emanuel]
            },
            {
              backgroundColor: '#7e3791',
              borderColor: '#7e3791',
              data: [data.miembros[0].yeshua]
            },
            {
              backgroundColor: '#a61b1b',
              borderColor: '#a61b1b',
              data: [data.miembros[0].adonai]
            },
            {
              backgroundColor: '#1f24ad',
              borderColor: '#1f24ad',
              data: [data.miembros[0].shadai]
            },
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: 'index',
            intersect: true
          },
          hover: {
            mode: 'index',
            intersect: true
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                  if (value >= 1000) {
                    value /= 1000
                    value += 'k'
                  }

                  // return '$' + value
                  return value
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    }

</script>
<script> 
  var dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

  function convertir(inputDia) {
    // var inputDia = document.getElementById('mes');
    // var numeroMes = parseInt(inputDia.value);
    if(! isNaN(inputDia) && inputDia >= 0  && inputDia <= 7 ) {
        return dias[inputDia];
    }
  }
</script>
@endrole
@endsection