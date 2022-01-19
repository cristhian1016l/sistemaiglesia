<?php

namespace App\Http\Controllers\Liderred;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tabredes;
use App\Tabcasasdepaz;
use App\Tabcon;
use App\Tabgrupos;
use App\Tabmimcaspaz;
use App\User;
use Illuminate\Support\Facades\DB;

class CDPController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCDP(){
        
        $datosRed = Tabredes::where('LID_RED', Auth::user()->codcon)->first();
        // $CDPs = Tabcasasdepaz::where('ID_Red', $datosRed->ID_RED)->get();        

        $CDPs = Tabcasasdepaz::join('TabCon', 'TabCasasDePaz.CodLid', '=', 'TabCon.CodCon')
                ->get(['TabCasasDePaz.ID_Red', 'TabCasasDePaz.CodCasPaz', 'TabCon.ApeCon', 'TabCon.NomCon', 'TabCasasDePaz.DirCasPaz', 'TabCasasDePaz.FecIniCasPaz', 'TabCasasDePaz.TotMimCasPaz'])
                ->where('ID_Red', $datosRed->ID_RED);
        $data = ['CDPs' => $CDPs];

        return view('liderred.cdp.index', $data);        
    }

    public function getReports(){
        return view('liderred.reportes_cdp.index');
    }

    public function getMembers($CodCasPaz){
        $codigo = substr($CodCasPaz, 4);
        $members = Tabmimcaspaz::select('TabCon.CodCon', 'TabCon.ApeCon', 'TabCon.NomCon', 'TabCon.EstaEnProceso', 'TabCon.FecNacCon', 'TabCon.DirCon', 'TabCon.NumCel', 'TabCon.TipCon')
                        ->join("TabCon", "TabMimCasPaz.CodCon", "=", "TabCon.CodCon")
                        ->where('TabMimCasPaz.CodCasPaz', $codigo)
                        ->get();
        // dd($members);
        $data = ['members' => $members, 'cdp' => $codigo];
        return view('liderred.cdp.members', $data);
    }

    public function getDetailsMember($codcon){
        $codigo = substr($codcon, 4);        
        $member = Tabcon::where('CodCon', $codigo)->first();
        $data = ["member" => $member, "cdp" => "yes"];
        return view('liderred.membresia.detailsMember', $data);
    }

    public function show_cdps(Request $request){
        
        $week = $request->week;
        $year = $request->year;
        $selectCDP = DB::select("SELECT CodCasPaz FROM TabInfCasPaz WHERE NumSem = ".$week." AND Anio = ".$year);
        $listnow = [];
        foreach($selectCDP as $md){
            array_push($listnow, $md->codarea);
        }
        $id_red = DB::select("SELECT ID_RED FROM TabRedes WHERE LID_RED='".User::find(Auth::user()->id)."'");
        $discipleships = Tabcasasdepaz::select('CodCasPaz')->where('ID_Red', $id_red)->get();
        $activelist = [];
        foreach($discipleships as $md){
            array_push($activelist, $md->CodArea);
        }

        $diffAdd = array_diff($activelist, $listnow);        

        $discipleships_fauls = [];

        foreach($diffAdd as $ds){
            $groups = Tabgrupos::select('CodArea', 'DesArea')
                                    ->where('CodArea', $ds)
                                    ->first();
            array_push($discipleships_fauls, $groups);
        }

        return response()->json($discipleships_fauls);
    }
}
