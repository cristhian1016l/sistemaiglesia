@extends('layouts.app')
@section('title', 'Detalles de miembro')
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detalles de miembro</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.membership.getMembers') }}">Membresía</a></li>
                <li class="breadcrumb-item active">Detalles de miembro</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('dist/img/logo.png') }}"
                                alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $member->ApeCon }}</h3>

                            <p class="text-muted text-center">{{ $member->NomCon }}</p>

                            <!-- <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                            </li>
                            </ul> 
                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detalles</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- <strong><i class="fas fa-book mr-1"></i> Education</strong>

                            <p class="text-muted">
                            B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>

                            <hr> -->

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Dirección</strong>

                            <p class="text-muted">
                                <?php
                                    if($member->DirCon){
                                        echo $member->DirCon;
                                    }else{
                                        echo "No existe en nuestros registros";
                                    }                                
                                ?>

                            </p>

                            <hr>

                            <!-- <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                            <p class="text-muted">
                            <span class="tag tag-danger">UI Design</span>
                            <span class="tag tag-success">Coding</span>
                            <span class="tag tag-info">Javascript</span>
                            <span class="tag tag-warning">PHP</span>
                            <span class="tag tag-primary">Node.js</span>
                            </p>

                            <hr> -->

                            <strong><i class="fas fa-birthday-cake mr-1"></i> Fecha de Nacimiento</strong>

                            <p class="text-muted">
                                <?php
                                if($member->FecNacCon){
                                    echo \Carbon\Carbon::parse($member->FecNacCon)->format('Y-m-d');
                                }else{
                                    echo "No existe en nuestros registros";
                                }                                
                                ?>
                            </p>
                            <hr>                            
                            <strong><i class="fas fa-birthday-cake mr-1"></i> Celular</strong>

                            <p class="text-muted">
                                <?php
                                if($member->NumCel){
                                    echo $member->NumCel;
                                }else{
                                    echo "No existe en nuestros registros";
                                }                                
                                ?>
                            </p>
                            <hr>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">CONVERSIÓN</a></li>
                                <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">GRUPOS</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li> -->
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane" id="activity">                                
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">GRUPOS A LOS QUE PERTENECE</h3>
                                        </div>
                                        <!-- /.card-header -->  
                                        <div class="card-body">
                                            <table class="table table-bordered" id="groupsTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 550px">DESCRIPCIÓN</th>
                                                    <th>OPCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>       
                                            @foreach($groups as $group)
                                                <tr>
                                                    <td>{{ $group->DesArea }}</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm" onclick="getData('<?php echo $member->CodCon ?>','<?php echo $group->CodArea ?>', '<?php echo $group->DesArea ?>')" data-toggle="modal" data-target="#modal-default" title="Quitar del grupo">
                                                            <i class="fas fa-user-minus"></i>   
                                                        </button>         
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="active tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    <div class="time-label">
                                        <span class="bg-danger">
                                        {{ \Carbon\Carbon::parse($member->FecReg)->format('Y-m-d') }}
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->                                    
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-play-circle bg-info"></i>

                                        <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i>{{ \Carbon\Carbon::parse($member->FecReg)->diffForHumans() }}</span>

                                        <h3 class="timeline-header border-0"><a href="#">{{ $member->NomCon }}</a> fue ganado en {{ $member->FuenConv }} 
                                        </h3>
                                        </div>
                                    </div>
                                    @if(isset($member->RefCon))
                                    <div>
                                        <i class="fas fa-user-friends bg-info"></i>

                                        <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i>{{ \Carbon\Carbon::parse($member->FecReg)->diffForHumans() }}</span>

                                        <h3 class="timeline-header border-0"><a href="#">{{ $member->NomCon }}</a> fue traido por <a href="">{{ $member->RefCon }}</a> 
                                        </h3>
                                        </div>
                                    </div>
                                    @endif                                                                        
                                    <div class="time-label">
                                        <span class="bg-warning">
                                        {{ \Carbon\Carbon::parse($member->FecReg)->format('Y-m-d') }}
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->                                    
                                    <!-- timeline item -->                                    
                                    <div>
                                        <i class="fas fa-cross bg-info"></i>

                                        <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i>{{ \Carbon\Carbon::parse($member->FecReg)->diffForHumans() }}</span>

                                        <h3 class="timeline-header border-0"><a href="#">{{ $member->NomCon }}</a> Aceptó a Cristo o se reconcilió
                                        </h3>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->                                    
                                    <!-- timeline time label -->
                                    @if(isset($member->FecBau))
                                        <div class="time-label">
                                            <span class="bg-success">
                                                {{ \Carbon\Carbon::parse($member->FecBau)->format('Y-m-d') }}
                                            </span>
                                        </div>
                                        <div>
                                            <i class="fas fa-water bg-purple"></i>

                                            <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i>{{ \Carbon\Carbon::parse($member->FecBau)->diffForHumans() }}</span>

                                            <h3 class="timeline-header"><a href="#">{{ $member->NomCon }}</a> realizó su bautizo en {{ $member->LugBau }} y fue realizado por el(la) {{ $member->MinBau }}</h3>

                                            <!-- <div class="timeline-body">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                            </div> -->
                                            </div>
                                        </div>
                                    <!-- END timeline item -->
                                    @endif
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->                                    
                                    <div>
                                        <i class="far fa-clock bg-gray"></i>
                                    </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <form id="formDelete" method="POST" action="{{ route('admin.membership.removeFromGroup') }}">
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">¿Estás seguro que deseas eliminar a este miembro del grupo<p id="groupName"></p></h4>              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">              
                <div class="form-group">
                  <input type="hidden" name="_token" value="{{ csrf_token()}}" id="{{ 'token' }}">
                  <input type="hidden" class="form-control" id="codcon">
                  <input type="hidden" class="form-control" id="codarea">
                </div>                                
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="close">CERRAR</button>
              <button id="btnDelete" type="submit" class="btn btn-sm btn-info float-left">ESTOY SEGURO</button>
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

