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
                    <p><b>Date of joinig: </b>{{ $converted_dates['joining_date'] }}</p>
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
                    <input type="date" class="form-control disablePast" value="{{ $emp_resignation->changed_dol }}" id="dateOfLeaving" name="dateOfLeaving">
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
                <li><a href="#tab_2-2" data-toggle="tab">Acceptance status</a></li>
                <li><a href="#tab_3-2" data-toggle="tab">No Due</a></li>
                @if(\Auth::User()->department_id != 7)
                <li><a href="#tab_4-2" data-toggle="tab">Feedback</a></li>
                @endif
                @if(Auth::User()->department_id == 2)
                <li><a href="#tab_5-2" data-toggle="tab">Exit Interview Answers</a></li>
                @endif
                @if(\Auth::User()->department_id == 2)
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
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Reason For Leaving the job</label>
                                            <div class="col-sm-6">
                                                <p>{{ $emp_resignation->reason }}</p>
                                            </div>
                                        </div>
                                        @if($emp_resignation->other_reason != NULL)
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Other Reasons </label>
                                            <div class="col-sm-6">
                                                <p>{{ $emp_resignation->other_reason }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Comments on leaving</label>
                                            <div class="col-sm-6">
                                                <p>{{ $emp_resignation->comment_on_resignation }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Date Of Resignation</label>
                                            <div class="col-sm-4">
                                                <p>{{ $converted_dates['date_of_resignation'] }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Date Of Leaving As Per Policy </label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                    <p>{{ $converted_dates['date_of_leaving'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($emp_resignation->date_of_withdraw == NULL)
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Date Of Leaving </label>
                                            <div class="col-sm-10">
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
                                    <form method="get" action="{{ route('addOrUpdateResignationComment') }}">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label for="leadComment" class="col-sm-2 form-label">Lead Comment </label>
                                                <div class="col-sm-6">
                                                @if(Auth::User()->designation_id == 2)
                                                <textarea class="form-control" name="leadComment" id="leadComment" cols="30" rows="10" required>{{ ($leadGeneralComment != NULL) ? $leadGeneralComment['comment'] : ''}}</textarea>
                                                @endif
                                                    @error('leadComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    @if(Auth::User()->designation_id != 2)
                                                    <p>{{ ($leadGeneralComment != NULL) ? $leadGeneralComment['comment'] : 'N/A' }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(Auth::User()->designation_id != 2)
                                            <div class="form-group row">
                                                <label for="headComment" class="col-sm-2 form-label">Head comment</label>
                                                <div class="col-sm-6">
                                                    @if(Auth::User()->designation_id == 3 )
                                                    <textarea name="headComment" class="form-control" id="headComment" cols="30" rows="10" required>{{ ($headGeneralComment != NULL) ? $headGeneralComment['comment'] : ''}}</textarea>
                                                    @endif
                                                    @error('headComment')
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    @if(Auth::User()->department_id == 2)
                                                    <p>{{ ($headGeneralComment != NULL) ? $headGeneralComment['comment'] : 'N/A' }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                            @if(Auth::User()->department_id == 2 )
                                            <div class="form-group row">
                                                <label for="hrComment" class="col-sm-2 form-label">HR comment</label>
                                                <div class="col-sm-6">
                                                    <textarea name="hrComment" class="form-control" id="hrComment" cols="30" rows="10" required>{{ ($hrGeneralComment != NULL) ? $hrGeneralComment['comment'] : '' }}</textarea>
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
                                        <input type="hidden" name="leadGeneralCommentId" value="{{ ($leadGeneralComment != NULL) ? $leadGeneralComment['id'] : NULL }} ">
                                        <input type="hidden" name="headGeneralCommentId" value="{{ ($headGeneralComment != NULL) ? $headGeneralComment['id'] : NULL }} ">
                                        <input type="hidden" name="hrGeneralCommentId" value="{{ ($hrGeneralComment != NULL) ? $hrGeneralComment['id'] : NULL }} ">
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
                                                    <td class="{{ ($leadGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($leadGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted' }}</td>
                                                    @if(\Auth::User()->department_id != 7)
                                                    <td>{{ $leadGeneralComment['comment'] }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $leadDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' ' }}</td>
                                                    <td>{{ $leadDolComment['comment'] }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Department Head / Unit Head</td>
                                                    <td class="{{ ($headGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($headGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted' }}</td>
                                                    @if(\Auth::User()->department_id != 7)
                                                    <td>{{ $headGeneralComment['comment'] }}</td>
                                                    <td>{{ ( $emp_resignation->changed_dol != NULL && $headDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' ' }}</td>
                                                    <td>{{ $headDolComment['comment'] }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>HR</td>
                                                    <td class="{{ ($hrGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success' }}">{{ ($hrGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted' }}</td>
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

                <!-- No due forms -->
                <div class="tab-pane" id="tab_3-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">No Due</h3>
                                    </div>
                                    <form method="get" action="{{ (!$nodue) ? route('storeNodue') : route('updateNodue') }}">
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
                                                                        <input type="checkbox" name="knowledge_transfer" value="completed" required @if($nodue) {{ ($nodue->knowledge_transfer_lead != NULL) ? 'checked' : '' }} @endif> Knowledge Transfer
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
                                                                    <textarea name="knowledge_transfer_comment" class="form-control" id="knowledge_transfer_comment" cols="30" rows="3" required>{{ (!$nodue) ? '' :  $nodue->knowledge_transfer_lead_comment  }}</textarea>
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
                                                                        <input type="checkbox" name="mail_id_closure" value="completed" required @if($nodue) {{ ($nodue->mail_id_closure_lead != NULL) ? 'checked' : '' }} @endif> Mail ID closure
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
                                                                    <textarea name="mail_id_closure_comment" class="form-control" id="mail_id_closure_comment" cols="30" rows="3" required>{{ (!$nodue) ? '' :  $nodue->mail_id_closure_lead_comment  }}</textarea>
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
                                                    <!-- No due forms for head -->
                                                    @if(Auth::User()->designation_id == 3)
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="knowledge_transfer" value="completed" required @if($nodue) {{ ($nodue->knowledge_transfer_head != NULL) ? 'checked' : '' }} @endif> Knowledge Transfer
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
                                                                    <textarea name="knowledge_transfer_comment" class="form-control" id="knowledge_transfer_comment" cols="30" rows="3" required>{{ (!$nodue) ? '' :  $nodue->knowledge_transfer_head_comment  }}</textarea>
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
                                                                        <input type="checkbox" name="mail_id_closure" value="completed" required @if($nodue) {{ ($nodue->mail_id_closure_head != NULL) ? 'checked' : '' }} @endif> Mail ID closure
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
                                                                    <textarea name="mail_id_closure_comment" class="form-control" id="mail_id_closure_comment" cols="30" rows="3" required>{{ (!$nodue) ? '' :  $nodue->mail_id_closure_head_comment  }}</textarea>
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
                                                                        <input type="checkbox" name="id_card" value="completed" required @if($nodue) {{ ($nodue->id_card != NULL) ? 'checked' : '' }} @endif> ID Card
                                                                    </label>
                                                                    @error('id_card')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="id_card_comment" class="form-control" id="id_card_comment" cols="30" rows="3" required>{{ (!$nodue) ? '' :  $nodue->id_card_comment  }}</textarea>
                                                                    @error('id_card_comment')
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
                                                                        <input type="checkbox" name="nda" value="completed" required @if($nodue) {{ ($nodue->nda != NULL) ? 'checked' : '' }} @endif> NDA
                                                                    </label>
                                                                    @error('nda')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="nda_comment" class="form-control" id="nda_comment" cols="30" rows="3" required>{{ (!$nodue) ? '' :  $nodue->nda_comment  }}</textarea>
                                                                    @error('nda_comment')
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
                                                                        <input type="checkbox" name="official_email_id" value="completed" required @if($nodue) {{ ($nodue->official_email_id != NULL) ? 'checked' : '' }} @endif> Official Email ID
                                                                    </label>
                                                                    @error('official_email_id')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="official_email_id_comment" class="form-control" id="official_email_id_comment" cols="30" rows="3" required>{{ (!$nodue) ? '' :  $nodue->official_email_id_comment  }}</textarea>
                                                                    @error('official_email_id_comment')
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
                                                                        <input type="checkbox" name="skype_account" value="completed" required @if($nodue) {{ ($nodue->skype_account != NULL) ? 'checked' : '' }} @endif> NDA
                                                                    </label>
                                                                    @error('skype_account')
                                                                    <br>
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="skype_account_comment" class="form-control" id="skype_account_comment" cols="30" rows="3" required>{{ (!$nodue) ? '' :  $nodue->skype_account_comment  }}</textarea>
                                                                    @error('skype_account_comment')
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
                                            <input type="hidden" id="nodueId" name="nodueId" value="{{ (!$nodue) ? '' : $nodue->id }}">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.tab-pane -->

                @if(\Auth::User()->department_id != 7)
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
                                                @if(Auth::User()->department_id == 2)
                                                    <td>{{ (!$feedback) ? 'N/A' : $feedback->skill_set_primary }}</td>
                                                @endif
                                                @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                    <td><input type="text" name="primary_skill" id="primary_skill" class="form-control" value="{{ (!$feedback) ? '' : $feedback->skill_set_primary }}" required>
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
                                                <td><label for="secondary_skill" class="form-label">Secondary</label</td>
                                                @if(Auth::User()->department_id == 2)
                                                    <td>{{ (!$feedback) ? 'N/A' : $feedback->skill_set_secondary }}</td>
                                                @endif
                                                @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                    <td><input type="text" name="secondary_skill" id="secondary_skill" class="form-control" value="{{ (!$feedback) ? '' : $feedback->skill_set_secondary }}" required>       
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
                                                <td><h3 class="text-center">Last worked project</h3></td>
                                                    <td>
                                                    <label for="last_worked_project" class="form-label">Project Name:</label</td>
                                                    </td>
                                                    @if(Auth::User()->department_id == 2)
                                                        <td>{{ (!$feedback) ? 'N/A' : $feedback->last_worked_project }}</td>
                                                    @endif
                                                    @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                        <td colspan="2">
                                                            <input type="text" name="last_worked_project" id="last_worked_project" class="form-control" value="{{ (!$feedback) ? '' : $feedback->last_worked_project }}" required>
                                                            @error('last_worked_project')
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </td>
                                                    @endif
                                                    
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
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedback) ? 'N/A' : $feedback->attendance_rating }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
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
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsiveness" class="form-label">Reponsiveness</label></td>
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedback) ? 'N/A' : $feedback->responsiveness_rating }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
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
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsibility" class="form-label">Reponsibility</label></td>
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedback) ? 'N/A' : $feedback->responsibility_rating }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
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
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="commit_on_task_delivery" class="form-label">Commit on Task Delivery</label></td>
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedback) ? 'N/A' : $feedback->commitment_on_task_delivery_rating }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
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
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="technical_knowledge" class="form-label">Technical Knowledge</label></td>
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedback) ? 'N/A' : $feedback->technical_knowledge_rating }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
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
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="logical_ablitiy" class="form-label">Logical Ability</label></td>
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedback) ? 'N/A' : $feedback->logical_ability_rating }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
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
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="attitude" class="form-label">Attitude</label></td>
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedback) ? 'N/A' : $feedback->attitude_rating }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
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
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><label for="overall_performance" class="form-label">Overall performance during the tenure with CG-VAK Software</label></td>
                                                        @if(Auth::User()->department_id == 2)
                                                            <td>{{ (!$feedback) ? 'N/A' : $feedback->overall_rating }}</td>
                                                        @endif
                                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
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
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            </br>
                                            @if((Auth::User()->department_id == 2) OR (Auth::User()->designation_id == 3))
                                                <div class="form-group">
                                                    <label class="form-label">Lead Comments</label>
                                                    <textarea class="form-control" readonly>{{ (!$feedback) ? 'N/A' :  $feedback->lead_comment  }}</textarea>
                                                </div>
                                            @endif
                                            @if(Auth::User()->department_id == 2)
                                                <div class="form-group">
                                                    <label class="form-label">Head Comments</label>
                                                    <textarea class="form-control" readonly>{{ (!$feedback) ? 'N/A' :  $feedback->head_comment  }}</textarea>
                                                </div>
                                            @endif
                                            @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                                <div class="form-group">
                                                    <label for="feedback_comments" class="form-label">Comments</label>
                                                    <textarea name="feedback_comments" id="feedback_comments" cols="30" rows="10" class="form-control" required>{{ (!$feedback) ? '' : ((Auth::user()->designation_id == 2) ? $feedback->lead_comment : $feedback->head_comment) }}</textarea>
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
                                            @endif
                                            <input type="hidden" id="resignationId" name="resignationId" value="{{ $emp_resignation->id }}"> 
                                            <input type="hidden" id="feedbackId" name="feedbackId" value="{{ (!$feedback) ? '' : $feedback->id }}"> 
                                        </div>
                                        @if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3))
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary" id="myBtn" @if(Auth::User()->designation_id == 2) {{ (!$feedback) ? '' : (($feedback->head_comment != NULL) ? 'disabled title= Head-Closed ' : '')}} @endif >{{ (!$feedback) ? 'Submit' : 'Update' }} </button>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- /.tab-pane -->
                <!-- /End of feedback -->
                @endif

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
                                    @if($answers == NULL)
                                        <h4 class="text-center"> Not yet answered</h4>
                                    @else
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
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /.tab-pane -->

                @if(\Auth::User()->department_id == 2)
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
                                                <input type="date" class="form-control" id="date_of_leaving" name="date_of_leaving" value="{{ ($emp_resignation->changed_dol == NULL) ? $emp_resignation->date_of_leaving : $emp_resignation->changed_dol }}" readonly>
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
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="documents">Experience Letter</label>
                                                <div class="col-sm-4">
                                                <input type="file" name="ExperienceLetter" id="ExperienceLetter" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="documents">Salary Certificate</label>
                                                <div class="col-sm-4">
                                                <input type="file" name="SalaryCertificate" id="SalaryCertificate" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="date_of_entry">Date: {{ Date('Y-m-d') }}</label>
                                                <input type="hidden" name="date_of_entry" value="{{ Date('Y-m-d') }}"> 
                                                <div class="col-sm-4">
                                                <label class="control-label pull-right" for="updated_by">Updated By: {{ Auth::User()->display_name }}</label>
                                                <input type="hidden" name="updated_by" value="{{ Auth::User()->display_name }}">
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
