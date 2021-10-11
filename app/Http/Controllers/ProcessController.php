<?php

namespace App\Http\Controllers;

use App\User;
use App\NoDue;
use App\Comments;
use App\Feedback;
use App\workflow;
use Carbon\Carbon;
use App\HeadSelect;
use App\WorkflowCc;
use App\Resignation;
use App\lead_selects;
use App\Helpers\Helper;
use App\AcceptanceStatus;
use App\FinalExitChecklist;
use App\Support\Facades\DB;
use Illuminate\Http\Request;
use App\HrExitInterviewComments;
use App\Jobs\ResignationEmailJob;

class ProcessController extends Controller
 {

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    function __constructor(){
        $this->middleware(['auth','backendAccess']);

    }

    public function index(){
        $loggedUserDepartmentId  = \Auth::User()->department_id;
        $leads_of_all_dept_list =  Helper::leadsList();

        $lead_dept_id = [];
        foreach($leads_of_all_dept_list as $leads){
            $lead_dept_id[] = $leads->designation_id;
        }

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
        $ids_for_list_all_resignations = config('constants.ids_for_list_all_resignations');

        $sql_emp = \DB::table('resignations')
                    ->select( 'resignations.id', 'employee_id', 'display_name', 'name', 'designation',  \DB::raw("DATE_FORMAT(date_of_resignation, '%d-%m-%Y') as date_of_resignation"), \DB::raw("DATE_FORMAT(date_of_leaving, '%d-%m-%Y') as date_of_leaving"), 'date_of_withdraw', 'lead', \DB::raw("DATE_FORMAT(changed_dol, '%d-%m-%Y') as changed_dol"), 'is_completed' )
                    ->join('users', 'resignations.employee_id', '=', 'users.emp_id');

        if(!in_array($loggedUserDepartmentId,$ids_for_list_all_resignations)){
            $sql_emp->where('users.department_id',$loggedUserDepartmentId);
        }

        $emp_list = $sql_emp->get();

        $lead_list = \DB::table( 'users' )
        ->where( 'users.department_id', \Auth::User()->department_id )
        // ->orWhere('users.department_id', 5)
        ->whereIn('designation_id', $lead_dept_id)
        ->get();




        return view( 'process.resignationList', compact( 'emp_list', 'lead_list','headId','leadId' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ){
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ){
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ){

        $emp_resignation = \DB::table( 'resignations' )
        ->select( 'resignations.id', 'employee_id', 'display_name', 'department_name', 'comment_on_resignation', 'name', 'designation', 'joining_date', 'date_of_resignation', 'date_of_leaving',\DB::raw("DATE_FORMAT(date_of_withdraw, '%d-%m-%Y') as date_of_withdraw"), 'lead', 'users.created_at', 'reason', 'comment_on_withdraw',\DB::raw("DATE_FORMAT(changed_dol, '%d-%m-%Y') as changed_dol"), 'other_reason' )
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
        // echo '<pre>';
        // print_r($converted_dates);
        // echo '</pre>';
        // die;

        $emp_id = \Auth::User()->emp_id ;

        // $answers = \DB::table( 'user_answers' )
        // ->Join( 'questions', 'questions.id', '=', 'user_answers.question_id' )
        // ->where( 'user_answers.resignation_id', $id )
        // ->get();

        // // echo '<pre>';
        // // print_r($answers);
        // // echo '</pre>';
        // // die;

        // $finalCheckList = \DB::table( 'final_exit_checklists' )
        // ->where( 'final_exit_checklists.resignation_id', $id )
        // ->first();
        $comments = \DB::table( 'comments' )
        ->where( 'comments.resignation_id', $id )
        ->get();
        // $resignation_id = $id;
        $leadGeneralComment = NULL;
        $headGeneralComment = NULL;
        $hrGeneralComment = NULL;
        $leadDowComment = NULL;
        $headDowComment = NULL;
        $hrDowComment = NULL;
        $leadDolComment = NULL;
        $headDolComment = NULL;
        $hrDolComment = NULL;

        // echo '<pre>';
        // echo empty($comments);
        // echo '</pre>';
        // die;
        if(!empty($comments)){
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
                if ( $comment->comment_type == 'withdraw' && $comment->comment_by == 'lead' ) {
                    $leadDowComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
                }
                if ( $comment->comment_type == 'withdraw' && $comment->comment_by == 'head' ) {
                    $headDowComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
                }
                if ( $comment->comment_type == 'withdraw' && $comment->comment_by == 'hr' ) {
                    $hrDowComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
                }
                if ( $comment->comment_type == 'date_of_leaving' && $comment->comment_by == 'lead' ) {
                    $leadDolComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
                }
                if ( $comment->comment_type == 'date_of_leaving' && $comment->comment_by == 'head' ) {
                    $headDolComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
                }
                if ( $comment->comment_type == 'date_of_leaving' && $comment->comment_by == 'hr' ) {
                    $hrDolComment = array( 'comment'=>$comment->comment, 'id'=>$comment->id );
                }
            }
        }
        // $acceptanceStatuses = \DB::table( 'acceptance_statuses' )
        // ->where( 'acceptance_statuses.resignation_id', $id )
        // ->get();

        $leadAcceptance = NULL;
        $headAcceptance = NULL;
        $hrAcceptance = NULL;
        // foreach ( $acceptanceStatuses as $acceptanceStatus ) {
        //     if( $acceptanceStatus->reviewed_by == 'lead') {
        //         $leadAcceptance = $acceptanceStatus->acceptance_status;
        //     }
        //     if( $acceptanceStatus->reviewed_by == 'head') {
        //         $headAcceptance = $acceptanceStatus->acceptance_status;
        //     }
        //     if( $acceptanceStatus->reviewed_by == 'hr') {
        //         $hrAcceptance = $acceptanceStatus->acceptance_status;
        //     }
        // }

        $acceptanceValue = NULL;
        $acceptanceComment = NULL;
        $is_reviewed = false;
        // //Head
        if ( \Auth::User()->designation_id == 3 ) {
        //     $acceptanceValue = $headAcceptance;
        //     $acceptanceComment = $headGeneralComment['comment'];
            $is_reviewed = ($leadAcceptance == 'Accepted') ? true : false;
        }
        // //HR
        else if ( ( \Auth::User()->department_id == 2 ) ) {
        //     $acceptanceValue = $hrAcceptance;
        //     $acceptanceComment = $hrGeneralComment['comment'];
            $is_reviewed = ($leadAcceptance == 'Accepted' && $headAcceptance == 'Accepted') ? true : false;
        }
        // //LEAD
        else {
        //     dd($leadGeneralComment['comment']);
        //     $acceptanceValue = $leadAcceptance;
        //     $acceptanceComment = $leadGeneralComment['comment'];
            $is_reviewed = true;
        }

        // //Feedback tab view enable

        $is_feedback_enable = ($leadAcceptance == 'Accepted' && $headAcceptance == 'Accepted' && $hrAcceptance == 'Accepted') ? true : false;

        // //fixing no due when to appear
        $today = Carbon::now();
        $nodueDate = Carbon::parse(date('d-m-Y', strtotime($converted_dates['changed_dol']. ' - 3 days')));
        $displayNodue = $today >= $nodueDate;

        // //Exit interview answers
        $showAnswers = \DB::table( 'user_answers' )
        ->where( 'resignation_id', $id )
        ->first();

        // //Exit interview comments
        // $hrExitInterviewComments = \DB::table( 'hr_exit_interview_comments' )
        // ->where( 'resignation_id', $id )
        // ->get();

        // //completed no due
        // // $completed_no_due = \DB::table( 'no_dues' )
        // // ->where([
        // //     ['no_dues.resignation_id', $id],
        // //     ['knowledge_transfer_lead','!=',NULL],
        // //     ['mail_id_closure_lead','!=',NULL],
        // //     ['knowledge_transfer_head','!=',NULL],
        // //     ['mail_id_closure_head','!=',NULL],
        // //     ['id_card','!=',NULL],
        // //     ['nda','!=',NULL],
        // //     ['official_email_id','!=',NULL],
        // //     ['skype_account','!=',NULL]
        // //     ])
        // // ->first();

        // //HR list for select the name in final exit checklist

        // $nodues = \DB::table( 'no_dues' )
        // ->where( 'no_dues.resignation_id', $id )
        // ->get();

        $nodueAttribute = NULL;
        // foreach($nodues as $nodue) {
        //     if($nodue->attribute == 'Knowledge Transfer') {
        //         $nodueAttribute['knowledge_transfer_comment'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Mail ID closure') {
        //         $nodueAttribute['mail_closure'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'ID Card') {
        //         $nodueAttribute['id_card'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'NDA') {
        //         $nodueAttribute['nda'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Professional Tax') {
        //         $nodueAttribute['professional_tax'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Official Email ID') {
        //         $nodueAttribute['official_email_id'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Skype Account') {
        //         $nodueAttribute['skype_account'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Gmail or Yahoo Testing Purpose') {
        //         $nodueAttribute['gmail_yahoo'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Testing Tools') {
        //         $nodueAttribute['testing_tools'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Linux or Mac Machine Password') {
        //         $nodueAttribute['linux_mac_password'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Specific Tools For Renewal Details') {
        //         $nodueAttribute['renewal_tools'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Handover Testing Device') {
        //         $nodueAttribute['testing_device'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Headset') {
        //         $nodueAttribute['headset'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Machine Port Forwarding') {
        //         $nodueAttribute['machine_port_forwarding'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'SVN & VSS & TFS Login Details') {
        //         $nodueAttribute['svn_vss_tfs'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'RDP, VPN Connection') {
        //         $nodueAttribute['rdp_vpn'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Laptop and Data Card') {
        //         $nodueAttribute['laptop_datacard'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Salary Advance Due') {
        //         $nodueAttribute['salary_advance_due'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Income Tax Due') {
        //         $nodueAttribute['income_tax_due'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Documents For IT') {
        //         $nodueAttribute['documents_it'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Laptop') {
        //         $nodueAttribute['laptop'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Data Card') {
        //         $nodueAttribute['data_card'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Official Property If Any') {
        //         $nodueAttribute['official_property'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Exit Process Completion From Core Departments') {
        //         $nodueAttribute['exit_process_completion'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'ISMS/QMS Incidents & Tickets Closure Status') {
        //         $nodueAttribute['isms_qms'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Disable All Access Control') {
        //         $nodueAttribute['disable_access'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'KT completed for all the current and old projects') {
        //         $nodueAttribute['kt_completion'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Relieving date informed and accepted by client') {
        //         $nodueAttribute['relieving_date_informed'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)') {
        //         $nodueAttribute['internal_client_souce_code'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)') {
        //         $nodueAttribute['project_detail_document'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Handing over CLIENT details (Excel)') {
        //         $nodueAttribute['client_details_handle'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'KT on HOT & WARM prospects') {
        //         $nodueAttribute['kt_hot_warm'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Introducing new account manager to CLIENTS via Email') {
        //         $nodueAttribute['intro_new_acc_manager'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'Completion of Data Categorization') {
        //         $nodueAttribute['data_categorization'] = $nodue->comment;
        //     }
        //     if($nodue->attribute == 'RFP System updation') {
        //         $nodueAttribute['rfp_system'] = $nodue->comment;
        //     }
        // }

        // $feedbacks = \DB::table( 'feedback' )
        // ->where( 'feedback.resignation_id', $id )
        // ->get();

        $feedbackValues = NULL;
        // foreach($feedbacks as $feedback) {
        //     if($feedback->attribute == 'Primary') {
        //         $feedbackValues['primary'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Secondary') {
        //         $feedbackValues['secondary'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Project Name') {
        //         $feedbackValues['project_name'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Attendance') {
        //         $feedbackValues['attendance'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Reponsiveness') {
        //         $feedbackValues['reponsiveness'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Reponsibility') {
        //         $feedbackValues['reponsibility'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Commit on Task Delivery') {
        //         $feedbackValues['commit_on_task_delivery'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Technical Knowledge') {
        //         $feedbackValues['technical_knowledge'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Logical Ability') {
        //         $feedbackValues['logical_ability'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Attitude') {
        //         $feedbackValues['attitude'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Overall performance during the tenure with CG-VAK Software') {
        //         $feedbackValues['overall_performance'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Lead Comment') {
        //         $feedbackValues['lead_comment'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Head Comment') {
        //         $feedbackValues['head_comment'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Learning & Responsiveness') {
        //         $feedbackValues['learning_responsiveness'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Commitment & Integrity') {
        //         $feedbackValues['commitment_integrity'] = $feedback->comment_rating;
        //     }
        //     if($feedback->attribute == 'Sales Performance') {
        //         $feedbackValues['sales_performance'] = $feedback->comment_rating;
        //     }
        // }


        $hr_list = \DB::table( 'users' )
        ->where( 'department_id', 2 )
        ->get();

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

        return view('process.viewResignation' , compact('emp_resignation','converted_dates','leadGeneralComment','headGeneralComment','hrGeneralComment','headDolComment','leadDolComment','hrDolComment','leadAcceptance','headAcceptance','hrAcceptance','is_reviewed','displayNodue','showAnswers','is_feedback_enable','hr_list','nodueAttribute','feedbackValues','headId','leadId'));

        // return view('process.viewResignation' , compact('emp_resignation','feedback','converted_dates','nodues','finalCheckList','leadGeneralComment','headGeneralComment','hrGeneralComment','leadDowComment','headDowComment','hrDowComment','leadDolComment','headDolComment','hrDolComment','answers','leadAcceptance','headAcceptance','hrAcceptance','acceptanceValue','acceptanceComment','is_reviewed','displayNodue','showAnswers','hrExitInterviewComments','is_feedback_enable','completed_no_due','hr_list','nodueAttribute','feedbackValues'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    //Updating lead for the user in process.resignationList blade

    public function update( Request $request, $id ){
        $request->validate( [
            'lead'=>'required'
        ] );

        $previousRecords = lead_selects::where('assigned_to',$id)
        ->get();

        if($previousRecords){
            lead_selects::where('assigned_to',$id)->delete();
        }

        $leadId = $request->get( 'lead' );
        $lead = User::where( 'emp_id', $leadId )->first();
        $user = User::where( 'emp_id', $id )->first();
        $user->lead = $lead->display_name;
        $user->save();

        $lead_details = new lead_selects;
        $lead_details->department_name = $lead->department_name;
        $lead_details->emp_id = $lead->emp_id;
        $lead_details->assigned_to = $id;
        $lead_details->save();

        return redirect( '/process' );
    }

    public function sendMail(){
        $subject = "New Resignation Applied!";
        $template = "emails.resignationMail";
        $details = [
            'firstName' => "Gowtham",
            'content' => 'has applied resignation',
            'date' => '2-2-2022'
        ];

        // \Mail::to([config('constants.HEAD_EMAIL'),config('constants.HR_EMAIL')])->cc(config('constants.LEAD_EMAIL'))->send(new \App\Mail\SendMail($details,$subject,$template));

        dd("mail sent now");
    }
    //add or update date of leaving

    public function addOrUpdateDolComments( Request $request ) {
        $request->validate( [
            'commentDol'=>'required'
        ] );
        $resignationId = $request->get( 'resignationId' );
        $resignation = Resignation::find( $resignationId );
        $resignation->changed_dol = Carbon::createFromFormat('d-m-Y', $request->get( 'dateOfLeaving' ))->format('Y-m-d') ;

        if ( ( ( \Auth::User()->designation_id == 2 ) && ( $request->get( 'leadDolCommentId' ) == NULL ) ) || ( ( \Auth::User()->designation_id == 3 ) && ( $request->get( 'headDolCommentId' ) == NULL ) ) || ( ( \Auth::User()->department_id == 2 ) && ( $request->get( 'hrDolCommentId' ) == NULL ) ) ) {
            $addOrUpdateDolComment = new Comments( [
                'resignation_id' => $request->get( 'resignationId' ),
                'comment_type' => 'date_of_leaving'
            ] );
        } else if ( ( \Auth::User()->designation_id == 2 ) && ( $request->get( 'leadDolCommentId' ) != NULL ) ) {
            $addOrUpdateDolComment = Comments::find( $request->get( 'leadDolCommentId' ) );
        } else if ( ( \Auth::User()->designation_id == 3 ) && ( $request->get( 'headDolCommentId' ) != NULL ) ) {
            $addOrUpdateDolComment = Comments::find( $request->get( 'headDolCommentId' ) );
        } else if ( ( \Auth::User()->department_id == 2 ) && ( $request->get( 'hrDolCommentId' ) != NULL ) ) {
            $addOrUpdateDolComment = Comments::find( $request->get( 'hrDolCommentId' ) );
        }
        //Head
        if ( \Auth::User()->designation_id == 3 ) {
            $request->validate( [
                'commentDol'=>'required'
            ] );
            $addOrUpdateDolComment->comment_by = 'head';
            $addOrUpdateDolComment->comment = $request->get( 'commentDol' );
        }
        //HR
        else if ( \Auth::User()->department_id == 2 ) {
            $request->validate( [
                'commentDol'=>'required'
            ] );
            $addOrUpdateDolComment->comment_by = 'hr';
            $addOrUpdateDolComment->comment = $request->get( 'commentDol' );
        }
        //lead
        else {
            $request->validate( [
                'commentDol'=>'required'
            ] );
            $addOrUpdateDolComment->comment_by = 'lead';
            $addOrUpdateDolComment->comment = $request->get( 'commentDol' );
        }

        $resignation->save();
        $addOrUpdateDolComment->save();
        $notification=array(
            'message' => 'Date of leaving has been changed!',
            'alert-type' => 'success'
        );

        //Sending mail
        $empname = Resignation::find( $resignationId )
        ->select('display_name')
        ->join('users', 'resignations.employee_id', '=', 'users.emp_id')
        ->first();

        $subject = "Changes in resignation!";
        $template = "emails.dolChangeMail";
        $details = [
            'name' => $empname->display_name,
            'content' => "resignation's date of leaving has changed",
            'date' => $request->get( 'dateOfLeaving' )
        ];

        // \Mail::to([config('constants.HEAD_EMAIL'),config('constants.HR_EMAIL')])->cc(config('constants.LEAD_EMAIL'))->send(new \App\Mail\SendMail($details,$subject,$template));

        return redirect()->route('process.edit', ['process' => $resignationId])->with($notification);
    }

    //function to add or update acceptance details
    public function addOrUpdateResignationAcceptance( Request $request ) {
        $resignationId = $request->get( 'resignationId' );

        $request->validate( [
            'acceptanceComment'=>'required',
            'accepatanceStatus'=>'required'
        ] );

        //Head
        if ( \Auth::User()->designation_id == 3 ) {
            $acceptanceStatusComment = Comments::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'comment_by' => 'head',
                'comment_type' => 'general'
            ],
            [
                'comment' => $request->get( 'acceptanceComment' )
            ]
            );
            $acceptanceStatusComment->save();

            $acceptanceStatus = AcceptanceStatus::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'reviewed_by' => 'head'
            ],
            [
                'acceptance_status' => $request->get( 'accepatanceStatus' )
            ]);
            $acceptanceStatus->save();
        }
        //HR
        else if ( \Auth::User()->department_id == 2 ) {

            $acceptanceStatusComment = Comments::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'comment_by' => 'hr',
                'comment_type' => 'general'
            ],
            [
                'comment' => $request->get( 'acceptanceComment' )
            ]
            );
            $acceptanceStatusComment->save();

            $acceptanceStatus = AcceptanceStatus::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'reviewed_by' => 'hr'
            ],
            [
                'acceptance_status' => $request->get( 'accepatanceStatus' )
            ]);
            $acceptanceStatus->save();
        }
        //lead
        else {

            $acceptanceStatusComment = Comments::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'comment_by' => 'lead',
                'comment_type' => 'general'
            ],
            [
                'comment' => $request->get( 'acceptanceComment' )
            ]
            );
            $acceptanceStatusComment->save();

            $acceptanceStatus = AcceptanceStatus::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'reviewed_by' => 'lead'
            ],
            [
                'acceptance_status' => $request->get( 'accepatanceStatus' )
            ]);
            $acceptanceStatus->save();
        }


        $notification=array(
            'message' => 'Comments has been recorded!',
            'alert-type' => 'success'
        );
        return redirect()->route('process.edit', ['process' => $resignationId])->with($notification);

    }

    //add or update date of withdraw comment

    public function addOrUpdateDowComment( Request $request ) {
        $resignationId = $request->get( 'resignationId' );
        if ( ( ( \Auth::User()->designation_id == 2 ) && ( $request->get( 'leadDowCommentId' ) == NULL ) ) || ( ( \Auth::User()->designation_id == 3 ) && ( $request->get( 'headDowCommentId' ) == NULL ) ) || ( ( \Auth::User()->department_id == 2 ) && ( $request->get( 'hrDowCommentId' ) == NULL ) ) ) {
            $addOrUpdateDowComment = new Comments( [
                'resignation_id' => $request->get( 'resignationId' ),
                'comment_type' => 'withdraw'
            ] );
        } else if ( ( \Auth::User()->designation_id == 2 ) && ( $request->get( 'leadDowCommentId' ) != NULL ) ) {
            $addOrUpdateDowComment = Comments::find( $request->get( 'leadDowCommentId' ) );
        } else if ( ( \Auth::User()->designation_id == 3 ) && ( $request->get( 'headDowCommentId' ) != NULL ) ) {
            $addOrUpdateDowComment = Comments::find( $request->get( 'headDowCommentId' ) );
        } else if ( ( \Auth::User()->department_id == 2 ) && ( $request->get( 'hrDowCommentId' ) != NULL ) ) {
            $addOrUpdateDowComment = Comments::find( $request->get( 'hrDowCommentId' ) );
        }
        //Head
        if ( \Auth::User()->designation_id == 3 ) {
            $request->validate( [
                'withdrawHeadComment'=>'required'
            ] );
            $addOrUpdateDowComment->comment_by = 'head';
            $addOrUpdateDowComment->comment = $request->get( 'withdrawHeadComment' );
        }
        //HR
        else if ( \Auth::User()->department_id == 2 ) {
            $request->validate( [
                'withdrawHrComment'=>'required'
            ] );
            $addOrUpdateDowComment->comment_by = 'hr';
            $addOrUpdateDowComment->comment = $request->get( 'withdrawHrComment' );
        }
        //lead
        else {
            $request->validate( [
                'withdrawLeadComment'=>'required'
            ] );
            $addOrUpdateDowComment->comment_by = 'lead';
            $addOrUpdateDowComment->comment = $request->get( 'withdrawLeadComment' );
        }
        $addOrUpdateDowComment->save();
        $notification=array(
            'message' => 'Comments has been recorded!',
            'alert-type' => 'success'
        );
        return redirect()->route('process.edit', ['process' => $resignationId])->with($notification);
    }
    //Store or Updating feedback for the resignation
    public function addOrUpdateFeedback(Request $request){
        $request->validate( [
            'attribute'=>'required',
            'value'=>'required'
        ] );
        $resignationId = $request->get( 'resignationId' );
        for($arraySize = 0; $arraySize < count($request->attribute) ; $arraySize++ ) {
            $feedback = Feedback::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'attribute' => $request->attribute[$arraySize],
            ],
            [
                'comment_rating' => $request->value[$arraySize],
            ]
            );
            $feedback->save();
            // echo $request->attribute[$arraySize];
            // echo '<pre>';
            // echo $request->comment[$arraySize];
            // echo '<pre>';

        }
        $notification=array(
            'message' => 'Feedback has been recorded!',
            'alert-type' => 'success'
        );
        return redirect()->route( 'process.edit', ['process' => $resignationId] )->with($notification);

    }

    //Storing or update No Due forms for the resignation

    public function addOrUpdateNodue( Request $request ) {
        $request->validate( [
            'attribute'=>'required',
            'comment'=>'required'
        ] );
        $resignationId = $request->get( 'resignationId' );
        for($arraySize = 0; $arraySize < count($request->attribute) ; $arraySize++ ) {
            $noDue = NoDue::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'attribute' => $request->attribute[$arraySize],
            ],
            [
                'comment' => $request->comment[$arraySize],
            ]
            );
            $noDue->save();
            // echo $request->attribute[$arraySize];
            // echo '<pre>';
            // echo $request->comment[$arraySize];
            // echo '<pre>';

        }
        $notification=array(
            'message' => 'No-due has been recorded!',
            'alert-type' => 'success'
        );
        return redirect()->route( 'process.edit', ['process' => $resignationId] )->with($notification);
    }

    //Final checklist store

    public function storeFinalCheckList( Request $request ) {
        $request->validate( [
            'type_of_exit'=>'required',
            'date_of_leaving'=>'required',
            'reason_for_leaving'=>'required',
            'last_drawn_salary'=>'required',
            'consider_for_rehire'=>'required',
            'overall_feedback'=>'required',
            'relieving_letter'=>'required',
            'experience_letter'=>'required',
            'salary_certificate'=>'required',
            'final_comment'=>'required'
        ] );

        $RelievingLetterName = NULL;
        $ExperienceLetterName = NULL;
        $SalaryCertificateName = NULL;
        $resignationId = $request->get( 'resignationId' );
            if ( $request->file( 'RelievingLetter' ) ) {
                $RelievingLetterPath = $request->file( 'RelievingLetter' );
                $RelievingLetterName = $RelievingLetterPath->getClientOriginalName();
                $RelievingLetterFilepath = $request->file( 'RelievingLetter' )->storeAs( 'uploads', $RelievingLetterName, 'public' );

            } else {
                $RelievingLetterFilepath = '';
            }
            if ( $request->file( 'ExperienceLetter' ) ) {
                $ExperienceLetterPath = $request->file( 'ExperienceLetter' );
                $ExperienceLetterName = $ExperienceLetterPath->getClientOriginalName();
                $ExperienceLetterFilepath = $request->file( 'ExperienceLetter' )->storeAs( 'uploads', $ExperienceLetterName, 'public' );

            }else {
                $ExperienceLetterFilepath = '';
            }
            if ( $request->file( 'SalaryCertificate' ) ) {

                $SalaryCertificatePath = $request->file( 'SalaryCertificate' );
                $SalaryCertificateName = $SalaryCertificatePath->getClientOriginalName();
                $SalaryCertificateFilepath = $request->file( 'SalaryCertificate' )->storeAs( 'uploads', $SalaryCertificateName, 'public' );
            }else {
                $SalaryCertificateFilepath = '';
            }


        $finalCheckList = new FinalExitChecklist( [
            'resignation_id' => $request->get( 'resignationId' ),
            'type_of_exit' => $request->get( 'type_of_exit' ),
            'date_of_leaving' => Carbon::createFromFormat('d-m-Y', $request->get( 'date_of_leaving' ))->format('Y-m-d'),
            'reason_for_leaving' => $request->get( 'reason_for_leaving' ),
            'last_drawn_salary' => $request->get( 'last_drawn_salary' ),
            'consider_for_rehire' => $request->get( 'consider_for_rehire' ),
            'overall_feedback' => $request->get( 'overall_feedback' ),
            'relieving_letter' => $request->get( 'relieving_letter' ),
            'experience_letter' => $request->get( 'experience_letter' ),
            'salary_certificate' => $request->get( 'salary_certificate' ),
            'final_comment' => $request->get( 'final_comment' ),
            'relieving_document' => $RelievingLetterName,
            'experience_document' => $ExperienceLetterName,
            'salary_document' => $SalaryCertificateName,
            'date_of_entry' => $request->get( 'date_of_entry' ),
            'updated_by' => $request->get( 'updated_by' )
        ] );
        $finalCheckList->save();

        if(($request->get( 'relieving_letter' ) == 'Given') && ($request->get( 'experience_letter' ) == 'Given') && ($request->get( 'salary_certificate' ) == 'Given')) {
            \DB::table('resignations')
            ->where('id', $resignationId)
            ->update(['is_completed' => 1]);
        }
        $notification=array(
            'message' => 'Final checklist has been recorded!',
            'alert-type' => 'success'
        );
        return redirect()->route( 'process.edit', ['process' => $resignationId] )->with($notification);
    }

    //Final checklist update

    public function updateFinalCheckList( Request $request ) {
        $request->validate( [
            'type_of_exit'=>'required',
            'date_of_leaving'=>'required',
            'reason_for_leaving'=>'required',
            'last_drawn_salary'=>'required',
            'consider_for_rehire'=>'required',
            'overall_feedback'=>'required',
            'relieving_letter'=>'required',
            'experience_letter'=>'required',
            'salary_certificate'=>'required',
            'final_comment'=>'required'
        ] );
        $finalCheckListId = $request->get( 'finalChecklistId' );
        $resignationId = $request->get( 'resignationId' );
        if ( ( $request->file( 'RelievingLetter' ) ) || ( $request->file( 'ExperienceLetter' ) ) || ( $request->file( 'SalaryCertificate' ) ) ) {
            if ( $request->file( 'RelievingLetter' ) ) {
                $RelievingLetterPath = $request->file( 'RelievingLetter' );
                $RelievingLetterName = $RelievingLetterPath->getClientOriginalName();
                $RelievingLetterFilepath = $request->file( 'RelievingLetter' )->storeAs( 'uploads', $RelievingLetterName, 'public' );

            }
            if ( $request->file( 'ExperienceLetter' ) ) {
                $ExperienceLetterPath = $request->file( 'ExperienceLetter' );
                $ExperienceLetterName = $ExperienceLetterPath->getClientOriginalName();
                $ExperienceLetterFilepath = $request->file( 'ExperienceLetter' )->storeAs( 'uploads', $ExperienceLetterName, 'public' );

            }
            if ( $request->file( 'SalaryCertificate' ) ) {

                $SalaryCertificatePath = $request->file( 'SalaryCertificate' );
                $SalaryCertificateName = $SalaryCertificatePath->getClientOriginalName();
                $SalaryCertificateFilepath = $request->file( 'SalaryCertificate' )->storeAs( 'uploads', $SalaryCertificateName, 'public' );
            }
        }
        $updateFinalCheckList = FinalExitChecklist::find( $finalCheckListId );
        $updateFinalCheckList->resignation_id = $request->get( 'resignationId' );
        $updateFinalCheckList->type_of_exit = $request->get( 'type_of_exit' );
        $updateFinalCheckList->date_of_leaving = Carbon::createFromFormat('d-m-Y', $request->get( 'date_of_leaving' ))->format('Y-m-d');
        $updateFinalCheckList->reason_for_leaving = $request->get( 'reason_for_leaving' );
        $updateFinalCheckList->last_drawn_salary = $request->get( 'last_drawn_salary' );
        $updateFinalCheckList->consider_for_rehire = $request->get( 'consider_for_rehire' );
        $updateFinalCheckList->overall_feedback = $request->get( 'overall_feedback' );
        $updateFinalCheckList->relieving_letter = $request->get( 'relieving_letter' );
        $updateFinalCheckList->experience_letter = $request->get( 'experience_letter' );
        $updateFinalCheckList->salary_certificate = $request->get( 'salary_certificate' );
        $updateFinalCheckList->final_comment = $request->get( 'final_comment' );
        if ( ( $request->file( 'RelievingLetter' ) ) || ( $request->file( 'ExperienceLetter' ) ) || ( $request->file( 'SalaryCertificate' ) ) ) {
            if ( $request->file( 'RelievingLetter' ) ) {
                $updateFinalCheckList->relieving_document = $RelievingLetterName;
            }
            if ( $request->file( 'ExperienceLetter' ) ) {
                $updateFinalCheckList->experience_document = $ExperienceLetterName;
            }
            if ( $request->file( 'SalaryCertificate' ) ) {
                $updateFinalCheckList->salary_document = $SalaryCertificateName;
            }
        }
        $updateFinalCheckList->date_of_entry = $request->get( 'date_of_entry' );
        $updateFinalCheckList->updated_by = $request->get( 'updated_by' );
        $updateFinalCheckList->save();
        if(($request->get( 'relieving_letter' ) == 'Given') && ($request->get( 'experience_letter' ) == 'Given') && ($request->get( 'salary_certificate' ) == 'Given')) {
            \DB::table('resignations')
            ->where('id', $resignationId)
            ->update(['is_completed' => 1]);
        }
        $notification=array(
            'message' => 'Final checklist has been updated!',
            'alert-type' => 'success'
        );
        return redirect()->route( 'process.edit', ['process' => $resignationId] )->with($notification);
    }

    //Add and update HR exit interview comments

    public function addOrUpdateHrInterview(Request $request) {
        $resignationId = $request->get( 'resignationId' );
        for($arraySize = 0; $arraySize < count($request->hr_exitinterview_comment) ; $arraySize++ ) {
            $hrInterview = HrExitInterviewComments::updateOrCreate([
                'resignation_id' => $request->get( 'resignationId' ),
                'action_area' => $request->hr_exitinterview_actionarea[$arraySize],
            ],
            [
                'comments' => $request->hr_exitinterview_comment[$arraySize],
                'commented_by' => $request->commented_by
            ]
            );
            $hrInterview->save();

        }
        $notification=array(
            'message' => 'Exit interview comments has been recorded!',
            'alert-type' => 'success'
        );
        return redirect()->route('process.edit', ['process' => $resignationId])->with($notification);

    }

    public function downloadDocs($filename){

        return response()->download(storage_path("app\public\uploads/" .$filename ));
    }

    public function getMailValue($resignation_department,$mailto_department,$workflows){
            $data = 0;
            foreach($workflows as $workflow){
                if($workflow->resignation_department === $resignation_department && $workflow->mail_to_department === $mailto_department){
                    $data = 1;
                    continue;
               }
            }
            return $data;
    }

    public function formatData($resignation_departments, $mailto_departments,$workflows){
        $savedWorkflow= [];
            foreach($resignation_departments as $resignation_department){
               foreach($mailto_departments as $mailto_department){
                   $savedWorkflow[$resignation_department][$mailto_department] = $this->getMailValue($resignation_department,$mailto_department, $workflows);
               }
           }
       return $savedWorkflow;
    }

    public function getselectedDepartmentHeads($department_name){
        $results = \DB::table( 'head_selects' )->select('emp_id')->where('department_name', $department_name)->get();
        $data = [];
        if(!empty($results)){
            foreach($results as $result){
                $data[] = $result->emp_id;
            }
        }


        return $data;
    }

    public function getselectedWorkFlowCcs($department_name, $mail_type){
        $results = WorkflowCc::where('resignation_department', $department_name)
                    ->where('mail_type', $mail_type)
                    ->get();
        // echo '<pre>';
        // echo $department_name;
        // echo $mail_type;
        // print_r($results);
        // echo '</pre>';
        // die;

        $data = [];
        if(!empty($results)){
            foreach($results as $result){
                // echo $result;
                $data[] = $result->cc_emp_id;
            }
        }



        return $data;
    }
    public function workflow(){

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

        $RegistationWorkflows = \DB::table( 'workflows' )->where('mail_type', 'Resignation')->get();
        // $RegistationWorkflowsCC = \DB::table( 'workflow_cc' )->where('mail_type', 'Resignation')->get();
        $NoDueWorkflows = \DB::table( 'workflows' )->where('mail_type', 'No Due')->get();
        // $NoDueWorkflowsCC = \DB::table( 'workflow_cc' )->where('mail_type', 'No Due')->get();
        $selectedDepartmentHeads = \DB::table( 'head_selects' )->get();
        $resignation_departments = config('constants.resignation_departments');
        $mailto_departments = config('constants.mailto_departments');
        $savedWorkflow = [];
        $Registation = $this->formatData($resignation_departments, $mailto_departments, $RegistationWorkflows);
        $Nodue = $this->formatData($resignation_departments, $mailto_departments, $NoDueWorkflows);

        $department_heads = \DB::table( 'users' )
        ->select('emp_id','display_name','department_name','department_id','designation')
        ->whereNotIn('department_name', ['Management','IT Recruitment'])
        ->whereIn('designation_id',config('constants.depatment_heads_designation_id'))
        ->get();

        $department_users = [];
        foreach($department_heads as $department_head) {
            $department_users[$department_head->department_name]['list'][$department_head->emp_id] = $department_head->display_name;
            $department_users[$department_head->department_name]['selected_users'] = json_encode($this->getselectedDepartmentHeads($department_head->department_name));
            // $Registation[$department_head->department_name]['list'][$department_head->emp_id] = $department_users[$department_head->department_name]['list'][$department_head->emp_id];
        }

        // foreach ( $resignation_departments as $resignation_department){
        //     //  echo $resignation_department;

        //     //  print_r($this->getselectedWorkFlowCcs($resignation_department,'No Due'));
        //     //  print_r($this->getselectedWorkFlowCcs($resignation_department,'No Due'));
        //     $department_users[$resignation_department]['resignation']['selected_ccs'][] = json_encode($this->getselectedWorkFlowCcs($resignation_department,'Resignation'));
        //     $department_users[$resignation_department]['noDue']['selected_ccs'][] = json_encode($this->getselectedWorkFlowCcs($resignation_department,'No Due'));
        // }


            $Registation['HR']['list']['select'] = $department_users['Human Resource']['list'];
            $Registation['Technical']['list']['select'] = $department_users['Software Development']['list'];
            $Registation['Accounts']['list']['select'] = $department_users['Accounts']['list'];
            $Registation['Marketing']['list']['select'] = $department_users['Marketing']['list'];
            $Registation['System Admin']['list']['select'] = $department_users['System Administration']['list'];
            $Registation['Administrator']['list']['select'] = $department_users['Administration']['list'];

            $Nodue['HR']['list']['select'] = $department_users['Human Resource']['list'];
            $Nodue['Technical']['list']['select'] = $department_users['Software Development']['list'];
            $Nodue['Accounts']['list']['select'] = $department_users['Accounts']['list'];
            $Nodue['Marketing']['list']['select'] = $department_users['Marketing']['list'];
            $Nodue['System Admin']['list']['select'] = $department_users['System Administration']['list'];
            $Nodue['Administrator']['list']['select']= $department_users['Administration']['list'];

            $Registation['HR']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('HR','Resignation'));
            $Registation['Technical']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('Technical','Resignation'));
            $Registation['Accounts']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('Accounts','Resignation'));
            $Registation['Marketing']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('Marketing','Resignation'));
            $Registation['System Admin']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('System Admin','Resignation'));
            $Registation['Administrator']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('Administrator','Resignation'));

            $Nodue['HR']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('HR','No Due'));
            $Nodue['Technical']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('Technical','No Due'));
            $Nodue['Accounts']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('Accounts','No Due'));
            $Nodue['Marketing']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('Marketing','No Due'));
            $Nodue['System Admin']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('System Admin','No Due'));
            $Nodue['Administrator']['list']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs('Administrator','No Due'));

        //     $resignation_departments[$resignation_department]['resignation']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs($resignation_department,'Resignation'));
        //     $resignation_departments[$resignation_department]['noDue']['selected_ccs'] = json_encode($this->getselectedWorkFlowCcs($resignation_department,'No Due'));
        // }


            $Registation['HR']['list'] = $department_users['Human Resource']['list'];
            $Registation['Technical']['list'] = $department_users['Software Development']['list'];
            $Registation['Accounts']['list'] = $department_users['Accounts']['list'];
            $Registation['Marketing']['list'] = $department_users['Marketing']['list'];
            $Registation['System Admin']['list'] = $department_users['System Administration']['list'];
            $Registation['Administrator']['list'] = $department_users['Administration']['list'];

            $Nodue['HR']['list'] = $department_users['Human Resource']['list'];
            $Nodue['Technical']['list'] = $department_users['Software Development']['list'];
            $Nodue['Accounts']['list'] = $department_users['Accounts']['list'];
            $Nodue['Marketing']['list'] = $department_users['Marketing']['list'];
            $Nodue['System Admin']['list'] = $department_users['System Administration']['list'];
            $Nodue['Administrator']['list'] = $department_users['Administration']['list'];





        // echo '<pre>';
        // echo 'department_users';
        // print_r($department_users);
        // echo 'Registation';
        // print_r($Registation);
        // print_r($NoDueWorkflows);
        // print_r($Nodue);
        // echo 'department_users';
        // print_r($department_users);
        // echo '</pre>';
        // die;

    //    dd($department_users);

        return view('process.workflow', compact('Registation','Nodue', 'resignation_departments','department_users','selectedDepartmentHeads','headId', 'leadId'));
    }


    public function manageCc($arrCc){
        $departmentCc = WorkflowCc::where('mail_type',$arrCc['mailType'])
                                ->where('resignation_department',$arrCc['departmentName'])
                                ->delete();

               if(!empty($arrCc['CC'])) {
                foreach($arrCc['CC'] as $workflowCCEmpId)
                    {
                            WorkflowCc::insert([
                                'mail_type' => $arrCc['mailType'],
                                'resignation_department' => $arrCc['departmentName'],
                                "cc_emp_id" =>  $workflowCCEmpId,
                                ]);
                    }
                }
    }

    public function workflowStore(Request $request){

        $mailDepartment = array(
                     $request->formData['Technical'] == 'true' ? "Technical": NULL,
                     $request->formData['HR'] == 'true' ? "HR":NULL,
                     $request->formData['Accounts'] == 'true' ? "Accounts":NULL,
                     $request->formData['Marketing'] == 'true' ? "Marketing":NULL,
                     $request->formData['System Admin'] == 'true' ? "System Admin":NULL,
                     $request->formData['Administrator'] == 'true' ? "Administrator":NULL,
                    );
        $mailDepartment_count = count($mailDepartment);

        $department = workflow::where('mail_type',$request->formData['mailType'])
                                ->where('resignation_department',$request->formData['departmentName'])
                                ->delete();

            foreach($mailDepartment as $maildepart)
            {   if($maildepart != NULL)
                {
                    workflow::insert([
                        'mail_type' => $request->formData['mailType'],
                        'resignation_department' => $request->formData['departmentName'],
                        "mail_to_department" =>  $maildepart,
                        ]);
                }
            }


            $this->manageCc($request->formData);

        return response()->json(
            [
                'success' => true,
                'message' => "Data saved successfully"
            ]
        );
    }

    public function headSelectStore(Request $request){

        $previousRecords = HeadSelect::where('department_name',$request->formData['departmentName'])
        ->get();

        if($previousRecords) {
            foreach($previousRecords as $previousRecord) {
                HeadSelect::where('id',$previousRecord->id)->delete();
            }
            foreach($request->formData['headValues'] as $headId){
                $insertData = HeadSelect::insert([
                    'department_name' => $request->formData['departmentName'],
                    'emp_id' => $headId
                ]);
            }
        }
        else {
            foreach($request->formData['headValues'] as $headId){
                $insertData = HeadSelect::insert([
                    'department_name' => $request->formData['departmentName'],
                    'emp_id' => $headId
                ]);
            }
        }
        if($insertData) {
            return response()->json(
                [
                    'success' => true,
                    'message' => "Data saved successfully"
                ]
            );
        }
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
