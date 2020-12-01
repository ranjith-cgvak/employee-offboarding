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
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table('resignations')
        ->where([
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ])
        ->count();
        
        if((\Auth::User()->designation_id == 2) || (\Auth::User()->designation_id == 3) || (\Auth::User()->department_id == 2)) {
            return redirect()->route('process.index');
        }
        else if($myResignation == 0) {
            return redirect()->route('resignation.create');
           }
        else{
            return redirect()->route('resignation.index');
       }
    }
}
