<?php

use Illuminate\Support\Facades\Auth;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

//RUTAS DE LOGIN
Route::get('/', 'Auth\LoginController@show_login')->name('show_login');
Route::post('login', 'Auth\LoginController@login')->name('login'); //sólo para invitados!
Route::post('logout', 'Auth\LoginController@logout')->name('logout'); //sólo para invitados!

//RUTA PARA DESVIAR A LOS ROLES
Route::get('/panel', 'DashboardController@get_news')->name('panel');
                        //RUTA DEL LIDER DE RED
Route::group(['middleware' => 'isLiderred'], function(){
    // DASHBOARD
    Route::get('/panel-liderred', 'DashboardController@show_dashboard_liderred')->name('panel.liderred');

    // ADMINISTACIÓN DE CASAS DE PAZ
    Route::get('/CasasDePaz', 'Liderred\CDPController@getCDP')->name('liderred.getcdp');

    // REPORTES
    Route::get('/CasasDePaz/reportes', 'Liderred\CDPController@getReports')->name('liderred.getreports');
    Route::post('/casasdepaz/reportes/mostrar-cdp-faltantes','Liderred\CDPController@show_cdps')->name('admin.discipulado.show_cdps');    

    //MIEMBROS POR CP
    Route::get('miembros/verMiembros/{CodCasPaz}','Liderred\CDPController@getMembers')->name('liderred.membersCP.show');// VER DETALLES DE MIEMBRO 
    Route::get('miembros/verDetalle/{codcon}','Liderred\CDPController@getDetailsMember')->name('liderred.details.show');// VER DETALLES DE MIEMBRO 
    // ADMINISTRACIÓN DE USUARIOS
    Route::get('usuarios', 'Liderred\UserController@getUsers')->name('liderred.usuarios.getusers');
    Route::get('usuarios/agregar', 'Liderred\UserController@create')->name('liderred.usuarios.form');
    Route::post('usuarios/agregar', 'Liderred\UserController@create_user')->name('liderred.usuarios.add');
    Route::get('usuarios/editar/{id}', 'Liderred\UserController@edit')->name('liderred.usuarios.edit');
    Route::post('usuarios/actualizar/{id}', 'Liderred\UserController@update')->name('liderred.usuarios.update');
    Route::get('usuarios/activate/{id}', 'Liderred\UserController@activate')->name('liderred.usuarios.activate');
    Route::get('usuarios/desactivate/{id}', 'Liderred\UserController@desactivate')->name('liderred.usuarios.desactivate');    
    //OBSERVACIONES
    Route::get('observaciones', 'Liderred\ObservationsController@getObservations')->name('liderred.observations.getObservations'); // RUTA PARA MOSTRAR LAS OBSERVACIONES
    //MEMBRESÍA
    Route::get('membresia', 'Liderred\MembersController@getMembers')->name('liderred.membership.getMembers'); // TODOS LOS MIEMBROS ACTIVOS
    Route::get('membresia/verMiembro/{codcon}','Liderred\MembersController@getDetailsMember')->name('liderred.members.show');// VER DETALLES DE MIEMBRO 
    Route::get('membresia/generarQR/{codcon}','Liderred\MembersController@QRGenerate')->name('liderred.members.QRGenerate');// GENERAR CÓDIGO QR
    //INFORMES RECIBIDOS
    Route::post('informes/cdps/mostrar-cpds-faltantes','Liderred\ReportCdpController@show_cdps')->name('liderred.cdps.show_cdps');    
    Route::post('informes/cpds/agregar','Liderred\ReportCdpController@add_cdp')->name('liderred.cdps.add_cdp');
    Route::post('informes/cpds/traer-registros','Liderred\ReportCdpController@get_records')->name('liderred.cdps.getrecords');    
    Route::post('informes/cpds/cerrar-cdp','Liderred\ReportCdpController@close_cdp')->name('Liderred.cdps.close_cdp');
    Route::post('informes/cpds/abrir-cdp','Liderred\ReportCdpController@open_cdp')->name('Liderred.cdps.open_cdp');
    Route::get('informes/cpds/reporte-cdp/{numinf}','Liderred\ReportCdpController@reportDownload')->name('Liderred.cdps.reportDownload');
    //PERMISOS
    Route::get('permisos', 'Liderred\PermissionsController@getPermissions')->name('liderred.permisos'); // RUTA PARA MOSTRAR LOS PERMISOS
    // PERMISOS - MÉTODOS AJAX
    Route::post('permisos/obtener-permisos','Liderred\PermissionsController@getPermissionsAjax')->name('liderred.permiso.getPermissionsAjax');
    Route::post('permisos/agregar-permiso','Liderred\PermissionsController@addPermission')->name('liderred.permiso.addPermission');
    Route::post('permisos/deshabilitar-permiso','Liderred\PermissionsController@disablePermission')->name('liderred.permiso.disablePermission');
    Route::post('permisos/habilitar-permiso','Liderred\PermissionsController@enablePermission')->name('liderred.permiso.enablePermission');
    Route::post('permisos/eliminar-permiso','Liderred\PermissionsController@deletePermission')->name('liderred.permiso.deletePermission');
    Route::post('permisos/obtener-permiso','Liderred\PermissionsController@getPermission')->name('liderred.permiso.getPermission');
    Route::post('permisos/editar-permiso','Liderred\PermissionsController@editPermission')->name('liderred.permiso.editPermission');
});
                            //RUTA DEL LIDER DE CASA DE PAZ
