<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // VALIDA LOS PARAMETROS RECIBIDOS
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // SI NO COINCIDEN EL EMAIL Y PASSWORD ENVÍA UN MENSAJE DE ALERTA
        if(!auth()->attempt($loginData)){
            return response(['message' => 'Credenciales inválidas']);
        }

        // ACTUALIZA EL TOKEN CADA VEZ QUE SE INICIA SESIÓN EL LA APLICACIÓN
        $user = User::find(Auth::user()->id);
        $user->api_token = Str::random(60);
        $user->save();
        $accessToken = User::find(Auth::user()->id)->api_token;

        return response(['user' => User::find(Auth::user()->id), 'access_token' => $accessToken]);
    }
}
