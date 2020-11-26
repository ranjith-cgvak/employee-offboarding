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
<!-- end employee details -->


<!-- Modal box for change of date of leave -->
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
<!-- end of model change of date of leave -->

<!-- START CUSTOM TABS -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs (Pulled to the left) -->
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Resignation Details</a></li>
                @if($emp_resignation->date_of_withdraw != NULL )
                <li><a href="#tab_1-2" data-toggle="tab">Withdraw Details</a></li>
                @endif
                @if($emp_resignation->date_of_withdraw == NULL )
                <li><a href="#tab_2-2" data-toggle="tab">Acceptance status</a></li>
                <li><a href="#tab_3-2" data-toggle="tab">No Due</a></li>
                <li><a href="#tab_4-2" data-toggle="tab">Feedback</a></li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <!-- Resignation Details -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox" >
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
                                        @if($emp_resignation->other_reason != NULL)
                                        <div class="form-group row">
                                            <label for="reason" class="col-sm-2 form-label">Other Reasons </label>
                                            <div class="col-sm-6">
                                                <p>{{ $emp_resignation->other_reason }}</p>
                                            </div>
                                        </div>
                                        @endif
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
                        
                        @if(Auth::user()->designation != 'SA')
                        @if($emp_resignation->date_of_withdraw == NULL)
                        <!-- Comments on the resignation -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox">
                                    <!--box-header -->
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
                                                @if(Auth::user()->designation == 'Lead' )
                                                <textarea class="form-control" name="leadComment" id="leadComment" cols="30" rows="10" required>{{ ($emp_resignation->comment_lead != NULL) ? $emp_resignation->comment_lead : ' '}}</textarea>
                                                @endif
                                                    @error('leadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    @if(Auth::user()->designation != 'Lead' )
                                                    <p>{{ $emp_resignation->comment_lead }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(Auth::user()->designation != 'Lead')
                                            <div class="form-group row">
                                                <label for="headComment" class="col-sm-2 form-label">Head comment</label>
                                                <div class="col-sm-6">
                                                    @if(Auth::user()->designation == 'Head' )
                                                    <textarea name="headComment" class="form-control" id="headComment" cols="30" rows="10" required>{{ ($emp_resignation->comment_head != NULL) ? $emp_resignation->comment_head : ' '}}</textarea>
                                                    @endif
                                                    @error('headComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    @if(Auth::user()->designation == 'HR')
                                                    <p>{{ $emp_resignation->comment_head }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                            @if(Auth::user()->designation == 'HR' )
                                            <div class="form-group row">
                                                <label for="hrComment" class="col-sm-2 form-label">HR comment</label>
                                                <div class="col-sm-6">
                                                    <textarea name="hrComment" class="form-control" id="hrComment" cols="30" rows="10" required>{{ ($emp_resignation->comment_hr != NULL) ? $emp_resignation->comment_hr : ' '}}</textarea>
                                                    @error('hrComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @endif

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
                        @endif
                        @endif
                    </div>
                </div>
                <!-- /.tab-pane -->
                @if($emp_resignation->date_of_withdraw != NULL )
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_1-2">

                    <!-- Withdraw Details -->
                    <div class="container-fluid">
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
                        @if(Auth::user()->designation != 'SA')
                        <!-- comments on withdraw details -->
                        <div class="row">
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
                                                    @if(Auth::user()->designation == 'Lead' )
                                                    <textarea name="withdrawLeadComment" id="withdrawLeadComment" class="form-control" cols="30" rows="10" required>{{ ($emp_resignation->comment_dow_lead != NULL) ? $emp_resignation->comment_dow_lead : ' '}}</textarea>
                                                    @endif

                                                    @error('withdrawLeadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                    @if(Auth::user()->designation != 'Lead' )
                                                    <p>{{ $emp_resignation->comment_dow_lead }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            @if(Auth::user()->designation != 'Lead')
                                            <div class="form-group row">
                                                <label for="withdrawHeadComment" class="col-sm-2 form-label">Head comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    @if (Auth::user()->designation == 'Head' ) 
                                                    <textarea name="withdrawHeadComment" id="withdrawHeadComment" cols="30" rows="10" class="form-control" required>{{ ($emp_resignation->comment_dow_head != NULL) ? $emp_resignation->comment_dow_head : ' '}}</textarea>
                                                    @endif
                                                    @error('withdrawHeadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                    @if(Auth::user()->designation == 'HR' )
                                                    <p>{{ $emp_resignation->comment_dow_head }}</p>
                                                    @endif

                                                </div>
                                            </div>
                                            @endif

                                            @if (Auth::user()->designation == 'HR' ) 
                                            <div class="form-group row">
                                                <label for="withdrawHrComment" class="col-sm-2 form-label">HR comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    <textarea name="withdrawHrComment" id="withdrawHrComment" cols="30" rows="10" class="form-control" required>{{ ($emp_resignation->comment_dow_hr != NULL) ? $emp_resignation->comment_dow_hr : ' '}}</textarea>
                                                    @error('withdrawHrComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @endif

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
                        @endif
                        
                    </div>
                
                </div>
                <!-- /.tab-pane -->
                @endif

                @if($emp_resignation->date_of_withdraw == NULL )
                <div class="tab-pane" id="tab_2-2">
                    <!-- Acceptance details -->
                    <div class="container-fluid">
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
                                                @if(Auth::user()->designation != 'SA')
                                                <th title="General Comment">Comment</th>
                                                <th>Date of leaving</th>
                                                <th title="Comment on date of leaving">Comment DOL</th>
                                                @endif
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Lead</td>
                                                    <td class="{{ ($emp_resignation->comment_lead == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($emp_resignation->comment_lead == NULL) ? 'Pending' : 'Accepted' }}</td>
                                                    @if(Auth::user()->designation != 'SA')
                                                    <td>{{ $emp_resignation->comment_lead }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_lead != NULL ) ? $emp_resignation->changed_dol : ' ' }}</td>
                                                    <td>{{ $emp_resignation->comment_dol_lead }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Department Head / Unit Head</td>
                                                    <td class="{{ ($emp_resignation->comment_head == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($emp_resignation->comment_head == NULL) ? 'Pending' : 'Accepted' }}</td>
                                                    @if(Auth::user()->designation != 'SA')
                                                    <td>{{ $emp_resignation->comment_head }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_head != NULL ) ? $emp_resignation->changed_dol : ' ' }}</td>
                                                    <td>{{ $emp_resignation->comment_dol_head }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>HR</td>
                                                    <td class="{{ ($emp_resignation->comment_hr == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($emp_resignation->comment_hr == NULL) ? 'Pending' : 'Accepted' }}</td>
                                                    @if(Auth::user()->designation != 'SA')
                                                    <td>{{ $emp_resignation->comment_hr }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_hr != NULL ) ? $emp_resignation->changed_dol : ' ' }}</td>
                                                    <td>{{ $emp_resignation->comment_dol_hr }}</td>
                                                    @endif
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
                @endif
                <div class="tab-pane" id="tab_3-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">No Due</h3>
                                    </div>
                                    <div class="box-body">
                                        
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Attributes</th>
                                                <th>Comments</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"> Official Email Account
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <textarea name="commentMailAccount" class="form-control" id="commentMailAccount" cols="30" rows="3"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"> Skype Account
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <textarea name="commentSkypeAccount" class="form-control" id="commentSkypeAccount" cols="30" rows="3"></textarea>
                                                        </div>
                                                    </td> 
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- /.tab-pane -->

                <!-- Feedback form -->
                <div class="tab-pane" id="tab_4-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <form method="get" action="{{ (!$feedback) ? route('storeFeedback') : route('updateFeedback') }}">
                                    <div class="box box-secondary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Feedback</h3>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                <td rowspan="2"><h3 class="text-center">Present Skill Set</h3></td>
                                                <td><label for="primary_skill" class="form-label">Primary</label></td></td>
                                                <td><input type="text" name="primary_skill" id="primary_skill" class="form-control" value="{{ (!$feedback) ? '' : $feedback->skill_set_primary }}" required>
                                                    @error('primary_skill')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </td>
                                                </tr>
                                                <tr>
                                                <td><label for="secondary_skill" class="form-label">Secondary</label</td>
                                                <td><input type="text" name="secondary_skill" id="secondary_skill" class="form-control" value="{{ (!$feedback) ? '' : $feedback->skill_set_secondary }}" required>       
                                                    @error('secondary_skill')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </td>
                                                </tr>

                                                <tr>
                                                <td><h3 class="text-center">Last worked project</h3></td>
                                                    <td>
                                                    <label for="last_worked_project" class="form-label">Project Name:</label</td>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="last_worked_project" id="last_worked_project" class="form-control" value="{{ (!$feedback) ? '' : $feedback->last_worked_project }}" required>
                                                        @error('last_worked_project')
                                                        <br>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </td>
                                                </tr>

                                            </table>
                                            </br>
                                            <table class="table table-bordered">
                                                
                                            </table>
                                            </br>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th><h3>Attributes</h3></th>
                                                    <th><h3>Ratings</h3></th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><label for="attendance" class="form-label">Attendance</label></td>
                                                        <td>
                                                            <select name="attendance" id="attendance" class="form-control" required>
                                                                <option value="{{ (!$feedback) ? '' : $feedback->attendance_rating }}">{{ (!$feedback) ? 'Select' : $feedback->attendance_rating }}</option>
                                                                <option value="Excellent">Excellent</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Satisfactory">Satisfactory</option>
                                                                <option value="Poor">Poor</option>
                                                            </select>
                                                            @error('attendance')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsiveness" class="form-label">Reponsiveness</label></td>
                                                        <td>
                                                            <select name="reponsiveness" id="reponsiveness" class="form-control" required>
                                                                <option value="{{ (!$feedback) ? '' : $feedback->responsiveness_rating }}">{{ (!$feedback) ? 'Select' : $feedback->responsiveness_rating }}</option>
                                                                <option value="Excellent">Excellent</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Satisfactory">Satisfactory</option>
                                                                <option value="Poor">Poor</option>
                                                            </select>
                                                            @error('reponsiveness')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsibility" class="form-label">Reponsibility</label></td>
                                                        <td>
                                                            <select name="reponsibility" id="reponsibility" class="form-control" required>
                                                                <option value="{{ (!$feedback) ? '' : $feedback->responsibility_rating }}">{{ (!$feedback) ? 'Select' : $feedback->responsibility_rating }}</option>
                                                                <option value="Excellent">Excellent</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Satisfactory">Satisfactory</option>
                                                                <option value="Poor">Poor</option>
                                                            </select>
                                                            @error('reponsibility')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="commit_on_task_delivery" class="form-label">Commit on Task Delivery</label></td>
                                                        <td>
                                                            <select name="commit_on_task_delivery" id="commit_on_task_delivery" class="form-control" required>
                                                                <option value="{{ (!$feedback) ? '' : $feedback->commitment_on_task_delivery_rating }}">{{ (!$feedback) ? 'Select' : $feedback->commitment_on_task_delivery_rating }}</option>
                                                                <option value="Excellent">Excellent</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Satisfactory">Satisfactory</option>
                                                                <option value="Poor">Poor</option>
                                                            </select>
                                                            @error('commit_on_task_delivery')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="technical_knowledge" class="form-label">Technical Knowledge</label></td>
                                                        <td>
                                                            <select name="technical_knowledge" id="technical_knowledge" class="form-control" required>
                                                                <option value="{{ (!$feedback) ? '' : $feedback->technical_knowledge_rating }}">{{ (!$feedback) ? 'Select' : $feedback->technical_knowledge_rating }}</option>
                                                                <option value="Excellent">Excellent</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Satisfactory">Satisfactory</option>
                                                                <option value="Poor">Poor</option>
                                                            </select>
                                                            @error('technical_knowledge')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="logical_ablitiy" class="form-label">Logical Ability</label></td>
                                                        <td>
                                                            <select name="logical_ablitiy" id="logical_ablitiy" class="form-control" required>
                                                                <option value="{{ (!$feedback) ? '' : $feedback->logical_ability_rating }}">{{ (!$feedback) ? 'Select' : $feedback->logical_ability_rating }}</option>
                                                                <option value="Excellent">Excellent</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Satisfactory">Satisfactory</option>
                                                                <option value="Poor">Poor</option>
                                                            </select>
                                                            @error('logical_ablitiy')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="attitude" class="form-label">Attitude</label></td>
                                                        <td>
                                                            <select name="attitude" id="attitude" class="form-control" required>
                                                                <option value="{{ (!$feedback) ? '' : $feedback->attitude_rating }}">{{ (!$feedback) ? 'Select' : $feedback->attitude_rating }}</option>
                                                                <option value="Excellent">Excellent</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Satisfactory">Satisfactory</option>
                                                                <option value="Poor">Poor</option>
                                                            </select>
                                                            @error('attitude')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="overall_performance" class="form-label">Overall performance during the tenure with CG-VAK Software</label></td>
                                                        <td>
                                                            <select name="overall_performance" id="overall_performance" class="form-control" required>
                                                                <option value="{{ (!$feedback) ? '' : $feedback->overall_rating }}">{{ (!$feedback) ? 'Select' : $feedback->overall_rating }}</option>
                                                                <option value="Excellent">Excellent</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Satisfactory">Satisfactory</option>
                                                                <option value="Poor">Poor</option>
                                                            </select>
                                                            @error('overall_performance')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            </br>
                                            <div class="form-group">
                                                <label for="feedback_comments" class="form-label">Comments</label>
                                                <textarea name="feedback_comments" id="feedback_comments" cols="30" rows="10" class="form-control" required>{{ (!$feedback) ? '' : ((Auth::user()->designation == 'Lead') ? $feedback->lead_comment : $feedback->head_comment) }}</textarea>
                                                @error('feedback_comments')
                                                <br>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xs-12">
                                                    <label class="form-label">Thankyou for your valuable feedback</label>
                                                </div>
                                                <div class="col-xs-2">
                                                    <input type="date" name="date_of_feedback" value="{{ Date('Y-m-d')}}" id="date_of_feedback" class="form-control disablePast">
                                                </div>
                                                
                                            </div>
                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">  
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                </div>
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
