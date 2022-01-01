@extends('layouts.app')
@section('title', 'Administración de las finanzas')
@section('css')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
            <h1 class="m-0">Lista de administración de las finanzas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('finance.activitymanage.getActivityManage') }}">Administración de las finanzas</a></li>
              <li class="breadcrumb-item active">Lista</li>
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
        <div class="row mb-2">
            <div class="col-md-3">
                <a>
                    <button type="button" onclick="debugging()" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-debug">Depuración de miembros</button>
                </a>
            </div>            
        </div>
        <div class="card">
            <!-- <div class="card-header">
            <h3 class="card-title">Miembros de casa de paz</h3>                
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>MANAGE_ID</th>
                        <th>CODCON</th>
                        <th>MIEMBRO</th>
                        <th>SEMANA 1</th>                
                        <th>SEMANA 2</th>                
                        <th>SEMANA 3</th>                
                        <th>SEMANA 4</th>                
                        <th>OPCIONES</th>                
                    </tr>
                </thead>
                <tbody>                   
                  @foreach($details as $detail)
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td> {{ $detail->nomapecon }} </td>
                      <td> S/. {{ $detail->amount1 }} </td>
                      <td> S/. {{ $detail->amount2 }} </td>
                      <td> S/. {{ $detail->amount3 }} </td>
                      <td> S/. {{ $detail->amount4 }} </td>                      
                      <td>
                        <button class='btn btn-success btn-sm' onclick="getData('<?php echo $detail->id ?>', '<?php echo $detail->manage_id ?>', '<?php echo $detail->codcon ?>')" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-edit"></i>
                        </button>
                      </td>                      
                    </tr>
                  @endforeach                                
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>MANAGE_ID</th>
                        <th>CODCON</th>
                        <th>MIEMBRO</th>
                        <th>SEMANA 1</th>
                        <th>SEMANA 2</th>
                        <th>SEMANA 3</th>
                        <th>SEMANA 4</th>
                        <th>OPCIONES</th>
                    </tr>
                </tfoot>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
      </div>
      <form id="formRegistro" method="POST" action="{{ route('finance.activitymanage.updateDetailActivityManageIndividual') }}">
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
                <div class="form-group">
                  <input type="hidden" name="_token" value="{{ csrf_token()}}" id="{{ 'token' }}">
                  <label for="nombres">Congregante</label>
                  <input type="text" class="form-control" id="nombres" placeholder="Congregante" >
                </div>                
                <div class="form-group">
                  <div class="row">
                    <input type="hidden" name="id" class="form-control" id="id">
                    <input type="hidden" name="manage_id" class="form-control" id="manage_id">
                    <div class="col-md-3">
                      <label for="monto1">Semana 1</label>
                      <input type="text" name="monto1" class="form-control" data-prefix="S/. " id="monto1" placeholder="Ingrese el monto" value="0.00">
                    </div>
                    <div class="col-md-3">
                      <label for="monto2">Semana 2</label>
                      <input type="text" name="monto2" class="form-control" data-prefix="S/. " id="monto2" placeholder="Ingrese el monto" value="0.00">
                    </div>
                    <div class="col-md-3">
                      <label for="monto3">Semana 3</label>
                      <input type="text" name="monto3" class="form-control" data-prefix="S/. " id="monto3" placeholder="Ingrese el monto" value="0.00">
                    </div>
                    <div class="col-md-3">
                      <label for="monto4">Semana 4</label>
                      <input type="text" name="monto4" class="form-control" data-prefix="S/. " id="monto4" placeholder="Ingrese el monto" value="0.00">
                    </div>
                  </div>
                </div>                
                <!-- <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>               -->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
              <button id="btnActualizar" type="submit" class="btn btn-sm btn-info float-left">GUARDAR CAMBIOS</button>
              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
          </div>
        </div>
      </div>
      </form>
      <!-- START MODAL -->
      <div class="modal fade" id="modal-debug">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">DETALLES</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card-body">
              <div class="alert alert-success alert-dismissible" id="new_members">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Nuevos miembros que se añadirán</h5>                  
              </div>        
              <button id="#" type="submit" class="btn btn-sm btn-info float-left">AÑADIR MIEMBROS</button>
            </div>        
            <div class="modal-body">                                              
              <table id="debugTable" class="table table-responsive table-bordered table-striped">
                  <thead>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>MIEMBRO</th>                         
                        <th>CANTIDAD</th>                
                        <th>OPCIONES</th>                
                    </tr>
                  </thead>
                  <tbody>                   
                    <tr>
                      <td>NC9938343</td>
                      <td>CARMONA OJEDA CRISTHIAN</td>
                      <td>OFRENDAS</td>
                      <td>15.00</td>
                      <td>
                        <button class='btn btn-danger btn-sm'>
                            <i class="fas fa-trash"></i>
                        </button>
                      </td>                      
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>CÓDIGO</th>
                        <th>MIEMBRO</th>
                        <th>CANTIDAD</th>
                        <th>OPCIONES</th>                
                    </tr>
                  </tfoot>
              </table>                
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
              <button id="btnActualizar" type="submit" class="btn btn-sm btn-info float-left">GUARDAR CAMBIOS</button>
              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
          </div>
        </div>
      </div>
      <!-- END MODAL -->
    </section>
  </div>
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
<!-- MasskMoney -->
<script src="{{ asset('plugins/maskmoney/dist/jquery.maskMoney.js') }}" type="text/javascript"></script>
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
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
        "infoFiltered": "(Filtrado de _MAX_ registros)",
        "paginate": {
            "first": "primero",
            "last": "último",
            "next": "siguiente",
            "previous": "anterior"
        },
      },
      "columnDefs": [
        {"targets": [0], "visible": false, "searchable": false},
        {"targets": [1], "visible": false, "searchable": false},
        {"targets": [2], "visible": false, "searchable": false},
      ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');    
    var table = $('#example1').DataTable(); 
    $('div.dataTables_filter input', table.table().container()).focus();
    $('#monto1').maskMoney({thousands:'', decimal:'.', allowZero:true});
    $('#monto2').maskMoney({thousands:'', decimal:'.', allowZero:true});
    $('#monto3').maskMoney({thousands:'', decimal:'.', allowZero:true});
    $('#monto4').maskMoney({thousands:'', decimal:'.', allowZero:true});
  });

    document.getElementById("tesoreroactivitiesopen").className += ' menu-open';    
    document.getElementById("tesoreroactivitiesactive").className += " active";    
    document.getElementById("tesoreromanage").className += " active";    
