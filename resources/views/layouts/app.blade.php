<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - Ministerio Internacional Avivamiento y Fuego</title>
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="{{asset('css/app.css')}}" rel="stylesheet"> Añadimos el css generado con webpack -->
  @yield('css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" type="image/png" href="{{ asset('/dist/img/logo-miaf.jpg') }}">
  <link rel="shortcut icon" sizes="192x192" href="{{ asset('/dist/img/logo-miaf.jpg') }}">
</head>
<!-- <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"> -->
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper" id="app">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{ asset('dist/img/logo-miaf.jpg') }}" alt="MIAF" height="60" width="60" style="border-radius: 20px;">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Link del navbar derecho -->
    <ul class="navbar-nav ml-auto">
      <!-- Pantalla completa -->      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- Menú de opciones -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{ asset('dist/img/logo-miaf.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">M I A F</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/logo-miaf.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->tabcon->NomCon }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                PANEL DE CONTROL
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('panel') }}" class="nav-link">
                  <i class="fas fa-chart-line nav-icon"></i>
                  <p>Noticias/Ayuda</p>
                </a>
              </li>
              @role('administrador')
              <li class="nav-item">
                <a href="{{ route('panel.admin') }}" class="nav-link">
                  <i class="fas fa-chart-line nav-icon"></i>
                  <p>Administración</p>
                </a>
              </li>
              @endrole
              @role('liderred')
              <li class="nav-item">
                <a href="{{ route('panel.liderred') }}" class="nav-link">
                  <i class="fas fa-chart-line nav-icon"></i>
                  <p>Líder de red</p>
                </a>
              </li>
              @endrole
              @role('lidercdp')
              <li class="nav-item">
                <a href="{{ route('panel.lidercdp') }}" class="nav-link">
                  <i class="fas fa-chart-line nav-icon"></i>
                  <p>Líder CP</p>
                </a>
              </li>
              @endrole
              @role('mentor')
              <li class="nav-item">
                <a href="{{ route('panel.mentor') }}" class="nav-link">
                  <i class="fas fa-chart-line nav-icon"></i>
                  <p>Mentor</p>
                </a>
              </li>
              @endrole
              @role('tesoreria')
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-chart-line nav-icon"></i>
                  <p>Tesorería</p>
                </a>
              </li>
              @endrole
            </ul>
          </li>
          @role('liderred')
          <li class="nav-header">LIDER DE RED</li>          
          <li class="nav-item" id="menumembresiaopen">
            <a href="#" class="nav-link" id="menumembresiaactive">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                MEMBRESÍA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('liderred.membership.getMembers') }}" class="nav-link" id="membresia">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Miembros de mi red</p>
                </a>
              </li>
            </ul>
          </li>    
          <li class="nav-item" id="menumiembroscpopen">
            <a href="#" class="nav-link" id="menumiembroscpactive">
              <i class="nav-icon fas fa-home"></i>
              <p>
                CASAS DE PAZ
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('liderred.getcdp') }}" class="nav-link" id="cps">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Ver casas de paz</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="{{ route('liderred.getreports') }}" class="nav-link" id="reports">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Informes Recibidos</p>
                </a>
              </li>              
            </ul>
          </li>
          <li class="nav-item" id="menugestioncpopen">
            <a href="#" class="nav-link" id="menugestioncpactive">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                GESTIÓN
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('liderred.permisos') }}" class="nav-link" id="permisoslr">
                  <i class="fas fa-hand-paper nav-icon"></i>
                  <p>Permisos de mi red</p>
                </a>
              </li>              
            </ul>
          </li>
          <!-- <li class="nav-item" id="menuusuariosopen">
            <a href="#" class="nav-link" id="menuusuariosactive">              
              <i class="nav-icon fas fa-users"></i>
              <p>
                USUARIOS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('liderred.usuarios.getusers') }}" class="nav-link" id="usuarios">
                  <i class="fas fa-user-cog nav-icon"></i>
                  <p>Usuarios líderes CP</p>
                </a>
              </li>   
            </ul>
          </li> -->
          @endrole    
          @role('lidercdp')
          <li class="nav-header">LIDER DE CASA DE PAZ</li>          
          <li class="nav-item" id="menucdpopen">
            <a href="#" class="nav-link" id="menucdpactive">
              <!-- <i class="nav-icon fas fa-table"></i> -->
              <i class="nav-icon fas fa-home"></i>
              <p>
                CASAS DE PAZ
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('lidercdp.getcdp') }}" class="nav-link" id="showcdp">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Ver casas de paz</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('lidercdp.getcdptoreport') }}" class="nav-link" id="showcdp">
                <i class="fas fa-pen nav-icon"></i>
                  <p>Informes semanales</p>
                </a>
              </li>
            </ul>
          </li>
          @endrole
          @role('administrador')
          <li class="nav-header">ADMINISTRADOR</li>          
          <li class="nav-item" id="adminmemberopen">
            @if(auth()->user()->hasAnyPermission(['ver miembros', 'registro asistencia', 'miembros nuevos']))
            <a href="#" class="nav-link" id="adminmemberactive">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                MEMBRESÍA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @endif
            @if(auth()->user()->can('ver miembros'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.membership.getMembers') }}" class="nav-link" id="adminmembresia">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Ver miembros</p>
                </a>
              </li>
            </ul>
            @endif
            @if(auth()->user()->can('registro asistencia'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.membership.register_assistance') }}" class="nav-link" id="adminmembresia">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Registro de Asistencia</p>
                </a>
              </li>
            </ul>
            @endif
            @if(auth()->user()->can('miembros nuevos'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.membership.new_members') }}" class="nav-link" id="adminmembresia">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Miembros nuevos</p>
                </a>
              </li>
            </ul>
            @endif
          </li>    
          <li class="nav-item" id="menuasistenciaopen">
            @if(auth()->user()->hasAnyPermission(['reportar asistencias', 'permisos', 'reportes']))
            <a href="#" class="nav-link" id="adminasistenciaactive">
              <i class="nav-icon fas fa-pray"></i>
              <p>
                ASISTENCIAS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @endif
            @if(auth()->user()->can('reportar asistencias'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.asistencia.index') }}" class="nav-link" id="assistance">
                  <i class="fas fa-pen nav-icon"></i>
                  <p>Reportar asistencias</p>
                </a>
              </li>
            </ul>
            @endif
            @if(auth()->user()->can('permisos'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.permissions.index') }}" class="nav-link" id="assistance">
                  <i class="fas fa-hand-paper nav-icon"></i>
                  <p>Permisos</p>
                </a>
              </li>
            </ul>
            @endif
            @if(auth()->user()->can('reportes'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link" id="assistance">
                  <i class="fas fa-file-pdf nav-icon"></i>
                  <p>Reportes</p>
                </a>
              </li>
            </ul>
            @endif
          </li>
          <li class="nav-item" id="adminusuarioopen">
            @if(auth()->user()->hasAnyPermission(['usuarios mentores']))
            <a href="#" class="nav-link" id="adminusuarioactive">
              <i class="nav-icon fas fa-users"></i>
              <p>
                USUARIOS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @endif
            @if(auth()->user()->can('usuarios mentores'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.usuarios.getusers') }}" class="nav-link" id="adminmentoruser">
                  <i class="fas fa-user-cog nav-icon"></i>
                  <p>Usuarios mentores</p>
                </a>
              </li>
            </ul>
            @endif
          </li>
          <li class="nav-item" id="admindiscipuladoopen">
            @if(auth()->user()->hasAnyPermission(['reunion de discipulados', 'administrar discipulados']))
            <a href="#" class="nav-link" id="admindiscipuladoactive">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                DISCIPULADOS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @endif
            @if(auth()->user()->can('reunion de discipulados'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.discipulado.index') }}" class="nav-link" id="admindiscipulado">
                  <i class="fas fa-users-cog nav-icon"></i>
                  <p>Reunión de discipulados</p>
                </a>
              </li>
            </ul>
            @endif
            @if(auth()->user()->can('administrar discipulados'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.discipulado.manage') }}" class="nav-link" id="admindiscipuladomanage">
                  <i class="fas fa-cog nav-icon"></i>
                  <p>Administrar discipulados</p>
                </a>
              </li>
            </ul>
            @endif
          </li>
          <li class="nav-item">
            @if(auth()->user()->hasAnyPermission(['administrar roles']))
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>
                ROLES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @endif
            @if(auth()->user()->can('administrar roles'))
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.roles.index') }}" class="nav-link">
                  <i class="fas fa-user-tie nav-icon"></i>
                  <p>Administrar Roles</p>
                </a>
              </li>
            </ul>
            @endif
          </li>  
          @endrole    
          @role('mentor')
          <li class="nav-header">MENTOR</li>          
          <li class="nav-item" id="mentordiscipulosopen">
            <a href="#" class="nav-link" id="mentordiscipulosactive">
              <!-- <i class="nav-icon fas fa-table"></i> -->
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                DISCÍPULOS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('mentor.discipulos.getDisciples') }}" class="nav-link" id="mentorshowdisciples">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>Ver discípulos</p>
                </a>
              </li>
            </ul>
          </li>    
          <li class="nav-item" id="menuasistenciaopen">
            <a href="#" class="nav-link" id="menuasistenciaactive">
              <i class="nav-icon fas fa-pray"></i>
              <p>
                ORACIÓN
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('mentor.report.show_assistance') }}" class="nav-link" id="assistance">
                  <i class="fas fa-pen nav-icon"></i>
                  <p>Reportar oraciones</p>
                </a>
              </li>
            </ul>
          </li>              
          <li class="nav-item" id="menudiscipuladoopen">
            <a href="#" class="nav-link" id="menudiscipuladoactive">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                DISCIPULADOS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('mentor.discipulado.index') }}" class="nav-link" id="discipulado">
                  <i class="fas fa-pen nav-icon"></i>
                  <p>Reportar discipulado</p>
                </a>
              </li>              
            </ul>
          </li>              
          @endrole    
          @role('tesorero')
          <li class="nav-header">TESORERÍA</li>          
          <li class="nav-item" id="tesoreroactivitiesopen">
            <a href="#" class="nav-link" id="tesoreroactivitiesactive">
              <!-- <i class="nav-icon fas fa-table"></i> -->
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                GESTIÓN
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('finance.activity.getActivities') }}" class="nav-link" id="tesoreroactivities">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>ACTIVIDADES</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('finance.activitymanage.getActivityManage') }}" class="nav-link" id="tesoreromanage">
                  <i class="fas fa-eye nav-icon"></i>
                  <p>ADMINISTRAR</p>
                </a>
              </li>
            </ul>
          </li>    
          <!-- <li class="nav-item" id="menuasistenciaopen">
            <a href="#" class="nav-link" id="menuasistenciaactive">
              <i class="nav-icon fas fa-pray"></i>
              <p>
                ORACIÓN
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('mentor.report.show_assistance') }}" class="nav-link" id="assistance">
                  <i class="fas fa-pen nav-icon"></i>
                  <p>Reportar oraciones</p>
                </a>
              </li>
            </ul>
          </li>               -->
          @endrole    
          <li class="nav-item">
            <a href="{{ route('global.usuarios.edit') }}" class="nav-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                CAMBIAR CONTRASEÑA
              </p>
            </a>            
          </li>
          <!-- <li class="nav-header">LABELS</li> -->
          <div>
            <li class="nav-item">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                <button type="button" class="btn btn-block bg-gradient-danger btn-lg">Cerrar Sesión</button>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </li>          
          </div>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('contenido')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2021<a href="https://iglesiaprimitivaperu.org" target="_blank">Iglesia Primitiva</a>.</strong>
    Todos los derechos reservados.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer> -->
</div>
<!-- ./wrapper -->
<!-- <script src="{{asset('js/app.js')}}"></script> Añadimos el js generado con webpack, donde se encuentra nuestro componente vuejs -->
@yield('js')
</body>
</html>
