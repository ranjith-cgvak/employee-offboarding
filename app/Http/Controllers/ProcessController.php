<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resignation;
use App\User;
use App\Feedback;
use App\NoDue;
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
        // Head
        if ( \Auth::User()->designation_id == 3 ) {
            $emp_list = \DB::table( 'resignations' )
            ->select( 'resignations.id', 'employee_id', 'display_name', 'name', 'designation', 'date_of_resignation', 'date_of_leaving', 'date_of_withdraw', 'lead', 'comment_head', 'comment_dol_head', 'changed_dol' )
            ->join( 'users', 'resignations.employee_id', '=', 'users.emp_id' )
            ->get();
        }
        //HR OR SA
        else if ( ( \Auth::User()->department_id == 2 ) || ( \Auth::User()->department_id == 7 ) ) {
            $emp_list = \DB::table( 'resignations' )
            ->select( 'resignations.id', 'employee_id', 'display_name', 'name', 'designation', 'date_of_resignation', 'date_of_leaving', 'date_of_withdraw', 'lead', 'comment_head', 'comment_dol_head', 'changed_dol' )
            ->join( 'users', 'resignations.employee_id', '=', 'users.emp_id' )
            ->get();
        }
        //LEAD
        else {
            $leadName = \Auth::User()->display_name;
            $emp_list = \DB::table( 'resignations' )
            ->select( 'resignations.id', 'employee_id', 'display_name', 'name', 'designation', 'date_of_resignation', 'date_of_leaving', 'date_of_withdraw', 'lead', 'comment_head', 'comment_dol_head', 'changed_dol' )
            ->join( 'users', 'resignations.employee_id', '=', 'users.emp_id' )
            ->where( 'lead', $leadName )
            ->get();
        }
        $lead_list = \DB::table( 'users' )
        ->where( 'designation_id', 2 )
        ->get();

        return view( 'process.resignationList', compact( 'emp_list', 'lead_list' ) );
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

    public function store( Request $request )
 {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id )
 {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id )
 {
        $emp_resignation = \DB::table( 'resignations' )
        ->select( 'resignations.id', 'employee_id', 'display_name', 'department_name', 'comment_on_resignation', 'name', 'designation', 'joining_date', 'date_of_resignation', 'date_of_leaving', 'date_of_withdraw', 'lead', 'users.created_at', 'reason', 'comment', 'comment_head', 'comment_dol_head', 'comment_lead', 'comment_dol_lead', 'comment_hr', 'comment_dol_hr', 'comment_dow_lead', 'comment_dow_head', 'comment_dow_hr', 'changed_dol', 'other_reason' )
        ->join( 'users', 'resignations.employee_id', '=', 'users.emp_id' )
        ->where( 'resignations.id', $id )
        ->first();
        //Converting the dates to dd-mm-yyyy
        $joining_date = strtotime( $emp_resignation->joining_date );
        $date_of_resignation = strtotime( $emp_resignation->date_of_resignation );
        $date_of_leaving = strtotime( $emp_resignation->date_of_leaving );
        $changed_dol = strtotime( $emp_resignation->changed_dol );

        $converted_joining_date = date( 'd-m-Y', $joining_date );
        $converted_resignation_date = date( 'd-m-Y', $date_of_resignation );
        $converted_leaving_date = date( 'd-m-Y', $date_of_leaving );
        $converted_changed_dol = date( 'd-m-Y', $changed_dol );

        $converted_dates = array( 'joining_date'=>$converted_joining_date, 'date_of_resignation'=>$converted_resignation_date, 'date_of_leaving'=>$converted_leaving_date, 'changed_dol'=>$converted_changed_dol );

        $feedback = \DB::table( 'feedback' )
        ->where( 'feedback.resignation_id', $id )
        ->first();
        $nodue = \DB::table( 'no_dues' )
        ->where( 'no_dues.resignation_id', $id )
        ->first();
        $emp_id=\Auth::User()->emp_id ;
        $answers = \DB::table( 'user_answers' )
        ->Join( 'questions', 'questions.id', '=', 'user_answers.question_id' )
        ->where( 'user_answers.resignation_id', $id )
        ->get();
        return view( 'process.viewResignation', compact( 'emp_resignation', 'isFeedback', 'feedback', 'converted_dates', 'nodue','answers' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    //Updating lead for the user in process.resignationList blade

    public function update( Request $request, $id )
 {
        $request->validate( [
            'lead'=>'required'
        ] );
        $user = User::where( 'emp_id', $id )->first();
        $user->lead = $request->get( 'lead' );
        $user->save();

        return redirect( '/process' );
    }

    //Updating date of leaving

    public function updateDol( Request $request ) {
        $request->validate( [
            'commentDol'=>'required'
        ] );
        $resignationId = $request->get( 'resignationId' );
        $resignation = Resignation::find( $resignationId );
        $resignation->changed_dol = $request->get( 'dateOfLeaving' );
        //HEAD
        if ( \Auth::User()->designation_id == 3 ) {
            $resignation->comment_dol_head = $request->get( 'commentDol' );
        }
        //LEAD
        else if ( \Auth::User()->department_id == 2 ) {
            $resignation->comment_dol_hr = $request->get( 'commentDol' );
        } else {
            $resignation->comment_dol_lead = $request->get( 'commentDol' );
        }
        $resignation->save();
        return redirect()->route( 'process.edit', ['process' => $resignationId] );
    }

    //updating resignation comment

    public function updateResignationComment( Request $request ) {
        $resignationId = $request->get( 'resignationId' );
        $resignation = Resignation::find( $resignationId );
        //Head
        if ( \Auth::User()->designation_id == 3 ) {
            $request->validate( [
                'headComment'=>'required'
            ] );
            $resignation->comment_head = $request->get( 'headComment' );
        }
        //HR
        else if ( \Auth::User()->department_id == 2 ) {
            $request->validate( [
                'hrComment'=>'required'
            ] );
            $resignation->comment_hr = $request->get( 'hrComment' );
        } else {
            $request->validate( [
                'leadComment'=>'required'
            ] );
            $resignation->comment_lead = $request->get( 'leadComment' );
        }
        $resignation->save();
        return redirect()->route( 'process.edit', ['process' => $resignationId] );
    }

    //Updating date of withdraw comment

    public function updateDowComment( Request $request ) {
        $resignationId = $request->get( 'resignationId' );
        $resignation = Resignation::find( $resignationId );
        //Head
        if ( \Auth::User()->designation_id == 3 ) {
            $request->validate( [
                'withdrawHeadComment'=>'required'
            ] );
            $resignation->comment_dow_head = $request->get( 'withdrawHeadComment' );
        }
        //HR
        else if ( \Auth::User()->department_id == 2 ) {
            $request->validate( [
                'withdrawHrComment'=>'required'
            ] );
            $resignation->comment_dow_hr = $request->get( 'withdrawHrComment' );
        } else {
            $request->validate( [
                'withdrawLeadComment'=>'required'
            ] );
            $resignation->comment_dow_lead = $request->get( 'withdrawLeadComment' );
        }
        $resignation->save();
        return redirect()->route( 'process.edit', ['process' => $resignationId] );
    }

    //Storing feedback for the resignation

    public function storeFeedback( Request $request ) {
        $request->validate( [
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
        ] );
        $resignationId = $request->get( 'resignationId' );
        $feedbackDate = date( 'Y-m-d', strtotime( $request->get( 'date_of_feedback' ) ) );
        $feedback = new feedback( [
            'resignation_id' => $request->get( 'resignationId' ),
            'skill_set_primary' => $request->get( 'primary_skill' ),
            'skill_set_secondary' => $request->get( 'secondary_skill' ),
            'last_worked_project' => $request->get( 'last_worked_project' ),
            'attendance_rating' => $request->get( 'attendance' ),
            'responsiveness_rating' => $request->get( 'reponsiveness' ),
            'responsibility_rating' => $request->get( 'reponsibility' ),
            'commitment_on_task_delivery_rating' => $request->get( 'commit_on_task_delivery' ),
            'technical_knowledge_rating' => $request->get( 'technical_knowledge' ),
            'logical_ability_rating' => $request->get( 'logical_ablitiy' ),
            'attitude_rating' => $request->get( 'attitude' ),
            'overall_rating' => $request->get( 'overall_performance' )
        ] );
        //Head login
        if ( \Auth::User()->designation_id == 3 ) {
            $feedback->head_comment = $request->get( 'feedback_comments' );
        }
        //lead
        else {
            $feedback->lead_comment = $request->get( 'feedback_comments' );
        }
        $feedback->feedback_date = $feedbackDate;
        $feedback->save();
        return redirect()->route( 'process.edit', ['process' => $resignationId] );
    }

    //Updating feedback for the resignation

    public function updateFeedback( Request $request ) {
        $request->validate( [
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
        ] );
        $feedbackId = $request->get( 'feedbackId' );
        $resignationId = $request->get( 'resignationId' );
        $feedbackDate = date( 'Y-m-d', strtotime( $request->get( 'date_of_feedback' ) ) );
        $updateFeedback = Feedback::find( $feedbackId );
        $updateFeedback->skill_set_primary =  $request->get( 'primary_skill' );
        $updateFeedback->skill_set_secondary = $request->get( 'secondary_skill' );
        $updateFeedback->last_worked_project = $request->get( 'last_worked_project' );
        $updateFeedback->attendance_rating = $request->get( 'attendance' );
        $updateFeedback->responsiveness_rating = $request->get( 'reponsiveness' );
        $updateFeedback->responsibility_rating = $request->get( 'reponsibility' );
        $updateFeedback->commitment_on_task_delivery_rating = $request->get( 'commit_on_task_delivery' );
        $updateFeedback->technical_knowledge_rating = $request->get( 'technical_knowledge' );
        $updateFeedback->logical_ability_rating = $request->get( 'logical_ablitiy' );
        $updateFeedback->attitude_rating = $request->get( 'attitude' );
        $updateFeedback->overall_rating = $request->get( 'overall_performance' );
        $updateFeedback->feedback_date = $feedbackDate;

        if ( \Auth::User()->designation_id == 3 ) {
            $updateFeedback->head_comment = $request->get( 'feedback_comments' );
        } else {
            $updateFeedback->lead_comment = $request->get( 'feedback_comments' );
        }
        $updateFeedback->save();
        return redirect()->route( 'process.edit', ['process' => $resignationId] );
    }

    //Storing No Due forms for the resignation

    public function storeNodue( Request $request ) {

        $resignationId = $request->get( 'resignationId' );
        $nodue = new NoDue( [
            'resignation_id' => $request->get( 'resignationId' )
        ] );
        //Head or lead login
        if ( ( \Auth::User()->designation_id == 3 ) || ( \Auth::User()->designation_id == 2 ) ) {
            $request->validate( [
                'knowledge_transfer'=>'required',
                'knowledge_transfer_comment'=>'required',
                'mail_id_closure'=>'required',
                'mail_id_closure_comment'=>'required'
            ] );
            //Lead login
            if ( \Auth::User()->designation_id == 2 ) {
                $nodue->knowledge_transfer_lead = $request->get( 'knowledge_transfer' );
                $nodue->knowledge_transfer_lead_comment =  $request->get( 'knowledge_transfer_comment' );
                $nodue->mail_id_closure_lead = $request->get( 'mail_id_closure' );
                $nodue->mail_id_closure_lead_comment = $request->get( 'mail_id_closure_comment' );
            }
            //Head login
            if ( \Auth::User()->designation_id == 3 ) {
                $nodue->knowledge_transfer_head = $request->get( 'knowledge_transfer' );
                $nodue->knowledge_transfer_head_comment =  $request->get( 'knowledge_transfer_comment' );
                $nodue->mail_id_closure_head = $request->get( 'mail_id_closure' );
                $nodue->mail_id_closure_head_comment = $request->get( 'mail_id_closure_comment' );
            }
        }
        //HR Store
        if ( \Auth::User()->department_id == 2 ) {
            $request->validate( [
                'id_card'=>'required',
                'id_card_comment'=>'required',
                'nda'=>'required',
                'nda_comment'=>'required'
            ] );

            $nodue->id_card = $request->get( 'id_card' );
            $nodue->id_card_comment =  $request->get( 'id_card_comment' );
            $nodue->nda = $request->get( 'nda' );
            $nodue->nda_comment = $request->get( 'nda_comment' );
        }
        //SA store
        if ( \Auth::User()->department_id == 7 ) {
            $request->validate( [
                'official_email_id'=>'required',
                'official_email_id_comment'=>'required',
                'skype_account'=>'required',
                'skype_account_comment'=>'required'
            ] );

            $nodue->official_email_id = $request->get( 'official_email_id' );
            $nodue->official_email_id_comment =  $request->get( 'official_email_id_comment' );
            $nodue->skype_account = $request->get( 'skype_account' );
            $nodue->skype_account_comment = $request->get( 'skype_account_comment' );
        }
        $nodue->save();
        return redirect()->route( 'process.edit', ['process' => $resignationId] );
    }

    //Update No due forms for resignation

    public function updateNodue( Request $request ) {
        $nodueId = $request->get( 'nodueId' );
        $resignationId = $request->get( 'resignationId' );
        $updateNodue = NoDue::find( $nodueId );

        //Head or Lead update
        if ( ( \Auth::User()->designation_id == 3 ) || ( \Auth::User()->designation_id == 2 ) ) {
            $request->validate( [
                'knowledge_transfer'=>'required',
                'knowledge_transfer_comment'=>'required',
                'mail_id_closure'=>'required',
                'mail_id_closure_comment'=>'required'
            ] );
            if ( \Auth::User()->designation_id == 2 ) {
                $updateNodue->knowledge_transfer_lead = $request->get( 'knowledge_transfer' );
                $updateNodue->knowledge_transfer_lead_comment =  $request->get( 'knowledge_transfer_comment' );
                $updateNodue->mail_id_closure_lead = $request->get( 'mail_id_closure' );
                $updateNodue->mail_id_closure_lead_comment = $request->get( 'mail_id_closure_comment' );
            }
            if ( \Auth::User()->designation_id == 3 ) {
                $updateNodue->knowledge_transfer_head = $request->get( 'knowledge_transfer' );
                $updateNodue->knowledge_transfer_head_comment =  $request->get( 'knowledge_transfer_comment' );
                $updateNodue->mail_id_closure_head = $request->get( 'mail_id_closure' );
                $updateNodue->mail_id_closure_head_comment = $request->get( 'mail_id_closure_comment' );
            }
        }

        //HR update
        if ( \Auth::User()->department_id == 2 ) {
            $request->validate( [
                'id_card'=>'required',
                'id_card_comment'=>'required',
                'nda'=>'required',
                'nda_comment'=>'required'
            ] );

            $updateNodue->id_card = $request->get( 'id_card' );
            $updateNodue->id_card_comment =  $request->get( 'id_card_comment' );
            $updateNodue->nda = $request->get( 'nda' );
            $updateNodue->nda_comment = $request->get( 'nda_comment' );
        }

        //SA update
        if ( \Auth::User()->department_id == 7 ) {
            $request->validate( [
                'official_email_id'=>'required',
                'official_email_id_comment'=>'required',
                'skype_account'=>'required',
                'skype_account_comment'=>'required'
            ] );

            $updateNodue->official_email_id = $request->get( 'official_email_id' );
            $updateNodue->official_email_id_comment =  $request->get( 'official_email_id_comment' );
            $updateNodue->skype_account = $request->get( 'skype_account' );
            $updateNodue->skype_account_comment = $request->get( 'skype_account_comment' );
        }
        $updateNodue->save();
        return redirect()->route( 'process.edit', ['process' => $resignationId] );
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id )
 {
        //
    }
}
