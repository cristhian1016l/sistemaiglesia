<?php

namespace App\Http\Controllers\Liderred;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Tabcon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getMembers()
    {
        $members = DB::table('TabCon')->where('EstCon', 'ACTIVO')->where('ID_Red', Auth::user()->tabredes->ID_RED)->orderBy('ApeCon')->get();
        $data = ['members' => $members];
        return view('liderred.membresia.index', $data);
    }

    public function getDetailsMember($codcon)
    {
        $members = TabCon::select('CodCon')->where('ID_Red', Auth::user()->tabredes->ID_RED)->get();
        // $array = array("1","2","3");
        $array = array();

        foreach($members as $member){
            array_push($array, $member->CodCon);
        }
        
        if(in_array($codcon, $array)){
            $member = Tabcon::where('CodCon', $codcon)->first();
            $data = ["member" => $member];
            return view('liderred.membresia.detailsMember', $data);
        }else{
            abort(403);
        };        
    }

    public function QRGenerate($codcon)
    {
        return QrCode::size(400)->generate($codcon);
    }
}