<script>
    $(function(){
        document.getElementById("adminmemberopen").className += ' menu-open';    
        document.getElementById("adminmemberactive").className += " active";    
        document.getElementById("adminmembresia").className += " active";    
    });
</script>
<script>
    function showGroups(groups, codcon){
        $("#groupsTable").slideDown("slow", function() {                                
            table = $("#groupsTable tbody");
            table.empty();
            $.each(groups, function(idx, elem){
                var options;
                
                options = "<td>"+
                                elem.DesArea+
                            "</td>"+
                            "<td>"+
                                '<button class="btn btn-danger btn-sm" onclick="getData('+"'" + codcon + "'"+','+"'"+ elem.CodArea + "'"+','+"'"+ elem.DesArea + "'"+')" data-toggle="modal" data-target="#modal-default" title="Quitar del grupo"><i class="fas fa-user-minus"></i></button>'+
                            "</td>";
                table.append(
                    "<tr>"+
                        options+
                    "</tr>"
                );
            });
        });
    }


    $("#btnDelete").click(function(e){
        e.preventDefault();
        var form = $('#formDelete').attr('action');
        let codcon = document.getElementById('codcon').value;
        let codarea = document.getElementById('codarea').value;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url: form,
            data:{
                "_token": "{{ csrf_token() }}",
                "codarea": codarea,
                "codcon": codcon
            },
            success:function(data) {           
                val = data.error;                 
                if(val === "500"){                              
                    toastr.error(data.msg)
                }else{                
                    toastr.options.positionClass = 'toast-bottom-right';
                    toastr.success(data.msg);                    
                    $('#groupsTable').hide(1000); //oculto mediante id
                    document.getElementById('close').click();
                    showGroups(data.groups, data.codcon);
                }
            }
        });
    })
    
    function getData(codcon, codarea, desarea){
        document.getElementById('groupName').innerHTML = desarea+'?';
        document.getElementById('codcon').value = codcon;
        document.getElementById('codarea').value = codarea;
    }
</script>
@endsection