<?php

namespace App\Http\Controllers;
use App\User;
use App\Resignation;
use App\HeadSelect;
use App\lead_selects;
use App\AcceptanceStatus;
use App\Support\Facades\DB;
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
        $department_heads = \DB::table( 'head_selects' )
        ->select('emp_id')
        ->get();
        $headId = [];
        foreach($department_heads as $department_head){
            $headId[] = $department_head->emp_id;
        }

<<<<<<< HEAD
        $department_heads = \DB::table( 'head_selects' )
        ->select('emp_id')
        ->get();
        $headId = [];
        foreach($department_heads as $department_head){
            $headId[] = $department_head->emp_id;
        }
=======
>>>>>>> 74a397b0d0be6613dc3bab54f78501164e1cde4f
        $department_leads = lead_selects::all();
        $leadId =[];
        foreach($department_leads as $department_lead){
            $leadId[] = $department_lead->emp_id;
        }
<<<<<<< HEAD
        return view( 'resignation.resignationDetails', compact( 'myResignation', 'user', 'converted_dates','headId','leadId' ) );
=======

        return view( 'resignation.resignationDetails', compact( 'myResignation', 'user', 'converted_dates', 'leadId', 'headId' ) );
>>>>>>> 74a397b0d0be6613dc3bab54f78501164e1cde4f
    }

    //Resignation progress status of the resignation
    public function resignationProgress() {
        $empId = \Auth::User()->emp_id;
        $myResignation = \DB::table('resignations')
        ->where([
            ['employee_id', '=', $empId],
            ['date_of_withdraw', '=', NULL],
        ])
        ->first();
        $completed_acceptance = \DB::table('acceptance_statuses')->where('resignation_id',$myResignation->id)->where('reviewed_by','hr')->first();
        $noDueStatus = 'sdsds';
        $completed_no_due = NULL;
        $exitInterview = \DB::table('user_answers')->where('resignation_id',$myResignation->id)->first();
        $finalChecklist = \DB::table('final_exit_checklists')->where('resignation_id',$myResignation->id)->first();
        $user = \DB::table('users')->where('emp_id',$empId)->first();
        return view('resignation.progress', compact('myResignation','user','noDueStatus','exitInterview','finalChecklist','completed_no_due','completed_acceptance'));
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

        $acceptanceStatuses = \DB::table( 'acceptance_statuses' )
        ->where( 'acceptance_statuses.resignation_id', $myResignation->id )
        ->get();

        $leadAcceptance = NULL;
        $headAcceptance = NULL;
        $hrAcceptance = NULL;
        foreach ( $acceptanceStatuses as $acceptanceStatus ) {
            if( $acceptanceStatus->reviewed_by == 'lead') {
                $leadAcceptance = $acceptanceStatus->acceptance_status;
            }
            if( $acceptanceStatus->reviewed_by == 'head') {
                $headAcceptance = $acceptanceStatus->acceptance_status;
            }
            if( $acceptanceStatus->reviewed_by == 'hr') {
                $hrAcceptance = $acceptanceStatus->acceptance_status;
            }
        }

        return view( 'resignation.acceptanceStatus', compact( 'myResignation', 'user', 'converted_dates', 'leadGeneralComment', 'headGeneralComment', 'hrGeneralComment','leadAcceptance','headAcceptance','hrAcceptance' ) );
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

        $nodues = \DB::table( 'no_dues' )
        ->where( 'no_dues.resignation_id', $myResignation->id )
        ->get();
        $nodueAttribute = NULL;
        foreach($nodues as $nodue) {
            if($nodue->attribute == 'Knowledge Transfer') {
                $nodueAttribute['knowledge_transfer_comment'] = $nodue->comment;
            }
            if($nodue->attribute == 'Mail ID closure') {
                $nodueAttribute['mail_closure'] = $nodue->comment;
            }
            if($nodue->attribute == 'ID Card') {
                $nodueAttribute['id_card'] = $nodue->comment;
            }
            if($nodue->attribute == 'NDA') {
                $nodueAttribute['nda'] = $nodue->comment;
            }
            if($nodue->attribute == 'Professional Tax') {
                $nodueAttribute['professional_tax'] = $nodue->comment;
            }
            if($nodue->attribute == 'Official Email ID') {
                $nodueAttribute['official_email_id'] = $nodue->comment;
            }
            if($nodue->attribute == 'Skype Account') {
                $nodueAttribute['skype_account'] = $nodue->comment;
            }
            if($nodue->attribute == 'Gmail or Yahoo Testing Purpose') {
                $nodueAttribute['gmail_yahoo'] = $nodue->comment;
            }
            if($nodue->attribute == 'Testing Tools') {
                $nodueAttribute['testing_tools'] = $nodue->comment;
            }
            if($nodue->attribute == 'Linux or Mac Machine Password') {
                $nodueAttribute['linux_mac_password'] = $nodue->comment;
            }
            if($nodue->attribute == 'Specific Tools For Renewal Details') {
                $nodueAttribute['renewal_tools'] = $nodue->comment;
            }
            if($nodue->attribute == 'Handover Testing Device') {
                $nodueAttribute['testing_device'] = $nodue->comment;
            }
            if($nodue->attribute == 'Headset') {
                $nodueAttribute['headset'] = $nodue->comment;
            }
            if($nodue->attribute == 'Machine Port Forwarding') {
                $nodueAttribute['machine_port_forwarding'] = $nodue->comment;
            }
            if($nodue->attribute == 'SVN & VSS & TFS Login Details') {
                $nodueAttribute['svn_vss_tfs'] = $nodue->comment;
            }
            if($nodue->attribute == 'RDP, VPN Connection') {
                $nodueAttribute['rdp_vpn'] = $nodue->comment;
            }
            if($nodue->attribute == 'Laptop and Data Card') {
                $nodueAttribute['laptop_datacard'] = $nodue->comment;
            }
            if($nodue->attribute == 'Salary Advance Due') {
                $nodueAttribute['salary_advance_due'] = $nodue->comment;
            }
            if($nodue->attribute == 'Income Tax Due') {
                $nodueAttribute['income_tax_due'] = $nodue->comment;
            }
            if($nodue->attribute == 'Documents For IT') {
                $nodueAttribute['documents_it'] = $nodue->comment;
            }
            if($nodue->attribute == 'Laptop') {
                $nodueAttribute['laptop'] = $nodue->comment;
            }
            if($nodue->attribute == 'Data Card') {
                $nodueAttribute['data_card'] = $nodue->comment;
            }
            if($nodue->attribute == 'Official Property If Any') {
                $nodueAttribute['official_property'] = $nodue->comment;
            }
            if($nodue->attribute == 'Exit Process Completion From Core Departments') {
                $nodueAttribute['exit_process_completion'] = $nodue->comment;
            }
            if($nodue->attribute == 'ISMS/QMS Incidents & Tickets Closure Status') {
                $nodueAttribute['isms_qms'] = $nodue->comment;
            }
            if($nodue->attribute == 'Disable All Access Control') {
                $nodueAttribute['disable_access'] = $nodue->comment;
            }
            if($nodue->attribute == 'KT completed for all the current and old projects') {
                $nodueAttribute['kt_completion'] = $nodue->comment;
            }
            if($nodue->attribute == 'Relieving date informed and accepted by client') {
                $nodueAttribute['relieving_date_informed'] = $nodue->comment;
            }
            if($nodue->attribute == 'All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)') {
                $nodueAttribute['internal_client_souce_code'] = $nodue->comment;
            }
            if($nodue->attribute == 'Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)') {
                $nodueAttribute['project_detail_document'] = $nodue->comment;
            }
            if($nodue->attribute == 'Handing over CLIENT details (Excel)') {
                $nodueAttribute['client_details_handle'] = $nodue->comment;
            }
            if($nodue->attribute == 'KT on HOT & WARM prospects') {
                $nodueAttribute['kt_hot_warm'] = $nodue->comment;
            }
            if($nodue->attribute == 'Introducing new account manager to CLIENTS via Email') {
                $nodueAttribute['intro_new_acc_manager'] = $nodue->comment;
            }
            if($nodue->attribute == 'Completion of Data Categorization') {
                $nodueAttribute['data_categorization'] = $nodue->comment;
            }
            if($nodue->attribute == 'RFP System updation') {
                $nodueAttribute['rfp_system'] = $nodue->comment;
            }
        }

        return view('resignation.noDueStatus', compact('myResignation','user','converted_dates','nodue','answers','completed_no_due','nodueAttribute'));
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

        $department_heads = \DB::table( 'head_selects' )
        ->select('emp_id')
        ->get();
        $headId = [];
        foreach($department_heads as $department_head){
            $headId[] = $department_head->emp_id;
        }
        $department_leads = lead_selects::all();
        $leadId =[];
        foreach($department_leads as $department_lead){
            $leadId[] = $department_lead->emp_id;
        }

<<<<<<< HEAD
        return view( 'resignation.create', compact( 'myResignation', 'user', 'converted_dates','headId','leadId' ) );
=======
        return view( 'resignation.create', compact( 'myResignation', 'user', 'converted_dates','headId', 'leadId' ) );
>>>>>>> 74a397b0d0be6613dc3bab54f78501164e1cde4f
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

        // \Mail::to([config('constants.HEAD_EMAIL'),config('constants.HR_EMAIL')])->cc(config('constants.LEAD_EMAIL'))->send(new \App\Mail\SendMail($details,$subject,$template));
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

        \DB::table('users')
        ->where('id', \Auth::User()->id)
        ->update(['lead' => NULL]);

        \DB::table('resignations')
        ->where('id', $id)
        ->update(['is_completed' => 0]);

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

        // \Mail::to([config('constants.HEAD_EMAIL'),config('constants.HR_EMAIL')])->cc(config('constants.LEAD_EMAIL'))->send(new \App\Mail\SendMail($details,$subject,$template));

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
