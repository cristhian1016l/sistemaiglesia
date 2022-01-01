@extends('layouts.app')
@section('title', 'Administración de roles')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">  
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
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
            <h1 class="m-0">Roles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Administración de roles</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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
        <!-- <div class="row mb-2">
            <div class="col-md-3">
                <a href="{{ route('admin.usuarios.form') }}">
                    <button  type="button" class="btn btn-block btn-primary">Añadir nuevo usuario</button>
                </a>
            </div>
        </div> -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Usuarios mentores</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Email</th>
                      <th>Nombres</th>
                      <th>¿Activo?</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <tr>                      
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->ApeCon.' '.$user->NomCon }}</td>
                      @if($user->active == 1)
                        <td>
                            <a href="{{ route('admin.roles.desactivate', $user->id) }}">
                                <button class="btn btn-danger">
                                    Desactivar
                                    <i class="fas fa-user-minus"></i>
                                </button>                        
                            </a> 
                            <a>
                                <button class="btn btn-info" onclick="getPermissions(<?php echo $user->id; ?>)" data-toggle="modal" data-target="#modal-default">
                                    Ver permisos
                                    <i class="fas fa-edit"></i>
                                </button>                        
                            </a>
                        </td>
                      @else
                        <td>
                            <a href="{{ route('admin.roles.activate', $user->id) }}">
                                <button class="btn btn-success">
                                    Activar
                                    <i class="fas fa-user-minus"></i>
                                </button>                        
                            </a>
                            <a>
                                <button class="btn btn-info" onclick="getPermissions(<?php echo $user->id; ?>)" data-toggle="modal" data-target="#modal-default">
                                    Ver permisos
                                    <i class="fas fa-edit"></i>
                                </button>                        
                            </a>
                        </td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <form id="formUpdate" method="POST" action="{{ route('admin.roles.updatePermissions') }}">
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">DETALLES</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Permisos asignados</h3>
                            </div>
                            <div class="card-body">
                                <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                                <div id="accordion">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                                MEMBRESÍA
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="vermiembros">
                                                        <label class="form-check-label">Ver Miembros</label>
                                                    </div>                            
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="registroasistencia">
                                                        <label class="form-check-label">Registro de Asistencia</label>
                                                    </div>                            
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="miembrosnuevos">
                                                        <label class="form-check-label">Miembros nuevos</label>
                                                    </div>                            
                                                    <input type="text" name="id_hash" id="user_id_hash" disabled hidden>
                                                    <input type="text" name="id" id="user_id" disabled hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                                ASISTENCIA
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="collapse show" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="reportarasistencias">
                                                        <label class="form-check-label">Reportar Asistencias</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="permisos">
                                                        <label class="form-check-label">Permisos</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="reportes">
                                                        <label class="form-check-label">Reportes</label>
                                                    </div>                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                                USUARIOS
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="collapse show" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="usuariosmentores">
                                                        <label class="form-check-label">Usuarios Mentores</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
                                                DISCIPULADOS
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseFour" class="collapse show" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="reuniondiscipulados">
                                                        <label class="form-check-label">Reunión de Discipulados</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="administrardiscipulados">
                                                        <label class="form-check-label">Administrar Discipulados</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseFive">
                                                ROLES
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseFive" class="collapse show" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="administrarroles">
                                                        <label class="form-check-label">Administrar Roles</label>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="close">CERRAR</button>
                        <button id="btnUpdate" type="submit" class="btn btn-sm btn-info float-left">GUARDAR CAMBIOS</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
    </form>
    
@endsection

@section('js')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
$(function(){
  var url = window.location;
  
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

function getPermissions(user_id){
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:'/administracion/roles/obtener-permisos',
        data:{
            "_token": "{{ csrf_token() }}",
            "user_id": user_id
        },
        success:function(data) {   
            document.getElementById('vermiembros').checked = false;
            document.getElementById('registroasistencia').checked = false;
            document.getElementById('miembrosnuevos').checked = false;
            document.getElementById('reportarasistencias').checked = false;
            document.getElementById('permisos').checked = false;
            document.getElementById('reportes').checked = false;
            document.getElementById('usuariosmentores').checked = false;
            document.getElementById('reuniondiscipulados').checked = false;
            document.getElementById('administrardiscipulados').checked = false;
            document.getElementById('administrarroles').checked = false;
            document.getElementById('registroasistencia').checked = false;
            $.each(data.permissions, function(idx, opt) {
                if(opt.name == "ver miembros"){
                    document.getElementById('vermiembros').checked = true;
                }
                if(opt.name == "registro asistencia"){
                    document.getElementById('registroasistencia').checked = true;
                }
                if(opt.name == "miembros nuevos"){
                    document.getElementById('miembrosnuevos').checked = true;
                }
                if(opt.name == "reportar asistencias"){
                    document.getElementById('reportarasistencias').checked = true;
                }                
                if(opt.name == "permisos"){
                    document.getElementById('permisos').checked = true;
                }                
                if(opt.name == "reportes"){
                    document.getElementById('reportes').checked = true;
                }                
                if(opt.name == "usuarios mentores"){
                    document.getElementById('usuariosmentores').checked = true;
                }                
                if(opt.name == "reunion de discipulados"){
                    document.getElementById('reuniondiscipulados').checked = true;
                }                
                if(opt.name == "administrar discipulados"){
                    document.getElementById('administrardiscipulados').checked = true;
                }                
                if(opt.name == "administrar roles"){
                    document.getElementById('administrarroles').checked = true;
                }                             
            });
            document.getElementById('user_id_hash').value = data.user_id_hash;
            document.getElementById('user_id').value = data.user_id;
        }
    });
}

    $("#btnUpdate").click(function(e){
        e.preventDefault();
        var form = $('#formUpdate').attr('action');
        let vermiembros = $("#vermiembros").is(":checked")
        let registroasistencia = $("#registroasistencia").is(":checked")
        let miembrosnuevos = $("#miembrosnuevos").is(":checked")
        let reportarasistencias = $("#reportarasistencias").is(":checked")
        let permisos = $("#permisos").is(":checked")
        let reportes = $("#reportes").is(":checked")
        let usuariosmentores = $("#usuariosmentores").is(":checked")
        let reuniondiscipulados = $("#reuniondiscipulados").is(":checked")
        let administrardiscipulados = $("#administrardiscipulados").is(":checked")
        let administrarroles = $("#administrarroles").is(":checked");
        let user_id = document.getElementById("user_id").value;
        let user_id_hash = document.getElementById("user_id_hash").value;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url: form,
            data:{
                "_token": "{{ csrf_token() }}",
                "vermiembros": vermiembros,
                "registroasistencia": registroasistencia,
                "miembrosnuevos": miembrosnuevos,
                "reportarasistencias": reportarasistencias,
                "permisos": permisos,
                "reportes": reportes,
                "usuariosmentores": usuariosmentores,
                "reuniondiscipulados": reuniondiscipulados,
                "administrardiscipulados": administrardiscipulados,
                "administrarroles": administrarroles,
                "user_id": user_id,
                "user_id_hash": user_id_hash
            },
            success:function(data) {                           
                val = data.code;
                if(val === "500"){
                    toastr.error(data.msg)
                }else{
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.success(data.msg);
                    document.getElementById('close').click();
                }
            }
        });
    })
</script>
@endsection