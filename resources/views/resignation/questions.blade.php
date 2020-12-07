@extends('layouts.app_home')

@section('content')


@if(session()->get('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

@if(Auth::User()->department_id == 2)
<!-- My resignation details -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Exit Interview Question List</h3>
                    <a href="{{ route('addquestions.index')}}" class="btn btn-primary" style="float: right;">Add Question</a>
                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive ">
                    <table class="table table-hover">
                        <tr>
                            <th width=5%>Question Number</th>
                            <th>Question</th>
                            <th>Options</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($Question as $questions)
                        <?php $Question_options = \DB::table('options')
                            ->where('question_id', $questions->id)
                            ->get(); ?>

                        <tr>
                            <td>{{$questions->question_number}}</td>
                            <td>{{$questions->questions}}</td>
                            <td> @foreach ($Question_options as $options)
                                <ul>
                                    <li>{{ $options->option_value }}</li>
                                </ul></b>
                                @endforeach</td>
                            <td><a href="{{ route('questions.edit', $questions->id )}}" class="btn btn-primary">Edit</a>&nbsp;<a href="{{ url('deleteQuestion/'.$questions->id) }}" class="btn btn-primary">Delete</a></td>
                        </tr> @endforeach


                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@else

<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Exit Interview questions</h3>
        </div>

        <form method="post" action="{{ route('questions.store') }}">
            @csrf

            <div class="box-body">

                @foreach ($Question as $questions)
                <?php $Question_options = \DB::table('options')
                    ->where('question_id', $questions->id)
                    ->get(); ?>

                <div class="form-group row"><br>
                    <label for="withdrawDate" class="col-sm-8  form-label">{{$questions->id}}. {{$questions->questions}} <span class="text-danger">*</span></label>
                    <br>
                    <div class="col-sm-8">
                        @if($questions->question_type == 1)
                        <input type="text" name="{{ $questions->id }}" required class="form-control">
                        @elseif($questions->question_type == 2)
                        @foreach ($Question_options as $options)
                        <input type="radio" class=" {{ $questions->id }}" required name="{{ $questions->id }}" value="{{ $options->option_value }}" id="{{ $options->question_id }}{{ $options->id }}">
                        <label class="radio-custom-label" for="{{ $questions->question_id }}{{ $questions->id }}">
                            <b> {{ $options->option_value }}</b>
                        </label>
                        @endforeach
                        @elseif($questions->question_type == 3)
                        @foreach ($Question_options as $options)
                        <input type="radio" id="chk{{ $options->option_value }}" required name="{{ $questions->id }}" value="{{ $options->option_value }}" onclick="ShowHideDiv()">
                        <label class="radio-custom-label" for="{{ $questions->question_id }}{{ $questions->id }}">
                            <b> {{ $options->option_value }}</b>
                        </label>

                        @endforeach
                        <div id="dvtext" style="display: none">
                            <label class="radio-custom-label" for="{{ $questions->question_id }}{{ $questions->id }}">
                                <b> Specify If Yes.</b>
                            </label>
                            <input type="text" id="txtBox" name="{{$questions->id}}" class="form-control">

                        </div>
                        <div id="dv1text" style="display: none">

                            <input type="hidden" id="txtBox" name="{{$questions->id}}" value="No" class="form-control">

                        </div>
                        @elseif($questions->question_type == 4)
                        <input type="date" name="{{ $questions->id }}" required class="form-control">
                        @endif
                        @error('withdrawDate')
                        <br>
                        <span class="invalid-feedback" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endforeach


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Exit Interview questions -->
<script>
    function ShowHideDiv() {
        var chkYes = document.getElementById("chkYes");
        var dvtext = document.getElementById("dvtext");
        var dv1text = document.getElementById("dv1text");
        dvtext.style.display = chkYes.checked ? "block" : "none";
        dv1text.style.display = chkYes.checked ? "none" : "block";
    }
</script>
@endsection