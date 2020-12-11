@extends('layouts.app_home')

@section('content')

<!-- Employee details -->
@if(session()->get('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
<!-- Leaving form -->

@if(Auth::User()->department_id == 2)
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary formBox">
                <div class="box-header with-border">
                    <h3 class="box-title">Leaving Form</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="{{ route('questions.update',$questions->id) }}">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="question_number" class="col-sm-2 form-label">Question Number<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly="true" required name="question_number" id="question_number" value="{{$questions->question_number}}">
                                @error('question_number')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="question" class="col-sm-2 form-label">Question <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" required name="question" id="question" value="{{$questions->questions}}">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="question_type" class="col-sm-2 form-label">Question Type <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select id="selectBox" class="form-control " name="question_type" onchange="changeFunc();">
                                    <option value="{{$questions->question_type}}">{{$questions->type}}</option>

                                    @foreach($QuestionType as $QuestionTypes)
                                    <option value="{{$QuestionTypes->id}}">{{$QuestionTypes->type}}</option>
                                    @endforeach
                                </select>
                                @error('question_type')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>@php $i = 0; @endphp
                        </div>
                        @foreach($Question_options as $question_option)


                        <div class="form-group row" style="display: none" {{$i++}} id="textboxe{{$i}}">
                            <label for="question" class="col-sm-2 form-label">Option-{{$i}} <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$question_option->option_value}}" name="{{$i}}" id="option-{{$i}}">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>@endforeach
                        @if($questions->question_type==3)
                        <div class="form-group row" style="display: none" id="textboxe3">
                            <label for="question" class="col-sm-2 form-label">Option-3 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="3" id="option-3">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe4">
                            <label for="question" class="col-sm-2 form-label">Option-4 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="4" id="option-4">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($questions->question_type==1 || $questions->question_type== 4)
                        <div class="form-group row" style="display: none" id="textboxe1">
                            <label for="question" class="col-sm-2 form-label">Option-1 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="1" id="option-1">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe2">
                            <label for="question" class="col-sm-2 form-label">Option-2 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="2" id="option-2">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe3">
                            <label for="question" class="col-sm-2 form-label">Option-3 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="3" id="option-3">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe4">
                            <label for="question" class="col-sm-2 form-label">Option-4 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="4" id="option-4">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="form-group row" style="display: none" id="textboxe5">
                            <label for="question" class="col-sm-2 form-label">Option-1 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="5" id="option-5">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe6">
                            <label for="question" class="col-sm-2 form-label">Option-2 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="6" id="option-6">
                                @error('question')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <button type="submit" id="myBtn" class="btn btn-primary ">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<script type="text/javascript">
    function changeFunc() {
        var selectBox = document.getElementById("selectBox");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if (selectedValue == 2) {
            $('#textboxe1').show();
            $('#textboxe2').show();
            $('#textboxe3').show();
            $('#textboxe4').show();

        } else {
            $('#textboxe1').hide();
            $('#textboxe2').hide();
            $('#textboxe3').hide();
            $('#textboxe4').hide();
        }
        if (selectedValue == 3) {
            $('#textboxe5').show();
            $('#textboxe6').show();
            $("#option-5").val("Yes");
            $("#option-6").val("No");
        } else {
            $('#textboxe5').hide();
            $('#textboxe6').hide();
        }

    }
</script>




@endsection