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
                <p><b>Date of Joining: </b>{{ $converted_dates['joining_date'] }}</p>
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

<!-- No Due status -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">No Due Status</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>Lead</th>
                            <th>Department Head / Unit Head</th>
                            <th>HR</th>
                            <th>SA</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td @if($nodue) class="{{ ($nodue->knowledge_transfer_lead == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Knowledge Transfer</td>
                                <td @if($nodue) class="{{ ($nodue->knowledge_transfer_head == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Knowledge Transfer</td>
                                <td @if($nodue) class="{{ ($nodue->id_card == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>ID Card</td>
                                <td @if($nodue) class="{{ ($nodue->official_email_id == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Official Email ID</td>
                            </tr>
                            <tr>
                                <td @if($nodue) class="{{ ($nodue->mail_id_closure_lead == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Mail ID Closure</td>
                                <td @if($nodue) class="{{ ($nodue->mail_id_closure_head == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Mail ID Closure</td>
                                <td @if($nodue) class="{{ ($nodue->nda == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>NDA</td>
                                <td @if($nodue) class="{{ ($nodue->skype_account == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif>Skype Account</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    @if($completed_no_due)
                    <a href="{{ route('questions.index')}}" class="btn btn-primary" style="float: right;">Exit Interview</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
