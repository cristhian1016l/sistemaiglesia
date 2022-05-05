<?php

namespace App\Http\Controllers;

use App\Tabasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Tabcasasdepaz;
use App\Tabcon;
use App\Tabgrupos;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_news(){
        return view('dashboard.news');
    }
    public function show_dashboard_liderred(){
        
        $idred = Auth::user()->tabredes->ID_RED;
        $CDPs = Tabcasasdepaz::where('ID_Red', $idred)->get();
        $users = DB::select("SELECT u.codcon FROM users u INNER JOIN TabCon c ON u.codcon = c.CodCon WHERE c.ID_Red = '$idred'");
        $miembros = DB::table('TabCon')
                        ->where('EstCon', 'ACTIVO')
                        ->where('ID_Red', $idred)
                        ->count();

        $red = DB::table('TabRedes')
                    ->where('ID_RED', $idred)
                    ->first();
        // $cultos = DB::select("SELECT CodAsi, FecAsi, TipAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC");
        $cultos = DB::select("SELECT DISTINCT FecAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC");
        $cdps = DB::select("SELECT * FROM TabCasasDePaz WHERE ID_Red = '".$idred."'");
        $dataRed = ['CDPs' => count($CDPs), 'users' => count($users), 'miembros' => $miembros, 'red' => $red, 'cultos' => $cultos, 'cdps' => $cdps];
        return view('dashboard.liderred', $dataRed);
    }

    public function show_dashboard_mentor(){        
        $codarea = Tabgrupos::select('CodArea')
                            ->where('CodCon', Auth::user()->codcon)
                            ->where('TipGrup', 'D')
                            ->first();        
        $disciples = DB::select("SELECT * FROM TabGruposMiem WHERE CodArea = '".$codarea->CodArea."'");
        $data = ['disciples' => count($disciples)];
        return view('dashboard.mentor', $data);
    }

    public function show_dashboard_lidercdp(){
        // CASAS DE PAZ
        $CDPs = Tabcasasdepaz::where('CodLid', Auth::user()->codcon)->get();
        // MIEMBROS EN LA RED
        $CDPs = Tabcasasdepaz::select('CodCasPaz', 'TotMimCasPaz')->where('CodLid', Auth::user()->codcon)->get();
        // dd($CDPs);
        $total = 0;
        foreach($CDPs as $CDP){
            $miembros = DB::table('TabMimCasPaz')
                    ->join('TabCasasDePaz', 'TabMimCasPaz.CodCasPaz', '=', 'TabCasasDePaz.CodCasPaz')
                    ->where('TabCasasDePaz.CodCasPaz', $CDP->CodCasPaz)
                    ->get();
            $total = count($miembros)+$total;
        }            

        $data = ['CDPs' => count($CDPs), 'miembros' => $total];
        return view('dashboard.lidercdp', $data);
    }

    public function show_dashboard_admin(){            
        $CDPs = Tabcasasdepaz::count();
        $asis = Tabasi::where('FecAsi', date('Y-m-d'))->first();
        $members = Tabcon::where('EstCon', 'ACTIVO')->count();
        // $cultos = TabAsi::select('CodAsi', 'FecAsi', 'TipAsi')->where('CodAct', '001')->OrderBy('FecAsi', 'desc')->take(10)->get();
        $cultos = DB::select("SELECT CodAsi, FecAsi, TipAsi FROM TabAsi WHERE CodAct = '001' ORDER BY FecAsi DESC LIMIT 10");
        $data = ['CDPs' => $CDPs, 'asis' => $asis, 'members' => $members, 'cultos' => $cultos];
        return view('dashboard.administracion', $data);
    }
}