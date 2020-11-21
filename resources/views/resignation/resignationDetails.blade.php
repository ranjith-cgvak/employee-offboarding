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
                <p><b>Employee Name: </b>{{ $user->name }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Employee ID: </b>{{ $user->id }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Date of joinig: </b>{{ $user->created_at }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <p><b>Designation: </b>{{ $user->designation }}</p>
            </div>
            <div class="col-xs-4">
                <p><b>Department: </b>IT</p>
            </div>
            <div class="col-xs-4">
                <p><b>Lead: </b>{{ ($user->lead == NULL) ? 'Not Assigned' : $user->lead }}</p>
            </div>
        </div>
    </div>
</div>

<!-- My resignation details -->
<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">My Resignation Details</h3>
        </div>

        <div class="box-body">
            <div class="form-group row">
                <label for="reason" class="col-sm-2 form-label">Reason For Leaving </label>
                <div class="col-sm-6">
                    <p>{{ $myResignation->reason }}</p>
                </div>
            </div>
            @if($myResignation->other_reason != NULL)
            <div class="form-group row">
                <label for="reason" class="col-sm-2 form-label">Other Reason </label>
                <div class="col-sm-6">
                    <p>{{ $myResignation->other_reason }}</p>
                </div>
            </div>
            @endif
            <div class="form-group row">
                <label for="comment_on_resignation" class="col-sm-2 form-label">Comments </label>
                <div class="col-sm-6">
                    <p>{{ $myResignation->comment_on_resignation }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label for="dateOfResignation" class="col-sm-2 form-label">Date Of Resignation </label>
                <div class="col-sm-4">
                    <p>{{ $myResignation->date_of_resignation }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label for="dateOfLeaving" class="col-sm-2 form-label">Date Of Leaving As Per Policy </label>
                <div class="col-sm-4">
                    <p>{{ $myResignation->date_of_leaving }}</p>
                </div>     
            </div>
        </div>
    </div>

</div>


@endsection