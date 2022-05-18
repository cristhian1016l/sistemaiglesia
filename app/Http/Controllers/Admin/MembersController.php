<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tabcon;
use App\Tabredes;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getMembers()
    {
        $members = DB::table('TabCon')->where('EstCon', 'ACTIVO')->orderBy('ApeCon')->get();
        $data = ['members' => $members];
        return view('admin.membresia.index', $data);
    }

    public function toDown(Request $request){
        try{
            DB::beginTransaction();
            DB::update('UPDATE TabCon set EstCon = ?, FecBaja = ?, MotBaja = ? WHERE CodCon = ? ',
                        ['BAJA', \Carbon\Carbon::now(), $request->motbaja, $request->codcon]);
            $delete = DB::table('TabGruposMiem')                    
                    ->where('CodCon', $request->codcon)
                    ->delete();
            $deleteCP = DB::table('TabMimCasPaz')
                        ->where('CodCon', $request->codcon)
                        ->delete();

            $members = DB::table('TabCon')->where('EstCon', 'ACTIVO')->orderBy('ApeCon')->get();
            DB::commit();
            return response()->json([                
                'members' => $members,                
                'msg' => "El miembro fue dado de baja"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'error' => '500',        
                'members' => $members,
                'msg' => $th->getMessage()
            ]);
        }  
    }

    public function getDetailsMember($codcon){
        $member = DB::table('TabCon')->where('CodCon', $codcon)->first();
        $groups = DB::select("SELECT tg.CodArea, tg.DesArea FROM TabGrupos tg INNER JOIN 
                                TabGruposMiem tgm ON tg.CodArea = tgm.CodArea WHERE tgm.CodCon = '".$codcon."'");
        $data = ["member" => $member, "groups" => $groups];
        return view('admin.membresia.detailsMember', $data);
    }

    public function removeFromGroup(Request $request){        
        try{
            $find = DB::table('TabGruposMiem')
                    ->where('CodArea', $request->codarea)
                    ->where('CodCon', $request->codcon)
                    ->delete();
            $groups = DB::select("SELECT tg.CodArea, tg.DesArea FROM TabGrupos tg INNER JOIN 
                                TabGruposMiem tgm ON tg.CodArea = tgm.CodArea WHERE tgm.CodCon = '".$request->codcon."'");
            return response()->json([
                'error' => '200',
                'groups' => $groups,
                'codcon' => $request->codcon,
                'msg' => "Miembro eliminado correctamente del grupo"
            ]);
        }catch(\Exception $th){
            return response()->json([
                'error' => '500',                
                'msg' => $th->getMessage()
                // 'msg' => "Hubo un error y no se pudo eliminar del grupo"
            ]);
        }
    }

    public function getAssistances(){                
        $user = User::find(Auth::user()->id);        
        if($user->hasRole('liderred')){
            $red = Tabredes::select('ID_RED')->where('LID_RED', $user->codcon)->first();
            $members = DB::select("SELECT * FROM TabCon WHERE EstCon = 'ACTIVO' AND ID_Red=$red->ID_RED ORDER BY ApeCon");
        }else{
            $members = DB::select("SELECT * FROM TabCon WHERE EstCon = 'ACTIVO' ORDER BY ApeCon");
        }        
        $data = ['members' => $members];
        // dd($members);
        return view('admin.registro_asistencia.index', $data);
    }

    public function getNewsMembers(){
        $dt = Carbon::create(date('Y-m-d'));
        // $members = DB::table('TabCon')->where('EstCon', 'ACTIVO')->where('FecReg','>',$dt->subMonth(3)->format('Y-m-d'))->orderBy('ApeCon')->get();
        // $members = DB::select("SELECT * FROM TabCon WHERE EstCon = 'ACTIVO' AND FecReg > '".$dt->subMonth(3)->format('Y-m-d')."' ORDER BY ApeCon");

        $members = DB::select("SELECT c.*, mo.Estado, mo.Observacion FROM TabCon c LEFT JOIN miembros_observados mo ON c.CodCon = mo.CodCon
                                WHERE c.EstCon = 'ACTIVO' AND c.FecReg > '".$dt->subMonth(3)->format('Y-m-d')."' ORDER BY c.ApeCon");

        $redes = DB::table('TabRedes')->get();
        $data = ['members' => $members, 'redes' => $redes];
        return view('admin.miembros_nuevos.index', $data);
    }
    
    public function debugMembers()
    {
        // $cultos = array('001', '012');
        // $registroCultos = array();
        // $faltantes = array();        

        // foreach($cultos as $key=>$culto){

        //     $CodAsi = DB::select("SELECT CodAsi FROM TabAsi WHERE CodAct = '".$culto."' ORDER BY FecAsi DESC LIMIT 1");
        //     $filter = DB::select("SELECT * FROM TabDetAsi WHERE CodAsi = '".$CodAsi[0]->CodAsi."' AND (EstAsi = 'P' OR EstAsi = 'F' ) LIMIT 10");
        //     $registroCultos[$key] = $filter;
        // }

        // if(count($registroCultos) > 1){
        //     foreach($registroCultos as $keyRc=>$rc){
        //         foreach($rc as $ForRc){
        //             array_push($faltantes, $ForRc);
        //         }
        //     }
        // }        

        // return response()->json($faltantes);

        // array (
        //     0 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '04033291',
        //       'NomApeCon' => 'ALANIA HUARICAPCHA DARIO GONZALO',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     1 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '04041094',
        //       'NomApeCon' => 'CABELLO URETA  CRISPINA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     2 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '04067617',
        //       'NomApeCon' => 'HUAYLLACAYAN CHARRI ANTONIO',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     3 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '04068238',
        //       'NomApeCon' => 'VELIZ CAPCHA LOURDES ADELAIDA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     4 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '04068519',
        //       'NomApeCon' => 'CASTRO TORRES FELIX',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     5 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '06566697',
        //       'NomApeCon' => 'HUAMAN IZARRA MARCELINA GRICELDA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     6 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '06785686',
        //       'NomApeCon' => 'RIVERA LICLA MAGDALENA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     7 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '06961637',
        //       'NomApeCon' => 'TINEO SULCA GREGORIO SANTIAGO',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     8 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '06970077',
        //       'NomApeCon' => 'QUISPE RUA BRIGIDA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     9 => 
        //     array (
        //       'CodAsi' => '070520220501',
        //       'CodCon' => '07097495',
        //       'NomApeCon' => 'AGUIRRE AQUINO ELEODORA CHARITO',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     10 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '04033291',
        //       'NomApeCon' => 'ALANIA HUARICAPCHA DARIO GONZALO',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     11 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '04041094',
        //       'NomApeCon' => 'CABELLO URETA  CRISPINA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     12 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '04067617',
        //       'NomApeCon' => 'HUAYLLACAYAN CHARRI ANTONIO',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     13 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '04068238',
        //       'NomApeCon' => 'VELIZ CAPCHA LOURDES ADELAIDA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     14 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '04068519',
        //       'NomApeCon' => 'CASTRO TORRES FELIX',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     15 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '05314995',
        //       'NomApeCon' => 'TAMANI MANUYAMA GILMA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     16 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '06566697',
        //       'NomApeCon' => 'HUAMAN IZARRA MARCELINA GRICELDA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     17 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '06785686',
        //       'NomApeCon' => 'RIVERA LICLA MAGDALENA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     18 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '06961637',
        //       'NomApeCon' => 'TINEO SULCA GREGORIO SANTIAGO',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //     19 => 
        //     array (
        //       'CodAsi' => '150520220419',
        //       'CodCon' => '06970077',
        //       'NomApeCon' => 'QUISPE RUA BRIGIDA',
        //       'HorLlegAsi' => NULL,
        //       'EstAsi' => 'F',
        //       'Asistio' => 0,
        //       'Motivo' => NULL,
        //     ),
        //   )
       
    }

}
