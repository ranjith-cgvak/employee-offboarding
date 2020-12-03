@extends('layouts.app_home')

@section('content')

<!-- Employee details -->
@if(session()->get('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
<!-- Leaving form -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary formBox">
                <div class="box-header with-border">
                    <h3 class="box-title">Leaving Form</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="{{ route('addquestions.store') }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="question_number" class="col-sm-2 form-label">Question Number<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly="true" required name="question_number" id="question_number" value="{{$count}}">
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
                                <input type="text" class="form-control" required name="question" id="question">
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
                                    <option value="0">--Select--</option>
                                    @foreach($QustionType as $QustionTypes)
                                    <option value="{{$QustionTypes->id}}">{{$QustionTypes->type}}</option>
                                    @endforeach
                                </select>
                                @error('question_type')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe1">
                            <label for="question" class="col-sm-2 form-label">Option-1 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="1" id="option-1">
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
                                <input type="text" class="form-control"  name="2" id="option-2">
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
                                <input type="text" class="form-control"  name="3" id="option-3">
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
                                <input type="text" class="form-control"  name="4" id="option-4">
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
                        <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    function changeFunc() {
        var selectBox = document.getElementById("selectBox");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if (selectedValue == 2) {
            $('#textboxe1').show();
            $('#textboxe2').show();
            $('#textboxe3').show();
            $('#textboxe4').show();
            $("#option-1").val("");
            $("#option-2").val("");
        } else {
            $('#textboxe1').hide();
            $('#textboxe2').hide();
            $('#textboxe3').hide();
            $('#textboxe4').hide();
        }
        if (selectedValue == 3) {
            $('#textboxe1').show();
            $('#textboxe2').show();
            $("#option-1").val("Yes");
            $("#option-2").val("No");
        }

    }
</script>




@endsection