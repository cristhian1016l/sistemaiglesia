<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tabgrupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupsController extends Controller
{
    public function getGroups(){
        $groups = Tabgrupos::all();
        return $groups;
    }

    public function getDisciplesGroups()
    {
        $groups = Tabgrupos::select('CodArea', 'DesArea')->where('TipGrup', 'D')->orderBy('CodArea')->get();
        return $groups;
    }

    public function getGroupsMembers(Request $request){
        $groups_members = DB::select("SELECT c.CodCon, CONCAT(c.ApeCon, ' ', c.NomCon) as Nombres, c.TipCon, c.FecNacCon, c.NumCel, c.ApeCon, c.NomCon 
                    FROM TabGruposMiem gm INNER JOIN TabCon c ON gm.CodCon = c.CodCon WHERE CodArea = '".$request->CodArea."' ORDER BY c.ApeCon");    
        return $groups_members;
    }
    
    public function getGroupsTypes(Request $request){
        $groups = DB::select("SELECT g.CodArea, g.DesArea, CONCAT(m.ApeCon, ' ', m.NomCon) as Nombres, g.TipGrup FROM TabGrupos g INNER JOIN TabCon m ON g.CodCon = 
                            m.CodCon WHERE g.TipGrup = '".$request->TipGrup."' ORDER BY g.CodArea ASC");
        return $groups;
    }
}