Route::group(['middleware' => 'isLidercdp'], function(){
    // DASHBOARD
    Route::get('/panel-lidercdp', 'DashboardController@show_dashboard_lidercdp')->name('panel.lidercdp');
    // ADMINISTRACIÓN DE CASAS DE PAZ
    Route::get('lidercdp/CasasDePaz', 'Lidercdp\CDPController@getCDP')->name('lidercdp.getcdp'); // OBTIENE LAS CASAS DE PAZ
    Route::get('lidercdp/CasasDePaz/{codcaspaz}', 'Lidercdp\CDPController@getMembers')->name('lidercdp.cdp.getmembers'); //ADMINISTRACIÓN DE MIEMBROS

    // REPORTES SEMANALES
    Route::get('lidercdp/casasdepaz-asignadas', 'Lidercdp\CDPController@getCDPToReport')->name('lidercdp.getcdptoreport'); // OBTIENE LAS CASAS DE PAZ
    // Route::get('lidercdp/CasasDePaz/{codcaspaz}', 'Lidercdp\CDPController@getMembers')->name('lidercdp.cdp.getmembers'); //ADMINISTRACIÓN DE MIEMBROS

    //MIEMBROS
    Route::get('lidercdp/verMiembro/{codcon}','Lidercdp\CDPController@getDetailsMember')->name('lidercdp.members.show');// VER DETALLES DE MIEMBRO 
    
    // OBSERVACIONES DE MIEMBROS
    Route::get('lidercdp/reportarMiembro/{codcon}/{codcaspaz}', 'Lidercdp\ObservationsController@reportMember')->name('lidercdp.observations.reportMember'); // RUTA VER EL FORMULARIO DE REPORTAR MIEMBRO
    Route::post('lidercdp/reportarMiembro', 'Lidercdp\ObservationsController@reportMemberPost')->name('lidercdp.observations.reportMemberPost'); // RUTA PARA ENVIAR LA INFORMACIÓN DE REPORTAR MIEMBRO
    Route::get('lidercdp/observaciones', 'Lidercdp\ObservationsController@getObservations')->name('lidercdp.observations.getObservations'); // RUTA PARA MOSTRAR LAS OBSERVACIONES
    
    // REPORTE SEMANAL DE CASA DE PAZ
    Route::get('lidercdp/reportesemanal/crear_asistencia/{numinf}/{codcaspaz}','Lidercdp\ReportCdpController@create')->name('Lidercdp.reportesemanal.create');    
});

                            //RUTA DEL MENTOR
Route::group(['middleware' => 'isMentor'], function(){
    // DASHBOARD
    Route::get('/panel-mentor', 'DashboardController@show_dashboard_mentor')->name('panel.mentor');
    // DASHBOARD MÉTODOS AJAX
    Route::post('/mentor/obtenerAsistenciasGraficas', 'Mentor\DashboardController@getGraphicAssistance'); // ASISTENCIAS GRÁFICAS DE ORACIONES

    // VER DISCIPULOS
    Route::get('mentor/discipulos', 'Mentor\DisciplesController@getDisciples')->name('mentor.discipulos.getDisciples'); // TODOS LOS DISCIPULOS
    Route::get('mentor/verDiscipulo/{codcon}','Mentor\DisciplesController@getDetailsDisciple')->name('mentor.disciples.show');// VER DETALLES DEL DISCIPULO

    // GESTIÓN DE REPORTES    
    Route::get('mentor/Reporte/Asistencias/registrarAsistencia','Mentor\ReportController@show_assistance')->name('mentor.report.show_assistance'); //MOSTRAR LA PÁGINA PARA REGISTRAR ASISTENCIA

    // GESTIÓN DE REPORTES - MÉTODOS AJAX
    Route::post('mentor/registrarAsistencia','Mentor\ReportController@updateAssistanceDisciple')->name('mentor.report.updateAssistanceDisciple');// REGISTRAR ASISTENCIA
    Route::post('mentor/eliminarAsistencia','Mentor\ReportController@removeAssistanceDisciple')->name('mentor.report.removeAssistanceDisciple');// ELIMINAR ASISTENCIA
    // Route::post('mentor/obtenerNumero/{CodCasPaz}','Mentor\ReportController@getNumberAssistance')->name('mentor.report.getNumberAssistance');// OBTENER ASISTENCIAS Y FALTAS

    //GESTIÓN DE DISCIPULADOS
    Route::get('mentor/discipulado/listado','Mentor\DiscipleshipController@index')->name('mentor.discipulado.index');
    Route::get('mentor/discipulado/crear_asistencia/{codasi}','Mentor\DiscipleshipController@create')->name('mentor.discipulado.create');    
    //GESTIÓN DE DISCIPULADOS - MÉTODOS AJAX
    Route::post('mentor/discipulado/registrarAsistencia','Mentor\DiscipleshipController@updateAssistanceDisciple')->name('mentor.discipulados.updateAssistanceDisciple');// REGISTRAR ASISTENCIA
    Route::post('mentor/discipulado/eliminarAsistencia','Mentor\DiscipleshipController@removeAssistanceDisciple')->name('mentor.discipulados.removeAssistanceDisciple');// ELIMINAR ASISTENCIAR ASISTENCIAS Y FALTAS
    Route::post('mentor/discipulado/actualizar_asistencia','Mentor\DiscipleshipController@updateAssistance')->name('mentor.discipulados.actualizar');    
});

Route::group(['middleware' => 'isTesorero'], function(){
    // ACTIVIDADES
    Route::get('/tesoreria/actividades', 'Finance\ActivityController@getActivities')->name('finance.activity.getActivities');
    Route::get('/tesoreria/actividades/agregar', 'Finance\ActivityController@create')->name('finance.activity.form');
    Route::post('/tesoreria/actividades/agregar', 'Finance\ActivityController@create_activity')->name('finance.activity.add');

    // ADMINISTRACION DE ACTIVIDADES
    Route::get('/tesoreria/administracion', 'Finance\ActivityManageController@getActivitiesManage')->name('finance.activitymanage.getActivityManage');
    Route::get('/tesoreria/administracion/agregar', 'Finance\ActivityManageController@create')->name('finance.activitymanage.create');
    Route::post('/tesoreria/administracion/agregar', 'Finance\ActivityManageController@create_activitiy_manage')->name('finance.activitymanage.createActivityManage');

    // ADMINISTRACIÓN DE DETALLE DE ACTIVIDADES
    Route::get('/tesoreria/administracion/detalle/{id}', 'Finance\ActivityManageController@getDetailsActivityManage')->name('finance.activitymanage.getDetailsActivityManage');
    // ADMINISTRACIÓN DE DETALLE DE ACTIVIDADES - MÉTODOS AJAX
    Route::post('/tesoreria/administracion/detalleindividual', 'Finance\ActivityManageController@getDetailsActivityManageIndividual')->name('finance.activitymanage.getDetailsActivityManageIndividual');
    Route::post('/tesoreria/administracion/actualizardetalleindividual', 'Finance\ActivityManageController@updateDetailActivityManageIndividual')->name('finance.activitymanage.updateDetailActivityManageIndividual');
    Route::post('/tesoreria/administracion/depuracionmiembros', 'Finance\ActivityManageController@members_debug')->name('finance.activitymanage.members_debug');
});
                            

                            //RUTA DEL ADMINISTRADOR