</script>

<script>
  function getData(id, manage_id, codcon){        
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:'/tesoreria/administracion/detalleindividual',
      data:{
        "_token": "{{ csrf_token() }}",
        "id": id,
        "manage_id": manage_id,
        "codcon": codcon
      },
      success:function(data) {           
        document.getElementById('id').value = data.id;
        document.getElementById('manage_id').value = data.manage_id;
        document.getElementById('nombres').value = data.nomapecon;
        document.getElementById('monto1').value = data.amount1;
        document.getElementById('monto2').value = data.amount2;
        document.getElementById('monto3').value = data.amount3;
        document.getElementById('monto4').value = data.amount4;        
      }
    });
  }
</script>

<script>
  $("#btnActualizar").click(function(e){
    e.preventDefault();
    var form = $('#formRegistro').attr('action');

    let id = document.getElementById('id').value;
    let manage_id = document.getElementById('manage_id').value;
    let monto1 = document.getElementById('monto1').value;
    let monto2 = document.getElementById('monto2').value;
    let monto3 = document.getElementById('monto3').value;
    let monto4 = document.getElementById('monto4').value;

    $('#example1').dataTable().fnClearTable();
    $('#example1').dataTable().fnDestroy();
    $('#example1').DataTable({
      "ajax":{
        "type": "POST",
        "url": form,
        "data": {'id': id, 'manage_id': manage_id, 'monto1': monto1, 'monto2': monto2, 'monto3': monto3, 'monto4': monto4 },
        "dataSrc": function(data){
          console.log(data);
          return data.details;
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
        {"data": "id"},
        {"data": "manage_id"},
        {"data": "codcon"},
        {"data": "nomapecon"},
        {"data": "amount1"},          
        {"data": "amount2"},
        {"data": "amount3"},
        {"data": "amount4"},
        {"data": "id"},
      ],
      "columnDefs": [
        {"targets": [0], "visible": false, "searchable": false},
        {"targets": [1], "visible": false, "searchable": false},
        {"targets": [2], "visible": false, "searchable": false},
        {"targets": [3], "searchable": true},
        {
          "targets": [4],
          "searchable": false,
          render: function(data){
            return 'S/. '+data
          }
        },        
        {
          "targets": [5],
          "searchable": false,
          render: function(data){
            return 'S/. '+data
          }
        },        
        {
          "targets": [6],
          "searchable": false,
          render: function(data){
            return 'S/. '+data
          }
        },        
        {
          "targets": [7],
          "searchable": false,
          render: function(data){
            return 'S/. '+data
          }
        },        
        {
          "targets": [8],
          "searchable": false,
          render: function(data, type, row){
            return createManageBtn(data, row.manage_id, row.codcon)
          }
        },
      ],
    });
    var table = $('#example1').DataTable(); 
    $('div.dataTables_filter input', table.table().container()).focus();
  })
</script>

<script type="text/javascript">
  function createManageBtn(id, manage_id, codcon) {
    return '<button class="btn btn-success btn-sm" onclick="getData('+"'" + id + "'"+','+"'"+ manage_id + "'"+','+"'"+ codcon +"'"+')" data-toggle="modal" data-target="#modal-default"><i class="fas fa-edit"></i></button>';
    // <button onclick="getData('<?php echo $detail->id ?>', '<?php echo $detail->manage_id ?>', '<?php echo $detail->codcon ?>')" data-toggle="modal" data-target="#modal-default">
    //     <i class="fas fa-edit"></i>
    // </button>
  }    
</script>

<script>
  function debugging(){    
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:'/tesoreria/administracion/depuracionmiembros',
      data:{
        "_token": "{{ csrf_token() }}",
        "manage_id": <?php echo $manage_id; ?>,
      },
      success:function(data) {      
        console.log(data.diffAddData);
        table = $("#debugTable tbody");    
        table.empty();
        $.each(data.diffSubtractData, function(idx, elem){
          
          // var options;
          var total = (parseFloat(elem.amount1)+parseFloat(elem.amount2)+parseFloat(elem.amount3)+parseFloat(elem.amount4));            
          // options = "<td class='bg-info'>"+total+"</td>";
          table.append(
            "<tr>"+
              "<td>"+elem.codcon+"</td>"+
              "<td>"+elem.nomapecon+"</td>"+
              "<td>"+'S/.'+total+"</td>"+
              "<td>"+
                "<button class='btn btn-danger btn-sm'>"+
                    "<i class='fas fa-trash'></i>"+
                "</button>"+
              "</td>"+
            "</tr>"
          );
        });
        $("#new_members li").remove();
        li = $("#new_members li");        
        div = $("#new_members");
        $.each(data.diffAddData, function(idx, elem){
          div.append(
            "<li>"+
              elem.ApeCon+' '+elem.NomCon+
            "</li>"
          );
        });

        // toastr.info('Asistencia de miembro eliminada correctamente');
      }
    });
  }
</script>
@endsection