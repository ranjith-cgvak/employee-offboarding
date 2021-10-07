<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Question_option;
use App\Answer;
use App\User;
use App\QuestionType;

use App\Support\Facades\DB;

class AddQuestionController extends Controller
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

        $Question = Question::all();

        $count = 1 + ( Question::all()->where( 'id' )->count() );
        $answer = Answer::all();
        $Question_option = Question_option::all();

        $QuestionType = QuestionType::all();

        $department_heads = \DB::table( 'head_selects' )
        ->select('emp_id')
        ->get();
        $headId = [];
        foreach($department_heads as $department_head){
            $headId[] = $department_head->emp_id;
        }
        return view( 'questions.create', compact( 'Question', 'answer', 'count', 'myResignation', 'Question_option', 'QuestionType' ,'headId') );

    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request )
 {
        $question_type = $request->question_type;
        if ( $question_type == 1 || $question_type == 4 ) {

            $question = new Question( [
                'question_number' => $request->question_number,
                'questions' => $request->question,
                'question_type' => $request->question_type,
            ] );
            $question->save();
            $notification=array(
                'message' => 'Question has been added!',
                'alert-type' => 'success'
            );
            return redirect( '/questions' )->with($notification);
        }
        if ( $question_type == 2 ) {

            $question = new Question( [
                'question_number' => $request->question_number,
                'questions' => $request->question,
                'question_type' => $request->question_type,
            ] );
            $question->save();
            $id = Question::latest( 'id' )->first();
            if($request->get( 4 )){
                $question_options = array(
                array( 'question_id' => $id->id, 'option_value' => $request->get( 1 ) ),
                array( 'question_id' => $id->id, 'option_value' => $request->get( 2 ) ),
                array( 'question_id' => $id->id, 'option_value' => $request->get( 3 ) ),
                array( 'question_id' => $id->id, 'option_value' => $request->get( 4 ) )
                );
            }
            else{
                $question_options = array(
                array( 'question_id' => $id->id, 'option_value' => $request->get( 1 ) ),
                array( 'question_id' => $id->id, 'option_value' => $request->get( 2 ) ),
                array( 'question_id' => $id->id, 'option_value' => $request->get( 3 ) )
            );
            }
            Question_option::insert( $question_options );
            $notification=array(
                'message' => 'Question has been added!',
                'alert-type' => 'success'
            );
            return redirect( '/questions' )->with($notification);
        }

        if ( $question_type == 3 ) {

            $question = new Question( [
                'question_number' => $request->question_number,
                'questions' => $request->question,
                'question_type' => $request->question_type,
            ] );
            $question->save();
            $id = Question::latest( 'id' )->first();
            $question_options = array(

                array( 'question_id' => $id->id, 'option_value' => $request->get( 1 ) ),
                array( 'question_id' => $id->id, 'option_value' => $request->get( 2 ) ),

                //...

            );
            Question_option::insert( $question_options );
            $notification=array(
                'message' => 'Question has been added!',
                'alert-type' => 'success'
            );
            return redirect( '/questions' )->with($notification);
        }
    }
}
