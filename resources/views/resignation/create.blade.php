@extends('layouts.app_home')

@section('content')

@if(session()->get('success'))
<div class="alert alert-success">
{{ session()->get('success') }}
</div>
@endif

<!-- Employee details -->
<div class="container-fluid">
    <div class="box box-primary box-body">
        <div class="row">
            <div class="col-xs-4">
                <p><b>Employee Name: </b>{{ $user->display_name }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Employee ID: </b>{{ $user->emp_id }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Date of joinig: </b>{{ $user->joining_date }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <p><b>Designation: </b>{{ $user->designation }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Department: </b>{{ $user->department_name }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Lead: </b>{{ ($user->lead == NULL) ? 'Not Assigned' : $user->lead }}</p>
            </div>
        </div>
    </div>
</div>

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
                <form method="post" action="{{ route('resignation.store') }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="reason" class="col-sm-2 form-label">Reason For Leaving <span class="text-danger">*</span></label>
                            
                            <div class="col-sm-6">
                                <select name="reason" id="reason" class="form-control" onchange='CheckOthers(this.value)'>
                                <option value="">Select</option>
                                <option value="Health reason">Health reason</option>
                                <option value="others">Others</option>
                                </select>
                                @error('reason')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" id="othersDiv"  style='display:none;'>
                            <label for="others" class="col-sm-2 form-label">Mention the reason  <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="others"  class="form-control">
                                @error('others')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="comment_on_resignation" class="col-sm-2 form-label">Comments <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <textarea name="comment_on_resignation" id="comment_on_resignation" class="form-control" cols="20" rows="10" required></textarea>
                                @error('comments')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dateOfResignation" class="col-sm-2 form-label">Date Of Resignation <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control disablePast" value="{{ Date('Y-m-d')}}" id="dateOfResignation" name="dateOfResignation">
                                @error('dateOfResignation')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dateOfLeaving" class="col-sm-2 form-label">Date Of Leaving As Per Policy </label>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control" value="{{ Date('m/d/Y', strtotime('+3 months')) }}" id="dateOfLeaving" name="dateOfLeaving">
                                @error('dateOfLeaving')
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
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

<!-- others option on drop down -->
<script>
function CheckOthers(val){
    var element=document.getElementById('othersDiv');
    if(val=='others')
    element.style.display='block';
    else  
        element.style.display='none';
    }
</script>

@endsection
