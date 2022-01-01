<?php

namespace App\Http\Controllers\Finance;

use App\Activity;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getActivities(){
        $activities = Activity::all();
        $data = ['activities' => $activities];
        return view('finance.activity.index', $data);
    }    
    
    public function create()
    {        
        return view('finance.activity.create');
    }

    public function create_activity(Request $request)
    {
        try{
            $activity = new Activity();
            $activity->activity = $request->activity;            
            $activity->description = $request->description;
            $activity->save();
            return redirect('/tesoreria/actividades')
                ->with('msg', 'Nueva actividad registrada correctamente')
                ->with('type-alert', 'success');
        } catch (\Exception $th) {
            return redirect('/tesoreria/actividades/agregar')->withInput()
                ->with('msg', $th->getMessage())
                ->with('type-alert', 'warning');
        }             
        
    }

} 
