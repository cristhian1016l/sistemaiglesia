<?php

namespace App\Http\Controllers\Liderred;

use App\Http\Controllers\Controller;
use App\ReportMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ObservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getObservations(){
        $observations = ReportMember::join('TabCon', 'report_members.codlid', 'TabCon.CodCon')
                        ->where('TabCon.ID_Red', Auth::user()->tabredes->ID_RED)->get();
        $data = ['observations' => $observations];
        return view('liderred.observations.index', $data);
    }
}
