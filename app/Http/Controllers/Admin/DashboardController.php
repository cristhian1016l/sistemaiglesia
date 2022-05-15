<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Tabasi;
use App\Tabcasasdepaz;
use App\Tabdetasi;
use App\Tabmimcaspaz;
use App\Tabredes;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getGraphicAssistance()
    {
        $data = DB::select("SELECT DATE(FecAsi) AS FecAsi, TotAsistencia FROM TabAsi WHERE CodAct = '002' ORDER BY FecAsi DESC LIMIT 7");
        return json_encode($data);
    }

    public function getGraphicAssistanceCultos()
    {
        $data = DB::select("SELECT DATE(FecAsi) AS FecAsi, TotAsistencia FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC LIMIT 3");
        return json_encode($data);
    }

    public function getGraphicAssistanceCultosXRed(Request $request)
    {
        // $codasi = Tabasi::select('CodAsi')->where('CodAct', '001')->OrderBy('FecAsi', 'DESC')->first();
        $asistencias_faltas = DB::select("SELECT 
                                        SUM(case when (da.EstAsi = 'A' OR da.EstAsi = 'T') and c.ID_Red = 4 then 1 else 0 end ) as asistencia_adonai,
                                        SUM(case when (da.EstAsi = 'A' OR da.EstAsi = 'T') and c.ID_Red = 2 then 1 else 0 end ) as asistencia_yeshua,
                                        SUM(case when (da.EstAsi = 'A' OR da.EstAsi = 'T') and c.ID_Red = 1 then 1 else 0 end ) as asistencia_emanuel,
                                        SUM(case when (da.EstAsi = 'A' OR da.EstAsi = 'T') and c.ID_Red = 5 then 1 else 0 end ) as asistencia_shadai,
                                        SUM(case when da.EstAsi = 'F' and c.ID_Red = 4 then 1 else 0 end ) as ausencia_adonai,
                                        SUM(case when da.EstAsi = 'F' and c.ID_Red = 2 then 1 else 0 end ) as ausencia_yeshua,
                                        SUM(case when da.EstAsi = 'F' and c.ID_Red = 1 then 1 else 0 end ) as ausencia_emanuel,
                                        SUM(case when da.EstAsi = 'F' and c.ID_Red = 5 then 1 else 0 end ) as ausencia_shadai FROM TabDetAsi da INNER JOIN TabCon c on da.CodCon = c.CodCon  WHERE da.CodAsi = '".$request->codasi."'");

        // <<<<<<<<<<<<<<<<<<  -------------------------- PERMISOS ACTUALES --------------------------
        // $permisos = DB::select("SELECT 
        //                         SUM(case when c.ID_Red = 4 then 1 else 0 end ) as permisos_adonai,
        //                         SUM(case when c.ID_Red = 2 then 1 else 0 end ) as permisos_yeshua,
        //                         SUM(case when c.ID_Red = 1 then 1 else 0 end ) as permisos_emanuel,
        //                         SUM(case when c.ID_Red = 5 then 1 else 0 end ) as permisos_shadai
        //                         FROM TabCon c INNER JOIN TabDocumentos d ON c.CodCon = d.CodCon 
        //                         INNER JOIN TabDetDocumentos dd ON d.NumReg = dd.NumReg WHERE dd.CodAct = '001'
        //                         AND c.EstCon = 'ACTIVO'");
        //  -------------------------- PERMISOS ACTUALES -------------------------- >>>>>>>>>>>>>>>>>>>>>>

        $permisos = DB::select("SELECT
                                SUM(case WHEN da.EstAsi = 'P' AND c.ID_Red = 4 THEN 1 ELSE 0 END ) AS permisos_adonai,
                                SUM(case WHEN da.EstAsi = 'P' AND c.ID_Red = 2 THEN 1 ELSE 0 END ) AS permisos_yeshua,
                                SUM(case WHEN da.EstAsi = 'P' AND c.ID_Red = 1 THEN 1 ELSE 0 END ) AS permisos_emanuel,
                                SUM(case WHEN da.EstAsi = 'P' AND c.ID_Red = 5 THEN 1 ELSE 0 END ) AS permisos_shadai FROM TabDetAsi da INNER JOIN TabCon c ON da.CodCon = c.CodCon WHERE da.CodAsi = '".$request->codasi."'");                                
        

        $asistencia = Tabdetasi::where('CodAsi', $request->codasi)->where('Asistio', 1)->count();
        $falta = Tabdetasi::where('CodAsi', $request->codasi)->where('EstAsi', 'F')->count();
        $data = ['asistencias' => $asistencias_faltas, 'permisos' => $permisos, 'asistencia' => $asistencia, 'falta' => $falta];
        return response()->json($data);
    }

    public function getGraphicMembersXRed()
    {
        $miembros = DB::select("SELECT 
                                SUM(CASE WHEN ID_Red = 1 THEN 1 ELSE 0 END ) AS emanuel,
                                SUM(CASE WHEN ID_Red = 2 THEN 1 ELSE 0 END ) AS yeshua,
                                SUM(CASE WHEN ID_Red = 4 THEN 1 ELSE 0 END ) AS adonai,
                                SUM(CASE WHEN ID_Red = 5 THEN 1 ELSE 0 END ) AS shadai FROM TabCon WHERE EstCon = 'ACTIVO'");
        $data = ['miembros' => $miembros];
        return response()->json($data);
    }

    public function reportAsisCultDownload($codasi)
    {        
        $asis = DB::select("SELECT FecAsi FROM TabAsi WHERE CodAsi='".$codasi."'");
        $redes = Tabredes::all();
        // $redes = Tabredes::all()->take(1);
        $full_data = array();
        $total_data = array();
        foreach($redes as $red){
            $cdps = DB::select("SELECT cdp.CodCasPaz, cdp.DirCasPaz, CONCAT(c.ApeCon,' ',c.NomCon) AS Nombres FROM TabCasasDePaz cdp INNER JOIN TabCon c ON cdp.CodLid = c.CodCon
                                WHERE cdp.ID_Red='".$red->ID_RED."' ORDER BY cdp.CodCasPaz");
            // dd($cdps);
            $total_members_network = 0;
            $total_members_assistances = 0;
            $total_members_faults = 0;
            $total_members_permissions = 0;
            foreach($cdps as $cdp){
                $total_members = DB::table('TabMimCasPaz AS m')
                                    ->join('TabDetAsi AS da', 'm.CodCon', '=', 'da.CodCon')
                                    ->where('m.CodCasPaz', $cdp->CodCasPaz)
                                    ->where('da.CodAsi', $codasi)->get();
                // $asistencias = $total_members->sum('Asistio');
                $asistencias = $total_members->where('Asistio', '=', 1); // OBTIENE EN UNA COLECCIÓN LOS DATOS DE LOS MIEMBROS QUE ASISTIERON
                $faltas = $total_members->where('Asistio', '=', 0); // OBTIENE EN UNA COLECCIÓN LOS DATOS DE LOS MIEMBROS QUE FALTARON
                $permisos = $total_members->where('EstAsi', '=', 'P'); // OBTIENE EN UNA COLECCIÓN LOS DATOS DE LOS MIEMBROS QUE TIENEN PERMISO                
                array_push($full_data, ['cdp' => $cdp->CodCasPaz, 'direccion' => $cdp->DirCasPaz, 'lider' => $cdp->Nombres, 'total_miembros' => count($total_members), 
                                        'asistencias' => count($asistencias), 'faltas' => count($faltas)-count($permisos), 'permisos' => count($permisos), 
                                        'id_red' => $red->ID_RED]);
                $total_members_network = $total_members_network + count($total_members);
                $total_members_assistances = $total_members_assistances + count($asistencias);
                $total_members_faults = $total_members_faults + count($faltas)-count($permisos);
                $total_members_permissions = $total_members_permissions + count($permisos);
            }
            array_push($total_data, ['total_miembros_red' => $total_members_network, 
                                    'total_miembros_asistencias' => $total_members_assistances,
                                    'total_miembros_faltas' => $total_members_faults,
                                    'total_miembros_permisos' => $total_members_permissions,
                                    'nombre_red' => $red->NOM_RED,
                                    'fecha' => $asis[0]->FecAsi,
                                    'id_red' => $red->ID_RED]);
        }
        // dd($total_data);
        $data = ['redes' => collect($total_data), 'detalles' => collect($full_data)];
        $pdf=PDF::loadView('admin.reports.asistencia_culto_xcdp', $data);
        // $pdf=PDF::loadView('admin.reports.asistencia_culto_xcdp');
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function reportAsisCultLideresDownload($codasi)
    {        
        // dd($codasi);
        $fecasi = DB::select("SELECT FecAsi FROM TabAsi WHERE CodAct = '001' OR CodAct = '012' ORDER BY FecAsi DESC LIMIT 1");
        $fecha_culto = date('Y-m-d', strtotime($fecasi[0]->FecAsi));
        $discipulosArray = array();
        $grupos = DB::select("SELECT CodArea, DesArea FROM TabGrupos WHERE TipGrup = 'D' ORDER BY CodArea LIMIT 1");
        foreach($grupos as $key => $gp){            
            $i = 0;
            $discipulos = DB::select("SELECT c.CodCon, c.ApeCon, c.NomCon, gm.CarDis, gm.CodArea FROM TabGruposMiem gm INNER JOIN TabCon c ON
                                    gm.CodCon = c.CodCon WHERE CodArea = '".$gp->CodArea."' AND CarDis 
                                    in('MENTOR', 'LIDER CDP', 'SUBLIDER CDP')  ORDER BY c.ApeCon");        
            $asisCulto = array();
            $asisTarCont = 0;
            foreach($discipulos as $keyDis => $ms){

                $asistenciaCulto = DB::select("SELECT a.TipAsi, da.Asistio, da.EstAsi, da.HorLlegAsi, da.Motivo FROM TabAsi a INNER JOIN TabDetAsi da ON a.CodAsi = da.CodAsi
                                            WHERE a.FecAsi = '".$fecha_culto."' AND da.CodCon = '".$ms->CodCon."' AND ( CodAct = '001' OR CodAct = '012')");
                
                foreach($asistenciaCulto as $ac){
                    if($ac->EstAsi == 'F' || $ac->EstAsi == 'T'){
                        $i++;
                        $asisTarCont++;
                        array_push($asisCulto, [
                            'TipAsi' => $ac->TipAsi,
                            'EstAsi' => $ac->EstAsi,
                            'HorLlegAsi' => $ac->HorLlegAsi,    
                            'Motivo' => $ac->Motivo,
                        ]);
                    }
                }

                if($asisTarCont > 0){
                    array_push($discipulosArray, [
                        'NomApeCon' => $ms->ApeCon.' '.$ms->NomCon,                        
                        'CodArea' => $gp->CodArea,
                        'CarDis' => $ms->CarDis,                        
                        'asistencias' => $asisCulto
                    ]);
                }

                $asisCulto = [];
                $asisTarCont = 0;

            }
            if($i==0){
                unset($grupos[$key]);
            }
        }

        $data = ['discipulados' => $grupos, 'discipulos' => collect($discipulosArray), 'fecha' => $fecha_culto];
        // dd($data);
        $pdf=PDF::loadView('admin.reports.asistencia_culto_lideres', $data);
        return $pdf->stream();
    }
}
