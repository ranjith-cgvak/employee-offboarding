<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resignation;
use App\User;
use App\Feedback;
use App\Support\Facades\DB;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::User()->designation == "Head") {
        $emp_list = \DB::table('resignations')
        ->select('resignations.id','user_id','name','designation','date_of_resignation','date_of_leaving','date_of_withdraw','lead','comment_head','comment_dol_head','changed_dol')
        ->join('users', 'resignations.user_id', '=', 'users.id')
        ->get();
        }
        else if(\Auth::User()->designation == "HR" || \Auth::User()->designation == "SA") {
            $emp_list = \DB::table('resignations')
            ->select('resignations.id','user_id','name','designation','date_of_resignation','date_of_leaving','date_of_withdraw','lead','comment_head','comment_dol_head','changed_dol')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->get();
        }
        else {
            $leadName = \Auth::User()->name;
            $emp_list = \DB::table('resignations')
            ->select('resignations.id','user_id','name','designation','date_of_resignation','date_of_leaving','date_of_withdraw','lead','comment_head','comment_dol_head','changed_dol')
            ->join('users', 'resignations.user_id', '=', 'users.id')
            ->where('lead', $leadName)
            ->get();
        }
        $lead_list = \DB::table('users')
        ->where('designation','Lead')
        ->get();
        return view('process.resignationList', compact('emp_list','lead_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $emp_resignation = \DB::table('resignations')
        ->select('resignations.id','user_id','name','designation','date_of_resignation','date_of_leaving','date_of_withdraw','lead','users.created_at','reason','comment','comment_head','comment_dol_head','comment_lead','comment_dol_lead','comment_hr','comment_dol_hr','comment_dow_lead','comment_dow_head','comment_dow_hr','changed_dol','other_reason')
        ->join('users', 'resignations.user_id', '=', 'users.id')
        ->where('resignations.id',$id)
        ->first();
        $commenterId = auth()->id();
        $isFeedback = \DB::table('feedback')
        ->where('commenter_id',$commenterId)
        ->first();
        return view('process.viewResignation' , compact('emp_resignation','isFeedback'));
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
            'lead'=>'required'
        ]);
        $user = User::find($id);
        $user->lead = $request->get('lead');
        $user->save();

        return redirect('/process');
    }

    public function updateDol(Request $request) {
        $request->validate([
            'commentDol'=>'required'
        ]);
        $resignationId = $request->get('resignationId');
        $resignation = Resignation::find($resignationId);
        $resignation->changed_dol = $request->get('dateOfLeaving');
        if(\Auth::User()->designation == "Head") {
            $resignation->comment_dol_head = $request->get('commentDol');
        }
        else if(\Auth::User()->designation == "HR") {
            $resignation->comment_dol_hr = $request->get('commentDol');
        }
        else {
            $resignation->comment_dol_lead = $request->get('commentDol');
        }
        $resignation->save();
        return redirect()->route('process.edit', ['process' => $resignationId]);
    }

    public function updateResignationComment(Request $request) {
        $resignationId = $request->get('resignationId');
        $resignation = Resignation::find($resignationId);
        if(\Auth::User()->designation == "Head") {
            $request->validate([
                'headComment'=>'required'
            ]);
            $resignation->comment_head = $request->get('headComment');
        }
        else if(\Auth::User()->designation == "HR") {
            $request->validate([
                'hrComment'=>'required'
            ]);
            $resignation->comment_hr = $request->get('hrComment');
        }
        else {
            $request->validate([
                'leadComment'=>'required'
            ]);
            $resignation->comment_lead = $request->get('leadComment');
        }
        $resignation->save();
        return redirect()->route('process.edit', ['process' => $resignationId]);
    }

    public function updateDowComment(Request $request) {
        $resignationId = $request->get('resignationId');
        $resignation = Resignation::find($resignationId);
        if(\Auth::User()->designation == "Head") {
            $request->validate([
                'withdrawHeadComment'=>'required'
            ]);
            $resignation->comment_dow_head = $request->get('withdrawHeadComment');
        }
        else if(\Auth::User()->designation == "HR") {
            $request->validate([
                'withdrawHrComment'=>'required'
            ]);
            $resignation->comment_dow_hr = $request->get('withdrawHrComment');
        }
        else {
            $request->validate([
                'withdrawLeadComment'=>'required'
            ]);
            $resignation->comment_dow_lead = $request->get('withdrawLeadComment');
        }
        $resignation->save();
        return redirect()->route('process.edit', ['process' => $resignationId]);
    }

    public function storeFeedback(Request $request) {
        $request->validate([
            'primary_skill'=>'required',
            'secondary_skill'=>'required',
            'last_worked_project'=>'required',
            'attendance'=>'required',
            'reponsiveness'=>'required',
            'reponsibility'=>'required',
            'commit_on_task_delivery'=>'required',
            'technical_knowledge'=>'required',
            'logical_ablitiy'=>'required',
            'attitude'=>'required',
            'overall_performance'=>'required',
            'feedback_comments'=>'required'
        ]);
        $resignationId = $request->get('resignationId');
        $commenterId = auth()->id();
        $feedbackDate = date("Y-m-d",strtotime($request->get('date_of_feedback')));
        $feedback = new feedback([
            'emp_id' => $request->get('user_id'),
            'skill_set_primary' => $request->get('primary_skill'),
            'skill_set_secondary' => $request->get('secondary_skill'),
            'last_worked_project' => $request->get('last_worked_project'),
            'attendance_rating' => $request->get('attendance'),
            'responsiveness_rating' => $request->get('reponsiveness'),
            'responsibility_rating' => $request->get('reponsibility'),
            'commitment_on_task_delivery_rating' => $request->get('commit_on_task_delivery'),
            'technical_knowledge_rating' => $request->get('technical_knowledge'),
            'logical_ability_rating' => $request->get('logical_ablitiy'),
            'attitude_rating' => $request->get('attitude'),
            'overall_rating' => $request->get('overall_performance'),
            'comments' => $request->get('feedback_comments')
        ]);
        $feedback->feedback_date = $feedbackDate;
        $feedback->commenter_id = $commenterId;
        $feedback->save();
        return redirect()->route('process.edit', ['process' => $resignationId]);
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
