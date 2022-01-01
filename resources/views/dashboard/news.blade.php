@extends('layouts.app')
@section('title', 'Noticias')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
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
            <h1>Noticias</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('panel')}}">Noticias</a></li>
              <li class="breadcrumb-item active">Noticias</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
      @role('mentor')
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Noticias</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    </div>
                    <div class="card-body">
                        <blockquote>
                        <p><b>IMPORTANTE!!</b></p>
                        <small>* Mira el vídeo!! Es un ejemplo de <cite title="Source Title">registro de los informes de reuniones de discipulado</cite></small><br>
                        <!-- <small>* Todos los discípulos tienen falta en la oración, por lo tanto solo registra a los que asistieron.</small> -->
                        </blockquote>                        
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                    Noticias del sistema
                    </div>
                    <!-- /.card-footer-->
                </div>
            </div>
            <div class="col-md-6">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" width="560" height="370" src="https://www.youtube.com/embed/Hoor9QnMTmU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
      @endrole
      @role('administrador')
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">        
              <h1>Ayuda - Administrador</h1>
            </div><!-- /.col -->            
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>      
      <div class="row">
        <div class="col-12" id="accordion">
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseOneAdmin">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          1. ¿Cómo ver los miembros activos?
                      </h4>
                  </div>
              </a>
              <div id="collapseOneAdmin" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      Dirigírse al menú "MEMBRESÍA" <i class="fas fa-arrow-right"></i> Ver miembros.
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseTwoAdmin">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          2. ¿Cómo crear el registro diario?
                      </h4>
                  </div>
              </a>
              <div id="collapseTwoAdmin" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "ORACIÓN" <i class="fas fa-arrow-right"></i> Reportar oraciones.<br>
                      2. Luego seleccionar la fecha de hoy en el calendario <i class="fas fa-arrow-right"></i>, Dar click en "realizar registro".<br>
                      3. Observarás los detalles de la actividad <i class="fas fa-arrow-right"></i>, Clickear en "Llenar lista de oración".<br>
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseThreeAdmin">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          3. ¿Cómo registrar las oraciones?
                      </h4>
                  </div>
              </a>
              <div id="collapseThreeAdmin" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "ORACIÓN" <i class="fas fa-arrow-right"></i> Reportar oraciones.<br>
                      2. Luego seleccionar la fecha de hoy en el calendario.<br>
                      3. Seleccionar la actividad en la lista desplegable <i class="fas fa-arrow-right"></i>, Dar click en "Ir a asistencia anterior".<br>
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseFourAdmin">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          4. ¿Cómo agregar un usuario del rol mentor?
                      </h4>
                  </div>
              </a>
              <div id="collapseFourAdmin" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "USUARIOS" <i class="fas fa-arrow-right"></i> Usuarios mentores.<br>
                      2. Luego dar click en "Añadir nuevo usuario".<br>
                      3. Seleccionar el mentor en la lista deplegable y llena todos los datos necesarios.<br>
                      4. Dar click en "Crear usuario".<br>
                  </div>
              </div>
          </div>
          <!-- <div class="card card-warning card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          4. Donec pede justo
                      </h4>
                  </div>
              </a>
              <div id="collapseFour" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                  </div>
              </div>
          </div>
          <div class="card card-danger card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseSeven">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          7. Aenean leo ligula
                      </h4>
                  </div>
              </a>
              <div id="collapseSeven" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.
                  </div>
              </div>
          </div> -->
        </div>
      </div>  
      @endrole        
      @role('lidercdp')
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">        
              <h1>Ayuda - Líder de casa de paz</h1>
            </div><!-- /.col -->            
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>      
      <div class="row">
        <div class="col-12" id="accordion">
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseOneLidercp">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          1. ¿Cómo ver el detalle de mis miembros de casa de paz?
                      </h4>
                  </div>
              </a>
              <div id="collapseOneLidercp" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "CASAS DE PAZ" <i class="fas fa-arrow-right"></i> Ver casas de paz.<br>
                      2. Seleccione su casa de paz <i class="fas fa-arrow-right"></i> Ver miembros.<br>
                      3. Dar click en el botón <button class="btn btn-success btn-sm"><i class="fas fa-eye fa-sm"></i></button> para ver detalles.
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseTwoLidercp">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          2. ¿Cómo reportar a un miembro para dar de baja?
                      </h4>
                  </div>
              </a>
              <div id="collapseTwoLidercp" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "CASAS DE PAZ" <i class="fas fa-arrow-right"></i> Ver casas de paz.<br>
                      2. Seleccione su casa de paz <i class="fas fa-arrow-right"></i> Ver miembros.<br>
                      3. Dar click en el botón <button class="btn btn-warning btn-sm"><i class="fas fa-pen-nib fa-sm"></i></button> , luego dar una descripción detallada.<br>
                      4. Presionar el botón "REPORTAR".
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseThreeLidercp">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          3. ¿Cómo registrar las oraciones de mis miembros de casa de paz?
                      </h4>
                  </div>
              </a>
              <div id="collapseThreeLidercp" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "ORACIÓN" <i class="fas fa-arrow-right"></i> Reportar oraciones.<br>
                      2. Luego seleccione su casa de paz.<br>
                      3. En la tabla de actividades presionar el botón "Registrar" <i class="fas fa-arrow-right"></i> registra la oración de sus miembros<br>
                      4. Busca un miembro y dar click en <button class="btn btn-success btn-sm"><i class="far fa-check-circle"></i></button> , para registrar su oración.<br>
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseFourLidercp">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          4. ¿Cómo quitar el registro de oración de un miembro de casa de paz?
                      </h4>
                  </div>
              </a>
              <div id="collapseFourLidercp" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "ORACIÓN" <i class="fas fa-arrow-right"></i> reportar oraciones.<br>
                      2. Luego seleccione su casa de paz.<br>
                      3. Busca un miembro y dar click en <button class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i></button> , para quitar su oración.<br>
                  </div>
              </div>
          </div>          
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseFiveLidercp">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          5. ¿Qué pasa si no me aparece el botón "registrar" en las oraciones?
                      </h4>
                  </div>
              </a>
              <div id="collapseFiveLidercp" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Inténtelo de nuevo más tarde, ya que el registro aún no ha sido creado.<br>                      
                  </div>
              </div>
          </div>

          <!-- <div class="card card-warning card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          4. Donec pede justo
                      </h4>
                  </div>
              </a>
              <div id="collapseFour" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                  </div>
              </div>
          </div>
          <div class="card card-danger card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseSeven">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          7. Aenean leo ligula
                      </h4>
                  </div>
              </a>
              <div id="collapseSeven" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.
                  </div>
              </div>
          </div> -->
        </div>
      </div>  
      @endrole        
      @role('liderred')
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">        
              <h1>Ayuda - Líder de red</h1>
            </div><!-- /.col -->            
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>      
      <div class="row">
        <div class="col-12" id="accordion">
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseOneLiderred">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          1. ¿Cómo ver el detalle de mis miembros de mi red?
                      </h4>
                  </div>
              </a>
              <div id="collapseOneLiderred" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "MEMBRESÍA" <i class="fas fa-arrow-right"></i> Miembros de mi red.<br>
                      2. Dar click en el botón <button class="btn btn-success btn-sm"><i class="fas fa-eye fa-sm"></i></button> para ver detalles.
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseTwoLiderred">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          2. ¿Cómo ver los miembros de las casas de paz de mi red?
                      </h4>
                  </div>
              </a>
              <div id="collapseTwoLiderred" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "CASAS DE PAZ" <i class="fas fa-arrow-right"></i> Ver casas de paz.<br>
                      2. Dar click en el botón <button class="btn btn-success btn-sm"><i class="fas fa-eye fa-sm"></i></button> , para ver los miembros de esa casa de paz.<br>                      
                      3. Dar click en el botón <button class="btn btn-success btn-sm"><i class="fas fa-eye fa-sm"></i></button> , para ver el detalle de cada miembro.<br>                      
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseThreeLiderred">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          3. ¿Cómo registrar un usuario de un líder de casa de paz?
                      </h4>
                  </div>
              </a>
              <div id="collapseThreeLiderred" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "USUARIOS" <i class="fas fa-arrow-right"></i> Usuarios líderes CP.<br>
                      2. Dar clíck en "Añadir nuevo usuario".<br>
                      3. Seleccionar el líder en la lista deplegable y llena todos los datos necesarios.<br>
                      4. Dar click en "Crear usuario".<br>
                  </div>
              </div>
          </div>          
        </div>
      </div>  
      @endrole        
      @role('mentor')
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">        
              <h1>Ayuda - Mentor</h1>
            </div><!-- /.col -->            
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>      
      <div class="row">
        <div class="col-12" id="accordion">
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseOneMentor">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          1. ¿Cómo ver el detalle de mis discípulos?
                      </h4>
                  </div>
              </a>
              <div id="collapseOneMentor" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "DISCÍPULOS" <i class="fas fa-arrow-right"></i> ver discípulos.<br>
                      2. Dar click en el botón <button class="btn btn-success btn-sm"><i class="fas fa-eye fa-sm"></i></button> para ver detalles.
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseTwoMentor">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          2. ¿Cómo registrar la oración de mis discípulos?
                      </h4>
                  </div>
              </a>
              <div id="collapseTwoMentor" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "ORACIÓN" <i class="fas fa-arrow-right"></i> reportar oraciones.<br>
                      2. Busca en miembro y dar click en <button class="btn btn-success btn-sm"><i class="far fa-check-circle"></i></button> , para registrar su oración.<br>                      
                      <!-- <button class="btn btn-danger btn-sm" onclick="deleteAssistanceMember('04033291','160620211108',1)"><i class="fas fa-minus-circle"></i></button> -->
                  </div>
              </div>
          </div>
          <div class="card card-primary card-outline">
              <a class="d-block w-100" data-toggle="collapse" href="#collapseThreeMentor">
                  <div class="card-header">
                      <h4 class="card-title w-100">
                          3. ¿Cómo quitar el registro de oración de un díscipulo?
                      </h4>
                  </div>
              </a>
              <div id="collapseThreeMentor" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                      1. Dirigírse al menú "ORACIÓN" <i class="fas fa-arrow-right"></i> reportar oraciones.<br>
                      2. Busca un discípulo y dar click en <button class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i></button> , para quitar su oración.<br>
                  </div>
              </div>
          </div>          
        </div>
      </div>  
      @endrole        
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
  });
</script>
@endsection