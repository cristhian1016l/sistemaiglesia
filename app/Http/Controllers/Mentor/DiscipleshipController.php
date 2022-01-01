<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Tabasi;
use App\Tabasidiscipulados;
use App\Tabdetasidiscipulados;
use App\Tabgrupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DiscipleshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $codarea = Tabgrupos::select('CodArea')->where('CodCon', Auth::user()->codcon)->where('TipGrup', 'D')->first();
        $discipleship = DB::select("SELECT * FROM tabasidiscipulados WHERE codarea = '".$codarea['CodArea']."' ORDER BY mes DESC, anio = YEAR(now()) DESC");
        $data = ['discipleship' => $discipleship];
        return view('mentor.discipleship.index', $data);
    }

    public function create($codasi){
        $validation = Tabasidiscipulados::select('activo')->where('codasi', $codasi)->first();
        if($validation['activo'] == 1){
            $codarea = Tabgrupos::select('CodArea', 'DesArea')->where('CodCon', Auth::user()->codcon)->where('TipGrup', 'D')->first();
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

    public function updateAssistance(Request $request){         
        if($request->codasi == ''){
            return response()->json(['code' => 500, 'msg' => 'CÓDIGO NO INGRESADO']);
        }
        if($request->fecha == ''){
            return response()->json(['code' => 500, 'msg' => 'INGRESE LA FECHA DEL DISCIPULADO']);
        }
        if($request->tema == ''){
            return response()->json(['code' => 500, 'msg' => 'INGRESE EL TEMA DEL DISCIPULADO']);
        }
        if($request->ofrenda == ''){
            return response()->json(['code' => 500, 'msg' => 'INGRESE LA OFRENDA DEL']);
        }

        $codarea = Tabgrupos::select('CodArea')->where('CodCon', Auth::user()->codcon)->where('TipGrup', 'D')->first();
        try{
            db::beginTransaction();
            if (strpos($request->codasi, $codarea['CodArea']) == true) {
                if(strlen($request->codasi) >= 11){
                    $findoffering = strpos($request->ofrenda, 'S/. ');
                    if($findoffering === false){}else{$request->ofrenda = substr($request->ofrenda, 4);}
                    DB::update('UPDATE tabasidiscipulados SET fecasi = ?, tema = ?, ofrenda = ?, testimonios = ?, observaciones = ? WHERE codasi = ?'
                                ,[$request->fecha, $request->tema, $request->ofrenda, $request->testimonios, $request->observaciones, $request->codasi]);
                    $tabsi = Tabasidiscipulados::findOrFail($request->codasi);
                    $tabsi->activo = 0;
                    $tabsi->save();                    
                        db::commit();
                    return response()->json(['code' => 200, 'msg' => 'INFORME DE DISCIPULADO REGISTRADO CORRECTAMENTE, USTED SERÁ REDIRIGIDO A LA LISTA DE INFORMES']);
                }else{
                    db::rollBack();
                    return response()->json(['code' => 500, 'msg' => 'NO INTENTE CAMBIAR EL CÓDIGO!!']);
                }
            }else{
                db::rollBack();
                return response()->json(['code' => 500, 'msg' => 'NO INTENTE CAMBIAR EL CÓDIGO']);
            }        
        }catch(\Exception $th){
            db::rollBack();
                return response()->json(['code' => 500, 'msg' => 'NO INTENTE CAMBIAR EL CÓDIGO']);
        }
    }

    public function updateAssistanceDisciple(Request $request){
        // return response()->json($request->all());
        $members = $request->miembros;
        try{      
            DB::update('UPDATE tabdetasidiscipulados set estasi=?, asistio=? WHERE codasi = ? AND codcon = ? ',['A',true,$request->codasi,$request->codcon]);
            DB::update("UPDATE tabasidiscipulados set totfaltas = totfaltas - 1, totasistencia = totasistencia + 1 WHERE codasi = '".$request->codasi."'");
            
            foreach ($members as &$miembro)
            {                    
                if ($miembro['codcon']==$request->codcon) {
                    $miembro['asistio'] = 1;
                    $miembro['estasi']= 'A';
                }
            }
            $detasi = $this->DetailsAssistance($request->codasi);
            return json_encode(["200", "miembros" => $members, "detasi" => $detasi]);
        }catch(\Exception $th){
            return response()->json(["error" => "500", "cod" => $th->getMessage()]);
        }
    }

    public function removeAssistanceDisciple(Request $request){
           
        $members = $request->miembros;
        try{      
            DB::update('UPDATE tabdetasidiscipulados set estasi=?, asistio=? WHERE codasi = ? AND codcon = ? ',['F',false,$request->codasi,$request->codcon]);
            DB::update("UPDATE tabasidiscipulados set totfaltas = totfaltas + 1, totasistencia = totasistencia - 1 WHERE codasi = '".$request->codasi."'");
            
            foreach ($members as &$miembro)
            {                    
                if ($miembro['codcon']==$request->codcon) {
                    $miembro['asistio'] = 0;
                    $miembro['estasi']= 'F';
                }
            }
            $detasi = $this->DetailsAssistance($request->codasi);
            return json_encode(["200", "miembros" => $members, "detasi" => $detasi]);
        }catch(\Exception $th){
            return response()->json(["error" => "500", "cod" => $th->getMessage()]);
        }
    }

    public function DetailsAssistance($codasi){
        $details = Tabasidiscipulados::select('totfaltas', 'totasistencia')->where('codasi', $codasi)->first();
        return $details;
    }
}
