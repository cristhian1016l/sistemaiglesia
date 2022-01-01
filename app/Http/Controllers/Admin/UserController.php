<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tabgrupos;
use App\Tabredes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;

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

        $users = DB::select("SELECT DISTINCT u.id, u.email, c.ApeCon, c.NomCon, u.active FROM users u 
                            INNER JOIN TabCon c ON u.codcon = c.CodCon 
                            INNER JOIN TabGrupos g ON c.CodCon = g.CodCon
                            INNER JOIN model_has_roles mhr ON u.id = mhr.model_id
                            WHERE mhr.role_id = '4'");
        $data = ['users' => $users];
        return view('admin.users.mentor.index', $data);
    }

    public function create()
    {
        $lideres = Tabgrupos::select('c.CodCon', 'c.ApeCon', 'c.NomCon')
                            ->join('TabCon as c', 'TabGrupos.CodCon', '=', 'c.CodCon')
                            ->where('TipGrup', 'D')
                            ->orderBy('c.ApeCon')
                            ->get();

        $data = ['miembros' => $lideres];
        return view('admin.users.mentor.create', $data);
    }

    public function create_user(Request $request)
    {
        $userFound = User::where('CodCon', $request->miembro)->first();        
        if($userFound){
            try{
                $user = User::findOrFail($userFound->id);
                $user->assignRole('mentor');
                $user->save();
                return redirect('/administracion/usuarios')
                        ->with('msg', 'El usuario ya tenía un rol en el sistema, se le añadió el rol de mentor y se registró con el correo '.$userFound->email)
                        ->with('type-alert', 'success');
            } catch (\Exception $th) {
                return redirect('/administracion/usuarios/agregar')->withInput()
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
                $user->assignRole('mentor');
                $user->save();
                return redirect('/administracion/usuarios')
                    ->with('msg', 'Nuevo usuario registrado correctamente')
                    ->with('type-alert', 'success');
            } catch (\Exception $th) {
                return redirect('/administracion/usuarios/agregar')->withInput()
                    ->with('msg', $th->getMessage())
                    ->with('type-alert', 'warning');
            }
        }                
        
    }

    public function edit($id)
    {   
        $user = DB::table('users as u')
                ->join('model_has_roles as mhr', 'u.id', '=', 'mhr.model_id')
                ->select('u.*', 'mhr.role_id as type_user')
                ->where('id', $id)
                ->first();
            $datos = ['user' => $user];
            return view('admin.users.mentor.edit', $datos);     
    }

    public function update(Request $request, $id)
    {        
        $email = User::where('email', $request->email)->first();
        if($email==null){
            return redirect('/administracion/usuarios/editar/'.$id)
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
                return redirect('/administracion/usuarios/editar/'.$id)->withErrors($validator)
                    ->with('msg', 'El usuario no fue actualizado')
                    ->with('type-alert', 'warning');
            }else{
                $user = User::findOrFail($id);
                $user->password = bcrypt($request->password);
                $user->active = $request->active;
                $user->save();

                return redirect('/administracion/usuarios')
                        ->with('msg', 'Usuario actualizado correctamente')
                        ->with('type-alert', 'success');
            }
                        
            } catch (\Exception $th) {
                return redirect('/administracion/usuarios/editar/'.$id)->withErrors($validator)
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
            return redirect('/administracion/usuarios');
        }    
    }

    public function desactivate($id)
    {
        $user = User::findOrFail($id);
        foreach($user as $us){
            $user->active = 0;
            $user->save();
            return redirect('/administracion/usuarios');
        }        
    }
}
