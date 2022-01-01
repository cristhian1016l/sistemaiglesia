<?php

namespace App\Http\Controllers\Lidercdp;

use App\Http\Controllers\Controller;
use App\Tabcasasdepaz;
use App\TabInfCasPaz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportCdpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create($numinf, $codcaspaz){                
        dd($codcaspaz);
        $validation = TabInfCasPaz::select('Enviado')->where('NumInf', $numinf)->first();
        if($validation['Enviado'] == 0){
            $codarea = Tabcasasdepaz::select('CodCasPaz')->where('CodLid', Auth::user()->codcon)->get();
            $total = count($codarea);
            dd();
            $security = strpos($codasi, $codarea['CodArea']);
            if($security === false){
                abort('403');
            }else{
                $asistencia = DB::table('tabasidiscipulados')
                        ->select('codasi', 'fecasi', 'tema', 'ofrenda', 'testimonios', 'observaciones', 'totfaltas', 'totasistencia', 'mes', 'anio')
                        ->where('codasi', $codasi)
                        ->first();          
                        // dd($asistencia->codasi);
                $discipulos = Tabdetasidiscipulados::where('codasi', $codasi)->get();
                $data = ['asistencia' => $asistencia, 'discipulos' => $discipulos, 'desarea' => $codarea['DesArea']];
                return view('mentor.discipleship.registerAssistance', $data);                
            } 
        }else{            
            return redirect('mentor/discipulado/listado')
                    ->with('msg', 'El informe de discipulado ha sido cerrado')
                    ->with('type-alert', 'warning');
        }
    }
}
