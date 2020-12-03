<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Question_option;
use App\QuestionType;
use App\Answer;
use App\User;
use App\Support\Facades\DB;

class QuestionController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {

        $Question = Question::all();
        $answer = Answer::all();
        dd($Question);
                return view( 'resignation.questions', compact( 'Question', 'answer' ) );
            }

            /**
            * Show the form for creating a new resource.
            *
            * @return \Illuminate\Http\Response
            */

            public function store( Request $request ) {
                $Question = Question::all();

                foreach ( $Question as $questions ) {
                    $user_id = auth()->id();
                    $answers = new Answer( [
                        'answers' => $request->get( $questions->id )
                    ] );
                    $answers->user_id = $user_id;
                    $answers->question_id = $questions->id;
                    $answers->save();
                }
                return redirect( '/questions' )->with( 'success', 'Details saved!' );
            }
            /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */

            public function edit( $id ) {
                $Question_options = Question_option::where( 'question_id', $id )
                ->get();
                $QuestionType = QuestionType::all();
                $questions = Question::select( 'questions.id', 'questions.questions', 'questions.question_number', 'questions.question_type', 'question_types.type', 'options.option_value' )
                ->leftJoin( 'options', 'questions.id', '=', 'options.question_id' )
                ->Join( 'question_types', 'questions.question_type', '=', 'question_types.id' )
                ->where( 'questions.id', $id )
                ->first();
                return view( 'questions.edit', compact( 'questions', 'count', 'QuestionType', 'Question_options' ) );
            }

            /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */

            public function update( Request $request, $id ) {
                $question_type = Question::select( 'questions.question_type' )
                ->Join( 'question_types', 'questions.question_type', '=', 'question_types.id' )
                ->where( 'questions.id', $id )
                ->first();
                $request_questiontype = $request->question_type;
                if ( $question_type->question_type == 1 || $question_type->question_type == 4 ) {

                    if ( $request_questiontype == 1 || $request_questiontype == 4 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    } elseif ( $request_questiontype == 2 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        $question_options = array(

                            array( 'question_id' => $id, 'option_value' => $request->get( 1 ) ),
                            array( 'question_id' => $id, 'option_value' => $request->get( 2 ) ),
                            array( 'question_id' => $id, 'option_value' => $request->get( 3 ) ),
                            array( 'question_id' => $id, 'option_value' => $request->get( 4 ) ),
                            //...

                        );
                        Question_option::insert( $question_options );
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    } elseif ( $request_questiontype == 3 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        $question_options = array(

                            array( 'question_id' => $id, 'option_value' => $request->get( 5 ) ),
                            array( 'question_id' => $id, 'option_value' => $request->get( 6 ) ),
                            //...

                        );
                        Question_option::insert( $question_options );
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    }
                } elseif ( $question_type->question_type == 2 ) {
                    if ( $request_questiontype == 1 || $request_questiontype == 4 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        $options = Question_option::select( 'id' )->where( 'question_id', $id )->get();
                        for ( $i = 0; $i <= 3; $i++ ) {
                            $opton_id = $options[$i]->id;
                            Question_option::where( 'id', $opton_id )->firstorfail()->delete();
                        }
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    } elseif ( $request_questiontype == 2 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        $options = Question_option::select( 'id' )->where( 'question_id', $id )->get();
                        for ( $i = 0; $i <= 3; $i++ ) {
                            $opton_id = $options[$i]->id;
                            $gets = $i + 1;
                            $update_option = array( 'option_value' => $request->get( $gets ) );
                            Question_option::where( 'id', $opton_id )->update( $update_option );
                        }
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    } elseif ( $request_questiontype == 3 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        $options = Question_option::select( 'id' )->where( 'question_id', $id )->get();
                        for ( $i = 0; $i <= 3; $i++ ) {
                            $opton_id = $options[$i]->id;
                            Question_option::where( 'id', $opton_id )->firstorfail()->delete();
                        }
                        $question_options = array(

                            array( 'question_id' => $id, 'option_value' => $request->get( 5 ) ),
                            array( 'question_id' => $id, 'option_value' => $request->get( 6 ) ),
                            //...

                        );
                        Question_option::insert( $question_options );
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    }
                } elseif ( $question_type->question_type == 3 ) {
                    if ( $request_questiontype == 1 || $request_questiontype == 4 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        $options = Question_option::select( 'id' )->where( 'question_id', $id )->get();
                        for ( $i = 0; $i <= 1; $i++ ) {
                            $opton_id = $options[$i]->id;
                            Question_option::where( 'id', $opton_id )->firstorfail()->delete();
                        }
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    } elseif ( $request_questiontype == 2 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        $options = Question_option::select( 'id' )->where( 'question_id', $id )->get();
                        for ( $i = 0; $i <= 1; $i++ ) {
                            $opton_id = $options[$i]->id;
                            $gets = $i + 1;
                            $update_option = array( 'option_value' => $request->get( $gets ) );
                            Question_option::where( 'id', $opton_id )->update( $update_option );
                        }
                        $question_options = array(

                            array( 'question_id' => $id, 'option_value' => $request->get( 3 ) ),
                            array( 'question_id' => $id, 'option_value' => $request->get( 4 ) ),
                            //...

                        );
                        Question_option::insert( $question_options );
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    } elseif ( $request_questiontype == 3 ) {
                        $question = Question::find( $id );
                        $question->question_number       = $request->get( 'question_number' );
                        $question->questions      = $request->get( 'question' );
                        $question->question_type = $request->get( 'question_type' );
                        $question->save();
                        $options = Question_option::select( 'id' )->where( 'question_id', $id )->get();
                        for ( $i = 0; $i <= 1; $i++ ) {
                            $opton_id = $options[$i]->id;
                            $gets = $i + 5;
                            $update_option = array( 'option_value' => $request->get( $gets ) );
                            Question_option::where( 'id', $opton_id )->update( $update_option );
                        }
                        return redirect( '/questions' )->with( 'success', 'Details saved!' );
                    }
                }
            }

            public function show( $id ) {
                $del = 'gegggggggggg';
                $delete_question = Question::find( $id );
                dd( $del );
            }

           
            /**
            * Show the form for deleting the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */

            public function destroy( $id ) {
                $delete_question = Question::find( $id );
                $delete_question->delete();
                return redirect( '/questions' )->with( 'danger', 'Details Deleted!' );
            }
        }
