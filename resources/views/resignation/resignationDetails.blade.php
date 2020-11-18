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
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Reason : </b>{{ $myResignation->reason }}</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date of Resignation: </b>{{ $myResignation->date_of_resignation }}</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date of leaving as per policy: </b>{{ ($myResignation->changed_dol == NULL) ? $myResignation->date_of_leaving : $myResignation->changed_dol }}</p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection