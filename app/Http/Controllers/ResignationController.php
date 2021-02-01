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
        $myResignation = \DB::table( 'resignations' )
        ->where( [
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ] )
        ->first();
        $user = \DB::table( 'users' )->where( 'emp_id', $empId )->first();
        //Converting the dates to dd-mm-yyyy
        $joining_date = strtotime( $user->joining_date );
        $date_of_resignation = strtotime( $myResignation->date_of_resignation );
        $date_of_leaving = strtotime( $myResignation->date_of_leaving );
        $changed_dol = strtotime( $myResignation->changed_dol );

        $converted_joining_date = date( 'd-m-Y', $joining_date );
        $converted_resignation_date = date( 'd-m-Y', $date_of_resignation );
        $converted_leaving_date = date( 'd-m-Y', $date_of_leaving );
        $converted_changed_dol = date( 'd-m-Y', $changed_dol );

        $converted_dates = array( 'joining_date'=>$converted_joining_date, 'date_of_resignation'=>$converted_resignation_date, 'date_of_leaving'=>$converted_leaving_date, 'changed_dol'=>$converted_changed_dol );

        return view( 'resignation.resignationDetails', compact( 'myResignation', 'user', 'converted_dates' ) );
    }

    //Acceptance status of the resignation
    public function resignationProgress() {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table('resignations')
        ->where([
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ])
        ->first();
        $user = \DB::table('users')->where('emp_id',$empId)->first();
        return view('resignation.progress', compact('myResignation','user'));
    }

    //Acceptance status of the resignation
    public function showAcceptanceStatus() {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table( 'resignations' )
        ->where( [
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ] )
        ->first();
        $user = \DB::table( 'users' )->where( 'emp_id', $empId )->first();
        //Converting the dates to dd-mm-yyyy
        $joining_date = strtotime( $user->joining_date );
        $converted_joining_date = date( 'd-m-Y', $joining_date );
        $converted_dates = array( 'joining_date'=>$converted_joining_date );

        $comments = \DB::table( 'comments' )
        ->where( 'comments.resignation_id', $myResignation->id )
        ->get();

        $leadGeneralComment = NULL;
        $headGeneralComment = NULL;
        $hrGeneralComment = NULL;

        foreach ( $comments as $comment ) {
            if ( $comment->comment_type == 'general' && $comment->comment_by == 'lead' ) {
                $leadGeneralComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
            }
            if ( $comment->comment_type == 'general' && $comment->comment_by == 'head' ) {
                $headGeneralComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
            }
            if ( $comment->comment_type == 'general' && $comment->comment_by == 'hr' ) {
                $hrGeneralComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
            }
        }

        return view( 'resignation.acceptanceStatus', compact( 'myResignation', 'user', 'converted_dates', 'leadGeneralComment', 'headGeneralComment', 'hrGeneralComment' ) );
    }

    //No due status of the resignation

    public function noDueStatus() {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table( 'resignations' )
        ->where( [
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ] )
        ->first();
        $nodue = \DB::table( 'no_dues' )
        ->where( 'no_dues.resignation_id', $myResignation->id )
        ->first();
        $answers = \DB::table( 'user_answers' )
        ->Join( 'questions', 'questions.id', '=', 'user_answers.question_id' )
        ->where( 'user_answers.resignation_id', $myResignation->id )
        ->get();
        $user = \DB::table( 'users' )->where( 'emp_id', $empId )->first();
        //Converting the dates to dd-mm-yyyy
        $joining_date = strtotime($user->joining_date);
        $converted_joining_date = date("d-m-Y", $joining_date);
        $converted_dates = array("joining_date"=>$converted_joining_date);
        
        $answers = \DB::table('user_answers')
        ->where('user_answers.resignation_id',$myResignation->id)
        ->first();

        return view('resignation.noDueStatus', compact('myResignation','user','converted_dates','nodue','answers'));
    }

    //Withdraw for the resignation

    public function showWithdrawForm() {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table( 'resignations' )
        ->where( [
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ] )
        ->first();
        $user = \DB::table( 'users' )->where( 'emp_id', $empId )->first();
        //Converting the dates to dd-mm-yyyy
        $joining_date = strtotime( $user->joining_date );
        $converted_joining_date = date( 'd-m-Y', $joining_date );
        $converted_dates = array( 'joining_date'=>$converted_joining_date );

        return view( 'resignation.withdrawForm', compact( 'myResignation', 'user', 'converted_dates' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create()
 {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table( 'resignations' )
        ->where( [
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ] )
        ->first();
        $user = \DB::table( 'users' )->where( 'emp_id', $empId )->first();
        //Converting the dates to dd-mm-yyyy
        $joining_date = strtotime( $user->joining_date );
        $converted_joining_date = date( 'd-m-Y', $joining_date );
        $converted_dates = array( 'joining_date'=>$converted_joining_date );

        return view( 'resignation.create', compact( 'myResignation', 'user', 'converted_dates' ) );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request )
 {
        $request->validate( [
            'reason'=>'required'
        ] );
        $empId = \Auth::User()->emp_id;
        $dateofleaving = date( 'Y-m-d', strtotime( $request->get( 'dateOfLeaving' ) ) );
        $resignation = new resignation( [
            'reason' => $request->get( 'reason' ),
            'date_of_resignation' => $request->get( 'dateOfResignation' ),
            'comment_on_resignation' => $request->get( 'comment_on_resignation' )
        ] );
        if ( $request->get( 'others' ) != NULL ) {
            $resignation->other_reason = $request->get( 'others' );
        }

        $resignation->employee_id = $empId;
        $resignation->date_of_leaving = $dateofleaving;
        $resignation->changed_dol = $dateofleaving;
        $resignation->save();
        $notification=array(
            'message' => 'Resignation Applied Successfully',
            'alert-type' => 'success'
        );

        //Sending mail
        $subject = "New Resignation Applied!";
        $template = "emails.resignationMail";
        $details = [
            'name' => \Auth::User()->display_name,
            'content' => 'has applied resignation',
            'date' => $request->get( 'dateOfResignation' )
        ];
       
        \Mail::to([config('constants.HEAD_EMAIL'),config('constants.HR_EMAIL')])->cc(config('constants.LEAD_EMAIL'))->send(new \App\Mail\SendMail($details,$subject,$template));
        return redirect('/resignation')->with($notification);
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
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    //Updating the withdraw details

    public function update( Request $request, $id )
 {
        $request->validate( [
            'comment'=>'required'
        ] );
        $resignation = Resignation::find( $id );
        $withdrawDate = date( 'Y-m-d', strtotime( $request->get( 'withdrawDate' ) ) );
        $resignation->date_of_withdraw = $withdrawDate;
        $resignation->comment_on_withdraw = $request->get( 'comment' );
        $resignation->save();
        $notification=array(
            'message' => 'Resignation has been withdrawn!',
            'alert-type' => 'error'
        );

        //Sending mail
        $subject = "Resignation Withdrawn!";
        $template = "emails.withdrawMail";
        $details = [
            'name' => \Auth::User()->display_name,
            'content' => 'has withdrawn resignation',
            'date' => $withdrawDate
        ];
       
        \Mail::to([config('constants.HEAD_EMAIL'),config('constants.HR_EMAIL')])->cc(config('constants.LEAD_EMAIL'))->send(new \App\Mail\SendMail($details,$subject,$template));

        return redirect('/resignation/create')->with($notification);
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
