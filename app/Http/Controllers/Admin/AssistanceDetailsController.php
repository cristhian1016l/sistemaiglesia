<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MiembrosObservados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Tabactmes;
use App\Tabasi;
use App\Tabcon;
use App\Tabdetasi;
use Exception;
use SebastianBergmann\Environment\Console;

class AssistanceDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getDiaryRegister($CodAct){
        // dd($CodAct);
        $activities = Tabactmes::select('FecAct', 'DesAct', 'LugAct', 'HorIni', 'MinTol', 'CodAct')
                ->where('CodActMes', $CodAct)
                ->first();
        $data = ['activities' => $activities, 'CodAct' => $CodAct];
        return view('admin.asistencia.asistenciaDiaria', $data);
    }

    public function checkDiaryRegister($CodAct){
        // dd($CodAct);        
        $activities = DB::table('TabActMes')->select('FecAct', 'DesAct', 'LugAct', 'HorIni', 'MinTol', 'CodAct')
                    ->where('CodActMes', $CodAct)
                    ->first();        

        $data = ['activities' => $activities, 'CodAct' => $CodAct];

        return view('admin.asistencia.asistenciaDiaria', $data);
    }

    public function registerAssistance(Request $request){
        
        $activities = Tabactmes::select('FecAct', 'DesAct', 'LugAct', 'HorIni', 'MinTol', 'CodAct', 'EstReg')
                    ->where('CodActMes', $request->codactmes)
                    ->first();
        
        if($activities->EstReg == 'R'){
            return redirect('administracion/asistencia')
            ->with('msg', 'hubo un error, la actividad ya está registrada')
            ->with('type-alert', 'warning');
            die();
        }
        
        if($activities==null ){
            return redirect('administracion/asistencia')
            ->with('msg', 'hubo un error, no se pudo encontrar el codigo de actividad')
            ->with('type-alert', 'warning');
            die();
        }else{
            $new_date_format = date('s', $activities->MinTol);
            $horhasta = \Carbon\Carbon::parse($activities->HorIni)->addMinutes($new_date_format);            

            try {
                DB::beginTransaction();
                    
                $rules = [
                    'fecha' => 'required',
                    'actividad' => 'required',
                    'desde' => 'required',
                    'hasta' => 'required'
                ];

                $messages = [                    
                    'fecha.required' => 'La fecha es requerida',
                    'actividad.required' => 'La actividad es obligatoria',
                    'desde.required' => 'La fecha de inicio de la actividad es obligatoria',
                    'hasta.required' => 'La fecha de finalización de la actividad es obligatoria'
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return redirect('administracion/asistencia')->withErrors($validator)
                        ->with('msg', 'La asistencia no fue registrada')
                        ->with('type-alert', 'warning');
                }else{                    
                    $date = \Carbon\Carbon::now();
                    define('_CodAsi', $date->format('dmYhi'));
                    $miembros = DB::table('TabCon')
                    ->select('CodCon', 'ApeCon', 'NomCon')
                    ->where('EstCon', 'ACTIVO')
                    ->get();

                    $asistencia = new Tabasi();
                    $asistencia->CodAsi = _CodAsi;
                    $asistencia->FecAsi = $activities->FecAct;
                    $asistencia->TipAsi = $activities->DesAct;
                    $asistencia->CodAct = $activities->CodAct;
                    $asistencia->HorDesde = $activities->HorIni;
                    $asistencia->HorHasta = $horhasta;
                    $asistencia->TotFaltas = count($miembros);
                    $asistencia->TotAsistencia = 0;
                    $asistencia->TotPermisos = 0;
                    $asistencia->save();

                    $this->UpdateState($request->codactmes);

                    $this->InsertDetAsi(_CodAsi, $miembros);
                    // ACTUALIZAR LOS REGISTROS CON PERMISOS
                    if($activities->CodAct == '001')
                    {
                        $permisosEsporadicos = DB::select("SELECT d.CodCon, d.Motivo FROM TabDocumentos d INNER JOIN TabDetDocumentos dd ON d.NumReg = dd.NumReg
                        WHERE dd.CodAct = '001' AND d.Estado = true AND ('".$activities->FecAct."' BETWEEN d.FecIniReg AND d.FecFinReg) AND PerCon = 0");

                        $permisosConstantes = DB::select("SELECT d.CodCon, d.Motivo FROM TabDocumentos d INNER JOIN TabDetDocumentos dd ON d.NumReg = dd.NumReg
                                                        WHERE dd.CodAct = '001' AND PerCon = 1");
                            
                        foreach($permisosEsporadicos as $pe){
                            // $find = Faltascultods::where('Codcon', $pe->CodCon)->delete(); ELIMINAR POR LOS PERMISOS
                            DB::update('UPDATE TabDetAsi set EstAsi = ?, Motivo = ? WHERE CodCon = ? AND CodAsi = ? ',['P', substr($pe->Motivo.'[PERMISO]', 0, 99), $pe->CodCon, _CodAsi]); //ACTUALIZAR POR LOS PERMISOS
                        }

                        foreach($permisosConstantes as $pc){
                            DB::update('UPDATE TabDetAsi set EstAsi = ?, Motivo = ? WHERE CodCon = ? AND CodAsi = ? ',['P', substr($pc->Motivo.'[PERMISO]', 0, 99), $pc->CodCon, _CodAsi]); //ACTUALIZAR POR LOS PERMISOS
                        }

                        $pe = DB::select("SELECT TotFaltas FROM TabAsi WHERE CodAsi='"._CodAsi."' LIMIT 1");
                        DB::update('UPDATE TabAsi set TotFaltas = ?, TotPermisos = ? WHERE CodAsi = ? ',[$pe[0]->TotFaltas-count($permisosEsporadicos), count($permisosEsporadicos), _CodAsi]); //ACTUALIZAR POR LOS PERMISOS

                        $pc = DB::select("SELECT TotFaltas, TotPermisos FROM TabAsi WHERE CodAsi='"._CodAsi."' LIMIT 1");
                        DB::update('UPDATE TabAsi set TotFaltas = ?, TotPermisos = ? WHERE CodAsi = ? ',[$pc[0]->TotFaltas-count($permisosConstantes), $pc[0]->TotPermisos+count($permisosConstantes), _CodAsi]); //ACTUALIZAR POR LOS PERMISOS
                    }                    
                    // FIN - ACTUALIZAR LOS REGISTROS CON PERMISOS
                    DB::commit();
                    return redirect('administracion/asistencia/')
                            ->with('msg', 'Registro creado exitosamente')
                            ->with('type-alert', 'success');
                }
                        
            } catch (\Exception $th) {
                DB::rollback();
                return redirect('administracion/asistencia')->withErrors($validator)
                    ->with('msg', $th->getMessage())
                    ->with('type-alert', 'warning');
            }            
        }           
    }    

    public function UpdateState($codactmes){
        $actmes = Tabactmes::findOrFail($codactmes);
        $actmes->EstReg = 'R';
        $actmes->save();
    }

    public function InsertDetAsi($codasi, $miembros){
        
        foreach($miembros as $miembro){            

            $tabdetasi = new Tabdetasi();
            $tabdetasi->CodAsi = $codasi;
            $tabdetasi->CodCon = $miembro->CodCon;
            $tabdetasi->NomApeCon = $miembro->ApeCon.' '.$miembro->NomCon;
            $tabdetasi->EstAsi = 'F';
            $tabdetasi->Asistio = false;
            $tabdetasi->save();
        }
    }

    public function getDetailsDetAsi(Request $request){
        
        $asistencia = DB::table('TabAsi')
                        ->select('CodAsi', 'FecAsi', 'TipAsi', 'HorDesde', 'HorHasta', 'CodAct')
                        ->where('CodAsi', $request->CodAsi)
                        ->first();

        $detasi = DB::table('TabDetAsi')
                    ->select('CodAsi', 'CodCon', 'NomApeCon', 'HorLlegAsi', 'EstAsi','Asistio')
                    ->where('CodAsi', $request->CodAsi)
                    ->orderBy('NomApeCon')
                    ->get();
        
        $FilterAssistance = count($detasi->where('EstAsi', 'A'));
        $filterFoul = count($detasi->where('EstAsi', 'T'));
        $assistance = $FilterAssistance+$filterFoul;
        $filterDelay = count($detasi->where('EstAsi', 'F'));

        $data = ['asistencia' => $asistencia, 'detasi' => $detasi, 'asistentes' => $assistance, 'faltantes' => $filterDelay];
        return view('admin.asistencia.checkAsistencia', $data);
    }

    public function updateAssistanceMember(Request $request)
    {        
        try{
            $fecha = Carbon::now();
            $tabasi = DB::table('TabAsi')->select('HorHasta')->where('CodAsi', $request->codasi)->first();
            $asis = DB::table('TabDetAsi')
                ->select('Asistio')
                ->where('CodAsi', $request->codasi)
                ->where('CodCon', $request->codcon)
                ->first();
            if($asis->Asistio == 1){
                return response()->json(["state" => "OK"]);
            }else{
                $HORA_ACTUAL = Carbon::parse($fecha)->toTimeString();
                $HORA_MAXIMA = Carbon::parse($tabasi->HorHasta)->format('H:i:s');
                $estado = 'A';

                if($request->codact == '001'){
                    if($HORA_ACTUAL > $HORA_MAXIMA){                    
                        $estado = 'T';
                        DB::update('UPDATE TabDetAsi set HorLlegAsi = ?, EstAsi=?, Asistio=? WHERE CodAsi = ? AND CodCon = ? ',[$fecha, $estado,true,$request->codasi,$request->codcon]);
                    }else{
                        DB::update('UPDATE TabDetAsi set HorLlegAsi = ?, EstAsi=?, Asistio=? WHERE CodAsi = ? AND CodCon = ? ',[$fecha, $estado,true,$request->codasi,$request->codcon]);                    
                    }
                }else{
                    DB::update('UPDATE TabDetAsi set HorLlegAsi = ?, EstAsi=?, Asistio=? WHERE CodAsi = ? AND CodCon = ? ',[$fecha, $estado,true,$request->codasi,$request->codcon]);
                }
                
                DB::update("UPDATE TabAsi set TotFaltas = TotFaltas - 1, TotAsistencia = TotAsistencia + 1 WHERE CodAsi = '".$request->codasi."'");
                
                $detasi = DB::table('TabDetAsi')
                    ->select('CodAsi', 'CodCon', 'NomApeCon', 'HorLlegAsi', 'EstAsi','Asistio')
                    ->where('CodAsi', $request->codasi)
                    ->orderBy('NomApeCon')
                    ->get();                
                    
                return response()->json(['200', "miembros" => $detasi]);
                // Carbon::parse($fecha)->addMinutes(15)->toTimeString()
            }  
                        
        }catch(\Exception $th){
            return response()->json(["error" => "500"]);
            // return response()->json('500');
        }        
    }

    public function deleteAssistanceMember(Request $request)
    {                
        try{
            $asis = DB::table('TabDetAsi')
                ->select('Asistio')
                ->where('CodAsi', $request->codasi)
                ->where('CodCon', $request->codcon)
                ->first();
            if($asis->Asistio == 0){
                return response()->json(["state" => "OK"]);
            }else{  
                DB::update('UPDATE TabDetAsi set HorLlegAsi = ?, EstAsi=?, Asistio=? WHERE CodAsi = ? AND CodCon = ? ',[null,'F',false,$request->codasi,$request->codcon]);
                DB::update("UPDATE TabAsi set TotFaltas = TotFaltas + 1, TotAsistencia = TotAsistencia - 1 WHERE CodAsi = '".$request->codasi."'");            

                $detasi = DB::table('TabDetAsi')
                    ->select('CodAsi', 'CodCon', 'NomApeCon', 'HorLlegAsi', 'EstAsi','Asistio')
                    ->where('CodAsi', $request->codasi)
                    ->orderBy('NomApeCon')
                    ->get();

                return response()->json(['200', "miembros" => $detasi]);
            }             
        }catch(\Exception $th){
            return response()->json(["error" => "500", "msg" => $th]);
        }        
    }

    public function getNumbers($Codasi){
        try{
            $numbers = DB::table('TabAsi')
                    ->select('TotAsistencia', 'TotFaltas')
                    ->where('CodAsi', $Codasi)
                    ->get();
            return response()->json(['numbers' => $numbers,'status' => '500']);
        }catch(\Exception $th){
            $numbers = ['TotAsistencia' => 'error', 'TotFaltas' => 'error'];
            return response()->json(['numbers' => $numbers,'status' => '500', 'msg' => $th]);
        }
    }

    public function getDetailsAssistance(Request $request){
        $assistance = DB::select("SELECT CodAsi, FecAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC LIMIT 6");
        $dis = array();
        foreach($assistance as $as){
            $detasi = DB::select("SELECT EstAsi, NomApeCon FROM TabDetAsi WHERE CodAsi = '".$as->CodAsi."' AND CodCon = '".$request->codcon."'");
            if(isset($detasi[0])){
                array_push($dis, ['EstAsi' => $detasi[0]->EstAsi, 'Fecha' => $as->FecAsi, 'Nombres' => $detasi[0]->NomApeCon]);
            }
        }
        return response()->json($dis);
    }

    public function getObservation(Request $request)
    {
        $data = DB::select("SELECT * FROM miembros_observados WHERE CodCon='".$request->codcon."'");
        if($data==[]){
            $data = DB::select("SELECT CodCon FROM TabCon WHERE CodCon='".$request->codcon."'");
            return response()->json([$data, 'code' => 0]);
        }else{
            return response()->json([$data, 'code' => 1]);
        }
    }

    public function updateObservation(Request $request){
        // return response()->json($request->all());
        if($request->id == ''){
            if($request->checked == null){
                return response()->json(["code" => 500, "msg" => 'SELECCIONE EL ESTADO DEL MIEMBRO']);
            }            
            try{
                $miembroObs = new MiembrosObservados();
                $miembroObs->CodCon = $request->codcon;
                switch($request->checked){
                    case(0):
                        $miembroObs->Estado = 'VIRTUAL';
                        break;
                    case(1):
                        $miembroObs->Estado = 'CP';
                        break;
                    case(2):
                        $miembroObs->Estado = 'INCONSTANTE';
                        break;
                }
                $miembroObs->Observacion = $request->motivo;
                $miembroObs->FecReg = Carbon::now();
                $miembroObs->save();
                return response()->json(["code" => 200, "msg" => "OBSERVACION AGREGADA"]);
            }catch(\Exception $th){
                return response()->json(["code" => 500, "msg" => $th->getMessage()]);
            }
        }
        try{
            $miembroObs = MiembrosObservados::find($request->id);             
            $miembroObs->Observacion = $request->motivo;
            switch($request->checked){
                case(0):
                    $miembroObs->Estado = 'VIRTUAL';
                    break;
                case(1):
                    $miembroObs->Estado = 'CP';
                    break;
                case(2):
                    $miembroObs->Estado = 'INCONSTANTE';
                    break;
            }
            $miembroObs->FecReg = Carbon::now();  
            $miembroObs->save();
            return response()->json(["code" => 200, "msg" => "OBSERVACION ACTUALIZADA CORRECTAMENTE"]);
        }catch(\Exception $th){
            return response()->json(["code" => 500, "msg" => $th->getMessage()]);
        }        
    }

    public function getNewsMembersAjax(){
        $dt = Carbon::create(date('Y-m-d'));
        $members = DB::select("SELECT c.CodCon, c.EstaEnProceso, c.ApeCon, c.NomCon, c.FecReg, c.FecNacCon, mo.Estado, mo.Observacion FROM TabCon c LEFT JOIN miembros_observados mo ON c.CodCon = mo.CodCon
                                WHERE c.EstCon = 'ACTIVO' AND c.FecReg > '".$dt->subMonth(3)->format('Y-m-d')."' ORDER BY c.ApeCon");
        $data = ['code' => 200, 'members' => $members];
        return response()->json($data);
    }
}