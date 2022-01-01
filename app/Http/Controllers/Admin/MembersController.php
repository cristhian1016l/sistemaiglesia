<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tabcon;
use App\Tabredes;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
}
