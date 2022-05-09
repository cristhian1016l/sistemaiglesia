<?php

namespace App\Http\Controllers\Liderred;

use App\Http\Controllers\Controller;
use App\Tabredes;
use App\Tabasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function FaultsOfMemberDownload(Request $request){
        // 070420220838
        $datosRed = Tabredes::select('ID_RED')->where('LID_RED', Auth::user()->codcon)->first();        
        $id_red = $datosRed->ID_RED;
        $datos = array();
        // $fecCulto = Tabasi::select('FecAsi')->where('CodAct', '001')->OrderBy('FecAsi', 'desc')->first();
        $fecCulto = $request->culto;
        $cdps = DB::select("SELECT cdp.CodCasPaz, c.ApeCon, c.NomCon FROM TabCasasDePaz cdp INNER JOIN TabCon c 
                            ON cdp.CodLid = c.CodCon WHERE cdp.ID_Red = '".$id_red."' AND CodCasPaz = 'CP0155' ORDER BY cdp.CodCasPaz");
        
        $miembros = array();
        // dd($cdps);
        foreach($cdps as $key => $cdp){
            // $cdps = DB::select("SELECT da.NomApeCon, da.EstAsi, c.NumCel FROM TabDetAsi da
            //                 INNER JOIN TabMimCasPaz mcdp ON da.CodCon = mcdp.CodCon
            //                 INNER JOIN TabCon c ON mcdp.CodCon = c.CodCon
            //                 WHERE da.CodAsi = '".$request->culto."' AND mcdp.CodCasPaz = '".$cdp->CodCasPaz."' AND da.EstAsi = 'F' ORDER BY da.NomApeCon");

            $members = DB::select("SELECT c.CodCon, c.ApeCon, c.NomCon, c.TipCon, c.SoloCasPaz FROM TabMimCasPaz mcdp INNER JOIN TabCon c ON mcdp.CodCon = c.CodCon
                                    WHERE mcdp.CodCasPaz = '".$cdp->CodCasPaz."'");
            
            foreach($members as $member){
                $asistenciaCulto = DB::select("SELECT da.Asistio, da.EstAsi FROM TabAsi a INNER JOIN TabDetAsi da ON a.CodAsi = da.CodAsi
                                            WHERE a.FecAsi = '".$fecCulto."' AND da.CodCon = '".$member->CodCon."' AND CodAct = '001'");
                
                $faltas = 0;
                for($i = 0; $i < count($asistenciaCulto); $i++){
                    if($asistenciaCulto[$i]->EstAsi == "F"){
                        $faltas = $faltas + 1;    
                    }
                }
                // dd("FASF ".$faltas);
                if($faltas > 1){
                    array_push($miembros, ["miembro" => $member]);
                }                
            }

            array_push($datos, ["cdp" => $cdp->CodCasPaz, "lider" => $cdp->ApeCon.' '.$cdp->NomCon, "members" => $miembros]);            

            $miembros = [];
        }

        foreach($datos as $key=>$dato){
            if(count($datos[$key]['members']) < 1){
                unset($datos[$key]);
            }
        }
        
        $data = ['cdps' => $datos];
        $pdf=PDF::loadView('liderred.reportes_cdp.faultToCults', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

}
