<?php

namespace App\Http\Controllers\Admin;

use App\Faltascultods;
use App\Http\Controllers\Controller;
use App\Tabgrupos;
use App\Tabredes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use DateTime;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.reportes.index');
    }

    public function reporteFaltasDownload(Request $request)
    {
        // dd($request->faltas);
        Faltascultods::truncate();        

        try{
            DB::beginTransaction();
            $discipulos = [];
            $discipulados = Tabgrupos::where('TipGrup', 'D')->get();
            foreach($discipulados as $discipulado){
                $miembrosGrupo = DB::select("SELECT c.CodCon, CONCAT(c.ApeCon, ' ', c.NomCon), c.TipCon,
                                            c.FecNacCon, c.NumCel, c.ApeCon, c.NomCon, gm.CarDis FROM TabGruposMiem
                                            gm INNER JOIN TabCon c ON gm.CodCon = c.CodCon WHERE CodArea =
                                            '".$discipulado->CodArea."'  ORDER BY c.ApeCon");
                $cont = 0;
                foreach($miembrosGrupo as $mg){
                    $asistencias = DB::select("SELECT CodAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC LIMIT $request->faltas");                    
                    foreach($asistencias as $asistencia){
                        $sqlOracion = DB::select("SELECT da.CodCon, da.NomApeCon, da.Asistio, da.Motivo FROM TabAsi a INNER JOIN TabDetAsi da ON a.Codasi = da.CodAsi
                                                WHERE a.CodAsi = '".$asistencia->CodAsi."' AND da.CodCon ='".$mg->CodCon."'");
                        foreach($sqlOracion as $so){
                            if($so->Asistio == 0){
                                $cont++;
                                if($cont==$request->faltas){
                                    $this->InsertFaltasCultoDs($discipulado->CodArea, $so->CodCon, $discipulado->DesArea, $so->NomApeCon, $mg->CarDis, $so->Motivo);
                                }                                
                            }
                        }                        
                    }
                    $cont=0;
                }
            }
            DB::commit();
        }catch(\Exception $th){
            DB::rollBack();
        } 

        $data = ['faltas' => Faltascultods::all()];
        $pdf=PDF::loadView('admin.reports.faltas_consecutivas', $data);
        return $pdf->stream();
    }

    public function InsertFaltasCultoDs($codarea, $codcon, $desarea, $nombrescomp, $cargo, $motivo){
        $tabla_temporal = new Faltascultods();
        $tabla_temporal->CodArea = $codarea;
        $tabla_temporal->CodCon = $codcon;
        $tabla_temporal->DesArea = $desarea;
        $tabla_temporal->Nombrescomp = $nombrescomp;
        $tabla_temporal->Cargo = $cargo;
        $tabla_temporal->Motivo = substr($motivo, 0, 98);
        $tabla_temporal->save();
    }

    public function reporteFaltasDiscipuladosDownload(){
        // dd($request->faltas);
        Faltascultods::truncate();        

        try{
            DB::beginTransaction();
            $discipulados = Tabgrupos::select('CodArea', 'DesArea')->where('TipGrup', 'D')->get();            
            
            // $discipulados = Tabgrupos::select('CodArea', 'DesArea')->where('TipGrup', 'D')->where('CodArea', 'A010')->get();
            $datos = array();
            $datosvuelta = array();
            foreach($discipulados as $discipulado){ // RECORRE TODOS LOS DISCIPULADOS

                $asistencias = DB::select("SELECT codasi FROM tabasidiscipulados WHERE codarea = '".$discipulado->CodArea."' ORDER BY fecasi DESC LIMIT 3");                
                $discipulos = DB::select("SELECT CodCon, CarDis FROM TabGruposMiem WHERE CodArea = '".$discipulado->CodArea."'");                
                foreach($discipulos as $dis){ //RECORRE TODOS LOS DISCIPULOS QUE PERTENECEN A UN DETERMINADO DISCIPULADO
                    if(count($asistencias)>0){
                        $vuelta = 0;     
                        $faltas = 0;                     
                        foreach($asistencias as $asistencia){ //RECORRE TODOS LAS ASISTENCIAS AL DISCIPULADO                            
                            $sqlAsistencia = DB::select("SELECT CodCon, NomApeCon, Asistio FROM tabdetasidiscipulados WHERE
                                                CodAsi = '".$asistencia->codasi."' AND CodCon ='".$dis->CodCon."'");
                            // dd($sqlAsistencia);
                            foreach($sqlAsistencia as $sa){ //RECORRE TODOS LOS DETALLES DE ASISTENCIAS AL DISCIPULADO
                                if($vuelta==0){
                                    $datosvuelta[2] = $sa->Asistio;
                                }                                
                                if($vuelta==1){
                                    $datosvuelta[1] = $sa->Asistio;
                                }
                                if($vuelta==2){
                                    $datosvuelta[0] = $sa->Asistio;
                                }
                                if($sa->Asistio == 0){
                                    $faltas++;
                                }                                                                                              
                            }                                  
                            $vuelta++;
                        }   
                                         
                        if($faltas>0){            
                            array_push($datos, ['Codarea' => $discipulado->CodArea, 'Codcon' => $sa->CodCon, 'Desarea' => $discipulado->DesArea, 'Nombrescomp' => $sa->NomApeCon, 'Cargo' => $dis->CarDis, 'mes1' => $datosvuelta[0], 'mes2' => $datosvuelta[1], 'mes3' => $datosvuelta[2], 'total' => $faltas]);
                        }                                                                  
                        $faltas = 0;
                    }
                }
                
            }
            DB::commit();
        }catch(\Exception $th){
            DB::rollBack();
        } 
        // dd(Faltascultods::all());
        // $data = ['faltas' => Faltascultods::all()];
        // dd($datos);
        $data = ['faltas' => collect($datos)];
        $pdf=PDF::loadView('admin.reports.faltas_discipulados', $data);
        return $pdf->stream();
    }

    public function reportAsisCultMiemNuevosDownload($idred){
        $miembros = array();
        $datosvuelta = array();
        $dt = Carbon::create(date('Y-m-d'));
        // $members = DB::table('TabCon')->select('ApeCon', 'NomCon', 'CodCon', 'FecReg', 'NumCel')->where('EstCon', 'ACTIVO')
        //                             ->where('FecReg','>',$dt->subMonth(3)->format('Y-m-d'))->where('ID_Red', $idred)->orderBy('ApeCon')->get();        

        $members = DB::select("SELECT c.ApeCon, c.NomCon, c.CodCon, c.FecReg, c.NumCel, mo.Estado, mo.Observacion 
                                FROM TabCon c LEFT JOIN miembros_observados mo ON c.CodCon = mo.CodCon
                                WHERE c.EstCon = 'ACTIVO' AND c.FecReg > '".$dt->subMonth(3)->format('Y-m-d')."' AND c.ID_Red = '".$idred."' ORDER BY c.ApeCon");
                            
        $asistencias = DB::select("SELECT CodAsi, FecAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC LIMIT 7");

        foreach($members as $member){
            $vuelta = 0;     
            $faltas = 0;  
            $fechas = array();
            $datosvuelta[0] = 'N';
            $datosvuelta[1] = 'N';
            $datosvuelta[2] = 'N';
            $datosvuelta[3] = 'N';
            $datosvuelta[4] = 'N';
            $datosvuelta[5] = 'N';
            $datosvuelta[6] = 'N';
            foreach($asistencias as $asistencia){
                $sqlAsistencia = DB::select("SELECT NomApeCon, EstAsi FROM TabDetAsi WHERE
                                                        CodAsi = '".$asistencia->CodAsi."' AND CodCon ='".$member->CodCon."'");        
                foreach($sqlAsistencia as $sa){ //RECORRE TODOS LOS DETALLES DE ASISTENCIAS AL CULTO
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
                        case 5:
                            $datosvuelta[5] = $sa->EstAsi;
                            break;
                        case 6:
                            $datosvuelta[6] = $sa->EstAsi;
                            break;
                    }
                    if($sa->EstAsi == 'F'){
                        $faltas++;
                    }             
                }         
                array_push($fechas, [$vuelta, $asistencia->FecAsi]);
                $vuelta++;                
            }               
            $diferencias = array();
            $prueba = array();
            $vuelta = 0;
            foreach($fechas as $fecha){
                $fecreg = date('Y-m-d', strtotime($member->FecReg));
                $diff = date_diff(date_create($fecreg), date_create(date('Y-m-d', strtotime($fecha[1]))));
                switch($vuelta){
                    case 0:
                        $diferencias[0][0] = intval($diff->format('%a'));
                        $diferencias[0][1] = date('Y-m-d', strtotime($fecha[1]));
                        break;
                    case 1:
                        $diferencias[1][0] = intval($diff->format('%a'));
                        $diferencias[1][1] = date('Y-m-d', strtotime($fecha[1]));                        
                        break;
                    case 2:
                        $diferencias[2][0] = intval($diff->format('%a'));
                        $diferencias[2][1] = date('Y-m-d', strtotime($fecha[1]));
                        break;
                    case 3:
                        $diferencias[3][0] = intval($diff->format('%a'));
                        $diferencias[3][1] = date('Y-m-d', strtotime($fecha[1]));
                        break;
                    case 4:
                        $diferencias[4][0] = intval($diff->format('%a'));
                        $diferencias[4][1] = date('Y-m-d', strtotime($fecha[1]));
                        break;
                    case 5:
                        $diferencias[5][0] = intval($diff->format('%a'));
                        $diferencias[5][1] = date('Y-m-d', strtotime($fecha[1]));
                        break;
                    case 6:
                        $diferencias[6][0] = intval($diff->format('%a'));
                        $diferencias[6][1] = date('Y-m-d', strtotime($fecha[1]));
                        break;
                }        
                $vuelta++;
            }
            array_push($prueba, ['miembro' => $member->ApeCon.' '.$member->NomCon, 'FecReg' => $member->FecReg, '1' => $diferencias[0], '2' => $diferencias[1], '3' => $diferencias[2], '4' => $diferencias[3], '5' => $diferencias[4], '6' => $diferencias[5], '7' => $diferencias[6]]);            
            $i = 0;
            $fecha_menor = 0;
            $menor = 0;
            foreach($diferencias as $diferencia){
                if($i == 0){
                    $menor = $diferencias[$i][0];
                }
                if($i>0){
                    if($diferencias[$i][0] < $menor){
                        $fecha_menor = $diferencias[$i][1];
                        $menor = $diferencias[$i][0];
                    }
                    
                }
                $i++;
            }

            $cdp = DB::select("SELECT CodCasPaz FROM TabMimCasPaz WHERE CodCon = '".$member->CodCon."'");
            $cdpylider = DB::select("SELECT c.NomCon FROM TabCasasDePaz cdp INNER JOIN TabCon c ON cdp.CodLid = c.CodCon WHERE CodCasPaz = '".$cdp[0]->CodCasPaz."'");

            array_push($miembros, ['Fecha' => $fecha_menor, 'cdp' => $cdp[0]->CodCasPaz.' - '.$cdpylider[0]->NomCon , 
                                    'Nombrescomp' => $member->ApeCon.' '.$member->NomCon, 'NumCel' => $member->NumCel,
                                    'FecReg' => $member->FecReg, 'asis1' => $datosvuelta[0], 'asis2' => $datosvuelta[1], 
                                    'asis3' => $datosvuelta[2], 'asis4' => $datosvuelta[3], 'asis5' => $datosvuelta[4], 
                                    'asis6' => $datosvuelta[5], 'asis7' => $datosvuelta[6], 'faltas' => $faltas, 
                                    'estado' => $member->Estado, 'observacion' => $member->Observacion]);
            $faltas = 0;
        }
        $red = Tabredes::select('NOM_RED')->where('ID_RED', $idred)->first();
        // dd($miembros);
        $data = ['members' => collect($miembros), 'asistencias' => $asistencias, 'red' => $red];
        $pdf=PDF::loadView('admin.reports.asistencia_miembros_nuevos', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
}
