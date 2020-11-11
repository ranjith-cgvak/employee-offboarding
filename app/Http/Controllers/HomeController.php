<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Facades\DB;
use App\User;
use App\Resignation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employee = \Auth::User()->designation == "Software Engineer";
        $head = \Auth::User()->designation == "Head";
        $lead = \Auth::User()->designation == "Lead";
        $Hr = \Auth::User()->designation == "HR";
        $userId = auth()->id();
        $myResignation = \DB::table('resignations')
        ->where([
            ['user_id', '=', $userId],
            ['date_of_withdraw', '=', NULL],
        ])
        ->count();
        if($myResignation == 0 && $employee) {
         return redirect()->route('resignation.create');
        }
        else if($employee){
             return redirect()->route('resignation.index');
        }
        else if($lead) {
            return redirect()->route('process.index');
        }
        else if($head) {
            return redirect()->route('process.index');
        }
        else if($Hr) {
            return redirect()->route('process.index');
        }
    }
}
