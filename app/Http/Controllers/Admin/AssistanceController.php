<?php

namespace App\Http\Controllers\Admin;

use App\Faltascultocp;
use App\Faltascultods;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tabactmes;
use App\Tabasi;
use App\TabDocumentos;
use App\Tabgrupos;
use App\TabTempOracion;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use SebastianBergmann\Environment\Console;

class AssistanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function obtenerAsistencia()
    {
        return view('admin.asistencia.index');
    }

    public function obtenerActividadesMensuales($act)
    {        
        $fecha = substr($act, 0, 4).'-'.substr($act, 4, 2).'-'.substr($act, 6, 8);
        
        $actividades = DB::table('TabActMes')
                        ->select('DesAct', 'LugAct', 'CodActMes')
                        ->where('FecAct', $fecha)
                        ->where('EstReg', 'V')
                        ->get();
        return response()->json($actividades);
    }    

    public function obtenerAsistenciasPrevias($fec)
    {        
        $fecha = substr($fec, 0, 4).'-'.substr($fec, 4, 2).'-'.substr($fec, 6, 8);
                
        $actividades = DB::table('TabAsi')
                        ->select('CodAsi', 'TipAsi')
                        ->where('FecAsi', $fecha)
                        ->get();

        return response()->json($actividades);
    }

    public function obtenerFaltasDeDiscipulosAOracion($fec)
    {        
        $fecha = substr($fec, 0, 4).'-'.substr($fec, 4, 2).'-'.substr($fec, 6, 8);
        $actividades = DB::table('TabAsi')
                        ->select('CodAsi', 'TipAsi', 'CodAct')
                        ->where('FecAsi', $fecha)
                        ->orderBy('CodAct', 'DESC')
                        ->get();
        if(isset($actividades[0]))
        {
            if($actividades[0]->CodAct != '002')
            {
                return response()->json(['cod' => 1, 'msg' => 'La tabla se mostrará cuando la actividad sea de oración']);
            }else{
                $discipulados = DB::select("SELECT CodArea, DesArea FROM TabGrupos WHERE TipGrup = 'D'");
                $dis = array();
                foreach($discipulados as $ds)
                {
                    array_push($dis, ['CodArea' => $ds->CodArea, 'DesArea' => $ds->DesArea]);
                }
                $i = 0;
                foreach($discipulados as $ds)
                {
                    $discipulos = DB::select("SELECT CodCon FROM TabGruposMiem WHERE CodArea = '".$ds->CodArea."'");
                        foreach($discipulos as $dsl)
                        {
                            $verificar = DB::select("SELECT Asistio FROM TabDetAsi WHERE CodAsi = '".$actividades[0]->CodAsi."' AND CodCon = '".$dsl->CodCon."'");
                            if(isset($verificar[0]->Asistio))
                            {
                                if($verificar[0]->Asistio == 1)
                                {
                                    unset($dis[$i]);
                                };
                            }                        
                        }
                    $i++;
                }
                return response()->json(['cod' => 200, 'datos' => $dis]);
            }
        }else{
            return response()->json(['cod' => 500]);
        }        
    }  

    public function procesarFaltasDiscipulados($codasi)
    {
        Faltascultods::truncate();        

        $fecCulto = DB::select("SELECT CodAsi, FecAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC LIMIT 1");        

        try{
            DB::beginTransaction();

            $discipulados = Tabgrupos::where('TipGrup', 'D')->get();
            foreach($discipulados as $discipulado)
            {
                $miembrosGrupo = DB::select("SELECT c.CodCon, CONCAT(c.ApeCon, ' ', c.NomCon), gm.CarDis 
                                            FROM TabGruposMiem gm INNER JOIN TabCon c ON gm.CodCon = c.CodCon 
                                            WHERE CodArea = '".$discipulado->CodArea."'  ORDER BY c.ApeCon");

                foreach($miembrosGrupo as $mg)
                {

                    $asistenciaCulto = DB::select("SELECT da.CodCon, da.NomApeCon, da.Asistio, da.EstAsi, da.Motivo
                                                FROM TabAsi a INNER JOIN TabDetAsi da ON a.CodAsi = da.CodAsi
                                                WHERE a.FecAsi = '".$fecCulto[0]->FecAsi."' AND da.CodCon = '".$mg->CodCon."' AND (a.CodAct = '001' OR a.CodAct = '012')");

                    if(count($asistenciaCulto) > 0)
                    {
                        $faltas = 0;
                        for($i = 0; $i < count($asistenciaCulto); $i++){
                            if($asistenciaCulto[$i]->EstAsi == "F"){
                                $faltas = $faltas + 1;    
                            }
                        }
                        // dd("FASF ".$faltas);
                        if($faltas > count($asistenciaCulto)-1){
                            $this->InsertFaltasCultoDs($discipulado->CodArea, 
                                                        $mg->CodCon, 
                                                        $discipulado->DesArea, 
                                                        $asistenciaCulto[0]->NomApeCon, 
                                                        $mg->CarDis, 
                                                        $asistenciaCulto[0]->Motivo);
                        }                                    
                    }
                    
                }                                
            }            

            $fecha = Tabasi::select('FecAsi')->where('CodAsi', $codasi)->first();
            
            DB::commit();
            return response()->json(['code' => 200]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json(['code' => 500]);
        }        
    }

    public function procesarFaltasACdp($codasi)
    {        
        Faltascultocp::truncate();

        $fecCulto = DB::select("SELECT FecAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC LIMIT 1");

        try{
            DB::beginTransaction();
            $SQLCPs = DB::select("SELECT cdp.CodCasPaz, cdp.CodLid FROM TabCasasDePaz cdp 
                            INNER JOIN TabCon c ON cdp.CodLid = c.CodCon ORDER BY c.ApeCon ASC");
            foreach($SQLCPs as $cp)
            {
                $SQLMiembros = DB::select("SELECT m.CodCon FROM TabMimCasPaz m INNER JOIN TabCon c ON
                                        m.CodCon = c.CodCon WHERE m.CodCasPaz = '".$cp->CodCasPaz."' ORDER BY c.ApeCon");

                $SQLLiderCP = DB::select("SELECT CONCAT(ApeCon, ' ', NomCon) as nombres FROM TabCon WHERE
                                        CodCon ='".$cp->CodLid."'");
                foreach($SQLMiembros as $ms)
                {

                        $asistenciaCulto = DB::select("SELECT da.CodCon, da.NomApeCon, da.Asistio, da.EstAsi, da.Motivo
                                                FROM TabAsi a INNER JOIN TabDetAsi da ON a.CodAsi = da.CodAsi
                                                WHERE a.FecAsi = '".$fecCulto[0]->FecAsi."' AND da.CodCon = '".$ms->CodCon."' AND (a.CodAct = '001' OR a.CodAct = '012')");
                        if(count($asistenciaCulto) != 0)
                        {
                            $faltas = 0;
                            for($i = 0; $i < count($asistenciaCulto); $i++)
                            {
                                if($asistenciaCulto[$i]->EstAsi == "F")
                                {
                                    $faltas = $faltas + 1;    
                                }
                            }
                            // dd("FASF ".$faltas);
                            if($faltas > count($asistenciaCulto)-1)
                            {
                                $this->InsertFaltasCultoCp($cp->CodCasPaz, 
                                                            $cp->CodLid, 
                                                            $SQLLiderCP[0]->nombres, 
                                                            $asistenciaCulto[0]->CodCon, 
                                                            $asistenciaCulto[0]->NomApeCon);                                
                            }        
                        }                        

                }
            }

            $fecha = Tabasi::select('FecAsi')->where('CodAsi', $codasi)->first();
            $permisosEsporadicos = DB::select("SELECT * FROM TabDocumentos d INNER JOIN TabDetDocumentos dd ON d.NumReg = dd.NumReg
                                    WHERE dd.CodAct = '001' AND d.Estado = true AND ('".$fecha['FecAsi']."' BETWEEN d.FecIniReg AND d.FecFinReg)");
            
            foreach($permisosEsporadicos as $perm)
            {
                $find = Faltascultocp::where('Codcon', $perm->CodCon)->delete();
            }


            $permisosConstantes = DB::select("SELECT d.CodCon, d.Motivo FROM TabDocumentos d INNER JOIN TabDetDocumentos dd ON d.NumReg = dd.NumReg
                                            WHERE dd.CodAct = '001' AND PerCon = 1 AND d.Estado = true");

            foreach($permisosConstantes as $pc)
            {
                $find = Faltascultocp::where('CodCon', $pc->CodCon)->delete();
            }

            DB::commit();
            return response()->json(['code' => 200]);
        }catch(\Exception $th)
        {
            DB::rollBack();
            return response()->json(['code' => 500]);
        }
    }

    public function procesarAsistenciasDeOracion($codasi)
    {        
        $fec = Tabasi::select('FecAsi')->where('CodAsi', $codasi)->first();        
        $fecha = $fec['FecAsi'];        
        $dia   = substr($fecha,8,2);
        $mes = substr($fecha,5,2);
        $anio = substr($fecha,0,4); 
        $semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));
        $fechas = $this->getStartAndEndDate($semana, $anio);
        $inicioSemana = $fechas['week_start'];
        $finSemana = $fechas['week_end'];
        TabTempOracion::truncate();
        $grupos = DB::select("SELECT CodArea, DesArea FROM TabGrupos WHERE TipGrup = 'D' ORDER BY CodArea");
        try{
            DB::beginTransaction();
            foreach($grupos as $gp)
            {
                $miembros = DB::select("SELECT c.CodCon, c.ApeCon, c.NomCon FROM TabGruposMiem gm INNER JOIN TabCon c ON
                                        gm.CodCon = c.CodCon WHERE CodArea = '".$gp->CodArea."'  ORDER BY c.ApeCon");
                foreach($miembros as $ms)
                {            
                    try{                        
                        $this->InsertPrayerProcess($inicioSemana, $finSemana, $ms->CodCon, $ms->ApeCon, $ms->NomCon, $gp->CodArea);
                    }catch(\Exception $th)
                    {
                        DB::rollBack();
                        return response()->json($th->getMessage());
                    }
                }
            }
        }catch(\Exception $th)
        {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
        DB::commit();
        return response()->json(['code' => 200]);
    }    

    public function imprimirReporteDeOracion()
    {
        $discipulos = DB::select("SELECT t.CodArea, t.CodCon, t.NomCon, t.ApeCon, t.Lunes, t.Martes, t.Miercoles, t.Jueves, t.Viernes,
                                t.Sabado, t.Domingo, t.NumAsi, t.TotAsi, g.DesArea, g.EncArea, g.TipGrup FROM TabTempOracion t INNER JOIN
                                TabGrupos g ON t.CodArea = g.CodArea ORDER BY t.CodArea, t.ApeCon ASC");
        $discipulados = DB::select("SELECT * FROM TabGrupos WHERE TipGrup = 'D'");
        $data = ['discipulos' => $discipulos, 'discipulados' => $discipulados];
        $pdf=PDF::loadView('admin.reports.oracion_discipulados', $data);
        return $pdf->stream();
    }

    // MÉTODOS ADICIONALES

    public function InsertFaltasCultoDs($codarea, $codcon, $desarea, $nombrescomp, $cargo, $motivo)
    {
        $tabla_temporal = new Faltascultods();
        $tabla_temporal->CodArea = $codarea;
        $tabla_temporal->CodCon = $codcon;
        $tabla_temporal->DesArea = $desarea;
        $tabla_temporal->Nombrescomp = $nombrescomp;
        $tabla_temporal->Cargo = $cargo;
        $tabla_temporal->Motivo = substr($motivo, 0, 98);
        $tabla_temporal->save();
    }

    public function InsertFaltasCultoCp($codcaspaz, $codlid, $nombreslid, $codcon, $nombrescomp)
    {
        $tabla_temporal_cp = new Faltascultocp();
        $tabla_temporal_cp->Codcaspaz = $codcaspaz;
        $tabla_temporal_cp->Codlid = $codlid;
        $tabla_temporal_cp->Nombreslid = $nombreslid;
        $tabla_temporal_cp->Codcon = $codcon;
        $tabla_temporal_cp->Nombrescomp = $nombrescomp;
        $tabla_temporal_cp->save();
    }

    public function InsertPrayerProcess($FecIniPar, $FecFinPar, $codcon, $apecon, $nomcon, $codarea)
    {
        $datos = array();
        $SQLOracion = DB::select("SELECT da.CodCon, da.NomApeCon, a.FecAsi, da.Asistio  FROM TabAsi a INNER JOIN 
                                TabDetAsi da ON a.Codasi = da.CodAsi WHERE a.FecAsi BETWEEN '".$FecIniPar."' AND 
                                '".$FecFinPar."' AND a.CodAct = '002' AND da.CodCon = '".$codcon."' ORDER BY a.FecAsi");
        $vueltaFinal = 0;
        $vueltaFinal = count($SQLOracion);

        $NumAsi = 0;
        $vuelta = 1;
        $datos[0] = "";
        $datos[1] = "";
        $datos[2] = "";
        $datos[3] = "";
        $datos[4] = "";
        $datos[5] = "";
        $datos[6] = "";
        try{
            foreach($SQLOracion as $or)
            {
                $fechats = strtotime($or->FecAsi);
                switch(date('w', $fechats))
                {
                    case 1:
                        $datos[0] = $or->Asistio == 1 ? "ASISTIO" : "FALTO";
                        $NumAsi = $or->Asistio == 1 ? $NumAsi + 1 : $NumAsi;
                        break;
                    case 2:
                        $datos[1] = $or->Asistio == 1 ? "ASISTIO" : "FALTO";
                        $NumAsi = $or->Asistio == 1 ? $NumAsi + 1 : $NumAsi;
                        break;
                    case 3:
                        $datos[2] = $or->Asistio == 1 ? "ASISTIO" : "FALTO";
                        $NumAsi = $or->Asistio == 1 ? $NumAsi + 1 : $NumAsi;
                        break;
                    case 4:
                        $datos[3] = $or->Asistio == 1 ? "ASISTIO" : "FALTO";
                        $NumAsi = $or->Asistio == 1 ? $NumAsi + 1 : $NumAsi;
                        break;
                    case 5:
                        $datos[4] = $or->Asistio == 1 ? "ASISTIO" : "FALTO";
                        $NumAsi = $or->Asistio == 1 ? $NumAsi + 1 : $NumAsi;
                        break;
                    case 6:
                        $datos[5] = $or->Asistio == 1 ? "ASISTIO" : "FALTO";
                        $NumAsi = $or->Asistio == 1 ? $NumAsi + 1 : $NumAsi;
                        break;
                    case 0:
                        $datos[6] = $or->Asistio == 1 ? "ASISTIO" : "FALTO";
                        $NumAsi = $or->Asistio == 1 ? $NumAsi + 1 : $NumAsi;
                        break;

                }

                if($vuelta == $vueltaFinal)
                {
                    try{
                        $tabla_temporal_cp = new TabTempOracion();
                        $tabla_temporal_cp->CodArea = $codarea;
                        $tabla_temporal_cp->CodCon = $or->CodCon;
                        $tabla_temporal_cp->NomCon = $nomcon;
                        $tabla_temporal_cp->ApeCon = $apecon;
                        $tabla_temporal_cp->Lunes = $datos[0];
                        $tabla_temporal_cp->Martes = $datos[1];
                        $tabla_temporal_cp->Miercoles = $datos[2];
                        $tabla_temporal_cp->Jueves = $datos[3];
                        $tabla_temporal_cp->Viernes = $datos[4];
                        $tabla_temporal_cp->Sabado = $datos[5];
                        $tabla_temporal_cp->Domingo = $datos[6];                        
                        $tabla_temporal_cp->NumAsi = $NumAsi;                        
                        $tabla_temporal_cp->TotAsi = $vueltaFinal;
                        $tabla_temporal_cp->save();

                    }catch(\Exception $th)
                    {
                        return response()->json(['code' => 400, 'msg' => $th->getMessage()]);
                    }
                }
                $vuelta++;
            }
        }catch(\Exception $th){
            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }
    }    

    function getStartAndEndDate($week, $year)
    {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }    
}
