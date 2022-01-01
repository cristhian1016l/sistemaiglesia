<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Tabcon;
use App\Tabgrupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DisciplesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getDisciples(){
        // $codarea = DB::select("SELECT CodArea FROM TabGrupos WHERE CodCon = '".Auth::user()->codcon."' AND TipGrup = 'D'");
        $codarea = Tabgrupos::select('CodArea')
                            ->where('CodCon', Auth::user()->codcon)
                            ->where('TipGrup', 'D')
                            ->first();
        $disciples = DB::select("SELECT c.EstaEnProceso, c.CodCon, c.ApeCon, c.NomCon, c.FecNacCon, c.DirCon, c.NumCel 
                            FROM TabGruposMiem m INNER JOIN TabCon c ON m.CodCon = c.CodCon WHERE m.CodArea = '".$codarea->CodArea."' ORDER BY c.ApeCon");
        $data = ['disciples' => $disciples];
        return view('mentor.disciples.index', $data);
    }

    public function getDetailsDisciple($codcon){
        $codigo = substr($codcon, 4);
        $member = Tabcon::where('CodCon', $codigo)->first();
        $data = ["member" => $member];
        return view('mentor.disciples.show', $data);
    }
}
