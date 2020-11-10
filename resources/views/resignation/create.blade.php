@extends('layouts.app_home')

@section('content')

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
                <form method="post" action="{{ route('resignation.store') }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="reason" class="col-sm-2 form-label">Reason For Leaving <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <textarea name="reason" id="reason" class="form-control" cols="20" rows="10" required></textarea>
                                @error('reason')
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


@endsection
