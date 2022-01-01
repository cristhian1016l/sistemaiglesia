<?php

namespace App\Http\Controllers\Liderred;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use App\User;
use App\Tabcon;
use App\Tabredes;

class UserController extends Controller
{
    public function __construct()
    {
        $roles = Role::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');
        $active = [
            '1' => 'Activo',
            '0' => 'No activo'
        ];
        View::share('roles', $roles);
        View::share('active', $active);
        $this->middleware('auth');
    }

    public function getUsers(){
        
        $datosRed = Tabredes::where('LID_RED', Auth::user()->codcon)->first();
        // // $CDPs = Tabcasasdepaz::where('ID_Red', $datosRed->ID_RED)->get();        

        // $users = User::join('TabCon', 'users.codcon', '=', 'TabCon.CodCon')
        //         ->get(['TabCon.ID_Red', 'users.email', 'TabCon.ApeCon', 'TabCon.NomCon', 'users.active'])
        //         ->where('TabCon.ID_Red', $datosRed->ID_RED);

        $users = DB::select("SELECT DISTINCT u.id, u.email, c.ApeCon, c.NomCon, u.active FROM users u INNER JOIN TabCon
                             c ON u.codcon = c.CodCon INNER JOIN TabCasasDePaz cp ON c.CodCon = cp.CodLid 
                             INNER JOIN model_has_roles mr ON u.id = mr.model_id WHERE c.ID_Red =  '$datosRed->ID_RED' AND mr.role_id = 2");
        $data = ['users' => $users];
        return view('liderred.users.index', $data);
    }

    public function create()
    {
        $red = Tabredes::where('LID_RED', Auth::user()->codcon)->first();
        $lideres = DB::table('TabCasasDePaz')
                    ->join('TabCon', 'TabCasasDePaz.CodLid', 'TabCon.CodCon')
                    ->select('TabCon.CodCon', 'TabCon.ApeCon', 'TabCon.NomCon')
                    ->where('TabCasasDePaz.ID_RED', $red->ID_RED)
                    ->distinct()
                    ->get();

        $data = ['miembros' => $lideres];
        return view('liderred.users.create', $data);
    }

    public function create_user(Request $request)
    {
        $userFound = User::where('CodCon', $request->miembro)->first();        
        if($userFound){
            try{
                $user = User::findOrFail($userFound->id);
                $user->assignRole('lidercdp');
                $user->save();
                return redirect('/usuarios')
                        ->with('msg', 'El usuario ya tenía un rol en el sistema, se le añadió el rol de líder de casa de paz y se registró con el correo '.$userFound->email)
                        ->with('type-alert', 'success');
            } catch (\Exception $th) {
                return redirect('/usuarios/agregar')->withInput()
                    ->with('msg', $th->getMessage())
                    ->with('type-alert', 'warning');
            }       
        }else{
            try{
                $user = new User();
                $user->codcon = $request->miembro;
                $user->email = $request->email."@iglesiaprimitivaperu.org";
                $user->password = bcrypt($request->password);
                $user->active = $request->active;
                $user->assignRole('lidercdp');
                $user->save();
                return redirect('/usuarios')
                    ->with('msg', 'Nuevo usuario registrado correctamente')
                    ->with('type-alert', 'success');
            } catch (\Exception $th) {
                return redirect('/usuarios/agregar')->withInput()
                    ->with('msg', $th->getMessage())
                    ->with('type-alert', 'warning');
            }
        }                
        
    }

    public function edit($id)
    {   
        $userFound = User::findOrFail($id);
        $verify = Tabcon::select('ID_Red')->where('CodCon', $userFound->codcon)->first();
        if(Auth::user()->tabcon->ID_Red != $verify->ID_Red){
            return redirect('/usuarios')->withInput()
                    ->with('msg', 'Usted no tiene permiso para poder editar ese usuario')
                    ->with('type-alert', 'warning');
        }else{
            $user = DB::table('users as u')
                ->join('model_has_roles as mhr', 'u.id', '=', 'mhr.model_id')
                ->select('u.*', 'mhr.role_id as type_user')
                ->where('id', $id)
                ->first();
            $datos = ['user' => $user];
            return view('liderred.users.edit', $datos);
        }        
    }

    public function update(Request $request, $id)
    {        
        $email = User::where('email', $request->email)->first();
        if($email==null){
            return redirect('/usuarios/editar/'.$id)
            ->with('msg', 'No intente cambiar el email')
            ->with('type-alert', 'warning');
            die();
        }else{
            try {
                
            $rules = [
                'email' => 'required',
                'password' => 'required',
                'active' => 'required',            
            ];

            $messages = [                    
                'email.required' => 'El email es requerido',
                'password.required' => 'La contraseña es requerida',
                'active.required' => 'La condición del usuario es obligatorio',            
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect('/usuarios/editar/'.$id)->withErrors($validator)
                    ->with('msg', 'El usuario no fue actualizado')
                    ->with('type-alert', 'warning');
            }else{
                $user = User::findOrFail($id);
                $user->password = bcrypt($request->password);
                $user->active = $request->active;
                $user->save();

                return redirect('/usuarios')
                        ->with('msg', 'Usuario actualizado correctamente')
                        ->with('type-alert', 'success');
            }
                        
            } catch (\Exception $th) {
                return redirect('/usuarios/editar/'.$id)->withErrors($validator)
                    ->with('msg', $th->getMessage())
                    ->with('type-alert', 'warning');
            }
        }                
    }
    
    public function activate($id)
    {
        $user = User::findOrFail($id);
        foreach($user as $us){
            $user->active = 1;
            $user->save();
            return redirect('/usuarios');
        }    
    }

    public function desactivate($id)
    {
        $user = User::findOrFail($id);
        foreach($user as $us){
            $user->active = 0;
            $user->save();
            return redirect('/usuarios');
        }        
    }
}
