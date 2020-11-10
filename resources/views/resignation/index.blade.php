@extends('layouts.app_home')

@section('content')


@if(session()->get('success'))
<div class="alert alert-success">
{{ session()->get('success') }}
</div>
@endif

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
                            <td class="{{ ($myResignation->comment_lead == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($myResignation->comment_lead == NULL) ? 'Pending' : 'Accepted' }}</td>
                            <td class="{{ ($myResignation->comment_head == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($myResignation->comment_head == NULL) ? 'Pending' : 'Accepted' }}</td>
                            <td class="{{ ($myResignation->comment_hr == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($myResignation->comment_hr == NULL) ? 'Pending' : 'Accepted' }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- With draw form with collaped box -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Withdraw Form</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-solid formBox">
                                
                                <!-- /.box-header -->
                                <!-- form start -->
                                <form method="post" action="{{ route('resignation.update', $myResignation->id ) }}">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <div class="box-body">
                                        <div class="form-group row">
                                            <label for="withdrawDate" class="col-sm-2 form-label">Withdraw Date <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control disablePast" value="{{ Date('Y-m-d')}}" id="withdrawDate" name="withdrawDate">
                                                @error('withdrawDate')
                                                <br>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="comment" class="col-sm-2 form-label">Comment <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" required></textarea>
                                                @error('comment')
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
            </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
</div>


@endsection
