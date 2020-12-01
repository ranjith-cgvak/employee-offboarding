<?php

namespace App\Http\Controllers;
use App\Support\Facades\DB;
use App\User;
use App\Resignation;
use Illuminate\Http\Request;
class ResignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table('resignations')
        ->where([
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ])
        ->first();
        $user = \DB::table('users')->where('emp_id',$empId)->first();
        return view('resignation.resignationDetails', compact('myResignation','user'));
    }

    public function showAcceptanceStatus() {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table('resignations')
        ->where([
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ])
        ->first();
        $user = \DB::table('users')->where('emp_id',$empId)->first();
        return view('resignation.acceptanceStatus', compact('myResignation','user'));
    }

    public function showWithdrawForm() {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table('resignations')
        ->where([
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ])
        ->first();
        $user = \DB::table('users')->where('emp_id',$empId)->first();
        return view('resignation.withdrawForm', compact('myResignation','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table('resignations')
        ->where([
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ])
        ->first();
        $user = \DB::table('users')->where('emp_id',$empId)->first();
        return view('resignation.create', compact('myResignation','user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'reason'=>'required'
        ]);
        $empId = \Auth::User()->emp_id;
        $dateofleaving = date("Y-m-d",strtotime($request->get('dateOfLeaving')));
        $resignation = new resignation([
            'reason' => $request->get('reason'),
            'date_of_resignation' => $request->get('dateOfResignation'),
            'comment_on_resignation' => $request->get('comment_on_resignation')
        ]);
        if($request->get('others') != NULL ) {
            $resignation->other_reason = $request->get('others');
        } 
        $resignation->employee_id = $empId;
        $resignation->date_of_leaving = $dateofleaving;
        $resignation->save();
        return redirect('/resignation')->with('success','Details saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'comment'=>'required'
        ]);
        $resignation = Resignation::find($id);
        $withdrawDate = date("Y-m-d",strtotime($request->get('withdrawDate')));
        $resignation->date_of_withdraw = $withdrawDate;
        $resignation->comment = $request->get('comment');
        $resignation->save();
        return redirect('/resignation/create')->with('success','Details saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
