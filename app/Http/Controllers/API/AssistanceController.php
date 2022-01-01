<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssistanceController extends Controller
{
    public function ReportAssistanceService(Request $request){
        $SQLMembers = DB::select("SELECT da.CodCon, da.NomApeCon, da.Asistio FROM TabAsi a INNER JOIN TabDetAsi da ON a.Codasi = da.CodAsi
                      WHERE a.CodAsi = '".$request->CodAsi."' AND da.CodCon = '".$request->CodCon."'");
        return $SQLMembers;
    }
}
