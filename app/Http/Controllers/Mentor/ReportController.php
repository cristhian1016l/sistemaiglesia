<?php

namespace App\Http\Controllers\mentor;

use App\Http\Controllers\Controller;
use App\Tabasi;
use App\Tabgrupos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }    

    public function show_assistance(){

        $codarea = Tabgrupos::select('CodArea')->where('CodCon', Auth::user()->codcon)->where('TipGrup', 'D')->first();
        $asistencia = DB::table('TabAsi')
                    ->select('CodAsi', 'FecAsi', 'TipAsi', 'HorDesde', 'HorHasta')
                    ->where('FecAsi', date('Y-m-d'))
                    ->where('CodAct', '002')
                    ->first();            
        if($asistencia!=null){
            $detasiCol = DB::select("SELECT da.CodAsi, da.CodCon, da.NomApeCon, da.HorLlegAsi, da.EstAsi, da.Asistio FROM TabDetAsi da
            INNER JOIN TabGruposMiem gm ON da.CodCon = gm.CodCon WHERE gm.CodArea = '".$codarea->CodArea."' AND 
            da.CodAsi = '".$asistencia->CodAsi."' ORDER BY NomApeCon");   
            $data = ['asistencia' => $asistencia, 'detasi' => $detasiCol, 'status' => 'fill'];
            return view('mentor.assistance.registerAssistance', $data);
        }else{
            $data = ['status' => 'null', 'detasi' => null];
            return view('mentor.assistance.registerAssistance', $data);
        }        
    }
    
    public function updateAssistanceDisciple(Request $request)
    {      
        // return response()->json($request->miembros);        
        $members = $request->miembros;
        try{
            // $fecha = Carbon::now()->format("h:m:s");
            $fecha = Carbon::now();           
            $asis = DB::table('TabDetAsi')
                ->select('Asistio')
                ->where('CodAsi', $request->codasi)
                ->where('CodCon', $request->codcon)
                ->first();
            if($asis->Asistio == 1){
                return response()->json(["state" => "OK"]);
            }else{  
                DB::update('UPDATE TabDetAsi set HorLlegAsi = ?, EstAsi=?, Asistio=? WHERE CodAsi = ? AND CodCon = ? ',[$fecha,'A',true,$request->codasi,$request->codcon]);
                DB::update("UPDATE TabAsi set TotFaltas = TotFaltas - 1, TotAsistencia = TotAsistencia + 1 WHERE CodAsi = '".$request->codasi."'");
                
                foreach ($members as &$miembro)
                {                    
                    if ($miembro['CodCon']==$request->codcon) {
                        $miembro['Asistio'] = 1;
                        $miembro['EstAsi']= 'A';
                        $miembro['HorLlegAsi']= Carbon::parse(Carbon::now())->format("h:i:d A");
                    }
                }
                return json_encode(["200", "miembros" => $members]);
                // return response()->json('200');
            }            
        }catch(\Exception $th){
            return response()->json(["error" => "500", "cod" => $th->getMessage()]);
            // return response()->json('500');
        }        
    }

    public function removeAssistanceDisciple(Request $request)
    {       
        $members = $request->miembros; 
        try{
            // $fecha = Carbon::now()->format("h:m:s");
            $asis = DB::table('TabDetAsi')
                ->select('Asistio')
                ->where('CodAsi', $request->codasi)
                ->where('CodCon', $request->codcon)
                ->first();
            if($asis->Asistio == 0){
                return response()->json(["state" => "OK"]);
            }else{  
                DB::update('UPDATE TabDetAsi set HorLlegAsi = ?, EstAsi=?, Asistio=? WHERE CodAsi = ? AND CodCon = ? ',[null,'F',false,$request->codasi, $request->codcon]);
                DB::update("UPDATE TabAsi set TotFaltas = TotFaltas + 1, TotAsistencia = TotAsistencia - 1 WHERE CodAsi = '".$request->codasi."'");
                foreach ($members as &$miembro)
                {                    
                    if ($miembro['CodCon']==$request->codcon) {
                        $miembro['Asistio'] = 0;
                        $miembro['EstAsi']= 'F';
                        $miembro['HorLlegAsi']= null;
                    }
                }
                return json_encode(["200", "miembros" => $members]);
            }            
        }catch(\Exception $th){
            return response()->json(["error" => "500", "cod" => $th->getMessage()]);
            // return response()->json('500');
        }        
    }

    // public function getNumberAssistance($CodCasPaz){        
                
    //     $ExistsAsisToday = DB::table('TabAsi')->where('FecAsi', date('Y-m-d'))->first();
    //     if($ExistsAsisToday){
    //         $detasiCol = DB::table('TabDetAsi')
    //                         ->join('TabMimCasPaz', 'TabDetAsi.CodCon','TabMimCasPaz.CodCon')
    //                         ->join('TabAsi', 'TabAsi.CodAsi','TabDetAsi.CodAsi')
    //                         ->where('TabAsi.FecAsi', date('Y-m-d'))
    //                         ->where('TabAsi.CodAct', '002')
    //                         ->where('TabMimCasPaz.CodCasPaz', $CodCasPaz)
    //                         ->get();
            
    //         $FilterAssistance = count($detasiCol->where('EstAsi', 'A'));
    //         $filterFoul = count($detasiCol->where('EstAsi', 'T'));
    //         $assistance = $FilterAssistance+$filterFoul;
    //         $filterDelay = count($detasiCol->where('EstAsi', 'F'));

    //         return response()->json(["status" => "200", "asistencia" => $assistance, "falta" => $filterDelay]);
    //     }else{
    //         return response()->json(["status" => "404"]);
    //     }        
    // }
}
