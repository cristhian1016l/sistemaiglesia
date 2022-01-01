<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tabasidiscipulados;
use App\Tabcon;
use App\Tabdetasidiscipulados;
use App\Tabgrupos;
use App\Tabgruposmiem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class DiscipleshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        // $discipleship = Tabasidiscipulados::select('tabasidisci')
        //                 ->join('TabGrupos as tg', 'tabasidiscipulados.codarea', '=', 'tg.CodArea')
        //                 ->orderBy('fecasi', 'DESC')->get();
        $discipleship = DB::select('SELECT d.codasi, d.fecasi, d.tema, d.ofrenda, d.totfaltas,
                                    d.totasistencia, d.mes, d.activo, g.DesArea FROM tabasidiscipulados as d INNER JOIN TabGrupos as g ON
                                    d.codarea = g.CodArea ORDER BY d.fecasi ASC');
        $data = ['discipleship' => $discipleship];
        return view('admin.discipleship.index', $data);
    }

    public function get_records(Request $request){        
        $discipleship = $this->get_discipleship($request->mes, $request->anio);
        $foul = collect($discipleship)->whereIn('activo', 1)->count();
        return response()->json(['discipleship'=>$discipleship, 'foul' => $foul]);
    }

    public function InsertDetAsiDiscipleship($codasi, $miembros){
        foreach($miembros as $miembro){
            $tabdetasi = new Tabdetasidiscipulados();
            $tabdetasi->codasi = $codasi;
            $tabdetasi->codcon = $miembro->CodCon;
            $tabdetasi->nomapecon = $miembro->ApeCon.' '.$miembro->NomCon;
            $tabdetasi->estasi = 'F';
            $tabdetasi->asistio = false;
            $tabdetasi->save();
        }
    }

    public function close_all_discipleship(Request $request){
        try{
            DB::update('UPDATE tabasidiscipulados SET activo = ? WHERE mes = ? AND anio = ?',['0', $request->month, $request->year]);            
            $discipleship = $this->get_discipleship($request->month, $request->year);
            return response()->json(['discipleship'=>$discipleship, 'msg'=>'Acción concretada correctamente']);
        }catch(\Exception $th){
            return response()->json($th->getMessage());
        }        
    }

    public function close_discipleship(Request $request){
        try{            
            DB::update('UPDATE tabasidiscipulados SET activo = ? WHERE codasi = ?',['0', $request->codasi]);
            $discipleship = $this->get_discipleship($request->month, $request->year);
            return response()->json(['discipleship'=>$discipleship, 'msg'=>'Acción concretada correctamente']);
        }catch(\Exception $th){
            return response()->json($th->getMessage());
        }     
    }

    public function open_discipleship(Request $request){
        try{            
            DB::update('UPDATE tabasidiscipulados SET activo = ? WHERE codasi = ?',['1', $request->codasi]);
            $discipleship = $this->get_discipleship($request->month, $request->year);
            return response()->json(['discipleship'=>$discipleship, 'msg'=>'Acción concretada correctamente']);
        }catch(\Exception $th){
            return response()->json($th->getMessage());
        }     
    }

    // MÉTODO REUTILIZABLE
    public function get_discipleship($month, $year){
        $discipleship = DB::select('SELECT d.codasi, d.fecasi, d.tema, d.ofrenda, d.totfaltas,
                        d.totasistencia, d.mes, d.activo, g.DesArea FROM tabasidiscipulados as d INNER JOIN TabGrupos as g ON
                        d.codarea = g.CodArea WHERE d.mes = '.$month.' AND d.anio = '.$year.' ORDER BY d.fecasi ASC');
        return $discipleship;
    }

    public function reportDownload($codasi){
        $asistencias = Tabdetasidiscipulados::where('codasi', $codasi)->OrderBy('nomapecon')->get();
        $asis = DB::select("SELECT g.EncArea, g.DesArea, d.mes, d.anio, d.totfaltas, 
                            d.totasistencia, d.fecasi, d.tema, d.ofrenda, d.testimonios, d.observaciones 
                            FROM tabasidiscipulados d INNER JOIN TabGrupos g ON d.codarea = g.codarea 
                            WHERE d.codasi = '".$codasi."'");        
        $data = ['asistencias' => $asistencias, 'asis' => $asis];
        $pdf=PDF::loadView('admin.reports.discipleship', $data);
        return $pdf->stream();
    }

    public function manage(){
        $lideres = Tabgrupos::select('TabGrupos.CodArea','c.CodCon', 'c.ApeCon', 'c.NomCon')
                            ->join('TabCon as c', 'TabGrupos.CodCon', '=', 'c.CodCon')
                            ->where('TipGrup', 'D')
                            ->orderBy('c.ApeCon')
                            ->get();

        $data = ['miembros' => $lideres];
        return view('admin.discipleship.settings.index', $data);
    }

    public function getDisciples(Request $request){                
        $disciples = DB::select("SELECT c.EstaEnProceso, c.CodCon, c.ApeCon, c.NomCon, c.FecNacCon, c.DirCon, c.NumCel 
                            FROM TabGruposMiem m INNER JOIN TabCon c ON m.CodCon = c.CodCon WHERE m.CodArea = '".$request->codarea."' ORDER BY c.ApeCon");
        $full = collect($disciples)->count();        
        return response()->json(['disciples' => $disciples, 'total' => $full]);
    }

    public function deleteDisciple(Request $request){
        try{
            DB::beginTransaction();
            $delete = DB::table('TabGruposMiem')                    
                    ->where('CodCon', $request->codcon)
                    ->where('CodArea', $request->codarea)
                    ->delete();
            DB::commit();
            return response()->json(['code' => 200,'msg' => 'Discipulo eliminado correctamente']);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json(['code' => 500, 'msg' => 'Hubo un error al eliminar el discípulo']);
        }     
    }

    public function data_add_disciple(){
        $mentores = Tabgrupos::select('TabGrupos.CodArea','c.CodCon', 'c.ApeCon', 'c.NomCon')
                            ->join('TabCon as c', 'TabGrupos.CodCon', '=', 'c.CodCon')
                            ->where('TipGrup', 'D')
                            ->orderBy('c.ApeCon')
                            ->get();

        $discipulos = Tabgrupos::select('m.CodCon')
                                ->join('TabGruposMiem as m', 'TabGrupos.CodArea', '=', 'm.CodArea')
                                ->where('TabGrupos.TipGrup', 'D')
                                ->get();
        $listnow = [];
        foreach($discipulos as $dis){
            $i=1;
            array_push($listnow, $dis->CodCon);
            $i++;
        }
        
        $active_members = DB::select("SELECT CodCon FROM TabCon WHERE EstCon = 'ACTIVO'");
        // $active_members = Tabcon::select('CodCon')->where('EstCon', 'ACTIVO')->get();
        // return response()->json(['members' => $active_members]);
        $activelist = [];

        foreach($active_members as $am){
            array_push($activelist, $am->CodCon);
        }        

        $diffAdd = array_diff($activelist, $listnow);        

        $diffAddData = [];
        foreach($diffAdd as $da){
            $member = DB::select("SELECT CodCon, ApeCon, NomCon FROM TabCon WHERE CodCon='$da'");
            // $member = Tabcon::select('CodCon', 'ApeCon', 'NomCon')
            //                 ->where('CodCon', $da)
            //                 ->first();
            array_push($diffAddData, $member[0]);
        }
        // return response()->json(['members' => $diffAddData]);
        // $miembros = Tabcon::where('EstCon', 'ACTIVO')->get();
        return response()->json(['mentores' => $mentores, 'members' => $diffAddData]);
    }

    public function add_disciple(Request $request){
        // return response()->json($request->all());
        try{
            DB::beginTransaction();
            $gruposmiem = new Tabgruposmiem();
            $gruposmiem->CodArea = $request->codmentor;
            $gruposmiem->CodCon = $request->coddisciple;
            $gruposmiem->CarDis = 'SIN CARGO';
            $gruposmiem->FecEnv = null;
            $gruposmiem->EstMim = 1;
            $gruposmiem->FecInhab = null;
            $gruposmiem->ObsMim = null;
            $gruposmiem->save();
            DB::commit();
            return response()->json(['code' => 200,'msg' => 'Discípulo agregado correctamente']);            
        }catch(\Exception $th){
            DB::rollback();
            return response()->json(['code' => 500,'msg' => $th->getMessage()]);
        }
    }

    public function show_discipleships(Request $request){
        $month = $request->month;
        $year = $request->year;
        $selectDiscipleships = DB::select("SELECT codarea FROM tabasidiscipulados WHERE mes = ".$month." AND anio = ".$year);
        $listnow = [];
        foreach($selectDiscipleships as $md){
            array_push($listnow, $md->codarea);
        }

        $discipleships = Tabgrupos::select('CodArea')->where('TipGrup', 'D')->get();
        $activelist = [];
        foreach($discipleships as $md){
            array_push($activelist, $md->CodArea);
        }

        $diffAdd = array_diff($activelist, $listnow);        

        $discipleships_fauls = [];

        foreach($diffAdd as $ds){
            // $member = DB::select("SELECT codcon, nomapecon, amount1, amount2, amount3, amount4 FROM manage_details WHERE codcon='$ds' AND manage_id = $request->manage_id LIMIT 1");
            $groups = Tabgrupos::select('CodArea', 'DesArea')
                                    ->where('CodArea', $ds)
                                    ->first();
            array_push($discipleships_fauls, $groups);
        }

        return response()->json($discipleships_fauls);
    }

    public function add_discipleship(Request $request){
        $discipulados = $request->discipulados;
        try{
            DB::beginTransaction();
            foreach($discipulados as $dis){

                $det_members = DB::select("SELECT c.CodCon, c.ApeCon, c.NomCon FROM TabGruposMiem m 
                                            INNER JOIN TabCon c ON m.CodCon = c.CodCon WHERE m.CodArea ='".$dis."'");

                $date = \Carbon\Carbon::now();
                $codasi = $date->format('d').$request->month.$request->year.$dis;                

                DB::insert('insert into tabasidiscipulados (codasi, codarea, totfaltas, totasistencia, mes, anio, activo) 
                            values (?, ?, ?, ?, ?, ?, ?)',
                            [$codasi, $dis, count($det_members), 0, $request->month, $request->year, 1]);

                $this->InsertDetAsiDiscipleship($codasi, $det_members);         
            }            
            DB::commit();
            return response()->json(['msg' => 'Registro creado exitosamente']);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json($th->getMessage());
        }
    }
        
    // public function records_open(){        
    //     return view('admin.discipleship.records_open');
    // }
}

