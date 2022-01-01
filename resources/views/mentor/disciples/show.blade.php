@extends('layouts.app')
@section('title', 'Detalles de discípulo')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
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
            <h1>Detalles de discípulo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Volver a ver mis discípulos</a></li>
              <li class="breadcrumb-item active">Detalles de discípulo</li>
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
                                <!-- <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li> -->
                                <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Conversión</a></li>
                                <!-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li> -->
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
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

                                        <h3 class="timeline-header border-0"><a href="#">{{ $member->NomCon }}</a> fue traido por <a href="#">{{ $member->RefCon }}</a> 
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

                                        <h3 class="timeline-header border-0"><a href="#">{{ $member->NomCon }}</a> Aceptó a Cristo
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
@endsection

@section('js')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script>
    document.getElementById("mentordiscipulosopen").className += ' menu-open';    
    document.getElementById("mentordiscipulosactive").className += " active";    
    document.getElementById("mentorshowdisciples").className += " active";    
</script>
@endsection