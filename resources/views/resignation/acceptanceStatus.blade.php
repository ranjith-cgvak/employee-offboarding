@extends('layouts.app_home')

@section('content')

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
                <p><b>Date of joining: </b>{{ $converted_dates['joining_date'] }}</p>
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

<!-- Acceptance status -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Acceptance Status</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <th class="text-center">Lead</th>
                            <th class="text-center">Department Head / Unit Head</th>
                            <th class="text-center">HR</th>
                        </thead>
                        <tbody>
                            <td class="text-center {{ ($leadAcceptance == NULL || $leadAcceptance == 'Pending' ) ? 'bg-warning' :( $leadAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )}}">{{ ($leadAcceptance == NULL ) ? 'Pending' : $leadAcceptance }}</td>
                            <td class="text-center {{ ($headAcceptance == NULL || $headAcceptance == 'Pending' ) ? 'bg-warning' :( $headAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )}}">{{ ($headAcceptance == NULL ) ? 'Pending' : $headAcceptance }}</td>
                            <td class="text-center {{ ($hrAcceptance == NULL || $hrAcceptance == 'Pending' ) ? 'bg-warning' :( $hrAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )}}">{{ ($hrAcceptance == NULL ) ? 'Pending' : $hrAcceptance }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection