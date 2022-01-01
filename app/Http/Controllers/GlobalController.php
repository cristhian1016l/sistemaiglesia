<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GlobalController extends Controller
{
    
    public function edit()
    {   
        $user = DB::table('users as u')
                ->join('model_has_roles as mhr', 'u.id', '=', 'mhr.model_id')
                ->select('u.*', 'mhr.role_id as type_user')
                ->where('id', Auth::user()->id)
                ->first();
        $datos = ['user' => $user];
        return view('global.users.edit', $datos);     
    }

    public function update(Request $request)
    {        
        try {                
            $rules = [
                'email' => 'required',
                'password' => 'required',
            ];

            $messages = [                    
                'email.required' => 'El email es requerido',
                'password.required' => 'La contraseña es requerida',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect('/mi_perfil/editar/')->withErrors($validator)
                    ->with('msg', 'La contraseña no fue actualizada correctamente')
                    ->with('type-alert', 'warning');
            }else{
                $user = User::findOrFail(Auth::user()->id);
                $user->password = bcrypt($request->password);
                $user->save();

                return redirect('/mi_perfil/editar/')
                        ->with('msg', 'contraseña actualizada correctamente')
                        ->with('type-alert', 'success');
            }
                        
        } catch (\Exception $th) {
            return redirect('/usuarios/editar/'.Auth::user()->id)->withErrors($validator)
                ->with('msg', $th->getMessage())
                ->with('type-alert', 'warning');
        }       
    }
}
