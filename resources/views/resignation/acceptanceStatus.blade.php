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
                <p><b>Date of joinig: </b>{{ $converted_dates['joining_date'] }}</p>
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
                            <th>Lead</th>
                            <th>Department Head / Unit Head</th>
                            <th>HR</th>
                        </thead>
                        <tbody>
                            <td class="{{ ($leadGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($leadGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted' }}</td>
                            <td class="{{ ($headGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($headGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted' }}</td>
                            <td class="{{ ($hrGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($hrGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted' }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection