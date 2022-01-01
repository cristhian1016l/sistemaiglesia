<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = DB::select("SELECT u.id, u.email, u.active, c.ApeCon, c.NomCon FROM users u INNER JOIN model_has_roles mr ON u.id = mr.model_id INNER JOIN TabCon c ON u.codcon = c.CodCon WHERE mr.role_id = 3");        
        $data = ['users' => $users];
        return view('admin.roles.index', $data);
    }

    public function getPermissions(Request $request)
    {
        $permissions = DB::select("SELECT p.id, p.name FROM model_has_permissions mp INNER JOIN permissions p ON mp.permission_id = p.id WHERE mp.model_id = ".$request->user_id);
        $data = ['permissions' => $permissions, 'user_id_hash' => password_hash($request->user_id, PASSWORD_BCRYPT, ['cost' => 12,]), 'user_id' => $request->user_id];
        return response()->json($data);
    }

    public function updatePermissions(Request $request)
    {
        // return response()->json($request->all());
        if(password_verify($request->user_id, $request->user_id_hash)){
            DB::table("model_has_permissions")->where('model_id', $request->user_id)->delete();            
            if($request->vermiembros == "true"){
                User::find($request->user_id)->givePermissionTo('ver miembros');
            }
            if($request->reportarasistencias == "true"){
                User::find($request->user_id)->givePermissionTo('reportar asistencias');
            }
            if($request->permisos == "true"){
                User::find($request->user_id)->givePermissionTo('permisos');
            }
            if($request->reportes == "true"){
                User::find($request->user_id)->givePermissionTo('reportes');                
            }
            if($request->usuariosmentores == "true"){
                User::find($request->user_id)->givePermissionTo('usuarios mentores');                
            }
            if($request->reuniondiscipulados == "true"){
                User::find($request->user_id)->givePermissionTo('reunion de discipulados');                
            }
            if($request->administrardiscipulados == "true"){
                User::find($request->user_id)->givePermissionTo('administrar discipulados');                
            }
            if($request->administrarroles == "true"){
                User::find($request->user_id)->givePermissionTo('administrar roles');                
            }
            if($request->registroasistencia == "true"){
                User::find($request->user_id)->givePermissionTo('registro asistencia');                
            }
            if($request->miembrosnuevos == "true"){
                User::find($request->user_id)->givePermissionTo('miembros nuevos');
            }

            return response()->json(['code' => "200", 'msg' => 'Permisos actualizados correctamente']);
        }else{
            return response()->json(['code' => "500", 'msg' => 'Error al intentar actualizar los permisos, contacte con el administrador del sistema']);
        }     
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        foreach($user as $us){
            $user->active = 1;
            $user->save();
            return redirect('/administracion/roles');
        }    
    }

    public function desactivate($id)
    {
        $user = User::findOrFail($id);
        foreach($user as $us){
            $user->active = 0;
            $user->save();
            return redirect('/administracion/roles');
        }        
    }
}
