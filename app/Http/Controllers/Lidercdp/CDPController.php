<?php

namespace App\Http\Controllers\Lidercdp;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tabcasasdepaz;
use App\Tabcon;
use App\TabInfCasPaz;
use App\Tabmimcaspaz;

class CDPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCDP(){
        // dd(Auth::user()->tabcon->CodCon);
        $CDPs = Tabcasasdepaz::where('CodLid', Auth::user()->codcon)->get();

        $data = ['CDPs' => $CDPs];

        return view('lidercdp.cdp.index', $data);
    }

    public function getCDPToReport(){
        // dd(Auth::user()->tabcon->CodCon);
        $CDPs = Tabcasasdepaz::where('CodLid', Auth::user()->codcon)->get();    
        $inf = array();
        foreach($CDPs as $cdp){
            $informe = TabInfCasPaz::where('CodCasPaz', $cdp->CodCasPaz)->first();
            array_push($inf, $informe);
        }
        $data = ['Informes' => $inf];
        return view('lidercdp.reportes.index', $data);
    }

    public function getMembers($Codcaspaz){
        
        $CDPs = Tabcasasdepaz::select('CodCasPaz')->where('CodLid', Auth::user()->codcon)->get();
        // $array = array("1","2","3");
        $array = array();

        foreach($CDPs as $cdp){
            array_push($array, $cdp->CodCasPaz);            
        }
        
        if(in_array($Codcaspaz, $array)){
            $members = Tabmimcaspaz::select('TabCon.CodCon', 'TabCon.ApeCon', 'TabCon.NomCon', 'TabCon.EstaEnProceso', 'TabCon.FecNacCon', 'TabCon.DirCon', 'TabCon.NumCel', 'TabCon.TipCon')
                        ->join("TabCon", "TabMimCasPaz.CodCon", "=", "TabCon.CodCon")                        
                        ->where('TabMimCasPaz.CodCasPaz', $Codcaspaz)
                        ->get();
            // dd($members);
            $data = ['members' => $members, 'cdp' => $Codcaspaz];
            return view('lidercdp.cdp.members', $data);
        }else{
            abort(403);
        };
    }

    public function getDetailsMember($codcon){
        $codigo = substr($codcon, 4);
        $member = Tabcon::where('CodCon', $codigo)->first();
        $data = ["member" => $member];
        return view('lidercdp.member.index', $data);
    }
}
