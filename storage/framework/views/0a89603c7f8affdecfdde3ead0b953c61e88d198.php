

<?php $__env->startSection('content'); ?>


<?php if(session()->get('success')): ?>
<div class="alert alert-success">
<?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>

<!-- Employee details -->
<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Employee Details</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Employee Name: </b><?php echo e($emp_resignation->display_name); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Employee ID: </b><?php echo e($emp_resignation->employee_id); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date of joinig: </b><?php echo e($converted_dates['joining_date']); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Designation: </b><?php echo e($emp_resignation->designation); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Department: </b><?php echo e($emp_resignation->department_name); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Lead: </b><?php echo e($emp_resignation->lead); ?></p>
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
        <form method="get" action="<?php echo e(route('updateDol')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo e(method_field('PUT')); ?>

            <div class="form-group row">
                <label for="dateOfLeaving" class="col-sm-4 form-label">Change DOL: </label>
                <div class="col-sm-6">
                    <input type="date" class="form-control disablePast" value="<?php echo e($emp_resignation->changed_dol); ?>" id="dateOfLeaving" name="dateOfLeaving">
                    <?php $__errorArgs = ['dateOfLeaving'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <br>
                    <span class="invalid-feedback" role="alert">
                        <strong class="text-danger"><?php echo e($message); ?></strong>
                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>     
            </div>
            <div class="form-group row">
                <label for="commentDol" class="col-sm-4 form-label">Comment DOL: </label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required><?php echo e((Auth::User()->designation_id != 2) ? $emp_resignation->comment_dol_head : $emp_resignation->comment_dol_lead); ?></textarea>
                    <?php $__errorArgs = ['dateOfLeaving'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <br>
                    <span class="invalid-feedback" role="alert">
                        <strong class="text-danger"><?php echo e($message); ?></strong>
                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>     
            </div>
            <input type="hidden" id="resignationId" name="resignationId" value="<?php echo e($emp_resignation->id); ?>">
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
                <?php if($emp_resignation->date_of_withdraw != NULL ): ?>
                <li><a href="#tab_1-2" data-toggle="tab">Withdraw Details</a></li>
                <?php endif; ?>
                <?php if($emp_resignation->date_of_withdraw == NULL ): ?>
                <li><a href="#tab_2-2" data-toggle="tab">Acceptance status</a></li>
                <li><a href="#tab_3-2" data-toggle="tab">No Due</a></li>
                <li><a href="#tab_4-2" data-toggle="tab">Feedback</a></li>
                <?php endif; ?>
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
                                                <p><?php echo e($emp_resignation->reason); ?></p>
                                            </div>
                                        </div>
                                        <?php if($emp_resignation->other_reason != NULL): ?>
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Other Reasons </label>
                                            <div class="col-sm-6">
                                                <p><?php echo e($emp_resignation->other_reason); ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Comments on leaving</label>
                                            <div class="col-sm-6">
                                                <p><?php echo e($emp_resignation->comment_on_resignation); ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Date Of Resignation</label>
                                            <div class="col-sm-4">
                                                <p><?php echo e($converted_dates['date_of_resignation']); ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Date Of Leaving As Per Policy </label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                    <p><?php echo e($converted_dates['date_of_leaving']); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Date Of Leaving </label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                    <p><?php echo e($converted_dates['changed_dol']); ?></p>
                                                    </div>
                                                    <div class="col-sm-4">
                                                    <button type="button" class="btn modelBtn" data-toggle="modal" data-target="#exampleModalCenter"><i style='font-size:17px' class='fa fa-edit'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(Auth::user()->designation != 'SA'): ?>
                        <?php if($emp_resignation->date_of_withdraw == NULL): ?>
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
                                    <form method="get" action="<?php echo e(route('updateResignationComment')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo e(method_field('PUT')); ?>

                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label for="leadComment" class="col-sm-2 form-label">Lead Comment </label>
                                                <div class="col-sm-6">
                                                <?php if(Auth::User()->designation_id == 2): ?>
                                                <textarea class="form-control" name="leadComment" id="leadComment" cols="30" rows="10" required><?php echo e(($emp_resignation->comment_lead != NULL) ? $emp_resignation->comment_lead : ' '); ?></textarea>
                                                <?php endif; ?>
                                                    <?php $__errorArgs = ['leadComment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    <?php if(Auth::User()->designation_id != 2): ?>
                                                    <p><?php echo e(($emp_resignation->comment_lead == NULL)  ? 'N/A' : $emp_resignation->comment_lead); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if(Auth::User()->designation_id != 2): ?>
                                            <div class="form-group row">
                                                <label for="headComment" class="col-sm-2 form-label">Head comment</label>
                                                <div class="col-sm-6">
                                                    <?php if(Auth::User()->designation_id == 3 ): ?>
                                                    <textarea name="headComment" class="form-control" id="headComment" cols="30" rows="10" required><?php echo e(($emp_resignation->comment_head != NULL) ? $emp_resignation->comment_head : ' '); ?></textarea>
                                                    <?php endif; ?>
                                                    <?php $__errorArgs = ['headComment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    <?php if(Auth::User()->department_id == 2): ?>
                                                    <p><?php echo e($emp_resignation->comment_head); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(Auth::User()->department_id == 2 ): ?>
                                            <div class="form-group row">
                                                <label for="hrComment" class="col-sm-2 form-label">HR comment</label>
                                                <div class="col-sm-6">
                                                    <textarea name="hrComment" class="form-control" id="hrComment" cols="30" rows="10" required><?php echo e(($emp_resignation->comment_hr != NULL) ? $emp_resignation->comment_hr : ' '); ?></textarea>
                                                    <?php $__errorArgs = ['hrComment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <input type="hidden" id="resignationId" name="resignationId" value="<?php echo e($emp_resignation->id); ?>">
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                        <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <?php if($emp_resignation->date_of_withdraw != NULL ): ?>
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
                                                <p><?php echo e($emp_resignation->date_of_withdraw); ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="comment" class="col-sm-2 form-label">Comment </label>
                                            <div class="col-sm-4">
                                                <p><?php echo e($emp_resignation->comment); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(Auth::user()->designation != 'SA'): ?>
                        <!-- comments on withdraw details -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Comments on Withdraw</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form method="get" action="<?php echo e(route('updateDowComment')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo e(method_field('PUT')); ?>

                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label for="withdrawLeadComment" class="col-sm-2 form-label">Lead Comment on Withdraw </label>
                                                <div class="col-sm-6">
                                                    <?php if(Auth::User()->designation_id == 2 ): ?>
                                                    <textarea name="withdrawLeadComment" id="withdrawLeadComment" class="form-control" cols="30" rows="10" required><?php echo e(($emp_resignation->comment_dow_lead != NULL) ? $emp_resignation->comment_dow_lead : ' '); ?></textarea>
                                                    <?php endif; ?>

                                                    <?php $__errorArgs = ['withdrawLeadComment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                                    <?php if(Auth::User()->designation_id != 2): ?>
                                                    <p><?php echo e($emp_resignation->comment_dow_lead); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <?php if(Auth::User()->designation_id != 2): ?>
                                            <div class="form-group row">
                                                <label for="withdrawHeadComment" class="col-sm-2 form-label">Head comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    <?php if(Auth::User()->designation_id == 3): ?> 
                                                    <textarea name="withdrawHeadComment" id="withdrawHeadComment" cols="30" rows="10" class="form-control" required><?php echo e(($emp_resignation->comment_dow_head != NULL) ? $emp_resignation->comment_dow_head : ' '); ?></textarea>
                                                    <?php endif; ?>
                                                    <?php $__errorArgs = ['withdrawHeadComment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                                    <?php if(Auth::User()->department_id == 2): ?>
                                                    <p><?php echo e($emp_resignation->comment_dow_head); ?></p>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(Auth::User()->department_id == 2): ?> 
                                            <div class="form-group row">
                                                <label for="withdrawHrComment" class="col-sm-2 form-label">HR comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    <textarea name="withdrawHrComment" id="withdrawHrComment" cols="30" rows="10" class="form-control" required><?php echo e(($emp_resignation->comment_dow_hr != NULL) ? $emp_resignation->comment_dow_hr : ' '); ?></textarea>
                                                    <?php $__errorArgs = ['withdrawHrComment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <input type="hidden" id="resignationId" name="resignationId" value="<?php echo e($emp_resignation->id); ?>">
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                        <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                
                </div>
                <!-- /.tab-pane -->
                <?php endif; ?>

                <?php if($emp_resignation->date_of_withdraw == NULL ): ?>
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
                                                <?php if(Auth::user()->designation != 'SA'): ?>
                                                <th title="General Comment">Comment</th>
                                                <th>Date of leaving</th>
                                                <th title="Comment on date of leaving">Comment DOL</th>
                                                <?php endif; ?>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Lead</td>
                                                    <td class="<?php echo e(($emp_resignation->comment_lead == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($emp_resignation->comment_lead == NULL) ? 'Pending' : 'Accepted'); ?></td>
                                                    <?php if(Auth::user()->designation != 'SA'): ?>
                                                    <td><?php echo e($emp_resignation->comment_lead); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_lead != NULL ) ? $converted_dates['changed_dol'] : ' '); ?></td>
                                                    <td><?php echo e($emp_resignation->comment_dol_lead); ?></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>Department Head / Unit Head</td>
                                                    <td class="<?php echo e(($emp_resignation->comment_head == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($emp_resignation->comment_head == NULL) ? 'Pending' : 'Accepted'); ?></td>
                                                    <?php if(Auth::user()->designation != 'SA'): ?>
                                                    <td><?php echo e($emp_resignation->comment_head); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_head != NULL ) ? $converted_dates['changed_dol'] : ' '); ?></td>
                                                    <td><?php echo e($emp_resignation->comment_dol_head); ?></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>HR</td>
                                                    <td class="<?php echo e(($emp_resignation->comment_hr == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($emp_resignation->comment_hr == NULL) ? 'Pending' : 'Accepted'); ?></td>
                                                    <?php if(Auth::user()->designation != 'SA'): ?>
                                                    <td><?php echo e($emp_resignation->comment_hr); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_hr != NULL ) ? $converted_dates['changed_dol'] : ' '); ?></td>
                                                    <td><?php echo e($emp_resignation->comment_dol_hr); ?></td>
                                                    <?php endif; ?>
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
                <?php endif; ?>
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
                                <form method="get" action="<?php echo e((!$feedback) ? route('storeFeedback') : route('updateFeedback')); ?>">
                                    <div class="box box-secondary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Feedback</h3>
                                        </div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                <td rowspan="2"><h3 class="text-center">Present Skill Set</h3></td>
                                                <td><label for="primary_skill" class="form-label">Primary</label></td></td>
                                                <?php if(Auth::User()->department_id == 2): ?>
                                                    <td><?php echo e((!$feedback) ? 'N/A' : $feedback->skill_set_primary); ?></td>
                                                <?php endif; ?>
                                                <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                    <td><input type="text" name="primary_skill" id="primary_skill" class="form-control" value="<?php echo e((!$feedback) ? '' : $feedback->skill_set_primary); ?>" required>
                                                        <?php $__errorArgs = ['primary_skill'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <br>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </td>
                                                <?php endif; ?>
                                                </tr>
                                                <tr>
                                                <td><label for="secondary_skill" class="form-label">Secondary</label</td>
                                                <?php if(Auth::User()->department_id == 2): ?>
                                                    <td><?php echo e((!$feedback) ? 'N/A' : $feedback->skill_set_secondary); ?></td>
                                                <?php endif; ?>
                                                <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                    <td><input type="text" name="secondary_skill" id="secondary_skill" class="form-control" value="<?php echo e((!$feedback) ? '' : $feedback->skill_set_secondary); ?>" required>       
                                                        <?php $__errorArgs = ['secondary_skill'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <br>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </td>
                                                <?php endif; ?>
                                                </tr>

                                                <tr>
                                                <td><h3 class="text-center">Last worked project</h3></td>
                                                    <td>
                                                    <label for="last_worked_project" class="form-label">Project Name:</label</td>
                                                    </td>
                                                    <?php if(Auth::User()->department_id == 2): ?>
                                                        <td><?php echo e((!$feedback) ? 'N/A' : $feedback->last_worked_project); ?></td>
                                                    <?php endif; ?>
                                                    <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                        <td colspan="2">
                                                            <input type="text" name="last_worked_project" id="last_worked_project" class="form-control" value="<?php echo e((!$feedback) ? '' : $feedback->last_worked_project); ?>" required>
                                                            <?php $__errorArgs = ['last_worked_project'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <br>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                                            </span>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    
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
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedback) ? 'N/A' : $feedback->attendance_rating); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="attendance" id="attendance" class="form-control" required>
                                                                    <option value="<?php echo e((!$feedback) ? '' : $feedback->attendance_rating); ?>"><?php echo e((!$feedback) ? 'Select' : $feedback->attendance_rating); ?></option>
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Satisfactory">Satisfactory</option>
                                                                    <option value="Poor">Poor</option>
                                                                </select>
                                                                <?php $__errorArgs = ['attendance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsiveness" class="form-label">Reponsiveness</label></td>
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedback) ? 'N/A' : $feedback->responsiveness_rating); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="reponsiveness" id="reponsiveness" class="form-control" required>
                                                                    <option value="<?php echo e((!$feedback) ? '' : $feedback->responsiveness_rating); ?>"><?php echo e((!$feedback) ? 'Select' : $feedback->responsiveness_rating); ?></option>
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Satisfactory">Satisfactory</option>
                                                                    <option value="Poor">Poor</option>
                                                                </select>
                                                                <?php $__errorArgs = ['reponsiveness'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="reponsibility" class="form-label">Reponsibility</label></td>
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedback) ? 'N/A' : $feedback->responsibility_rating); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="reponsibility" id="reponsibility" class="form-control" required>
                                                                    <option value="<?php echo e((!$feedback) ? '' : $feedback->responsibility_rating); ?>"><?php echo e((!$feedback) ? 'Select' : $feedback->responsibility_rating); ?></option>
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Satisfactory">Satisfactory</option>
                                                                    <option value="Poor">Poor</option>
                                                                </select>
                                                                <?php $__errorArgs = ['reponsibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="commit_on_task_delivery" class="form-label">Commit on Task Delivery</label></td>
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedback) ? 'N/A' : $feedback->commitment_on_task_delivery_rating); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="commit_on_task_delivery" id="commit_on_task_delivery" class="form-control" required>
                                                                    <option value="<?php echo e((!$feedback) ? '' : $feedback->commitment_on_task_delivery_rating); ?>"><?php echo e((!$feedback) ? 'Select' : $feedback->commitment_on_task_delivery_rating); ?></option>
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Satisfactory">Satisfactory</option>
                                                                    <option value="Poor">Poor</option>
                                                                </select>
                                                                <?php $__errorArgs = ['commit_on_task_delivery'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="technical_knowledge" class="form-label">Technical Knowledge</label></td>
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedback) ? 'N/A' : $feedback->technical_knowledge_rating); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="technical_knowledge" id="technical_knowledge" class="form-control" required>
                                                                    <option value="<?php echo e((!$feedback) ? '' : $feedback->technical_knowledge_rating); ?>"><?php echo e((!$feedback) ? 'Select' : $feedback->technical_knowledge_rating); ?></option>
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Satisfactory">Satisfactory</option>
                                                                    <option value="Poor">Poor</option>
                                                                </select>
                                                                <?php $__errorArgs = ['technical_knowledge'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="logical_ablitiy" class="form-label">Logical Ability</label></td>
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedback) ? 'N/A' : $feedback->logical_ability_rating); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="logical_ablitiy" id="logical_ablitiy" class="form-control" required>
                                                                    <option value="<?php echo e((!$feedback) ? '' : $feedback->logical_ability_rating); ?>"><?php echo e((!$feedback) ? 'Select' : $feedback->logical_ability_rating); ?></option>
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Satisfactory">Satisfactory</option>
                                                                    <option value="Poor">Poor</option>
                                                                </select>
                                                                <?php $__errorArgs = ['logical_ablitiy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="attitude" class="form-label">Attitude</label></td>
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedback) ? 'N/A' : $feedback->attitude_rating); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="attitude" id="attitude" class="form-control" required>
                                                                    <option value="<?php echo e((!$feedback) ? '' : $feedback->attitude_rating); ?>"><?php echo e((!$feedback) ? 'Select' : $feedback->attitude_rating); ?></option>
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Satisfactory">Satisfactory</option>
                                                                    <option value="Poor">Poor</option>
                                                                </select>
                                                                <?php $__errorArgs = ['attitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <tr>
                                                        <td><label for="overall_performance" class="form-label">Overall performance during the tenure with CG-VAK Software</label></td>
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedback) ? 'N/A' : $feedback->overall_rating); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="overall_performance" id="overall_performance" class="form-control" required>
                                                                    <option value="<?php echo e((!$feedback) ? '' : $feedback->overall_rating); ?>"><?php echo e((!$feedback) ? 'Select' : $feedback->overall_rating); ?></option>
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Satisfactory">Satisfactory</option>
                                                                    <option value="Poor">Poor</option>
                                                                </select>
                                                                <?php $__errorArgs = ['overall_performance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <br>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                            </br>
                                            <?php if((Auth::User()->department_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                <div class="form-group">
                                                    <label class="form-label">Lead Comments</label>
                                                    <textarea class="form-control" readonly><?php echo e((!$feedback) ? 'N/A' :  $feedback->lead_comment); ?></textarea>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(Auth::User()->department_id == 2): ?>
                                                <div class="form-group">
                                                    <label class="form-label">Head Comments</label>
                                                    <textarea class="form-control" readonly><?php echo e((!$feedback) ? 'N/A' :  $feedback->head_comment); ?></textarea>
                                                </div>
                                            <?php endif; ?>
                                            <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                <div class="form-group">
                                                    <label for="feedback_comments" class="form-label">Comments</label>
                                                    <textarea name="feedback_comments" id="feedback_comments" cols="30" rows="10" class="form-control" required><?php echo e((!$feedback) ? '' : ((Auth::user()->designation_id == 2) ? $feedback->lead_comment : $feedback->head_comment)); ?></textarea>
                                                    <?php $__errorArgs = ['feedback_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <br>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <div class="col-xs-12">
                                                        <label class="form-label">Thankyou for your valuable feedback</label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input type="date" name="date_of_feedback" value="<?php echo e(Date('Y-m-d')); ?>" id="date_of_feedback" class="form-control disablePast">
                                                    </div>
                                                    
                                                </div>
                                            <?php endif; ?>
                                            <input type="hidden" id="resignationId" name="resignationId" value="<?php echo e($emp_resignation->id); ?>"> 
                                            <input type="hidden" id="feedbackId" name="feedbackId" value="<?php echo e((!$feedback) ? '' : $feedback->id); ?>"> 
                                        </div>
                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary" id="myBtn" <?php if(Auth::User()->designation_id == 2): ?> <?php echo e((!$feedback) ? '' : (($feedback->head_comment != NULL) ? 'disabled title= Head-Closed ' : '')); ?> <?php endif; ?> ><?php echo e((!$feedback) ? 'Submit' : 'Update'); ?> </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- /.tab-pane -->
                <!-- /End of feedback -->

            </div>
            <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\employee-offboarding\resources\views/process/viewResignation.blade.php ENDPATH**/ ?>