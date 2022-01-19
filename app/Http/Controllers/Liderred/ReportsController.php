<?php

namespace App\Http\Controllers\Liderred;

use App\Http\Controllers\Controller;
use App\Tabredes;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function FaultsOfMemberDownload(Request $request){
        $datosRed = Tabredes::select('ID_RED')->where('LID_RED', Auth::user()->codcon)->first();        
        $id_red = $datosRed->ID_RED;
        $datos = array();
        $cdps = DB::select("SELECT cdp.CodCasPaz, c.ApeCon, c.NomCon FROM TabCasasDePaz cdp INNER JOIN TabCon c 
                            ON cdp.CodLid = c.CodCon WHERE cdp.ID_Red = '".$id_red."' ORDER BY cdp.CodCasPaz");
        foreach($cdps as $cdp){
            $cdps = DB::select("SELECT da.NomApeCon, da.EstAsi, c.NumCel FROM TabDetAsi da
                            INNER JOIN TabMimCasPaz mcdp ON da.CodCon = mcdp.CodCon
                            INNER JOIN TabCon c ON mcdp.CodCon = c.CodCon
                            WHERE da.CodAsi = '".$request->culto."' AND mcdp.CodCasPaz = '".$cdp->CodCasPaz."' AND da.EstAsi = 'F' ORDER BY da.NomApeCon");
            array_push($datos, ["cdp" => $cdp->CodCasPaz, "lider" => $cdp->ApeCon.' '.$cdp->NomCon, "members" => $cdps]);
        }

        // dd($datos);
        // $request->culto
        $data = ['cdps' => $datos];
        $pdf=PDF::loadView('liderred.reportes_cdp.faultToCults', $data);
        return $pdf->stream();
    }

}
