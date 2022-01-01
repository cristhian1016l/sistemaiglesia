<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Tabasi;
use App\Tabgrupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getGraphicAssistance()
    {
        $codarea = Tabgrupos::select('CodArea')
                            ->where('CodCon', Auth::user()->codcon)
                            ->where('TipGrup', 'D')
                            ->first();
        $disciples = DB::select("SELECT CodCon FROM TabGruposMiem WHERE CodArea = '".$codarea->CodArea."'");
        $tabasi = DB::select("SELECT CodAsi, DATE(FecAsi) as FecAsi FROM TabAsi WHERE CodAct = '002' ORDER BY FecAsi DESC LIMIT 7");

        $listnow = [];
        $final_list = [];
        $cantidad = 0;
        foreach($tabasi as $ta){
            // foreach($disciples as $dis){
            //     $asi = DB::select("SELECT CodAsi, CodCon, NomApeCon, Asistio FROM TabDetAsi WHERE CodAsi = '".$ta->CodAsi."' AND CodCon = '".$dis->CodCon."'");
            //     if($asi[0]->Asistio == 1){
            //         array_push($listnow, ['asi' => $asi[0]->CodCon, 'fecha' => $ta->FecAsi]);
            //     }
            // }
            foreach($disciples as $dis){                
                $asi = DB::select("SELECT Asistio FROM TabDetAsi WHERE CodAsi = '".$ta->CodAsi."' AND CodCon = '".$dis->CodCon."'");
                if($asi[0]->Asistio == 1){
                    $cantidad++;
                    // array_push($listnow, ['asi' => $i]);
                }                
            }
            array_push($final_list, ['TotAsistencia' => $cantidad, 'FecAsi' => $ta->FecAsi]);
            $cantidad = 0;
        }

        $data = ['disciples' => $final_list];
        return response()->json($data);
    }
}