Route::group(['middleware' => 'isAdmin'], function(){    
    // DASHBOARD
    Route::get('/panel-administracion', 'DashboardController@show_dashboard_admin')->name('panel.admin');    
    // DASHBOARD MÉTODOS AJAX
    Route::post('/administracion/obtenerAsistenciasGraficas', 'Admin\DashboardController@getGraphicAssistance'); // ASISTENCIAS GRÁFICAS DE ORACIONES
    Route::post('/administracion/obtenerAsistenciasGraficasCultos', 'Admin\DashboardController@getGraphicAssistanceCultos'); // ASISTENCIAS GRÁFICAS DE CULTOS
    Route::post('/administracion/obtenerAsistenciasCultoXRed', 'Admin\DashboardController@getGraphicAssistanceCultosXRed'); // ASISTENCIAS GRÁFICAS DE CULTOS
    Route::post('/administracion/obtenerMiembrosXRed', 'Admin\DashboardController@getGraphicMembersXRed'); // ASISTENCIAS GRÁFICAS DE CULTOS
    Route::get('/administracion/reportes/asistencias-cultos/{codasi}','Admin\DashboardController@reportAsisCultDownload')->name('admin.dashboard.reportAsisCultDownload'); //IMPRIMIR LAS ASISTENCIAS AL CULTO POR CASAS DE PAZ

    Route::group(['middleware' => ['can:ver miembros']], function () {
        //MEMBRESÍA
        Route::get('administracion/membresia', 'Admin\MembersController@getMembers')->name('admin.membership.getMembers'); // TODOS LOS MIEMBROS ACTIVOS
        // Route::get('administracion/membresia/baja/{codcon}', 'Admin\MembersController@toDown')->name('admin.membership.toDown'); // DAR DE BAJA
        Route::get('administracion/verDetalle/{codcon}','Admin\MembersController@getDetailsMember')->name('admin.membership.show');// VER DETALLES DE MIEMBRO 
        // GRUPOS
        Route::post('administracion/grupo/baja', 'Admin\MembersController@removeFromGroup')->name('admin.membership.removeFromGroup'); // QUITAR DE UN GRUPO
        Route::post('administracion/membresia/baja', 'Admin\MembersController@toDown')->name('admin.membership.toDown'); // DAR DE BAJA        
    });    

    Route::group(['middleware' => ['can:registro asistencia']], function() {
        // REGISTRO DE ASISTENCIA
        Route::get('administracion/registro-asistencia', 'Admin\MembersController@getAssistances')->name('admin.membership.register_assistance'); // TODOS LOS MIEMBROS ACTIVOS

        // REGISTRO DE ASISTENCIA - AJAX
        Route::post('administracion/asistenciaCultos', 'Admin\AssistanceDetailsController@getDetailsAssistance')->name('admin.membership.getDetailsAssistanceCultos'); // OBTIENE LOS DETALLES DE LA ASISTENCIA
    });

    Route::group(['middleware' => ['can:miembros nuevos']], function() {
        // MIEMBROS NUEVOS
        Route::get('administracion/miembros-nuevos', 'Admin\MembersController@getNewsMembers')->name('admin.membership.new_members'); // TODOS LOS MIEMBROS ACTIVOS
        Route::get('administracion/reportes/asistencia-miembros-nuevos/{idred}','Admin\ReportController@reportAsisCultMiemNuevosDownload')->name('admin.new_members.reporteAsistenciaCultos'); //IMPRIMIR LAS FALTAS A LOS CULTO DE MIEMBROS NUEVOS

        // REGISTRO DE ASISTENCIA - AJAX
        Route::post('administracion/asistencia-cultos', 'Admin\AssistanceDetailsController@getDetailsAssistance')->name('admin.membership.getDetailsAssistance'); // OBTIENE LOS DETALLES DE LA ASISTENCIA DEL MIEMBRO NUEVO
        Route::post('administracion/obtener-observacion', 'Admin\AssistanceDetailsController@getObservation')->name('admin.membership.getObservation'); // OBTIENE LA OBSERVACIÓN PARA MOSTRARLO EN EL MODAL
        Route::post('administracion/actualizar-observacion', 'Admin\AssistanceDetailsController@updateObservation')->name('admin.membership.updateObservation'); // INSERTA O ACTUALZA LA OBSERVACIÓN
        Route::post('administracion/obtener-miembros', 'Admin\AssistanceDetailsController@getNewsMembersAjax')->name('admin.membership.getNewsMembersAjax'); // OBTIENE LOS MIEMBROS NUEVOS A TRAVÉS DE AJAX
        
    });

    Route::group(['middleware' => ['can:reportar asistencias']], function () {
        // ASISTENCIA
        Route::get('administracion/asistencia', 'Admin\AssistanceController@getAssistance')->name('admin.asistencia.index');
        Route::post('administracion/asistencia/{act}','Admin\AssistanceController@getTabActMes')->name('admin.asistencia.getTabActMes');
        Route::post('administracion/asistenciaAnterior/{fec}','Admin\AssistanceController@getPrevAssists')->name('admin.asistencia.getPrevAssists');
        Route::post('administracion/asistencia/faltas/{act}','Admin\AssistanceController@getFaltasDiscipulosOracion')->name('admin.asistencia.getFaltasDiscipulosOracion');
        Route::post('administracion/asistencia/procesar-faltas/{codasi}', 'Admin\AssistanceController@faultsProcess');
        Route::post('administracion/asistencia/procesar-faltas-CP/{codasi}', 'Admin\AssistanceController@faultsProcessCP');
        Route::post('administracion/asistencia/procesar-oracion/{codasi}', 'Admin\AssistanceController@prayerProcess');
        Route::get('administracion/asistencia/reporte/imprimir-oracion', 'Admin\AssistanceController@printPrayer')->name('admin.imprimir_oracion');

        // DETALLE ASISTENCIA
        Route::post('administracion/asistenciaAnterior','Admin\AssistanceDetailsController@getDetailsDetAsi')->name('admin.asistencia.getDetailsDetAsi');
        Route::get('administracion/asistencia/{CodAct}','Admin\AssistanceDetailsController@getDiaryRegister')->name('admin.asistencia.getDiaryRegister');
        Route::post('administracion/asistencia/','Admin\AssistanceDetailsController@registerAssistance')->name('admin.asistencia.registerAssistance');
        Route::get('administracion/verasistencia/{CodAct}','Admin\AssistanceDetailsController@checkDiaryRegister')->name('admin.asistencia.checkDiaryRegister');
        Route::post('administracion/registrarAsistencia','Admin\AssistanceDetailsController@updateAssistanceMember')->name('admin.asistencia.updateAssistanceMember');
        Route::post('administracion/eliminarAsistencia','Admin\AssistanceDetailsController@deleteAssistanceMember')->name('admin.asistencia.deleteAssistanceMember');
        Route::post('administracion/getNumbers/{Codasi}','Admin\AssistanceDetailsController@getNumbers')->name('admin.asistencia.getNumbers');
    });        

    Route::group(['middleware' => ['can:permisos']], function () {
        //PERMISOS
        Route::get('administracion/permisos', 'Admin\PermissionsController@getPermissions')->name('admin.permissions.index'); // RUTA PARA MOSTRAR LOS PERMISOS
        // PERMISOS - MÉTODOS AJAX
        Route::post('administracion/permisos/obtener-permisos','Admin\PermissionsController@getPermissionsAjax')->name('admin.permiso.getPermissionsAjax');
        Route::post('administracion/permisos/agregar-permiso','Admin\PermissionsController@addPermission')->name('admin.permiso.addPermission');
        Route::post('administracion/permisos/deshabilitar-permiso','Admin\PermissionsController@disablePermission')->name('admin.permiso.disablePermission');
        Route::post('administracion/permisos/habilitar-permiso','Admin\PermissionsController@enablePermission')->name('admin.permiso.enablePermission');
        Route::post('administracion/permisos/eliminar-permiso','Admin\PermissionsController@deletePermission')->name('admin.permiso.deletePermission');
        Route::post('administracion/permisos/obtener-permiso','Admin\PermissionsController@getPermission')->name('admin.permiso.getPermission');
        Route::post('administracion/permisos/editar-permiso','Admin\PermissionsController@editPermission')->name('admin.permiso.editPermission');
    });    

    Route::group(['middleware' => ['can:reportes']], function () {
        // REPORTES
        Route::get('administracion/reportes', 'Admin\ReportController@index')->name('admin.reports.index'); // RUTA PARA MOSTRAR LOS REPORTES
        Route::post('administracion/reportes/faltas_discipulos','Admin\ReportController@reporteFaltasDownload')->name('admin.faltasdiscipulos.report'); //IMPRIMIR EN PDF LAS FALTAS CONSECUTIVAS AL DISCIPULADO
        Route::get('administracion/reportes/faltas_discipulados','Admin\ReportController@reporteFaltasDiscipuladosDownload')->name('admin.faltasdiscipulados.report'); //IMPRIMIR LAS FALTAS AL DISCIPULADO MENSUAL
    });        

    Route::group(['middleware' => ['can:usuarios mentores']], function () {
        // ADMINISTRACIÓN DE USUARIOS MENTORES
        Route::get('administracion/usuarios', 'Admin\UserController@getUsers')->name('admin.usuarios.getusers');
        Route::get('administracion/usuarios/agregar', 'Admin\UserController@create')->name('admin.usuarios.form');
        Route::post('administracion/usuarios/agregar', 'Admin\UserController@create_user')->name('admin.usuarios.add');
        Route::get('administracion/usuarios/editar/{id}', 'Admin\UserController@edit')->name('admin.usuarios.edit');
        Route::post('administracion/usuarios/actualizar/{id}', 'Admin\UserController@update')->name('admin.usuarios.update');
        Route::get('administracion/usuarios/activate/{id}', 'Admin\UserController@activate')->name('admin.usuarios.activate');
        Route::get('administracion/usuarios/desactivate/{id}', 'Admin\UserController@desactivate')->name('admin.usuarios.desactivate');
    });        
    

    //OBSERVACIONES
    Route::get('administracion/observaciones', 'Admin\ObservationsController@getObservations')->name('admin.observations.getObservations'); // RUTA PARA MOSTRAR LAS OBSERVACIONES
    Route::post('administracion/observacionLeida/{observationid}', 'Admin\ObservationsController@markasread')->name('admin.observations.markasread'); // MARCAR OBSERVACIÓN COMO LEÍDA
    Route::post('administracion/eliminarObservacion/{observationid}', 'Admin\ObservationsController@deleteObservation')->name('admin.observations.deleteObservation'); // ELIMINAR OBSERVACIÓN
    //OBSERVACIONES AJAX
    Route::post('admin/observacionesajax', 'Admin\ObservationsController@getObservationsAjax')->name('admin.observations.getObservationsAjax'); // RUTA PARA MOSTRAR LAS OBSERVACIONES    

    Route::group(['middleware' => ['can:reunion de discipulados']], function () {
        //GESTIÓN DE REUNIÓN DISCIPULADOS
        Route::get('administracion/discipulado/listado','Admin\DiscipleshipController@index')->name('admin.discipulado.index');
        Route::get('administracion/discipulado/reporte-discipulado/{codasi}','Admin\DiscipleshipController@reportDownload')->name('admin.discipulado.reportDownload');
        //GESTIÓN DE REUNIÓN DE DISCIPULADOS - MÉTODOS AJAX
        Route::post('administracion/discipulado/traer-registros','Admin\DiscipleshipController@get_records')->name('admin.discipulado.getrecords');    
        Route::post('administracion/discipulado/abrir-discipulado','Admin\DiscipleshipController@open_discipleship')->name('admin.discipulado.open_discipleship');
        Route::post('administracion/discipulado/cerrar-discipulado','Admin\DiscipleshipController@close_discipleship')->name('admin.discipulado.close_discipleship');
        Route::post('administracion/discipulado/cerrar-discipulados-total','Admin\DiscipleshipController@close_all_discipleship')->name('admin.discipulado.close_all_discipleship');    
        Route::post('administracion/discipulado/mostrar-discipulados-faltantes','Admin\DiscipleshipController@show_discipleships')->name('admin.discipulado.show_discipleships');    
        Route::post('administracion/discipulado/agregar','Admin\DiscipleshipController@add_discipleship')->name('admin.discipulado.add_discipleship');
    });    

    Route::group(['middleware' => ['can:administrar discipulados']], function () {
        //GESTIÓN DE DISCIPULADOS
        Route::get('administracion/discipulado/administrar','Admin\DiscipleshipController@manage')->name('admin.discipulado.manage');
        //GESTIÓN DE DISCIPULADOS - MÉTODOS AJAX
        Route::post('administracion/discipulado/obtener-discipulos','Admin\DiscipleshipController@getDisciples')->name('admin.discipulado.getDisciples');    
        Route::post('administracion/discipulado/eliminar-discipulo','Admin\DiscipleshipController@deleteDisciple')->name('admin.discipulado.deleteDisciple');    
        Route::post('administracion/discipulado/data-agregar-discipulo','Admin\DiscipleshipController@data_add_disciple')->name('admin.discipulado.data_add_disciple');    
        Route::post('administracion/discipulado/agregar-discipulo','Admin\DiscipleshipController@add_disciple')->name('admin.discipulado.add_disciple');    
    });    

    Route::group(['middleware' => ['can:administrar roles']], function () {
        // ROLES
        Route::get('administracion/roles', 'Admin\RolesController@index')->name('admin.roles.index'); // RUTA PARA MOSTRAR LOS ROLES    
        Route::get('administracion/roles/activate/{id}', 'Admin\RolesController@activate')->name('admin.roles.activate');
        Route::get('administracion/roles/desactivate/{id}', 'Admin\RolesController@desactivate')->name('admin.roles.desactivate');
        // ROLES - MÉTODOS AJAX
        Route::post('administracion/roles/obtener-permisos','Admin\RolesController@getPermissions')->name('admin.roles.getPermissions');
        Route::post('administracion/roles/actualiza-permisos','Admin\RolesController@updatePermissions')->name('admin.roles.updatePermissions');    
    });
});

