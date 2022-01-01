@extends('layouts.app')
@section('title', 'Configuración de discipulados')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">  
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
            <h1 class="m-0">Configuración de discipulados</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">              
              <li class="breadcrumb-item active">Listado de discipulos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    
    <!-- Main content -->
    <section class="content">      
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-4">
                {!! Form::label('Seleccione el mentor') !!}
                <select name="miembro" class="form-control select2" style="width: 100%;" id="miselect">       
                    @foreach($miembros as $miembro)
                    <option value="<?php echo $miembro->CodArea ?>">{{ $miembro->ApeCon.' '.$miembro->NomCon }}</option>
                    @endforeach
                </select>
            </div>            
            <div class="col-md-3">
              <label for="">OPCIONES</label>
              <a>
                  <button  type="button" class="btn btn-block btn-success" onclick="abrirModal()" data-toggle="modal" data-target="#modal-debug">AÑADIR DISCIPULO</button>
              </a>                
            </div>            
        </div>
        <div class="row mb-2">
          <div class="col-md-3">
            <label style="color: blue" id="totaldiscipulos">TIENE N DISCIPULOS</label>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Listado de discípulos</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>                  
                  <th>NOMBRES</th>
                  <th>EDAD</th>
                  <th>CELULAR</th>                  
                  <th>OPCIONES</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>            
      </div><!--/. container-fluid -->
      <!-- START MODAL -->
      <div class="modal fade" id="modal-debug">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">AÑADIR DISCIPULOS</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card-body">
                <p>Seleccione el mentor, luego el discípulo que se añadirá</p>
                {!! Form::label('Seleccione el mentor') !!}
                <select name="miembro" class="form-control select2" style="width: 100%;" id="select_mentor">                    
                </select>
            </div>        
            <div class="modal-body">                                                            
                {!! Form::label('Seleccione el discipulo') !!}                
                <select name="miembro" class="form-control select2" style="width: 100%;" id="select_disciple">                    
                </select>
                <p class="text-info">Sólo se listan miembros que no pertenecen a ningún discipulado</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" id="closeAdd" data-dismiss="modal">CERRAR</button>
              <button id="btnAgregar" type="submit" class="btn btn-sm btn-info float-left">AÑADIR DISCIPULO</button>
              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
          </div>
        </div>
      </div>
      <!-- END MODAL -->
      <!-- START MODAL -->
      <form id="formDelete" method="POST" action="{{ route('admin.discipulado.deleteDisciple') }}">
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">¿Estás seguro que quitar del discipulado a <p id="name"></p></h4>              
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                  <input type="hidden" name="_token" value="{{ csrf_token()}}" id="{{ 'token' }}">
                  <input type="hidden" class="form-control" id="codcon">              
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal" id="close">CERRAR</button>
                  <button id="btnDelete" type="submit" class="btn btn-sm btn-info float-left">ESTOY SEGURO</button>
                  <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
              </div>
            </div>
        </div>      
      </form>
      <!-- END MODAL -->
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
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
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
    $(function(){
        $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        "buttons": ["excel", "pdf", "print", {extend: 'colvis', text: 'Columnas Visibles'}],
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

        //Initialize Select2 Elements
        $('.select2').select2()  

        $('#miselect').on('change', function (){
            get_disciples();
        });

        $('#miselect').trigger('change');
    })  
    document.getElementById("admindiscipuladoactive").className += " active";    
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
</script>

<script>
    function get_disciples(){
        var codarea = $('#miselect').val();
        $('#example1').dataTable().fnClearTable();
        $('#example1').dataTable().fnDestroy();
        $('#example1').DataTable({
            "ajax":{
            "type": "POST",
            "url": "/administracion/discipulado/obtener-discipulos",
            "data": {'codarea': codarea},
            "dataSrc": function(data){       
                document.getElementById('totaldiscipulos').innerHTML = 'HAY '+data.total+' DISCIPULOS EN ÉSTE GRUPO';                
                return data.disciples;
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
                {"data": "ApeCon"},
                {"data": "FecNacCon"},          
                {"data": "NumCel"},
                {"data": "CodCon"},
            ],
            "columnDefs": [                        
                { 
                    "targets": [0], 
                    render: function(data, type, row){
                        return data+' '+row.NomCon;
                    }
                },
                { 
                    "targets": [1], 
                    "searchable": false,
                    render: function(data){
                        return getAge(data)+ ' años';
                    }
                },
                { "targets": [2], "searchable": false },
                {
                    "targets": [3],
                    "searchable": false,
                    render: function(data, type, row){
                        return createManageBtn(data, row.ApeCon+' '+row.NomCon);
                    }
                }
            ],
        });
        var table = $('#example1').DataTable(); 
        $('div.dataTables_filter input', table.table().container()).focus();   
    }

    $("#btnDelete").click(function(e){
      e.preventDefault();
      var form = $('#formDelete').attr('action');
      var codarea = $('#miselect').val();
      let codcon = document.getElementById('codcon').value;
      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'/administracion/discipulado/eliminar-discipulo',
          data: {
            "_token": "{{ csrf_token() }}",
            'codcon' : codcon,          
            'codarea' : codarea
          },
          success:function(data) {            
            if(data.code == 200){                
                toastr.success(data.msg);
                document.getElementById('codcon').value = '';
                document.getElementById('name').value = '';    
                document.getElementById('close').click();
            }else{
                toastr.error(data.msg);
                document.getElementById('codcon').value = '';
                document.getElementById('name').value = '';    
                document.getElementById('close').click();
            }                            
            get_disciples();
          }
      });
    });

    function abrirModal(){
        event.preventDefault();            
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/administracion/discipulado/data-agregar-discipulo',
            data: {
                "_token": "{{ csrf_token() }}",                
            },
            success:function(data) {            
                console.log(data);
                $("#select_mentor").empty();
                $.each(data.mentores, function(idx, opt) {                
                    $('#select_mentor').append(
                        "<option value="+opt.CodArea+">" + opt.ApeCon +' '+opt.NomCon + "</option>"
                    );               
                });
                $("#select_disciple").empty();
                $.each(data.members, function(idx, opt) {                
                    $('#select_disciple').append(
                        "<option value="+opt.CodCon+">" + opt.ApeCon +' '+opt.NomCon + "</option>"
                    );               
                });
            }
        });
    }
    $("#btnAgregar").click(function(e){
        e.preventDefault();
        var codmentor = $('#select_mentor').val();
        var coddisciple = $('#select_disciple').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/administracion/discipulado/agregar-discipulo',
            data: {
                "_token": "{{ csrf_token() }}",
                'codmentor' : codmentor,          
                'coddisciple' : coddisciple
            },
            success:function(data) {
              if(data.code == 200){          
                toastr.success(data.msg);
                document.getElementById('closeAdd').click();
              }else{
                toastr.error(data.msg);
                document.getElementById('closeAdd').click();
              }             
              get_disciples();                
            }
        });
    });
    function getData(codcon, nombres){
      document.getElementById('name').innerHTML = nombres+'?';
      document.getElementById('codcon').value = codcon;      
    }
</script>
<script type="text/javascript">
  function createManageBtn(codcon, nombres) {
    return '<button class="btn btn-danger btn-sm" onclick="getData('+"'" + codcon + "', "+"'" + nombres + "'"+')" data-toggle="modal" data-target="#modal-default">Eliminar</button>';
    // return '<button class="btn btn-danger btn-sm" onclick="deleteDisciple('+"'" + codcon + "'"+')" data-toggle="modal" data-target="#modal-default">Eliminar</button>';
  }    

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