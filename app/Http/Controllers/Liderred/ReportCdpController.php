<?php

namespace App\Http\Controllers\Liderred;

use App\Http\Controllers\Controller;
use App\Tabcasasdepaz;
use App\TabDetInfCas;
use App\Tabredes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class ReportCdpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_records(Request $request){
        $cdp = $this->get_cdps($request->week);
        $foul = collect($cdp)->whereIn('Enviado', 0)->count();
        return response()->json(['cdps'=>$cdp, 'foul' => $foul]);
    }

    public function get_cdps($week){
        $cdp = DB::select('SELECT NumInf, CodCasPaz, FecInf, TotAsiReu, TotAusReu,
                        OfreReu, TemSem, Enviado FROM TabInfCaspaz WHERE NumSem = '.$week.' 
                        AND Anio = '.date("Y").' ORDER BY FecInf ASC');
        return $cdp;
    }

    public function show_cdps(Request $request){
        // return response()->json($request->all());
        $year = date("Y");
        $week = $request->week;
        $datosRed = Tabredes::where('LID_RED', Auth::user()->codcon)->first();

        $selectCdps = DB::select("SELECT CodCasPaz FROM TabInfCaspaz WHERE numsem = ".$week." AND Anio = ".$year);

        $listnow = [];
        foreach($selectCdps as $md){
            array_push($listnow, $md->CodCasPaz);
        }

        $cpds = Tabcasasdepaz::select('CodCasPaz')->where('ID_Red', $datosRed->ID_RED)->get();
        $activelist = [];
        foreach($cpds as $md){
            array_push($activelist, $md->CodCasPaz);
        }

        $diffAdd = array_diff($activelist, $listnow);
        $cdps_fauls = [];

        foreach($diffAdd as $ds){
            // $member = DB::select("SELECT codcon, nomapecon, amount1, amount2, amount3, amount4 FROM manage_details WHERE codcon='$ds' AND manage_id = $request->manage_id LIMIT 1");
            $groups = Tabcasasdepaz::select('TabCasasDePaz.CodCasPaz', 'TabCon.ApeCon', 'TabCon.NomCon')
                                ->join('TabCon', 'TabCasasDePaz.CodLid', '=', 'TabCon.CodCon')
                                ->where('TabCasasDePaz.CodCasPaz', $ds)
                                ->first();
            array_push($cdps_fauls, $groups);
        }

        return response()->json($cdps_fauls);
    }
    public function add_cdp(Request $request){
        // return response($request->all());
        $cdps = $request->cdps;
        $week = $request->week;
        try{
            DB::beginTransaction();
            foreach($cdps as $cdp){

                $det_members = DB::select("SELECT c.CodCon, c.ApeCon, c.NomCon FROM TabMimCasPaz m 
                                            INNER JOIN TabCon c ON m.CodCon = c.CodCon WHERE m.CodCasPaz ='".$cdp."'");

                // $date = \Carbon\Carbon::now();
                // $codasi = $date->format('d').$request->month.$request->year.$cdp;                

                DB::insert('insert into TabInfCaspaz (CodCasPaz, FecInf, NumSem, Anio, ReuSiNo, TotAsiReu, TotAusReu, OfreReu, TemSem, Enviado) 
                            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                            [$cdp, null, $week, date("Y"), 0, 0, count($det_members), null, null, 0]);
                $id = DB::getPdo()->lastInsertId();
                $this->InsertDetAsiCdp($id, $det_members);  
            }            
            DB::commit();
            return response()->json(['msg' => 'Registro creado exitosamente']);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json($th->getMessage());
        }
    }
    public function InsertDetAsiCdp($id, $miembros){
        foreach($miembros as $miembro){
            $tabdetasi = new TabDetInfCas();
            $tabdetasi->NumInf = $id;
            $tabdetasi->CodCon = $miembro->CodCon;
            $tabdetasi->NomCon = $miembro->NomCon;
            $tabdetasi->ApeCon = $miembro->ApeCon;
            $tabdetasi->TipCon = '';            
            $tabdetasi->EstAsi = 'F';
            $tabdetasi->AsiReu = false;
            $tabdetasi->save();
        }
    }
    public function close_cdp(Request $request){
        try{            
            DB::update('UPDATE TabInfCaspaz SET enviado = ? WHERE NumInf = ?',['1', $request->numinf]);
            $cdp = $this->get_cdps($request->week);
            return response()->json(['cdps'=>$cdp, 'msg'=>'Acción concretada correctamente']);
        }catch(\Exception $th){
            return response()->json($th->getMessage());
        }     
    }
    public function open_cdp(Request $request){
        try{            
            DB::update('UPDATE TabInfCaspaz SET enviado = ? WHERE NumInf = ?',['0', $request->numinf]);
            $cdp = $this->get_cdps($request->week);
            return response()->json(['cdps'=>$cdp, 'msg'=>'Acción concretada correctamente']);
        }catch(\Exception $th){
            return response()->json($th->getMessage());
        }     
    }

    public function reportDownload($numinf){
        $asistencias = TabDetInfCas::where('NumInf', $numinf)->OrderBy('ApeCon')->get();
        $asis = DB::select("SELECT * FROM TabInfCasPaz WHERE NumInf = '".$numinf."'");
        $data = ['asistencias' => $asistencias, 'asis' => $asis];
        $pdf=PDF::loadView('liderred.reports.informe_cdp', $data);
        return $pdf->stream();
    }
}