// CAMBIAR CONTRASEÑA
Route::get('mi_perfil/editar', 'GlobalController@edit')->name('global.usuarios.edit');
Route::post('mi_perfil/actualizar', 'GlobalController@update')->name('global.usuarios.update');

Route::get('/show', function(){
    //dd(Role::all(), Permission::all());
    //Role::first()->givePermissionTo(Permission::first());
    //dd(Role::first()->Permissions);
    //User::first()->assignRole('administrador');
    //dd(User::first()->can('Agregar usuarios'));
    //Permission::create(['name' => 'agregar usuarios']);
    // User::find(6)->givePermissionTo('ver miembros');
    // User::find(6)->givePermissionTo('reportar asistencias');
    //dd(User::role('administrador')->get());
    //dd(User::permission('Agregar usuarios')->get());
    //dd(Permission::get());
    //dd(Role::get());
    // dd(User::find(5)->hasRole('lidercdp'));
    //  dd(User::role('liderred')->get());
    //  dd(User::role('lidercdp')->get());
    // dd(User::find(Auth::user()->id)->hasRole('lidercdp'));    
    // dd(User::role('administrador')->get());
    // dd(User::find(6)->hasRole('lidercdp'));
});

Route::get('/create', function(){
    // $permission = Permission::create(['name' => 'ver miembros']);
    // $permission = Permission::create(['name' => 'reportar asistencias']);
    // $permission = Permission::create(['name' => 'permisos']);
    // $permission = Permission::create(['name' => 'reportes']);
    // $permission = Permission::create(['name' => 'usuarios mentores']);
    // $permission = Permission::create(['name' => 'reunion de discipulados']);
    // $permission = Permission::create(['name' => 'administrar discipulados']);
    // $permission = Permission::create(['name' => 'administrar roles']);
    // $permission = Permission::create(['name' => 'registro asistencia']);
    // $permission = Permission::create(['name' => 'miembros nuevos']);

    // User::find(6)->givePermissionTo('ver miembros');
    // User::find(6)->givePermissionTo('reportar asistencias');
    // User::find(6)->givePermissionTo('permisos');
    // User::find(6)->givePermissionTo('reportes');
    // User::find(6)->givePermissionTo('usuarios mentores');
    // User::find(6)->givePermissionTo('reunion de discipulados');
    // User::find(6)->givePermissionTo('administrar discipulados');
    // User::find(6)->givePermissionTo('administrar roles');
    // User::find(6)->givePermissionTo('miembros nuevos');
    // User::find(6)->givePermissionTo('registro asistencia');
    // Role::create(['name' => 'liderred']);
    // Role::create(['name' => 'lidercdp']);
    // Role::create(['name' => 'administrador']);
    // Role::create(['name' => 'mentor']);
    // Role::create(['name' => 'tesorero']);
    // User::find(1)->assignRole('liderred');
    // User::find(2)->assignRole('liderred');
    // User::find(3)->assignRole('liderred');
    // User::find(4)->assignRole('liderred');
    // User::find(5)->assignRole('lidercdp');
    // User::find(1)->assignRole('mentor');
    // User::find(6)->assignRole('tesorero');
    //Permission::create(['name'=>'Administrar usuarios']);
    //Permission::create(['name'=>'Administrar registro de trabajo realizado']);
    //Permission::create(['name'=>'Administrar pagos']);
    //Permission::create(['name'=>'Administrar almacén']);
    //factory(User::class)->create();
});