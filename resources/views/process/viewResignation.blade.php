@extends('layouts.app_home')

@section('content')


@if(session()->get('success'))
<div class="alert alert-success">
{{ session()->get('success') }}
</div>
@endif

<!-- Employee details -->
<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Employee Details</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Employee Name: </b>{{ $emp_resignation->name }}</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Employee ID: </b>{{ $emp_resignation->user_id }}</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date of joinig: </b>{{ $emp_resignation->created_at }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Designation: </b>{{ $emp_resignation->designation }}</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Department: </b>IT</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Lead: </b>{{ $emp_resignation->lead }}</p>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Change Date of Leaving</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="get" action="{{ route('updateDol')}}">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group row">
                <label for="dateOfLeaving" class="col-sm-4 form-label">Change DOL: </label>
                <div class="col-sm-6">
                    <input type="date" class="form-control disablePast" value="{{ $emp_resignation->date_of_leaving }}" id="dateOfLeaving" name="dateOfLeaving">
                    @error('dateOfLeaving')
                    <br>
                    <span class="invalid-feedback" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                    @enderror
                </div>     
            </div>
            <div class="form-group row">
                <label for="commentDol" class="col-sm-4 form-label">Comment DOL: </label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required>{{ (Auth::user()->designation != 'Lead' ) ? $emp_resignation->comment_dol_head : $emp_resignation->comment_dol_lead}}</textarea>
                    @error('dateOfLeaving')
                    <br>
                    <span class="invalid-feedback" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                    @enderror
                </div>     
            </div>
            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- START CUSTOM TABS -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs (Pulled to the left) -->
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Resignation Details</a></li>
                <li style="display:{{ ($emp_resignation->date_of_withdraw == NULL ) ? 'none' : ' ' }};" ><a href="#tab_1-2" data-toggle="tab">Withdraw Details</a></li>
                <li style="display:{{ ($emp_resignation->date_of_withdraw != NULL ) ? 'none' : ' ' }};"><a href="#tab_2-2" data-toggle="tab">Acceptance status</a></li>
                <!-- <li style="display:{{ ($emp_resignation->date_of_withdraw != NULL ) ? 'none' : ' ' }};"><a href="#tab_3-2" data-toggle="tab">No Due</a></li> -->
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <!-- Resignation Details -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox" @if(session()->get('success')) style="display: none;"  @endif >
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Resignation Details</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="box-body">
                                        <div class="form-group row">
                                            <label for="reason" class="col-sm-2 form-label">Reason For Leaving the job</label>
                                            <div class="col-sm-6">
                                                <p>{{ $emp_resignation->reason }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dateOfResignation" class="col-sm-2 form-label">Date Of Resignation</label>
                                            <div class="col-sm-4">
                                                <p>{{ $emp_resignation->date_of_resignation }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dateOfLeaving" class="col-sm-2 form-label">Date Of Leaving As Per Policy </label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                    <p>{{ ($emp_resignation->changed_dol == NULL) ? $emp_resignation->date_of_leaving : $emp_resignation->changed_dol }}</p>
                                                    </div>
                                                    <div class="col-sm-4" style="display:{{ ($emp_resignation->date_of_withdraw != NULL || $emp_resignation->changed_dol != NULL ) ? 'none' : ' ' }};">
                                                    <button type="button" class="btn btn-primary modelBtn" data-toggle="modal" data-target="#exampleModalCenter"><i style='font-size:17px' class='fa fa-edit'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Comments on the resignation -->
                        <div class="row" style="display:{{ ($emp_resignation->date_of_withdraw != NULL ) ? 'none' : ' ' }};">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox" @if(session()->get('success')) style="display: none;"  @endif >
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Comments</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form method="get" action="{{ route('updateResignationComment') }}">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label for="leadComment" class="col-sm-2 form-label">Lead Comment </label>
                                                <div class="col-sm-6">
                                                <textarea class="form-control" name="leadComment" id="leadComment" cols="30" rows="10" style="display:{{ (Auth::user()->designation != 'Lead' ) ? 'none' : ' ' }};" required>{{ ($emp_resignation->comment_lead != NULL) ? $emp_resignation->comment_lead : ' '}}</textarea>
                                                    @error('leadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    <p style="display:{{ (Auth::user()->designation == 'Lead' ) ? 'none' : ' ' }};">{{ $emp_resignation->comment_lead }}</p>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display:{{ (Auth::user()->designation == 'Lead' ) ? 'none' : ' ' }};">
                                                <label for="headComment" class="col-sm-2 form-label">Head comment</label>
                                                <div class="col-sm-6">
                                                    <textarea name="headComment" class="form-control" id="headComment" cols="30" rows="10" required>{{ ($emp_resignation->comment_head != NULL) ? $emp_resignation->comment_head : ' '}}</textarea>
                                                    @error('headComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
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
                <!-- /.tab-pane -->

                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_1-2" style="display:{{ ($emp_resignation->date_of_withdraw == NULL ) ? 'none' : ' ' }};">

                    <!-- Withdraw Details -->
                    <div class="container-fluid" style="display:{{ ($emp_resignation->date_of_withdraw == NULL ) ? 'none' : ' ' }};">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Withdraw Details</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="form-group row">
                                            <label for="withdrawDate" class="col-sm-2 form-label">Withdraw Date </label>
                                            <div class="col-sm-4">
                                                <p>{{ $emp_resignation->date_of_withdraw }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="comment" class="col-sm-2 form-label">Comment </label>
                                            <div class="col-sm-4">
                                                <p>{{ $emp_resignation->comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display:{{ ($emp_resignation->date_of_withdraw == NULL ) ? 'none' : ' ' }};">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Comments on Withdraw</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form method="get" action="{{ route('updateDowComment') }}">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label for="withdrawLeadComment" class="col-sm-2 form-label">Lead Comment on Withdraw </label>
                                                <div class="col-sm-6">
                                                    <textarea name="withdrawLeadComment" id="withdrawLeadComment" class="form-control" cols="30" rows="10" style="display:{{ (Auth::user()->designation != 'Lead' ) ? 'none' : ' ' }};" required>{{ ($emp_resignation->comment_dow_lead != NULL) ? $emp_resignation->comment_dow_lead : ' '}}</textarea>
                                                    @error('withdrawLeadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    <p style="display:{{ (Auth::user()->designation == 'Lead' ) ? 'none' : ' ' }};">{{ $emp_resignation->comment_dow_lead }}</p>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display:{{ (Auth::user()->designation == 'Lead' ) ? 'none' : ' ' }};">
                                                <label for="withdrawHeadComment" class="col-sm-2 form-label">Head comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    <textarea name="withdrawHeadComment" id="withdrawHeadComment" cols="30" rows="10" class="form-control" required>{{ ($emp_resignation->comment_dow_head != NULL) ? $emp_resignation->comment_dow_head : ' '}}</textarea>
                                                    @error('withdrawHeadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
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
                <!-- /.tab-pane -->

                <div class="tab-pane" id="tab_2-2">
                    <!-- Acceptance details -->
                    <div class="container-fluid" style="display:{{ ($emp_resignation->date_of_withdraw != NULL ) ? 'none' : ' ' }};" >
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Acceptance Status</h3>
                                    </div>
                                    <div class="box-body">
                                        
                                        <table class="table table-bordered">
                                            <thead>
                                                <th></th>
                                                <th>Resignation Details</th>
                                                <th title="General Comment">Comment</th>
                                                <th>Date of leaving</th>
                                                <th title="Comment on date of leaving">Comment DOL</th>
                                                
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Lead</td>
                                                    <td class="{{ ($emp_resignation->comment_lead == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($emp_resignation->comment_lead == NULL) ? 'Pending' : 'Accepted' }}</td>
                                                    <td>{{ $emp_resignation->comment_lead }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_lead != NULL ) ? $emp_resignation->changed_dol : ' ' }}</td>
                                                    <td>{{ $emp_resignation->comment_dol_lead }}</td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td>Department Head / Unit Head</td>
                                                    <td class="{{ ($emp_resignation->comment_head == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($emp_resignation->comment_head == NULL) ? 'Pending' : 'Accepted' }}</td>
                                                    <td>{{ $emp_resignation->comment_head }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_head != NULL ) ? $emp_resignation->changed_dol : ' ' }}</td>
                                                    <td>{{ $emp_resignation->comment_dol_head }}</td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>HR</td>
                                                    <td class="{{ ($emp_resignation->comment_hr == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($emp_resignation->comment_hr == NULL) ? 'Pending' : 'Accepted' }}</td>
                                                    <td>{{ $emp_resignation->comment_hr }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_hr != NULL ) ? $emp_resignation->changed_dol : ' ' }}</td>
                                                    <td>{{ $emp_resignation->comment_dol_hr }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
                <!-- /.tab-pane -->
                <!-- <div class="tab-pane" id="tab_3-2">

                
                
                </div> -->
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
</div>


@endsection
