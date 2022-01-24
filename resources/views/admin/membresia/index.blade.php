@extends('layouts.app')
@section('title', 'Membresía')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <style>    
    td:nth-child(1) {  
      text-align: center; 
      font-size: 20px
    }
  </style>
@endsection
@section('contenido')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Membresía de la Iglesia</h1>            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.membership.getMembers') }}">Membresía</a></li>
              <li class="breadcrumb-item active">Membresía</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- MENSAJES DE ALERTA -->        
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
    <!-- FIN DE MENSAJES DE ALERTA -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="card">
              <div class="card-header">
                <h3 class="card-title">Membresía total</h3>                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>PROCESO</th>
                    <th>NOMBRES</th>
                    <th>EDAD</th>
                    <th>DIRECCIÓN</th>
                    <th>CELULAR</th>
                    <th>TIPO</th>
                    <th>OPCIONES</th>
                  </tr>
                  </thead>
                  <tbody>             
                  @foreach($members as $member)
                    <tr>                  
                    <td>
                    @if($member->EstaEnProceso == 1)
                        <span class="badge badge-info">SI</span>
                    @else
                        <span class="badge badge-danger">NO</span>
                    @endif
                    </td>
                    <td>{{ $member->ApeCon. ' ' .$member->NomCon }}</td>
                    <td>
                        <?php
                            $edad = \Carbon\Carbon::parse($member->FecNacCon)->age;
                            if($edad == 0){
                                echo "------";
                            }else{
                                echo $edad. " años";
                            }                        
                        ?>                        
                    </td>
                    <td>{{ $member->DirCon }}</td>
                    <td>{{ $member->NumCel }}</td>
                    <td>{{ $member->TipCon }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.membership.toDown', $member->CodCon)}}"> --}}
                        <a>
                            <button class="btn btn-danger btn-sm" onclick="getData('<?php echo $member->CodCon ?>','<?php echo $member->ApeCon.' '.$member->NomCon ?>')" data-toggle="modal" data-target="#modal-default" title="Dar de baja a <?php echo $member->NomCon ?>">
                                <i class="fas fa-user-minus"></i>
                            </button>         
                        </a>
                        <a href="{{ route('admin.membership.show', $member->CodCon)}}" target="_blank">
                            <button class="btn btn-success btn-sm"  title="Ver detalles de <?php echo $member->NomCon ?>">
                                <i class="fas fa-eye"></i>
                            </button>         
                        </a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>PROCESO</th>
                    <th>NOMBRES</th>
                    <th>EDAD</th>
                    <th>DIRECCIÓN</th>
                    <th>CELULAR</th>
                    <th>TIPO</th>
                    <th>OPCIONES</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.content-wrapper -->
    <form id="formDelete" method="POST" action="{{ route('admin.membership.toDown') }}">
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">¿Estás seguro que deseas dar de baja a <p id="name"></p></h4>              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <input type="hidden" name="_token" value="{{ csrf_token()}}" id="{{ 'token' }}">
              <input type="hidden" class="form-control" id="codcon">
            <div class="modal-body">
              <label for="motbaja">Motivo de la baja</label>
              <input type="text" class="form-control" id="motbaja" placeholder="Ingrese el motivo de la baja">
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
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      "buttons": ["excel", "pdf", "print"],
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ miembros",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Miembros",
        "infoFiltered": "(Filtrado de _MAX_ registros)",
        "zeroRecords": "No se encontraron resultados",
        "emptyTable": "Ningún dato disponible en esta tabla",
        "paginate": {
          "first": "primero",
          "last": "último",
          "next": "siguiente",
          "previous": "anterior"
        },
      }, 
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    var table = $('#example1').DataTable(); 
    $('div.dataTables_filter input', table.table().container()).focus();
    
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
<script>
  $("#btnDelete").click(function(e){
    e.preventDefault();
    var form = $('#formDelete').attr('action');
    let codcon = document.getElementById('codcon').value;
    let motbaja = document.getElementById('motbaja').value;    
    $('#example1').dataTable().fnClearTable();
    $('#example1').dataTable().fnDestroy();
    $('#example1').DataTable({
      "ajax":{
        "type": "POST",
        "url": form,
        "data": {'codcon': codcon, 'motbaja': motbaja },
        "dataSrc": function(data){
          val = data.error; 
          if(val === "500"){                              
            toastr.error("Ha ocurrido un error, no se pudo dar de baja al miembro")
          }else{                
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.success('El miembro ha sido dado de baja exitosamente');                          
            document.getElementById('codcon').value = '';
            document.getElementById('motbaja').value = '';    
            document.getElementById('close').click();
            return data.members;             
          }                      
        },
        "headers": {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      },
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["excel", "pdf", "print"],
      "language": {
      "search": "Buscar:",
      "lengthMenu": "Mostrar _MENU_ miembros",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Miembros",
      "infoFiltered": "(Filtrado de _MAX_ registros)",
      "zeroRecords": "No se encontraron resultados",
      "emptyTable": "Ningún dato disponible en esta tabla",
      "paginate": {
          "first": "primero",
          "last": "último",
          "next": "siguiente",
          "previous": "anterior"
        },
      },        
      "columns":[
        {"data": "EstaEnProceso"},
        {"data": "ApeCon"},
        {"data": "FecNacCon"},
        {"data": "DirCon"},
        {"data": "NumCel"},          
        {"data": "TipCon"},        
        {"data": "CodCon"},        
      ],
      "columnDefs": [        
        {
          "targets": [0],
          "searchable": false,
          render: function(data){
            if(data===1){
              return "<span class='badge badge-info'>SI</span>";
            }else{
              return "<span class='badge badge-danger'>NO</span>";
            }
          }
        },
        {
          "targets": [1],
          "searchable": true,
          render: function(data, type, row){
            return data+' '+row.NomCon;
          }
        },        
        {
          "targets": [2],
          "searchable": false,
          render: function(data){
            return getAge(data)+ ' años';
          }
        },
        { "targets": [3], "searchable": false },
        { "targets": [4], "searchable": false },
        { "targets": [5], "searchable": false },
        {
          "targets": [6],
          "searchable": false,
          render: function(data, type, row){
            return createManageBtn(data, row.ApeCon, row.NomCon);
          }
        },
      ],
    });
    var table = $('#example1').DataTable(); 
    $('div.dataTables_filter input', table.table().container()).focus();    
  })
</script>

<script>
  function getData(codcon, nombres){
      document.getElementById('name').innerHTML = nombres+'?';
      document.getElementById('codcon').value = codcon;      
  }
</script>

<script type="text/javascript">
  function createManageBtn(codcon, apecon, nomcon) {    
    return  '<a>'+
              '<button class="btn btn-danger btn-sm" onclick="getData('+"'" + codcon + "'"+','+"'"+ apecon + " "+ nomcon +"'"+')" data-toggle="modal" data-target="#modal-default" title="Dar de baja a '+nomcon+'">'+
                '<i class="fas fa-user-minus"></i>'+
              '</button>'+
            '</a>'+
            '<a href="verDetalle/'+codcon+'" target="_blank">'+
              '<button class="btn btn-success btn-sm" title="Ver detalles de '+apecon+' '+nomcon+'">'+
                '<i class="fas fa-eye"></i>'+
              '</button>'+
            '</a>';
  }    
</script>

<script type="text/javascript">
  function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
  }
</script>
@endsection