@extends('layouts.app_home')

@section('content')

<!-- Employee details -->
<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Employee Details</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Employee Name: </b>{{ $emp_resignation->display_name }}</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Employee ID: </b>{{ $emp_resignation->employee_id }}</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date Of Joining: </b>{{ $converted_dates['joining_date'] }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Designation: </b>{{ $emp_resignation->designation }}</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Department: </b>{{ $emp_resignation->department_name }}</p>
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
        <form method="get" action="{{ route('addOrUpdateDolComments')}}">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group row">
                <label for="dateOfLeaving" class="col-sm-4 form-label">Change DOL: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control jquery-datepicker" value="{{ $emp_resignation->changed_dol }}" id="dateOfLeaving" name="dateOfLeaving">
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
                    @if(\Auth::User()->designation_id == 2)<textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required>{{($leadDolComment != NULL) ? $leadDolComment['comment'] : '' }}</textarea>@endif
                    @if(\Auth::User()->designation_id == 3)<textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required>{{($headDolComment != NULL) ? $headDolComment['comment'] : '' }}</textarea>@endif
                    @if(\Auth::User()->department_id == 2)<textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required>{{($hrDolComment != NULL) ? $hrDolComment['comment'] : '' }}</textarea>@endif
                    @error('dateOfLeaving')
                    <br>
                    <span class="invalid-feedback" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
            <input type="hidden" name="leadDolCommentId" value="{{ ($leadDolComment != NULL) ? $leadDolComment['id'] : NULL }} ">
            <input type="hidden" name="headDolCommentId" value="{{ ($headDolComment != NULL) ? $headDolComment['id'] : NULL }} ">
            <input type="hidden" name="hrDolCommentId" value="{{ ($hrDolComment != NULL) ? $hrDolComment['id'] : NULL }} ">
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
                <li><a href="#tab_2-2" data-toggle="tab">Acceptance Status</a></li>
                @if(\Auth::User()->department_id != 7 && $is_feedback_enable)
                <li><a href="#tab_3-2" data-toggle="tab">Feedback</a></li>
                @endif
                @if($displayNodue)
                <li><a href="#tab_4-2" data-toggle="tab">No Due</a></li>
                @endif
                @if(Auth::User()->department_id == 2 && $showAnswers != NULL)
                <li><a href="#tab_5-2" data-toggle="tab">Exit Interview Answers</a></li>
                @endif
                @if(\Auth::User()->department_id == 2 && $showAnswers != NULL)
                <li><a href="#tab_6-2" data-toggle="tab">Final Exit Checklist</a></li>
                @endif
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
                                    @if(\Auth::User()->department_id != 7)
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Reason For Leaving the job</label>
                                            <div class="col-sm-6">
                                                <p>{{ $emp_resignation->reason }}</p>
                                            </div>
                                        </div>
                                        @if($emp_resignation->other_reason != NULL)
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Other Reasons </label>
                                            <div class="col-sm-6">
                                                <p>{{ $emp_resignation->other_reason }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Comments on leaving</label>
                                            <div class="col-sm-6">
                                                <p>{{ $emp_resignation->comment_on_resignation }}</p>
                                            </div>
                                        </div>
                                    @endif
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Date Of Resignation</label>
                                            <div class="col-sm-4">
                                                <p>{{ $converted_dates['date_of_resignation'] }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Date Of Leaving As Per Policy </label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                    <p>{{ $converted_dates['date_of_leaving'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($emp_resignation->date_of_withdraw == NULL)
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Date Of Leaving </label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                    <p>{{ $converted_dates['changed_dol'] }}</p>
                                                    </div>
                                                    @if(\Auth::User()->department_id != 7)
                                                    <div class="col-sm-4">
                                                    <button type="button" class="btn modelBtn" data-toggle="modal" data-target="#exampleModalCenter"><i style='font-size:17px' class='fa fa-edit'></i></button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(\Auth::User()->department_id != 7)
                        @if($emp_resignation->date_of_withdraw == NULL)
                        @if($is_reviewed)
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
                                    <form method="get" action="{{ route('addOrUpdateResignationAcceptance') }}">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="box-body">

                                            <div class="form-group row">
                                                <label for="accepatanceStatus" class="col-sm-2 form-label">Your Acceptance</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="accepatanceStatus" id="accepatanceStatus" required>
                                                        <option value="{{ ($acceptanceValue == NULL) ? '' : $acceptanceValue }}">{{ ($acceptanceValue == NULL) ? 'Select' : $acceptanceValue }}</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Accepted">Accepted</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select>
                                                    @error('accepatanceStatus')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="acceptanceComment" class="col-sm-2 form-label">Your Comment </label>
                                                <div class="col-sm-6">
                                                <textarea class="form-control" name="acceptanceComment" id="acceptanceComment" cols="30" rows="10" required>{{ ($acceptanceComment != NULL) ? $acceptanceComment : '' }}</textarea>
                                                    @error('acceptanceComment')
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
                        @endif
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
                                                <p>{{ $emp_resignation->comment_on_withdraw }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(\Auth::User()->department_id != 7)
                        <!-- comments on withdraw details -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Comments on Withdraw</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form method="get" action="{{ route('addOrUpdateDowComment') }}">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label for="withdrawLeadComment" class="col-sm-2 form-label">Lead Comment on Withdraw </label>
                                                <div class="col-sm-6">
                                                    @if(Auth::User()->designation_id == 2 )
                                                    <textarea name="withdrawLeadComment" id="withdrawLeadComment" class="form-control" cols="30" rows="10" required>{{ ($leadDowComment != NULL) ? $leadDowComment['comment'] : '' }}</textarea>
                                                    @endif

                                                    @error('withdrawLeadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                    @if(Auth::User()->designation_id != 2)
                                                    <p>{{ ($leadDowComment != NULL) ? $leadDowComment['comment'] : 'N/A' }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            @if(Auth::User()->designation_id != 2)
                                            <div class="form-group row">
                                                <label for="withdrawHeadComment" class="col-sm-2 form-label">Head comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    @if (Auth::User()->designation_id == 3)
                                                    <textarea name="withdrawHeadComment" id="withdrawHeadComment" cols="30" rows="10" class="form-control" required>{{ ($headDowComment != NULL) ? $headDowComment['comment'] : ''}}</textarea>
                                                    @endif
                                                    @error('withdrawHeadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                    @if(Auth::User()->department_id == 2)
                                                    <p>{{ ($headDowComment != NULL) ? $headDowComment['comment'] : 'N/A' }}</p>
                                                    @endif

                                                </div>
                                            </div>
                                            @endif

                                            @if (Auth::User()->department_id == 2)
                                            <div class="form-group row">
                                                <label for="withdrawHrComment" class="col-sm-2 form-label">HR comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    <textarea name="withdrawHrComment" id="withdrawHrComment" cols="30" rows="10" class="form-control" required>{{ ($hrDowComment != NULL) ? $hrDowComment['comment'] : '' }}</textarea>
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
                                            <input type="hidden" name="leadDowCommentId" value="{{ ($leadDowComment != NULL) ? $leadDowComment['id'] : NULL }} ">
                                            <input type="hidden" name="headDowCommentId" value="{{ ($headDowComment != NULL) ? $headDowComment['id'] : NULL }} ">
                                            <input type="hidden" name="hrDowCommentId" value="{{ ($hrDowComment != NULL) ? $hrDowComment['id'] : NULL }} ">
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
                                                @if(\Auth::User()->department_id != 7)
                                                <th title="General Comment">Comment</th>
                                                <th>Date of leaving</th>
                                                <th title="Comment on date of leaving">Comment DOL</th>
                                                @endif
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Lead</td>
                                                    <td class="{{ ($leadAcceptance == NULL || $leadAcceptance == 'Pending' ) ? 'bg-warning' :( $leadAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )}}">{{ ($leadAcceptance == NULL ) ? 'Pending' : $leadAcceptance }}</td>
                                                    @if(\Auth::User()->department_id != 7)
                                                    <td>{{ $leadGeneralComment['comment'] }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $leadDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' ' }}</td>
                                                    <td>{{ $leadDolComment['comment'] }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Department Head / Unit Head</td>
                                                    <td class="{{ ($headAcceptance == NULL || $headAcceptance == 'Pending' ) ? 'bg-warning' :( $headAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )}}">{{ ($headAcceptance == NULL ) ? 'Pending' : $headAcceptance }}</td>
                                                    @if(\Auth::User()->department_id != 7)
                                                    <td>{{ $headGeneralComment['comment'] }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $headDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' ' }}</td>
                                                    <td>{{ $headDolComment['comment'] }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>HR</td>
                                                    <td class="{{ ($hrAcceptance == NULL || $hrAcceptance == 'Pending' ) ? 'bg-warning' :( $hrAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )}}">{{ ($hrAcceptance == NULL ) ? 'Pending' : $hrAcceptance }}</td>
                                                    @if(\Auth::User()->department_id != 7)
                                                    <td>{{ $hrGeneralComment['comment'] }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $hrDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' ' }}</td>
                                                    <td>{{ $hrDolComment['comment'] }}</td>
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

                @if(\Auth::User()->department_id != 7 && $is_feedback_enable)
                <!-- Feedback form Software-->
                <div class="tab-pane" id="tab_3-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <form method="get" action="{{ route('addOrUpdateFeedback') }}">
                                    <div class="box box-secondary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Feedback</h3>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th><h3>Present Skill Set</h3></th>
                                                    <th></th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><label for="primary_skill" class="form-label">Primary <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Primary">
                                                        @if(Auth::User()->department_id == 2)
                                                        <td>{{ (!$feedbackValues['primary']) ? 'N/A' : $feedbackValues['primary'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                        <td><input type="text" name="value[]" id="primary_skill" class="form-control" value="{{ $feedbackValues['primary'] }}" required>
                                                            @error('primary_skill')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="secondary_skill" class="form-label">Secondary <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Secondary">
                                                        @if(Auth::User()->department_id == 2)
                                                        <td>{{ (!$feedbackValues['secondary']) ? 'N/A' : $feedbackValues['secondary'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                        <td><input type="text" name="value[]" id="secondary_skill" class="form-control" value="{{ $feedbackValues['secondary'] }}" required>
                                                            @error('secondary_skill')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><h3>Last Worked Project</h3></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="last_worked_project" class="form-label">Project Name <span class="text-danger">*</span></label></td>
                                                            <input type="hidden" name="attribute[]" value="Project Name">
                                                        </td>
                                                        @if(Auth::User()->department_id == 2)
                                                        <td>{{ (!$feedbackValues['project_name']) ? 'N/A' : $feedbackValues['project_name'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td colspan="2">
                                                                <input type="text" name="value[]" id="last_worked_project" class="form-control" value="{{ $feedbackValues['project_name'] }}" required>
                                                                @error('last_worked_project')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th><h3>Attributes</h3></th>
                                                    <th><h3>Ratings</h3></th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><label for="attendance" class="form-label">Attendance <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Attendance">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['attendance']) ? 'N/A' : $feedbackValues['attendance'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="attendance" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['attendance'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['attendance'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['attendance'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['attendance'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('attendance')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsiveness" class="form-label">Reponsiveness <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Reponsiveness">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['reponsiveness']) ? 'N/A' : $feedbackValues['reponsiveness'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="reponsiveness" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['reponsiveness'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['reponsiveness'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['reponsiveness'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['reponsiveness'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('reponsiveness')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsibility" class="form-label">Reponsibility <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Reponsibility">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['reponsibility']) ? 'N/A' : $feedbackValues['reponsibility'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="reponsibility" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['reponsibility'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['reponsibility'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['reponsibility'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['reponsibility'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('reponsibility')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="commit_on_task_delivery" class="form-label">Commit on Task Delivery <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Commit on Task Delivery">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['commit_on_task_delivery']) ? 'N/A' : $feedbackValues['commit_on_task_delivery'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="commit_on_task_delivery" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['commit_on_task_delivery'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['commit_on_task_delivery'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['commit_on_task_delivery'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['commit_on_task_delivery'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('commit_on_task_delivery')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="technical_knowledge" class="form-label">Technical Knowledge <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Technical Knowledge">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['technical_knowledge']) ? 'N/A' : $feedbackValues['technical_knowledge'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="technical_knowledge" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['technical_knowledge'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['technical_knowledge'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['technical_knowledge'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['technical_knowledge'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('technical_knowledge')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="logical_ablitiy" class="form-label">Logical Ability <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Logical Ability">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['logical_ability']) ? 'N/A' : $feedbackValues['logical_ability'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="logical_ablitiy" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['logical_ability'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['logical_ability'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['logical_ability'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['logical_ability'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('logical_ablitiy')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="attitude" class="form-label">Attitude <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Attitude">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['attitude']) ? 'N/A' : $feedbackValues['attitude'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="attitude" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['attitude'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['attitude'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['attitude'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['attitude'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('attitude')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="overall_performance" class="form-label">Overall performance during the tenure with CG-VAK Software <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Overall performance during the tenure with CG-VAK Software">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['overall_performance']) ? 'N/A' : $feedbackValues['overall_performance'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="overall_performance" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['overall_performance'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['overall_performance'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['overall_performance'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['overall_performance'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('overall_performance')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <br>
                                            @if((Auth::User()->department_id == 2) OR (Auth::User()->designation_id == 3))
                                                <div class="form-group">
                                                    <label class="form-label">Lead Comments</label>
                                                    <textarea class="form-control" readonly>{{ (isset($feedbackValues['lead_comment'])) ? $feedbackValues['lead_comment'] : 'N/A'  }}</textarea>
                                                </div>
                                            @endif
                                            @if(Auth::User()->department_id == 2)
                                                <div class="form-group">
                                                    <label class="form-label">Head Comments</label>
                                                    <textarea class="form-control" readonly>{{ (isset($feedbackValues['head_comment'])) ? $feedbackValues['head_comment'] : 'N/A'  }}</textarea>
                                                </div>
                                            @endif
                                            @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                <div class="form-group">
                                                    <label for="feedback_comments" class="form-label">Comments <span class="text-danger">*</span></label>
                                                        @if(Auth::User()->designation_id == 2)
                                                            <input type="hidden" name="attribute[]" value="Lead Comment">
                                                            <textarea name="value[]" id="feedback_comments" cols="30" rows="10" class="form-control" required>{{ (isset($feedbackValues['lead_comment'])) ? $feedbackValues['lead_comment'] : '' }}</textarea>
                                                        @endif
                                                        @if(Auth::User()->designation_id == 3)
                                                            <input type="hidden" name="attribute[]" value="Head Comment">
                                                            <textarea name="value[]" id="feedback_comments" cols="30" rows="10" class="form-control" required>{{ (isset($feedbackValues['head_comment'])) ? $feedbackValues['head_comment'] : '' }}</textarea>
                                                        @endif

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
                                                </div>
                                            @endif
                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
                                        </div>
                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary" id="myBtn" >Submit</button>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.tab-pane -->
                <!-- /End of feedback Software-->
                <!-- Feedback form Accounts -->
                {{-- <div class="tab-pane" id="tab_3-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <form method="get" action="{{ route('addOrUpdateFeedback') }}">
                                    <div class="box box-secondary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Feedback</h3>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th><h3>Attributes</h3></th>
                                                    <th><h3>Ratings</h3></th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><label for="attendance" class="form-label">Attendance <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Attendance">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['attendance']) ? 'N/A' : $feedbackValues['attendance'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="attendance" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['attendance'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['attendance'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['attendance'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['attendance'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('attendance')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="learning&responsiveness" class="form-label">Learning & Responsiveness <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Learning & Responsiveness">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['learning_responsiveness']) ? 'N/A' : $feedbackValues['learning_responsiveness'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="learning&responsiveness" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['learning_responsiveness'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['learning_responsiveness'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['learning_responsiveness'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['learning_responsiveness'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('reponsiveness')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsibility" class="form-label">Reponsibility <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Reponsibility">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['reponsibility']) ? 'N/A' : $feedbackValues['reponsibility'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="reponsibility" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['reponsibility'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['reponsibility'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['reponsibility'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['reponsibility'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('reponsibility')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="commitment&integrity" class="form-label">Commitment & Integrity <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Commitment & Integrity">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['commitment_integrity']) ? 'N/A' : $feedbackValues['commitment_integrity'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="commitment&integrity" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['commitment_integrity'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['commitment_integrity'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['commitment_integrity'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['commitment_integrity'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('commit_on_task_delivery')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="sales_performance" class="form-label">Sales Performance <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Sales Performance">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['sales_performance']) ? 'N/A' : $feedbackValues['sales_performance'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="sales_performance" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['sales_performance'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['sales_performance'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['sales_performance'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['sales_performance'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('technical_knowledge')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="attitude" class="form-label">Attitude <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Attitude">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['attitude']) ? 'N/A' : $feedbackValues['attitude'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="attitude" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['attitude'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['attitude'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['attitude'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['attitude'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('attitude')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="overall_performance" class="form-label">Overall performance during the tenure with CG-VAK Software <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Overall performance during the tenure with CG-VAK Software">
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedbackValues['overall_performance']) ? 'N/A' : $feedbackValues['overall_performance'] }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                            <td>
                                                                <select name="value[]" id="overall_performance" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" {{ ($feedbackValues['overall_performance'] == 'Excellent') ? 'selected' : "" }}>Excellent</option>
                                                                    <option value="Good" {{ ($feedbackValues['overall_performance'] == 'Good') ? 'selected' : "" }}>Good</option>
                                                                    <option value="Satisfactory" {{ ($feedbackValues['overall_performance'] == 'Satisfactory') ? 'selected' : "" }}>Satisfactory</option>
                                                                    <option value="Poor" {{ ($feedbackValues['overall_performance'] == 'Poor') ? 'selected' : "" }}>Poor</option>
                                                                </select>
                                                                @error('overall_performance')
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <br>
                                            @if((Auth::User()->department_id == 2) OR (Auth::User()->designation_id == 3))
                                                <div class="form-group">
                                                    <label class="form-label">Lead Comments</label>
                                                    <textarea class="form-control" readonly>{{ (isset($feedbackValues['lead_comment'])) ? $feedbackValues['lead_comment'] : 'N/A'  }}</textarea>
                                                </div>
                                            @endif
                                            @if(Auth::User()->department_id == 2)
                                                <div class="form-group">
                                                    <label class="form-label">Head Comments</label>
                                                    <textarea class="form-control" readonly>{{ (isset($feedbackValues['head_comment'])) ? $feedbackValues['head_comment'] : 'N/A'  }}</textarea>
                                                </div>
                                            @endif
                                            @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                <div class="form-group">
                                                    <label for="feedback_comments" class="form-label">Comments <span class="text-danger">*</span></label>
                                                        @if(Auth::User()->designation_id == 2)
                                                            <input type="hidden" name="attribute[]" value="Lead Comment">
                                                            <textarea name="value[]" id="feedback_comments" cols="30" rows="10" class="form-control" required>{{ (isset($feedbackValues['lead_comment'])) ? $feedbackValues['lead_comment'] : '' }}</textarea>
                                                        @endif
                                                        @if(Auth::User()->designation_id == 3)
                                                            <input type="hidden" name="attribute[]" value="Head Comment">
                                                            <textarea name="value[]" id="feedback_comments" cols="30" rows="10" class="form-control" required>{{ (isset($feedbackValues['head_comment'])) ? $feedbackValues['head_comment'] : '' }}</textarea>
                                                        @endif

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
                                                </div>
                                            @endif
                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
                                        </div>
                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary" id="myBtn" >Submit</button>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div> --}}
                <!-- /.tab-pane -->
                <!-- /End of feedback Accounts-->
                @endif

                @if($displayNodue)
                <!-- No due forms -->
                <div class="tab-pane" id="tab_4-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">No Due</h3>
                                    </div>
                                    <form method="get" action="{{ route('addOrUpdateNodue') }}">
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th>Attributes</th>
                                                    <th>Comments</th>
                                                </thead>
                                                <tbody>
                                                <!-- No due forms for lead -->
                                                    @if(Auth::User()->designation_id == 2)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Knowledge Transfer" @if($nodueAttribute['knowledge_transfer_comment']) checked @endif required>Knowledge Transfer
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['knowledge_transfer_comment'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Mail ID closure" @if($nodueAttribute['mail_closure']) checked @endif required> Mail ID closure
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['mail_closure'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- No due forms for head -->
                                                    @if(Auth::User()->designation_id == 3)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="knowledge_transfer" value="completed" required> Knowledge Transfer
                                                                    </label>
                                                                    @error('knowledge_transfer')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="knowledge_transfer_comment" class="form-control" id="knowledge_transfer_comment" cols="30" rows="3" required></textarea>
                                                                    @error('knowledge_transfer_comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="mail_id_closure" value="completed" required> Mail ID closure
                                                                    </label>
                                                                    @error('mail_id_closure')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="mail_id_closure_comment" class="form-control" id="mail_id_closure_comment" cols="30" rows="3" required></textarea>
                                                                    @error('mail_id_closure_comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- No due forms for HR -->
                                                    @if(Auth::User()->department_id == 2)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="ID Card" {{ isset($nodueAttribute['id_card']) ? 'checked' : '' }} required> ID Card
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ isset($nodueAttribute['id_card']) ? $nodueAttribute['id_card'] : ''  }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="NDA" {{ isset($nodueAttribute['nda']) ? 'checked' : '' }} required> NDA
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control"cols="30" rows="3" required>{{ isset($nodueAttribute['nda']) ? $nodueAttribute['nda'] : '' }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Professional Tax" {{ isset($nodueAttribute['professional_tax']) ? 'checked' : '' }} required> Professional Tax
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ isset($nodueAttribute['professional_tax']) ? $nodueAttribute['professional_tax'] : '' }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- No due forms for SA -->
                                                    @if(Auth::User()->department_id == 7)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Official Email ID" @if($nodueAttribute['official_email_id']) checked @endif required> Official Email ID
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['official_email_id'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Skype Account" @if($nodueAttribute['skype_account']) checked @endif required> Skype Account
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['skype_account'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Gmail or Yahoo Testing Purpose" @if($nodueAttribute['gmail_yahoo']) checked @endif required> Gmail or Yahoo Testing Purpose
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['gmail_yahoo'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Testing Tools" @if($nodueAttribute['testing_tools']) checked @endif required> Testing Tools
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['testing_tools'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Linux or Mac Machine Password" @if($nodueAttribute['linux_mac_password']) checked @endif required> Linux or Mac Machine Password
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['linux_mac_password'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Specific Tools For Renewal Details" @if($nodueAttribute['renewal_tools']) checked @endif required> Specific Tools For Renewal Details
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['renewal_tools'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Handover Testing Device" @if($nodueAttribute['testing_device']) checked @endif required> Handover Testing Device
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['testing_device'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Headset" @if($nodueAttribute['headset']) checked @endif required> Headset
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['headset'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Machine Port Forwarding" @if($nodueAttribute['machine_port_forwarding']) checked @endif required> Machine Port Forwarding
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['machine_port_forwarding'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="SVN & VSS & TFS Login Details" @if($nodueAttribute['svn_vss_tfs']) checked @endif required> SVN & VSS & TFS Login Details
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['svn_vss_tfs'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="RDP, VPN Connection" @if($nodueAttribute['rdp_vpn']) checked @endif required> RDP, VPN Connection
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['rdp_vpn'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Laptop and Data Card" @if($nodueAttribute['laptop_datacard']) checked @endif required> Laptop and Data Card
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['laptop_datacard'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- No due forms for Accounts -->
                                                    @if(Auth::User()->designation_id == null)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Salary Advance Due" @if($nodueAttribute['salary_advance_due']) checked @endif required> Salary Advance Due
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['salary_advance_due'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Income Tax Due" @if($nodueAttribute['income_tax_due']) checked @endif required > Income Tax Due
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['income_tax_due'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Documents For IT" @if($nodueAttribute['documents_it']) checked @endif required> Documents For IT
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['documents_it'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- No due forms for Admin -->
                                                    @if(Auth::User()->designation_id == null)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Laptop" @if($nodueAttribute['laptop']) checked @endif required> Laptop
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['laptop'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Data Card" @if($nodueAttribute['data_card']) checked @endif required> Data Card
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['data_card'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Official Property If Any" @if($nodueAttribute['official_property']) checked @endif required> Official Property If Any
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['official_property'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- No due forms for Quality -->
                                                    @if(Auth::User()->designation_id == null)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Exit Process Completion From Core Departments" @if($nodueAttribute['exit_process_completion']) checked @endif required> Exit Process Completion From Core Departments
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['exit_process_completion'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="ISMS/QMS Incidents & Tickets Closure Status" @if($nodueAttribute['isms_qms']) checked @endif required> ISMS/QMS Incidents & Tickets Closure Status
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['isms_qms'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Disable All Access Control" @if($nodueAttribute['disable_access']) checked @endif required> Disable All Access Control
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['disable_access'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- No due forms for Technical Team -->
                                                    @if(Auth::User()->designation_id == null)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="KT completed for all the current and old projects" @if($nodueAttribute['kt_completion']) checked @endif required> KT completed for all the current and old projects
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['kt_completion'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Relieving date informed and accepted by client" @if($nodueAttribute['relieving_date_informed']) checked @endif required> Relieving date informed and accepted by client
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['relieving_date_informed'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)" @if($nodueAttribute['internal_client_souce_code']) checked @endif required> All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['internal_client_souce_code'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)" @if($nodueAttribute['project_detail_document']) checked @endif required> Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['project_detail_document'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <!-- No due forms for Marketing Team -->
                                                    @if(Auth::User()->designation_id == null)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Handing over CLIENT details (Excel)" @if($nodueAttribute['client_details_handle']) checked @endif required> Handing over CLIENT details (Excel)
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['client_details_handle'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="KT on HOT & WARM prospects" @if($nodueAttribute['kt_hot_warm']) checked @endif required> KT on HOT & WARM prospects
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['kt_hot_warm'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Introducing new account manager to CLIENTS via Email" @if($nodueAttribute['intro_new_acc_manager']) checked @endif required> Introducing new account manager to CLIENTS via Email
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['intro_new_acc_manager'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Completion of Data Categorization" @if($nodueAttribute['data_categorization']) checked @endif required> Completion of Data Categorization
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['data_categorization'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="RFP System updation" @if($nodueAttribute['rfp_system']) checked @endif required> RFP System updation
                                                                    </label>
                                                                    @error('attribute')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required>{{ $nodueAttribute['rfp_system'] }}</textarea>
                                                                    @error('comment')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="box-footer">

                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
                                            <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(Auth::User()->department_id == 2)
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
                                                <th>HR</th>
                                                <th>Accounts</th>
                                                <th>Admin</th>

                                                <th>Qulaity</th>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['id_card'])) class="{{ ($nodueAttribute['id_card'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >ID Card</td>
                                                    <td @if(isset($nodueAttribute['salary_advance_due'])) class="{{ ($nodueAttribute['salary_advance_due'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Salary Advance Due</td>
                                                    <td @if(isset($nodueAttribute['laptop'])) class="{{ ($nodueAttribute['laptop'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Laptop</td>
                                                    <td @if(isset($nodueAttribute['exit_process_completion'])) class="{{ ($nodueAttribute['exit_process_completion'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Exit Process Completion from Core Departments</td>

                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['nda'])) class="{{ ($nodueAttribute['nda'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >NDA</td>
                                                    <td @if(isset($nodueAttribute['income_tax_due'])) class="{{ ($nodueAttribute['income_tax_due'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Income Tax Due</td>
                                                    <td @if(isset($nodueAttribute['data_card'])) class="{{ ($nodueAttribute['data_card'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Data Card</td>
                                                    <td @if(isset($nodueAttribute['isms_qms'])) class="{{ ($nodueAttribute['isms_qms'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >ISMS/QMS Incidents & Tickets Closure Status</td>

                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['professional_tax'])) class="{{ ($nodueAttribute['professional_tax'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Professional Tax</td>
                                                    <td @if(isset($nodueAttribute['documents_it'])) class="{{ ($nodueAttribute['documents_it'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Documents for IT</td>
                                                    <td @if(isset($nodueAttribute['official_property'])) class="{{ ($nodueAttribute['official_property'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Official Property If Any</td>
                                                    <td @if(isset($nodueAttribute['disable_access'])) class="{{ ($nodueAttribute['disable_access'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Disable all Access Control</td>

                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>SA</th>
                                                <th>Technical Team</th>
                                                <th>Marketing Team</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['official_email_id'])) class="{{ ($nodueAttribute['official_email_id'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Official Email Account</td>
                                                    <td @if(isset($nodueAttribute['kt_completion'])) class="{{ ($nodueAttribute['kt_completion'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >KT completed for all the current and old projects</td>
                                                    <td @if(isset($nodueAttribute['client_details_handle'])) class="{{ ($nodueAttribute['client_details_handle'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Handing over CLIENT details (Excel)</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['skype_account'])) class="{{ ($nodueAttribute['skype_account'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Skype Account</td>
                                                    <td @if(isset($nodueAttribute['relieving_date_informed'])) class="{{ ($nodueAttribute['relieving_date_informed'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Relieving date informed and accepted by client</td>
                                                    <td @if(isset($nodueAttribute['kt_hot_warm'])) class="{{ ($nodueAttribute['kt_hot_warm'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >KT on HOT & WARM prospects</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['gmail_yahoo'])) class="{{ ($nodueAttribute['gmail_yahoo'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Gmail or Yahoo Testing Purpose</td>
                                                    <td @if(isset($nodueAttribute['internal_client_souce_code'])) class="{{ ($nodueAttribute['internal_client_souce_code'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)</td>
                                                    <td @if(isset($nodueAttribute['intro_new_acc_manager'])) class="{{ ($nodueAttribute['intro_new_acc_manager'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Introducing new account manager to CLIENTS via Email</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['testing_tools'])) class="{{ ($nodueAttribute['testing_tools'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Testing Tools</td>
                                                    <td @if(isset($nodueAttribute['project_detail_document'])) class="{{ ($nodueAttribute['project_detail_document'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)</td>
                                                    <td @if(isset($nodueAttribute['data_categorization'])) class="{{ ($nodueAttribute['data_categorization'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Completion of Data Categorization</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['linux_mac_password'])) class="{{ ($nodueAttribute['linux_mac_password'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Linux or Mac machine Password</td>
                                                    <td></td>
                                                    <td @if(isset($nodueAttribute['rfp_system'])) class="{{ ($nodueAttribute['rfp_system'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >RFP System updation</td>

                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['renewal_tools'])) class="{{ ($nodueAttribute['renewal_tools'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Specific tools for renewal details</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['testing_device'])) class="{{ ($nodueAttribute['testing_device'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Handover Testing Device</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['headset'])) class="{{ ($nodueAttribute['headset'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Headset</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['machine_port_forwarding'])) class="{{ ($nodueAttribute['machine_port_forwarding'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Machine Port Forwarding</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['svn_vss_tfs'])) class="{{ ($nodueAttribute['svn_vss_tfs'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >SVN & VSS & TFS Login Details</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['rdp_vpn'])) class="{{ ($nodueAttribute['rdp_vpn'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >RDP, VPN Connection</td>
                                                </tr>
                                                <tr>
                                                    <td @if(isset($nodueAttribute['laptop_datacard'])) class="{{ ($nodueAttribute['laptop_datacard'] == NULL) ? 'bg-warning' : 'bg-success' }}" @else class="bg-warning" @endif >Laptop and Data card</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.tab-pane -->
                @endif

                @if(Auth::User()->department_id == 2 && $showAnswers != NULL)
                <!-- Exit interview answers -->
                <div class="tab-pane" id="tab_5-2">
                    @if(Auth::User()->department_id == 2)
                    <!--Exit interview answers -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Exit Interview Answers</h3>
                                    </div>
                                    <div class="box-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th width="5%"> Q\N</th>
                                                <th width="65%">Exit Interview Question</th>
                                                <th>Exit Interview Answers</th>

                                            </thead>
                                            <tbody>
                                                @foreach($answers as $answer)
                                                <tr>
                                                    <td >{{$answer->question_number}}</td>
                                                    <td >{{$answer->questions}}</td>
                                                    <td >{{$answer->answers}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">HR EXIT INTERVIEW</h3>
                                    </div>
                                    <form method="get" action="{{ route('addOrUpdateHrInterview') }}">
                                            @csrf
                                            {{ method_field('PUT') }}
                                        <div class="box-body">
                                            <div class="input_fields_wrap">
                                                <button type="button" class="add_field_button btn btn-success" style="float: right;">Add More Fields</button>

                                                <table class="table table-striped" style="clear: both;">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Comment</th>
                                                        <th scope="col">Action Area</th>
                                                        <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table_body_wrap">
                                                    @foreach($hrExitInterviewComments as $hrExitInterviewComment)
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="hr_exitinterview_comment[]" class="form-control" value="{{ $hrExitInterviewComment->comments }}" required>
                                                            </td>
                                                            <td>
                                                                <select name="hr_exitinterview_actionarea[]" class="form-control" required>
                                                                    <option value="{{ $hrExitInterviewComment->action_area }}">{{ $hrExitInterviewComment->action_area }}</option>
                                                                    <option value="Salary">Salary</option>
                                                                    <option value="Leave and Holiday">Leave and Holiday</option>
                                                                    <option value="Benifits">Benifits</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="remove_field btn btn-danger" disabled title="Already recorded">Remove</button>
                                                            <td>
                                                        </tr>
                                                    @endforeach
                                                        <tr>
                                                        <td>
                                                            <input type="text" name="hr_exitinterview_comment[]" class="form-control" required>
                                                        </td>
                                                        <td>
                                                            <select name="hr_exitinterview_actionarea[]" class="form-control" required>
                                                                <option value="">Select</option>
                                                                <option value="Salary">Salary</option>
                                                                <option value="Leave and Holiday">Leave and Holiday</option>
                                                                <option value="Benifits">Benifits</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="remove_field btn btn-danger">Remove</button>
                                                        <td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label class="control-label" for="date_of_entry">Date: <span style="color: #757575;">{{ Date('d-m-Y') }}</span> </label>
                                                    <input type="hidden" name="date_of_entry" value="{{ Date('d-m-Y') }}">
                                                </div>

                                                <div class="col-sm-4">
                                                    <label class="control-label pull-right" for="updated_by">Updated By:
                                                    <select name="commented_by" id="commented_by" style="color: #757575;">
                                                        <option value="{{ Auth::User()->display_name }}">{{ Auth::User()->display_name }}</option>
                                                        @foreach($hr_list as $hr)
                                                        <option value="{{ $hr->display_name }}">{{ $hr->display_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
                                            <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.tab-pane -->
                @endif

                @if(\Auth::User()->department_id == 2 && $showAnswers != NULL)
                <!-- Final Exit check list -->
                <div class="tab-pane" id="tab_6-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox" >
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Final Exit Checklist</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form method="post"  action="{{ (!$finalCheckList) ? route('storeFinalCheckList') : route('updateFinalCheckList') }} " enctype="multipart/form-data">
                                        @csrf <div class="box-body">
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="type_of_exit">Type Of Exit</label>
                                                <div class="col-sm-4">
                                                    <select name="type_of_exit" id="type_of_exit"  class="form-control" required>
                                                        <option value="{{ (!$finalCheckList) ? '' : $finalCheckList->type_of_exit }}">{{ (!$finalCheckList) ? 'Select' : $finalCheckList->type_of_exit }}</option>
                                                        <option value="Voluntary">Voluntary</option>
                                                        <option value="Involuntary">Involuntary</option>
                                                    </select>
                                                    @error('type_of_exit')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="date_of_leaving">Date Of Leaving</label>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" id="date_of_leaving" name="date_of_leaving" value="{{ ($emp_resignation->changed_dol == NULL) ? $emp_resignation->date_of_leaving : $emp_resignation->changed_dol }}" readonly>
                                                @error('date_of_leaving')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="reason_for_leaving">Reason For Leaving</label>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" value="{{ ($emp_resignation->other_reason == NULL) ? $emp_resignation->reason : $emp_resignation->other_reason }}" readonly>
                                                @error('reason_for_leaving')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="last_drawn_salary">Last Drawn Salary</label>
                                                <div class="col-sm-4">
                                                <input type="number" class="form-control" id="last_drawn_salary" name="last_drawn_salary" value="{{ (!$finalCheckList) ? '' : $finalCheckList->last_drawn_salary }}" required>
                                                @error('last_drawn_salary')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="consider_for_rehire">Can Be Considered For Rehire</label>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" id="consider_for_rehire" name="consider_for_rehire" value="{{ (!$finalCheckList) ? '' : $finalCheckList->consider_for_rehire }}" required>
                                                @error('consider_for_rehire')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="overall_feedback">Overall Feedback</label>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" id="overall_feedback" name="overall_feedback" value="{{ (!$finalCheckList) ? '' : $finalCheckList->overall_feedback }}" required>
                                                @error('overall_feedback')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="relieving_letter">Relieving Letter</label>
                                                <div class="col-sm-4">
                                                    <select name="relieving_letter" id="relieving_letter"  class="form-control" required>
                                                        <option value="{{ (!$finalCheckList) ? '' : $finalCheckList->relieving_letter }}">{{ (!$finalCheckList) ? 'Select' : $finalCheckList->relieving_letter }}</option>
                                                        <option value="Given">Given</option>
                                                        <option value="Pending">Pending</option>
                                                    </select>
                                                    @error('relieving_letter')
                                                        <br>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="experience_letter">Experience Letter</label>
                                                <div class="col-sm-4">
                                                    <select name="experience_letter" id="experience_letter"  class="form-control" required>
                                                        <option value="{{ (!$finalCheckList) ? '' : $finalCheckList->experience_letter }}">{{ (!$finalCheckList) ? 'Select' : $finalCheckList->experience_letter }}</option>
                                                        <option value="Given">Given</option>
                                                        <option value="Pending">Pending</option>
                                                    </select>
                                                    @error('experience_letter')
                                                        <br>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="salary_certificate">Salary Certificate</label>
                                                <div class="col-sm-4">
                                                    <select name="salary_certificate" id="salary_certificate"  class="form-control" required>
                                                        <option value="{{ (!$finalCheckList) ? '' : $finalCheckList->salary_certificate }}">{{ (!$finalCheckList) ? 'Select' : $finalCheckList->salary_certificate }}</option>
                                                        <option value="Given">Given</option>
                                                        <option value="Pending">Pending</option>
                                                    </select>
                                                    @error('salary_certificate')
                                                        <br>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="final_comment">Final Comment</label>
                                                <div class="col-sm-4">
                                                <textarea name="final_comment" id="final_comment" class="form-control" cols="30" rows="10" required>{{ (!$finalCheckList) ? '' : $finalCheckList->final_comment }}</textarea>
                                                @error('final_comment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="documents">Relieving Letter</label>
                                                <div class="col-sm-4">
                                                <input type="file" name="RelievingLetter" id="RelievingLetter" class="form-control">
                                                </div>
                                                @if($finalCheckList)
                                                @if($finalCheckList->relieving_document)
                                                <div class="col-sm-4">
                                                   <a href="{{ route('downloadDocs', ['filename' => $finalCheckList->relieving_document] )}}" class="btn btn-success"> <i class="fa fa-download" aria-hidden="true"></i></a> {{ $finalCheckList->relieving_document }}
                                                </div>
                                                @endif
                                                @endif
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="documents">Experience Letter</label>
                                                <div class="col-sm-4">
                                                <input type="file" name="ExperienceLetter" id="ExperienceLetter" class="form-control">
                                                </div>
                                                @if($finalCheckList)
                                                @if($finalCheckList->experience_document)
                                                <div class="col-sm-4">
                                                   <a href="{{ route('downloadDocs', ['filename' => $finalCheckList->experience_document] )}}" class="btn btn-success"> <i class="fa fa-download" aria-hidden="true"></i></a> {{ $finalCheckList->experience_document }}
                                                </div>
                                                @endif
                                                @endif
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="documents">Salary Certificate</label>
                                                <div class="col-sm-4">
                                                <input type="file" name="SalaryCertificate" id="SalaryCertificate" class="form-control">
                                                </div>
                                                @if($finalCheckList)
                                                @if($finalCheckList->salary_document)
                                                <div class="col-sm-4">
                                                   <a href="{{ route('downloadDocs', ['filename' => $finalCheckList->salary_document] )}}" class="btn btn-success"> <i class="fa fa-download" aria-hidden="true"></i></a> {{ $finalCheckList->salary_document }}
                                                </div>
                                                @endif
                                                @endif
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label class="control-label" for="date_of_entry"> Date: <span style="color: #757575;">{{ Date('d-m-Y') }}</span> </label>
                                                    <input type="hidden" name="date_of_entry" value="{{ Date('Y-d-m') }}">
                                                </div>
                                                <div class="col-sm-4">
                                                <label class="control-label pull-right" for="updated_by">Updated By:
                                                <select name="updated_by" id="updated_by" style="color: #757575;">
                                                <option value="{{ Auth::User()->display_name }}">{{ Auth::User()->display_name }}</option>
                                                @foreach($hr_list as $hr)
                                                <option value="{{ $hr->display_name }}">{{ $hr->display_name }}</option>
                                                @endforeach
                                                </select>
                                                </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}">
                                            <input type="hidden" id="finalChecklistId" name="finalChecklistId" value="{{ (!$finalCheckList) ? '' : $finalCheckList->id }}">
                                            <button type="submit" class="btn btn-primary" id="myBtn">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <!-- /End of Final Exit check list -->
                @endif
            </div>
            <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
</div>






@endsection
