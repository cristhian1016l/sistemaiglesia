<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tabcon;
use App\TabDetDocumentos;
use App\TabDocumentos;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPermissions(){
        $permisos = DB::select("SELECT doc.NumReg, doc.FecIniReg, doc.FecFinReg, doc.Motivo, doc.PerCon, doc.Estado, c.ApeCon, c.NomCon, c.ID_Red
                                FROM TabDocumentos doc INNER JOIN TabCon c ON doc.CodCon = c.CodCon WHERE c.EstCon = 'ACTIVO'");
        $members = DB::select("SELECT * FROM TabCon WHERE EstCon = 'ACTIVO'");
        $data = ['permissions' => $permisos, 'miembros' => $members];
        return view('admin.permissions.index', $data);
    }

    public function getPermissionsAjax(){
        $permisos = DB::select("SELECT doc.NumReg, doc.FecIniReg, doc.FecFinReg, doc.Motivo, doc.PerCon, doc.Estado, c.ApeCon, c.NomCon, c.ID_Red
                                FROM TabDocumentos doc INNER JOIN TabCon c ON doc.CodCon = c.CodCon WHERE c.EstCon = 'ACTIVO'");
        $data = ['permissions' => $permisos];
        return response()->json($data);
    }

    public function addPermission(Request $request){
        $perCon = false;
        if($request->checked == 1){
            $perCon = true;
        }
        $yearIni = substr($request->fecinireg, 0, 4);
        $monthIni = substr($request->fecinireg, 5, 2);
        $dayIni = substr($request->fecinireg, 8, 9);

        $yearFin = substr($request->fecfinreg, 0, 4);
        $monthFin = substr($request->fecfinreg, 5, 2);
        $dayFin = substr($request->fecfinreg, 8, 9);

        if(!checkdate($monthIni, $dayIni, $yearIni)){
            return response()->json(["code" => 500, "msg" => "VERIFIQUE LA FECHA DE INICIO"]);
        }

        if(checkdate($monthFin, $dayFin, $yearFin) == false){
            return response()->json(["code" => 500, "msg" => "VERIFIQUE LA FECHA DE FINALIZACIÓN"]);
        }

        try{
            if(strlen($request->motivo) < 15){
                return response()->json(["code" => 300, "msg" => "INGRESE MAYOR INFORMACIÓN EN EL MOTIVO"]);
            }
            DB::beginTransaction();
            $date = new DateTime();        
            $permiso = new TabDocumentos();
            $permiso->NumReg = date_format($date, 'dmYis');
            $permiso->FecReg = date_format($date, 'Y-m-d');
            $permiso->CodCon = $request->codcon;
            $permiso->FecIniReg = $request->fecinireg;
            $permiso->FecFinReg = $request->fecfinreg;
            $permiso->PerCon = $perCon;
            $permiso->motivo = $request->motivo;
            $permiso->estado = 1;
            $permiso->save();

            $detPermiso = new TabDetDocumentos();
            $detPermiso->NumReg = $permiso->NumReg;
            $detPermiso->CodAct = '001';
            $detPermiso->save();
            DB::commit();
            return response()->json(["code" => 200, "msg" => "PERMISO REGISTRADO CORRECTAMENTE"]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json(["code" => 400, "msg" => $th->getMessage()]);        
        }        
    }

    public function disablePermission(Request $request){
        try{
            DB::beginTransaction();
            DB::update('UPDATE TabDocumentos set Estado = false WHERE NumReg = ?',[$request->numreg]);
            DB::commit();
            return response()->json(['code' => 200, 'msg' => "PERMISO DESHABILITADO CORRECTAMENTE"]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json(['code' => 500, 'msg' => "HUBO UN ERROR AL DESHABILITAR EL PERMISO"]);
        }
    }

    public function enablePermission(Request $request){
        try{
            DB::beginTransaction();
            DB::update('UPDATE TabDocumentos set Estado = true WHERE NumReg = ?',[$request->numreg]);
            DB::commit();
            return response()->json(['code' => 200, 'msg' => "PERMISO HABILITADO CORRECTAMENTE"]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json(['code' => 500, 'msg' => "HUBO UN ERROR AL HABILITAR EL PERMISO"]);
        }        
    }

    public function deletePermission(Request $request){
        try{
            DB::beginTransaction();
            $find1 = TabDetDocumentos::where('NumReg', $request->numreg)->delete();            
            $find = TabDocumentos::where('NumReg', $request->numreg)->delete();            
            DB::commit();
            return response()->json(['code' => 200, 'msg' => "PERMISO ELIMINAR CORRECTAMENTE"]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json(['code' => 500, 'msg' => $th->getMessage()]);
        }        
    }    

    public function getPermission(Request $request){
        $documento = DB::select("SELECT * FROM TabDocumentos WHERE NumReg = '".$request->numreg."'");
        
        return response()->json($documento);
    }

    public function editPermission(Request $request){          
        $perCon = false;
        if($request->checked == 1){
            $perCon = true;
        }
        $yearIni = substr($request->fecinireg, 0, 4);
        $monthIni = substr($request->fecinireg, 5, 2);
        $dayIni = substr($request->fecinireg, 8, 9);

        $yearFin = substr($request->fecfinreg, 0, 4);
        $monthFin = substr($request->fecfinreg, 5, 2);
        $dayFin = substr($request->fecfinreg, 8, 9);

        if(!checkdate($monthIni, $dayIni, $yearIni)){
            return response()->json(["code" => 500, "msg" => "VERIFIQUE LA FECHA DE INICIO"]);
        }

        if(checkdate($monthFin, $dayFin, $yearFin) == false){
            return response()->json(["code" => 500, "msg" => "VERIFIQUE LA FECHA DE FINALIZACIÓN"]);
        }

        try{
            if(strlen($request->motivo) < 15){
                return response()->json(["code" => 300, "msg" => "INGRESE MAYOR INFORMACIÓN EN EL MOTIVO"]);
            }
            DB::beginTransaction();
            $date = new DateTime();        
            DB::update('UPDATE TabDocumentos set FecIniReg=?, FecFinReg=?, Motivo=?, PerCon = ? WHERE NumReg = ?',[$request->fecinireg, $request->fecfinreg, $request->motivo, $perCon, $request->numreg]);            
            DB::commit();
            return response()->json(["code" => 200, "msg" => "PERMISO ACTUALIZADO CORRECTAMENTE"]);
        }catch(\Exception $th){
            DB::rollBack();
            return response()->json(["code" => 400, "msg" => $th->getMessage()]);        
        }      
    }

}
