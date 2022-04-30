<?php

namespace App\Http\Controllers\Liderred;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Tabasi;
use App\Tabcasasdepaz;
use App\Tabredes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reportAsisCultXCDPDownload($codcaspaz){    

        $cdp = Tabcasasdepaz::where('CodCasPaz', $codcaspaz)->first();
        $cdpylider = DB::select("SELECT c.NomCon, c.ApeCon FROM TabCasasDePaz cdp INNER JOIN TabCon c ON cdp.CodLid = c.CodCon WHERE CodCasPaz = '".$codcaspaz."'");
        $asistencias = DB::select("SELECT CodAsi, FecAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC LIMIT 5");
        $members = DB::select("SELECT c.CodCon, c.ApeCon, c.NomCon, c.NumCel, c.FecReg
                                    FROM TabMimCasPaz m INNER JOIN TabCon c ON m.CodCon = c.CodCon
                                    WHERE m.CodCasPaz = '".$codcaspaz."'");
        $miembros = array();
        foreach($members as $member){

            $vuelta = 0;     
            $faltas = 0;  
            $datosvuelta[0] = 'N';
            $datosvuelta[1] = 'N';
            $datosvuelta[2] = 'N';
            $datosvuelta[3] = 'N';
            $datosvuelta[4] = 'N';

            foreach($asistencias as $asistencia){
                $SQLAsistencias = DB::select("SELECT EstAsi, Asistio FROM TabDetAsi WHERE CodAsi = ".$asistencia->CodAsi." AND CodCon = '".$member->CodCon."'");

                foreach($SQLAsistencias as $sa){ //RECORRE TODOS LOS DETALLES DE ASISTENCIAS AL CULTO
                    switch($vuelta){
                        case 0:
                            $datosvuelta[0] = $sa->EstAsi;
                            break;
                        case 1:
                            $datosvuelta[1] = $sa->EstAsi;
                            break;
                        case 2:
                            $datosvuelta[2] = $sa->EstAsi;
                            break;
                        case 3:
                            $datosvuelta[3] = $sa->EstAsi;
                            break;
                        case 4:
                            $datosvuelta[4] = $sa->EstAsi;
                            break;
                    }
                    if($sa->EstAsi == 'F'){
                        $faltas++;
                    }             
                }         
                $vuelta++;                                                    
            }
            array_push($miembros, ['CodCon' => $member->CodCon,
                                        'Nombrescomp' => $member->ApeCon.' '.$member->NomCon, 'NumCel' => $member->NumCel,
                                        'asis1' => $datosvuelta[0], 'asis2' => $datosvuelta[1], 'asis3' => $datosvuelta[2],
                                        'asis4' => $datosvuelta[3], 'asis5' => $datosvuelta[4], 'faltas' => $faltas]);
        }

        $data = ['asistencias' => $asistencias, 'cdp' => $codcaspaz.' - '.$cdpylider[0]->ApeCon.' '.$cdpylider[0]->NomCon, 'members' => $miembros];
        // dd($data);
        $pdf=PDF::loadView('liderred.reports.asistencia_cultos_xcdp', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function weekReportCDP(){

        $datos = array();
        $datosCulto = array();
        $datosRed = Tabredes::where('LID_RED', Auth::user()->codcon)->first();
        $liderred = DB::select("SELECT ApeCon, NomCon FROM TabCon WHERE CodCon = '".$datosRed->LID_RED."'");
        // $CDPs = Tabcasasdepaz::where('ID_Red', $datosRed->ID_RED)->get();        

        // $CDPs = Tabcasasdepaz::join('TabCon', 'TabCasasDePaz.CodLid', '=', 'TabCon.CodCon')
        //         ->get(['TabCasasDePaz.CodCasPaz', 'TabCon.ApeCon', 'TabCon.NomCon', 'TabCasasDePaz.ID_Red'])
        //         ->where('TabCasasDePaz.ID_Red', $datosRed->ID_RED)
        //         ->take(2);
        
        $CDPs = DB::select("SELECT cdp.CodCasPaz, c.ApeCon, c.NomCon, cdp.ID_Red FROM TabCasasDePaz cdp INNER JOIN TabCon c
                            ON cdp.CodLid = c.CodCon WHERE cdp.ID_Red = '".$datosRed->ID_RED."'");
        
        $fecCulto = Tabasi::select('FecAsi')->where('CodAct', '001')->OrderBy('FecAsi', 'desc')->first();        
        $miembros = array();
        foreach($CDPs as $cdp){

            $members = DB::select("SELECT c.CodCon, c.ApeCon, c.NomCon FROM TabMimCasPaz mcdp INNER JOIN TabCon c ON
                                    mcdp.CodCon = c.CodCon WHERE mcdp.CodCasPaz = '".$cdp->CodCasPaz."' ORDER BY ApeCon ASC");
                        
            foreach($members as $key=>$member){
                $asistio = 'FALTO';
                $asistenciaCulto = DB::select("SELECT da.Asistio, da.EstAsi FROM TabAsi a INNER JOIN TabDetAsi da ON a.CodAsi = da.CodAsi 
                                            WHERE a.FecAsi = '".$fecCulto->FecAsi."' AND da.CodCon = '".$member->CodCon."' AND CodAct = '001'");
                // dd($fecCulto->FecAsi);
                foreach($asistenciaCulto as $ac){
                    
                    if($ac->EstAsi == 'P'){
                        $asistio = 'PERMISO';
                    }else{
                        if($ac->Asistio == 1){
                            $asistio = 'ASISTIO';
                        }
                    }
                    
                }
                array_push($miembros, ["miembro" => $member, "asistencias" => $asistio]);
            }    

            array_push($datos, ['cdp' => $cdp->CodCasPaz, 'lider' => $cdp->ApeCon.' '.$cdp->NomCon, 'miembros' => $miembros]);
        }                        

        $data = ['datos' => collect($datos), 'red' => $datosRed->NOM_RED,'liderred' => $liderred[0]];
// dd($data);
        $pdf=PDF::loadView('liderred.reports.reporte_semanal_cdp', $data);        
        return $pdf->stream();
    }
}
