<?php

namespace App\Http\Controllers\Finance;

use App\Activity;
use App\Http\Controllers\Controller;
use App\Manage;
use App\Managedetails;
use App\Tabcon;
use App\Weekmanagedetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class ActivityManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getActivitiesManage(){
        $manages = DB::select("SELECT m.id, a.activity, m.year, m.month FROM manage m INNER JOIN activities a
                                 ON m.activity_id = a.id");
        $data = ['manages' => $manages];
        return view('finance.manage.index', $data);
    }

    public function create(){
        $activities = Activity::all();
        $data = ['activities' => $activities];
        return view('finance.manage.create', $data);
    }

    public function create_activitiy_manage(Request $request){
        $date = explode("/", $request->date);
        $dt = "$date[0]/15/$date[1]";
        $month_start = strtotime('first day of this month', strtotime($dt));
        $month_end = strtotime('last day of this month', strtotime($dt));
        $mondays = array();

        $startDate = strtotime(date('d-m-Y', $month_start));
        $endDate = strtotime(date('d-m-Y', $month_end));
        for($i = strtotime('Monday', $startDate); $i <= $endDate; $i = strtotime('+1 week', $i)){
            array_push($mondays, date('Y-m-d', $i));
        }                
        if(is_numeric($date[0]) && is_numeric($date[1])){
            $validation = Manage::where('activity_id', $request->activity)->get();
            foreach($validation as $val){
                if($val['month'] == $date[0] && $val['year'] == $date[1] ){
                    return redirect('/tesoreria/administracion/agregar')->withInput()
                            ->with('msg', 'Ya está registrada una administración con el mismo año y mes')
                            ->with('type-alert', 'success');
                }
            }
            try{      
                DB::beginTransaction();      
                $manage = new Manage();
                $manage->activity_id = $request->activity;
                $manage->month = $date[0];
                $manage->year = $date[1];
                $manage->save();
                
                $members = DB::table('TabCon')->where('EstCon', 'ACTIVO')->get();    

                $weeks = array();
                for($i = 0; $i < count($mondays); ++$i){
                    array_push($weeks, $mondays[$i]);
                }
                // dd($weeks);
                foreach($members as $member){                                        
                    $manageDetails = new Managedetails();
                    $manageDetails->manage_id = $manage->id;
                    $manageDetails->codcon = $member->CodCon;
                    $manageDetails->nomapecon = $member->ApeCon.' '.$member->NomCon;
                    $manageDetails->week1 = $weeks[0];
                    $manageDetails->amount1 = '00.00';
                    $manageDetails->week2 = $weeks[1];
                    $manageDetails->amount2 = '00.00';
                    $manageDetails->week3 = $weeks[2];
                    $manageDetails->amount3 = '00.00';
                    $manageDetails->week4 = $weeks[3];
                    $manageDetails->amount4 = '00.00';
                    $manageDetails->save();                    
                }
                DB::commit();
                return redirect('/tesoreria/administracion')
                    ->with('msg', 'Nueva administración registrada correctamente')
                    ->with('type-alert', 'success');
            } catch (\Exception $th) {
                DB::rollback();
                return redirect('/tesoreria/administracion/agregar')->withInput()
                    ->with('msg', $th->getMessage())
                    ->with('type-alert', 'warning');
            }   
        }else{
            return redirect('/tesoreria/administracion/agregar')->withInput()
                ->with('msg', 'Debe ingresar correctamente la fecha')
                ->with('type-alert', 'warning');
        }
                  
    }

    public function getDetailsActivityManage($id){
        // $manage_details = Managedetails::where('manage_id', $id)->get();        
        // $manage_details = DB::select("SELECT * FROM manage_details WHERE manage_id = ".$id);
        // $manage_details = DB::table('manage_details')->where('manage_id', $id)->get();
        $manage_details = Managedetails::where('manage_id', $id)->get();
        // dd($manage_details);
        // $data = ['details' => $manage_details, 'count' => count($manage_details)];
        $data = ['details' => $manage_details, 'manage_id' => $id ];
        // dd($manage_details[0]);
        return view('finance.manage.manage_details.index', $data);
    }

    public function getDetailsActivityManageIndividual(Request $request){
        $manage_details = Managedetails::where('manage_id', $request->manage_id)
                                        ->where('id', $request->id)
                                        ->where('codcon', $request->codcon)->first();
        return response()->json($manage_details);
    }

    public function updateDetailActivityManageIndividual(Request $request){                
        // return response()->json($request->all());
        $findmonto1 = strpos($request->monto1, 'S/. ');
        $findmonto2 = strpos($request->monto2, 'S/. ');
        $findmonto3 = strpos($request->monto3, 'S/. ');
        $findmonto4 = strpos($request->monto4, 'S/. ');
        if($findmonto1 === false){}else{$request->monto1 = substr($request->monto1, 4);}     
        if($findmonto2 === false){}else{$request->monto2 = substr($request->monto2, 4);}
        if($findmonto3 === false){}else{$request->monto3 = substr($request->monto3, 4);}
        if($findmonto4 === false){}else{$request->monto4 = substr($request->monto4, 4);}        
        // return response()->json($request->monto1.' '.$request->monto2.' '.$request->monto3.' '.$request->monto4);        
        if($request->ajax()){

            try{
                DB::update("UPDATE manage_details set amount1 = ".$request->monto1.", amount2 = ".$request->monto2.", 
                        amount3 = ".$request->monto3.", amount4 = ".$request->monto4." WHERE id = ".$request->id);

                $manage_details = Managedetails::where('manage_id', $request->manage_id)->get();
                
                return response()->json([
                    '200',
                    'details' => $manage_details,
                    'typealert' => "bg-success",
                    'title' => "Domingo",
                    'msg' => "Horario del domingo actualizado"
                ]);
            }catch(\Exception $th){
                return response()->json(["error" => "500", "msg" => $th->getMessage()]);
            }                    
        }
    }

    public function members_debug(Request $request){
        $manage_details = Managedetails::select('codcon')->where('manage_id', $request->manage_id)->get();
        $listnow = [];
        foreach($manage_details as $md){
            array_push($listnow, $md->codcon);
        }

        $active_members = DB::select("SELECT CodCon FROM TabCon WHERE EstCon = 'ACTIVO'");
        $activelist = [];
        foreach($active_members as $am){
            array_push($activelist, $am->CodCon);
        }

        $diffAdd = array_diff($activelist, $listnow);
        $diffAddData = [];        
        foreach($diffAdd as $da){
            // $member = DB::select("SELECT CodCon, ApeCon, NomCon FROM TabCon WHERE CodCon='$da' LIMIT 1");
            $member = Tabcon::select('CodCon', 'ApeCon', 'NomCon')
                            ->where('CodCon', $da)
                            ->first();
            array_push($diffAddData, $member);
        }
        
        //HACER LO MISMO DE ARRIBA
        $diffSubtract = array_diff($listnow, $activelist);
        //TERMINO
        $diffSubtractData = [];        
        foreach($diffSubtract as $ds){
            // $member = DB::select("SELECT codcon, nomapecon, amount1, amount2, amount3, amount4 FROM manage_details WHERE codcon='$ds' AND manage_id = $request->manage_id LIMIT 1");
            $member = Managedetails::select('codcon', 'nomapecon', 'amount1', 'amount2', 'amount3', 'amount4')
                                    ->where('codcon', $ds)
                                    ->where('manage_id', $request->manage_id)
                                    ->first();
            array_push($diffSubtractData, $member);
        }

        return response()->json(["diffAddData" => $diffAddData, "diffSubtractData" => $diffSubtractData]);
    }
}
