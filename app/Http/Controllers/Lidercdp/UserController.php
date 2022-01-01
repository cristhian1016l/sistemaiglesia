<?php

namespace App\Http\Controllers\Lidercdp;

use App\Http\Controllers\Controller;
use App\Tabcon;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
}
