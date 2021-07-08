<?php $__env->startSection('content'); ?>

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
                    <p><b>Date Of Joining: </b><?php echo e($converted_dates['joining_date']); ?></p>
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
        <form method="get" action="<?php echo e(route('addOrUpdateDolComments')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo e(method_field('PUT')); ?>

            <div class="form-group row">
                <label for="dateOfLeaving" class="col-sm-4 form-label">Change DOL: </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control jquery-datepicker" value="<?php echo e($emp_resignation->changed_dol); ?>" id="dateOfLeaving" name="dateOfLeaving">
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
                    <?php if(\Auth::User()->designation_id == 2): ?><textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required><?php echo e(($leadDolComment != NULL) ? $leadDolComment['comment'] : ''); ?></textarea><?php endif; ?>
                    <?php if(\Auth::User()->designation_id == 3): ?><textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required><?php echo e(($headDolComment != NULL) ? $headDolComment['comment'] : ''); ?></textarea><?php endif; ?>
                    <?php if(\Auth::User()->department_id == 2): ?><textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required><?php echo e(($hrDolComment != NULL) ? $hrDolComment['comment'] : ''); ?></textarea><?php endif; ?>
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
            <input type="hidden" name="leadDolCommentId" value="<?php echo e(($leadDolComment != NULL) ? $leadDolComment['id'] : NULL); ?> ">
            <input type="hidden" name="headDolCommentId" value="<?php echo e(($headDolComment != NULL) ? $headDolComment['id'] : NULL); ?> ">
            <input type="hidden" name="hrDolCommentId" value="<?php echo e(($hrDolComment != NULL) ? $hrDolComment['id'] : NULL); ?> ">
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
                <li><a href="#tab_2-2" data-toggle="tab">Acceptance Status</a></li>
                <?php if(\Auth::User()->department_id != 7 && $is_feedback_enable): ?>
                <li><a href="#tab_3-2" data-toggle="tab">Feedback</a></li>
                <?php endif; ?>
                <?php if($displayNodue): ?>
                <li><a href="#tab_4-2" data-toggle="tab">No Due</a></li>
                <?php endif; ?>
                <?php if(Auth::User()->department_id == 2 && $showAnswers != NULL): ?>
                <li><a href="#tab_5-2" data-toggle="tab">Exit Interview Answers</a></li>
                <?php endif; ?>
                <?php if(\Auth::User()->department_id == 2 && $showAnswers != NULL): ?>
                <li><a href="#tab_6-2" data-toggle="tab">Final Exit Checklist</a></li>
                <?php endif; ?>
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
                                    <?php if(\Auth::User()->department_id != 7): ?>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Reason For Leaving the job</label>
                                            <div class="col-sm-6">
                                                <p><?php echo e($emp_resignation->reason); ?></p>
                                            </div>
                                        </div>
                                        <?php if($emp_resignation->other_reason != NULL): ?>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Other Reasons </label>
                                            <div class="col-sm-6">
                                                <p><?php echo e($emp_resignation->other_reason); ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Comments on leaving</label>
                                            <div class="col-sm-6">
                                                <p><?php echo e($emp_resignation->comment_on_resignation); ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Date Of Resignation</label>
                                            <div class="col-sm-4">
                                                <p><?php echo e($converted_dates['date_of_resignation']); ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Date Of Leaving As Per Policy </label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                    <p><?php echo e($converted_dates['date_of_leaving']); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($emp_resignation->date_of_withdraw == NULL): ?>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-label">Date Of Leaving </label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                    <p><?php echo e($converted_dates['changed_dol']); ?></p>
                                                    </div>
                                                    <?php if(\Auth::User()->department_id != 7): ?>
                                                    <div class="col-sm-4">
                                                    <button type="button" class="btn modelBtn" data-toggle="modal" data-target="#exampleModalCenter"><i style='font-size:17px' class='fa fa-edit'></i></button>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(\Auth::User()->department_id != 7): ?>
                        <?php if($emp_resignation->date_of_withdraw == NULL): ?>
                        <?php if($is_reviewed): ?>
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
                                    <form method="get" action="<?php echo e(route('addOrUpdateResignationAcceptance')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo e(method_field('PUT')); ?>

                                        <div class="box-body">

                                            <div class="form-group row">
                                                <label for="accepatanceStatus" class="col-sm-2 form-label">Your Acceptance</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="accepatanceStatus" id="accepatanceStatus" required>
                                                        <option value="<?php echo e(($acceptanceValue == NULL) ? '' : $acceptanceValue); ?>"><?php echo e(($acceptanceValue == NULL) ? 'Select' : $acceptanceValue); ?></option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Accepted">Accepted</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select>
                                                    <?php $__errorArgs = ['accepatanceStatus'];
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
                                                <label for="acceptanceComment" class="col-sm-2 form-label">Your Comment </label>
                                                <div class="col-sm-6">
                                                <textarea class="form-control" name="acceptanceComment" id="acceptanceComment" cols="30" rows="10" required><?php echo e(($acceptanceComment != NULL) ? $acceptanceComment : ''); ?></textarea>
                                                    <?php $__errorArgs = ['acceptanceComment'];
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
                                                <p><?php echo e($emp_resignation->comment_on_withdraw); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(\Auth::User()->department_id != 7): ?>
                        <!-- comments on withdraw details -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary formBox">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Comments on Withdraw</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form method="get" action="<?php echo e(route('addOrUpdateDowComment')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo e(method_field('PUT')); ?>

                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label for="withdrawLeadComment" class="col-sm-2 form-label">Lead Comment on Withdraw </label>
                                                <div class="col-sm-6">
                                                    <?php if(Auth::User()->designation_id == 2 ): ?>
                                                    <textarea name="withdrawLeadComment" id="withdrawLeadComment" class="form-control" cols="30" rows="10" required><?php echo e(($leadDowComment != NULL) ? $leadDowComment['comment'] : ''); ?></textarea>
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
                                                    <p><?php echo e(($leadDowComment != NULL) ? $leadDowComment['comment'] : 'N/A'); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <?php if(Auth::User()->designation_id != 2): ?>
                                            <div class="form-group row">
                                                <label for="withdrawHeadComment" class="col-sm-2 form-label">Head comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    <?php if(Auth::User()->designation_id == 3): ?>
                                                    <textarea name="withdrawHeadComment" id="withdrawHeadComment" cols="30" rows="10" class="form-control" required><?php echo e(($headDowComment != NULL) ? $headDowComment['comment'] : ''); ?></textarea>
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
                                                    <p><?php echo e(($headDowComment != NULL) ? $headDowComment['comment'] : 'N/A'); ?></p>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(Auth::User()->department_id == 2): ?>
                                            <div class="form-group row">
                                                <label for="withdrawHrComment" class="col-sm-2 form-label">HR comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    <textarea name="withdrawHrComment" id="withdrawHrComment" cols="30" rows="10" class="form-control" required><?php echo e(($hrDowComment != NULL) ? $hrDowComment['comment'] : ''); ?></textarea>
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
                                            <input type="hidden" name="leadDowCommentId" value="<?php echo e(($leadDowComment != NULL) ? $leadDowComment['id'] : NULL); ?> ">
                                            <input type="hidden" name="headDowCommentId" value="<?php echo e(($headDowComment != NULL) ? $headDowComment['id'] : NULL); ?> ">
                                            <input type="hidden" name="hrDowCommentId" value="<?php echo e(($hrDowComment != NULL) ? $hrDowComment['id'] : NULL); ?> ">
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
                                                <?php if(\Auth::User()->department_id != 7): ?>
                                                <th title="General Comment">Comment</th>
                                                <th>Date of leaving</th>
                                                <th title="Comment on date of leaving">Comment DOL</th>
                                                <?php endif; ?>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Lead</td>
                                                    <td class="<?php echo e(($leadAcceptance == NULL || $leadAcceptance == 'Pending' ) ? 'bg-warning' :( $leadAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )); ?>"><?php echo e(($leadAcceptance == NULL ) ? 'Pending' : $leadAcceptance); ?></td>
                                                    <?php if(\Auth::User()->department_id != 7): ?>
                                                    <td><?php echo e($leadGeneralComment['comment']); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $leadDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' '); ?></td>
                                                    <td><?php echo e($leadDolComment['comment']); ?></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>Department Head / Unit Head</td>
                                                    <td class="<?php echo e(($headAcceptance == NULL || $headAcceptance == 'Pending' ) ? 'bg-warning' :( $headAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )); ?>"><?php echo e(($headAcceptance == NULL ) ? 'Pending' : $headAcceptance); ?></td>
                                                    <?php if(\Auth::User()->department_id != 7): ?>
                                                    <td><?php echo e($headGeneralComment['comment']); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $headDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' '); ?></td>
                                                    <td><?php echo e($headDolComment['comment']); ?></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>HR</td>
                                                    <td class="<?php echo e(($hrAcceptance == NULL || $hrAcceptance == 'Pending' ) ? 'bg-warning' :( $hrAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )); ?>"><?php echo e(($hrAcceptance == NULL ) ? 'Pending' : $hrAcceptance); ?></td>
                                                    <?php if(\Auth::User()->department_id != 7): ?>
                                                    <td><?php echo e($hrGeneralComment['comment']); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $hrDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' '); ?></td>
                                                    <td><?php echo e($hrDolComment['comment']); ?></td>
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

                <?php if(\Auth::User()->department_id != 7 && $is_feedback_enable): ?>
                <!-- Feedback form Software-->
                <div class="tab-pane" id="tab_3-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <form method="get" action="<?php echo e(route('addOrUpdateFeedback')); ?>">
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
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                        <td><?php echo e((!$feedbackValues['primary']) ? 'N/A' : $feedbackValues['primary']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                        <td><input type="text" name="value[]" id="primary_skill" class="form-control" value="<?php echo e($feedbackValues['primary']); ?>" required>
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
                                                        <td><label for="secondary_skill" class="form-label">Secondary <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Secondary">
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                        <td><?php echo e((!$feedbackValues['secondary']) ? 'N/A' : $feedbackValues['secondary']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                        <td><input type="text" name="value[]" id="secondary_skill" class="form-control" value="<?php echo e($feedbackValues['secondary']); ?>" required>
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
                                                        <td><h3>Last Worked Project</h3></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="last_worked_project" class="form-label">Project Name <span class="text-danger">*</span></label></td>
                                                            <input type="hidden" name="attribute[]" value="Project Name">
                                                        </td>
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                        <td><?php echo e((!$feedbackValues['project_name']) ? 'N/A' : $feedbackValues['project_name']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td colspan="2">
                                                                <input type="text" name="value[]" id="last_worked_project" class="form-control" value="<?php echo e($feedbackValues['project_name']); ?>" required>
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
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedbackValues['attendance']) ? 'N/A' : $feedbackValues['attendance']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="value[]" id="attendance" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" <?php echo e(($feedbackValues['attendance'] == 'Excellent') ? 'selected' : ""); ?>>Excellent</option>
                                                                    <option value="Good" <?php echo e(($feedbackValues['attendance'] == 'Good') ? 'selected' : ""); ?>>Good</option>
                                                                    <option value="Satisfactory" <?php echo e(($feedbackValues['attendance'] == 'Satisfactory') ? 'selected' : ""); ?>>Satisfactory</option>
                                                                    <option value="Poor" <?php echo e(($feedbackValues['attendance'] == 'Poor') ? 'selected' : ""); ?>>Poor</option>
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
                                                        <td><label for="reponsiveness" class="form-label">Reponsiveness <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Reponsiveness">
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedbackValues['reponsiveness']) ? 'N/A' : $feedbackValues['reponsiveness']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="value[]" id="reponsiveness" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" <?php echo e(($feedbackValues['reponsiveness'] == 'Excellent') ? 'selected' : ""); ?>>Excellent</option>
                                                                    <option value="Good" <?php echo e(($feedbackValues['reponsiveness'] == 'Good') ? 'selected' : ""); ?>>Good</option>
                                                                    <option value="Satisfactory" <?php echo e(($feedbackValues['reponsiveness'] == 'Satisfactory') ? 'selected' : ""); ?>>Satisfactory</option>
                                                                    <option value="Poor" <?php echo e(($feedbackValues['reponsiveness'] == 'Poor') ? 'selected' : ""); ?>>Poor</option>
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
                                                        <td><label for="reponsibility" class="form-label">Reponsibility <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Reponsibility">
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedbackValues['reponsibility']) ? 'N/A' : $feedbackValues['reponsibility']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="value[]" id="reponsibility" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" <?php echo e(($feedbackValues['reponsibility'] == 'Excellent') ? 'selected' : ""); ?>>Excellent</option>
                                                                    <option value="Good" <?php echo e(($feedbackValues['reponsibility'] == 'Good') ? 'selected' : ""); ?>>Good</option>
                                                                    <option value="Satisfactory" <?php echo e(($feedbackValues['reponsibility'] == 'Satisfactory') ? 'selected' : ""); ?>>Satisfactory</option>
                                                                    <option value="Poor" <?php echo e(($feedbackValues['reponsibility'] == 'Poor') ? 'selected' : ""); ?>>Poor</option>
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
                                                        <td><label for="commit_on_task_delivery" class="form-label">Commit on Task Delivery <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Commit on Task Delivery">
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedbackValues['commit_on_task_delivery']) ? 'N/A' : $feedbackValues['commit_on_task_delivery']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="value[]" id="commit_on_task_delivery" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" <?php echo e(($feedbackValues['commit_on_task_delivery'] == 'Excellent') ? 'selected' : ""); ?>>Excellent</option>
                                                                    <option value="Good" <?php echo e(($feedbackValues['commit_on_task_delivery'] == 'Good') ? 'selected' : ""); ?>>Good</option>
                                                                    <option value="Satisfactory" <?php echo e(($feedbackValues['commit_on_task_delivery'] == 'Satisfactory') ? 'selected' : ""); ?>>Satisfactory</option>
                                                                    <option value="Poor" <?php echo e(($feedbackValues['commit_on_task_delivery'] == 'Poor') ? 'selected' : ""); ?>>Poor</option>
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
                                                        <td><label for="technical_knowledge" class="form-label">Technical Knowledge <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Technical Knowledge">
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedbackValues['technical_knowledge']) ? 'N/A' : $feedbackValues['technical_knowledge']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="value[]" id="technical_knowledge" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" <?php echo e(($feedbackValues['technical_knowledge'] == 'Excellent') ? 'selected' : ""); ?>>Excellent</option>
                                                                    <option value="Good" <?php echo e(($feedbackValues['technical_knowledge'] == 'Good') ? 'selected' : ""); ?>>Good</option>
                                                                    <option value="Satisfactory" <?php echo e(($feedbackValues['technical_knowledge'] == 'Satisfactory') ? 'selected' : ""); ?>>Satisfactory</option>
                                                                    <option value="Poor" <?php echo e(($feedbackValues['technical_knowledge'] == 'Poor') ? 'selected' : ""); ?>>Poor</option>
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
                                                        <td><label for="logical_ablitiy" class="form-label">Logical Ability <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Logical Ability">
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedbackValues['logical_ability']) ? 'N/A' : $feedbackValues['logical_ability']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="value[]" id="logical_ablitiy" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" <?php echo e(($feedbackValues['logical_ability'] == 'Excellent') ? 'selected' : ""); ?>>Excellent</option>
                                                                    <option value="Good" <?php echo e(($feedbackValues['logical_ability'] == 'Good') ? 'selected' : ""); ?>>Good</option>
                                                                    <option value="Satisfactory" <?php echo e(($feedbackValues['logical_ability'] == 'Satisfactory') ? 'selected' : ""); ?>>Satisfactory</option>
                                                                    <option value="Poor" <?php echo e(($feedbackValues['logical_ability'] == 'Poor') ? 'selected' : ""); ?>>Poor</option>
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
                                                        <td><label for="attitude" class="form-label">Attitude <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Attitude">
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedbackValues['attitude']) ? 'N/A' : $feedbackValues['attitude']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="value[]" id="attitude" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" <?php echo e(($feedbackValues['attitude'] == 'Excellent') ? 'selected' : ""); ?>>Excellent</option>
                                                                    <option value="Good" <?php echo e(($feedbackValues['attitude'] == 'Good') ? 'selected' : ""); ?>>Good</option>
                                                                    <option value="Satisfactory" <?php echo e(($feedbackValues['attitude'] == 'Satisfactory') ? 'selected' : ""); ?>>Satisfactory</option>
                                                                    <option value="Poor" <?php echo e(($feedbackValues['attitude'] == 'Poor') ? 'selected' : ""); ?>>Poor</option>
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
                                                        <td><label for="overall_performance" class="form-label">Overall performance during the tenure with CG-VAK Software <span class="text-danger">*</span></label></td>
                                                        <input type="hidden" name="attribute[]" value="Overall performance during the tenure with CG-VAK Software">
                                                        <?php if(Auth::User()->department_id == 2): ?>
                                                            <td><?php echo e((!$feedbackValues['overall_performance']) ? 'N/A' : $feedbackValues['overall_performance']); ?></td>
                                                        <?php endif; ?>
                                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                            <td>
                                                                <select name="value[]" id="overall_performance" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Excellent" <?php echo e(($feedbackValues['overall_performance'] == 'Excellent') ? 'selected' : ""); ?>>Excellent</option>
                                                                    <option value="Good" <?php echo e(($feedbackValues['overall_performance'] == 'Good') ? 'selected' : ""); ?>>Good</option>
                                                                    <option value="Satisfactory" <?php echo e(($feedbackValues['overall_performance'] == 'Satisfactory') ? 'selected' : ""); ?>>Satisfactory</option>
                                                                    <option value="Poor" <?php echo e(($feedbackValues['overall_performance'] == 'Poor') ? 'selected' : ""); ?>>Poor</option>
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

                                            <br>
                                            <?php if((Auth::User()->department_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                <div class="form-group">
                                                    <label class="form-label">Lead Comments</label>
                                                    <textarea class="form-control" readonly><?php echo e((isset($feedbackValues['lead_comment'])) ? $feedbackValues['lead_comment'] : 'N/A'); ?></textarea>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(Auth::User()->department_id == 2): ?>
                                                <div class="form-group">
                                                    <label class="form-label">Head Comments</label>
                                                    <textarea class="form-control" readonly><?php echo e((isset($feedbackValues['head_comment'])) ? $feedbackValues['head_comment'] : 'N/A'); ?></textarea>
                                                </div>
                                            <?php endif; ?>
                                            <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                                <div class="form-group">
                                                    <label for="feedback_comments" class="form-label">Comments <span class="text-danger">*</span></label>
                                                        <?php if(Auth::User()->designation_id == 2): ?>
                                                            <input type="hidden" name="attribute[]" value="Lead Comment">
                                                            <textarea name="value[]" id="feedback_comments" cols="30" rows="10" class="form-control" required><?php echo e((isset($feedbackValues['lead_comment'])) ? $feedbackValues['lead_comment'] : ''); ?></textarea>
                                                        <?php endif; ?>
                                                        <?php if(Auth::User()->designation_id == 3): ?>
                                                            <input type="hidden" name="attribute[]" value="Head Comment">
                                                            <textarea name="value[]" id="feedback_comments" cols="30" rows="10" class="form-control" required><?php echo e((isset($feedbackValues['head_comment'])) ? $feedbackValues['head_comment'] : ''); ?></textarea>
                                                        <?php endif; ?>

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
                                                </div>
                                            <?php endif; ?>
                                            <input type="hidden" id="resignationId" name="resignationId" value="<?php echo e($emp_resignation->id); ?>">
                                        </div>
                                        <?php if((Auth::User()->designation_id == 2) OR (Auth::User()->designation_id == 3)): ?>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary" id="myBtn" >Submit</button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.tab-pane -->
                <!-- /End of feedback Software-->
                <!-- Feedback form Accounts -->
                
                <!-- /.tab-pane -->
                <!-- /End of feedback Accounts-->
                <?php endif; ?>

                <?php if($displayNodue): ?>
                <!-- No due forms -->
                <div class="tab-pane" id="tab_4-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">No Due</h3>
                                    </div>
                                    <form method="get" action="<?php echo e(route('addOrUpdateNodue')); ?>">
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <th>Attributes</th>
                                                    <th>Comments</th>
                                                </thead>
                                                <tbody>
                                                <!-- No due forms for lead -->
                                                    <?php if(Auth::User()->designation_id == 2): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Knowledge Transfer" <?php if($nodueAttribute['knowledge_transfer_comment']): ?> checked <?php endif; ?> required>Knowledge Transfer
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['knowledge_transfer_comment']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Mail ID closure" <?php if($nodueAttribute['mail_closure']): ?> checked <?php endif; ?> required> Mail ID closure
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['mail_closure']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <!-- No due forms for head -->
                                                    <?php if(Auth::User()->designation_id == 3): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="knowledge_transfer" value="completed" required> Knowledge Transfer
                                                                    </label>
                                                                    <?php $__errorArgs = ['knowledge_transfer'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="knowledge_transfer_comment" class="form-control" id="knowledge_transfer_comment" cols="30" rows="3" required></textarea>
                                                                    <?php $__errorArgs = ['knowledge_transfer_comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="mail_id_closure" value="completed" required> Mail ID closure
                                                                    </label>
                                                                    <?php $__errorArgs = ['mail_id_closure'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="mail_id_closure_comment" class="form-control" id="mail_id_closure_comment" cols="30" rows="3" required></textarea>
                                                                    <?php $__errorArgs = ['mail_id_closure_comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <!-- No due forms for HR -->
                                                    <?php if(Auth::User()->department_id == 2): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="ID Card" <?php echo e(isset($nodueAttribute['id_card']) ? 'checked' : ''); ?> required> ID Card
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e(isset($nodueAttribute['id_card']) ? $nodueAttribute['id_card'] : ''); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="NDA" <?php echo e(isset($nodueAttribute['nda']) ? 'checked' : ''); ?> required> NDA
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control"cols="30" rows="3" required><?php echo e(isset($nodueAttribute['nda']) ? $nodueAttribute['nda'] : ''); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Professional Tax" <?php echo e(isset($nodueAttribute['professional_tax']) ? 'checked' : ''); ?> required> Professional Tax
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e(isset($nodueAttribute['professional_tax']) ? $nodueAttribute['professional_tax'] : ''); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <!-- No due forms for SA -->
                                                    <?php if(Auth::User()->department_id == 7): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Official Email ID" <?php if($nodueAttribute['official_email_id']): ?> checked <?php endif; ?> required> Official Email ID
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['official_email_id']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Skype Account" <?php if($nodueAttribute['skype_account']): ?> checked <?php endif; ?> required> Skype Account
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['skype_account']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Gmail or Yahoo Testing Purpose" <?php if($nodueAttribute['gmail_yahoo']): ?> checked <?php endif; ?> required> Gmail or Yahoo Testing Purpose
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['gmail_yahoo']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Testing Tools" <?php if($nodueAttribute['testing_tools']): ?> checked <?php endif; ?> required> Testing Tools
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['testing_tools']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Linux or Mac Machine Password" <?php if($nodueAttribute['linux_mac_password']): ?> checked <?php endif; ?> required> Linux or Mac Machine Password
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['linux_mac_password']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Specific Tools For Renewal Details" <?php if($nodueAttribute['renewal_tools']): ?> checked <?php endif; ?> required> Specific Tools For Renewal Details
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['renewal_tools']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Handover Testing Device" <?php if($nodueAttribute['testing_device']): ?> checked <?php endif; ?> required> Handover Testing Device
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['testing_device']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Headset" <?php if($nodueAttribute['headset']): ?> checked <?php endif; ?> required> Headset
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['headset']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Machine Port Forwarding" <?php if($nodueAttribute['machine_port_forwarding']): ?> checked <?php endif; ?> required> Machine Port Forwarding
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['machine_port_forwarding']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="SVN & VSS & TFS Login Details" <?php if($nodueAttribute['svn_vss_tfs']): ?> checked <?php endif; ?> required> SVN & VSS & TFS Login Details
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['svn_vss_tfs']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="RDP, VPN Connection" <?php if($nodueAttribute['rdp_vpn']): ?> checked <?php endif; ?> required> RDP, VPN Connection
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['rdp_vpn']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Laptop and Data Card" <?php if($nodueAttribute['laptop_datacard']): ?> checked <?php endif; ?> required> Laptop and Data Card
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['laptop_datacard']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <!-- No due forms for Accounts -->
                                                    <?php if(Auth::User()->designation_id == null): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Salary Advance Due" <?php if($nodueAttribute['salary_advance_due']): ?> checked <?php endif; ?> required> Salary Advance Due
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['salary_advance_due']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Income Tax Due" <?php if($nodueAttribute['income_tax_due']): ?> checked <?php endif; ?> required > Income Tax Due
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['income_tax_due']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Documents For IT" <?php if($nodueAttribute['documents_it']): ?> checked <?php endif; ?> required> Documents For IT
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['documents_it']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <!-- No due forms for Admin -->
                                                    <?php if(Auth::User()->designation_id == null): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Laptop" <?php if($nodueAttribute['laptop']): ?> checked <?php endif; ?> required> Laptop
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['laptop']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Data Card" <?php if($nodueAttribute['data_card']): ?> checked <?php endif; ?> required> Data Card
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['data_card']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Official Property If Any" <?php if($nodueAttribute['official_property']): ?> checked <?php endif; ?> required> Official Property If Any
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['official_property']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <!-- No due forms for Quality -->
                                                    <?php if(Auth::User()->designation_id == null): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Exit Process Completion From Core Departments" <?php if($nodueAttribute['exit_process_completion']): ?> checked <?php endif; ?> required> Exit Process Completion From Core Departments
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['exit_process_completion']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="ISMS/QMS Incidents & Tickets Closure Status" <?php if($nodueAttribute['isms_qms']): ?> checked <?php endif; ?> required> ISMS/QMS Incidents & Tickets Closure Status
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['isms_qms']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Disable All Access Control" <?php if($nodueAttribute['disable_access']): ?> checked <?php endif; ?> required> Disable All Access Control
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['disable_access']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <!-- No due forms for Technical Team -->
                                                    <?php if(Auth::User()->designation_id == null): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="KT completed for all the current and old projects" <?php if($nodueAttribute['kt_completion']): ?> checked <?php endif; ?> required> KT completed for all the current and old projects
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['kt_completion']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Relieving date informed and accepted by client" <?php if($nodueAttribute['relieving_date_informed']): ?> checked <?php endif; ?> required> Relieving date informed and accepted by client
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['relieving_date_informed']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)" <?php if($nodueAttribute['internal_client_souce_code']): ?> checked <?php endif; ?> required> All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['internal_client_souce_code']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)" <?php if($nodueAttribute['project_detail_document']): ?> checked <?php endif; ?> required> Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['project_detail_document']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <!-- No due forms for Marketing Team -->
                                                    <?php if(Auth::User()->designation_id == null): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Handing over CLIENT details (Excel)" <?php if($nodueAttribute['client_details_handle']): ?> checked <?php endif; ?> required> Handing over CLIENT details (Excel)
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['client_details_handle']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="KT on HOT & WARM prospects" <?php if($nodueAttribute['kt_hot_warm']): ?> checked <?php endif; ?> required> KT on HOT & WARM prospects
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['kt_hot_warm']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Introducing new account manager to CLIENTS via Email" <?php if($nodueAttribute['intro_new_acc_manager']): ?> checked <?php endif; ?> required> Introducing new account manager to CLIENTS via Email
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['intro_new_acc_manager']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="Completion of Data Categorization" <?php if($nodueAttribute['data_categorization']): ?> checked <?php endif; ?> required> Completion of Data Categorization
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['data_categorization']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="attribute[]" value="RFP System updation" <?php if($nodueAttribute['rfp_system']): ?> checked <?php endif; ?> required> RFP System updation
                                                                    </label>
                                                                    <?php $__errorArgs = ['attribute'];
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
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <textarea name="comment[]" class="form-control" cols="30" rows="3" required><?php echo e($nodueAttribute['rfp_system']); ?></textarea>
                                                                    <?php $__errorArgs = ['comment'];
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
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="box-footer">

                                            <input type="hidden" id="resignationId" name="resignationId" value="<?php echo e($emp_resignation->id); ?>">
                                            <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(Auth::User()->department_id == 2): ?>
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
                                                    <td <?php if(isset($nodueAttribute['id_card'])): ?> class="<?php echo e(($nodueAttribute['id_card'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >ID Card</td>
                                                    <td <?php if(isset($nodueAttribute['salary_advance_due'])): ?> class="<?php echo e(($nodueAttribute['salary_advance_due'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Salary Advance Due</td>
                                                    <td <?php if(isset($nodueAttribute['laptop'])): ?> class="<?php echo e(($nodueAttribute['laptop'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Laptop</td>
                                                    <td <?php if(isset($nodueAttribute['exit_process_completion'])): ?> class="<?php echo e(($nodueAttribute['exit_process_completion'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Exit Process Completion from Core Departments</td>

                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['nda'])): ?> class="<?php echo e(($nodueAttribute['nda'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >NDA</td>
                                                    <td <?php if(isset($nodueAttribute['income_tax_due'])): ?> class="<?php echo e(($nodueAttribute['income_tax_due'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Income Tax Due</td>
                                                    <td <?php if(isset($nodueAttribute['data_card'])): ?> class="<?php echo e(($nodueAttribute['data_card'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Data Card</td>
                                                    <td <?php if(isset($nodueAttribute['isms_qms'])): ?> class="<?php echo e(($nodueAttribute['isms_qms'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >ISMS/QMS Incidents & Tickets Closure Status</td>

                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['professional_tax'])): ?> class="<?php echo e(($nodueAttribute['professional_tax'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Professional Tax</td>
                                                    <td <?php if(isset($nodueAttribute['documents_it'])): ?> class="<?php echo e(($nodueAttribute['documents_it'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Documents for IT</td>
                                                    <td <?php if(isset($nodueAttribute['official_property'])): ?> class="<?php echo e(($nodueAttribute['official_property'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Official Property If Any</td>
                                                    <td <?php if(isset($nodueAttribute['disable_access'])): ?> class="<?php echo e(($nodueAttribute['disable_access'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Disable all Access Control</td>

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
                                                    <td <?php if(isset($nodueAttribute['official_email_id'])): ?> class="<?php echo e(($nodueAttribute['official_email_id'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Official Email Account</td>
                                                    <td <?php if(isset($nodueAttribute['kt_completion'])): ?> class="<?php echo e(($nodueAttribute['kt_completion'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >KT completed for all the current and old projects</td>
                                                    <td <?php if(isset($nodueAttribute['client_details_handle'])): ?> class="<?php echo e(($nodueAttribute['client_details_handle'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Handing over CLIENT details (Excel)</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['skype_account'])): ?> class="<?php echo e(($nodueAttribute['skype_account'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Skype Account</td>
                                                    <td <?php if(isset($nodueAttribute['relieving_date_informed'])): ?> class="<?php echo e(($nodueAttribute['relieving_date_informed'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Relieving date informed and accepted by client</td>
                                                    <td <?php if(isset($nodueAttribute['kt_hot_warm'])): ?> class="<?php echo e(($nodueAttribute['kt_hot_warm'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >KT on HOT & WARM prospects</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['gmail_yahoo'])): ?> class="<?php echo e(($nodueAttribute['gmail_yahoo'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Gmail or Yahoo Testing Purpose</td>
                                                    <td <?php if(isset($nodueAttribute['internal_client_souce_code'])): ?> class="<?php echo e(($nodueAttribute['internal_client_souce_code'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >All the Internal and client projects Source code, Projects Documents pushed to SVN and shared the details to concerned Projects Lead(s)</td>
                                                    <td <?php if(isset($nodueAttribute['intro_new_acc_manager'])): ?> class="<?php echo e(($nodueAttribute['intro_new_acc_manager'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Introducing new account manager to CLIENTS via Email</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['testing_tools'])): ?> class="<?php echo e(($nodueAttribute['testing_tools'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Testing Tools</td>
                                                    <td <?php if(isset($nodueAttribute['project_detail_document'])): ?> class="<?php echo e(($nodueAttribute['project_detail_document'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Prepared the document with the details of all the projects, access credentials and handover to concerned project Lead(s)</td>
                                                    <td <?php if(isset($nodueAttribute['data_categorization'])): ?> class="<?php echo e(($nodueAttribute['data_categorization'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Completion of Data Categorization</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['linux_mac_password'])): ?> class="<?php echo e(($nodueAttribute['linux_mac_password'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Linux or Mac machine Password</td>
                                                    <td></td>
                                                    <td <?php if(isset($nodueAttribute['rfp_system'])): ?> class="<?php echo e(($nodueAttribute['rfp_system'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >RFP System updation</td>

                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['renewal_tools'])): ?> class="<?php echo e(($nodueAttribute['renewal_tools'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Specific tools for renewal details</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['testing_device'])): ?> class="<?php echo e(($nodueAttribute['testing_device'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Handover Testing Device</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['headset'])): ?> class="<?php echo e(($nodueAttribute['headset'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Headset</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['machine_port_forwarding'])): ?> class="<?php echo e(($nodueAttribute['machine_port_forwarding'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Machine Port Forwarding</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['svn_vss_tfs'])): ?> class="<?php echo e(($nodueAttribute['svn_vss_tfs'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >SVN & VSS & TFS Login Details</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['rdp_vpn'])): ?> class="<?php echo e(($nodueAttribute['rdp_vpn'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >RDP, VPN Connection</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if(isset($nodueAttribute['laptop_datacard'])): ?> class="<?php echo e(($nodueAttribute['laptop_datacard'] == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?> >Laptop and Data card</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- /.tab-pane -->
                <?php endif; ?>

                <?php if(Auth::User()->department_id == 2 && $showAnswers != NULL): ?>
                <!-- Exit interview answers -->
                <div class="tab-pane" id="tab_5-2">
                    <?php if(Auth::User()->department_id == 2): ?>
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
                                                <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td ><?php echo e($answer->question_number); ?></td>
                                                    <td ><?php echo e($answer->questions); ?></td>
                                                    <td ><?php echo e($answer->answers); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">HR EXIT INTERVIEW</h3>
                                    </div>
                                    <form method="get" action="<?php echo e(route('addOrUpdateHrInterview')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo e(method_field('PUT')); ?>

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
                                                    <?php $__currentLoopData = $hrExitInterviewComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hrExitInterviewComment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="hr_exitinterview_comment[]" class="form-control" value="<?php echo e($hrExitInterviewComment->comments); ?>" required>
                                                            </td>
                                                            <td>
                                                                <select name="hr_exitinterview_actionarea[]" class="form-control" required>
                                                                    <option value="<?php echo e($hrExitInterviewComment->action_area); ?>"><?php echo e($hrExitInterviewComment->action_area); ?></option>
                                                                    <option value="Salary">Salary</option>
                                                                    <option value="Leave and Holiday">Leave and Holiday</option>
                                                                    <option value="Benifits">Benifits</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="remove_field btn btn-danger" disabled title="Already recorded">Remove</button>
                                                            <td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                    <label class="control-label" for="date_of_entry">Date: <span style="color: #757575;"><?php echo e(Date('d-m-Y')); ?></span> </label>
                                                    <input type="hidden" name="date_of_entry" value="<?php echo e(Date('d-m-Y')); ?>">
                                                </div>

                                                <div class="col-sm-4">
                                                    <label class="control-label pull-right" for="updated_by">Updated By:
                                                    <select name="commented_by" id="commented_by" style="color: #757575;">
                                                        <option value="<?php echo e(Auth::User()->display_name); ?>"><?php echo e(Auth::User()->display_name); ?></option>
                                                        <?php $__currentLoopData = $hr_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($hr->display_name); ?>"><?php echo e($hr->display_name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <input type="hidden" id="resignationId" name="resignationId" value="<?php echo e($emp_resignation->id); ?>">
                                            <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- /.tab-pane -->
                <?php endif; ?>

                <?php if(\Auth::User()->department_id == 2 && $showAnswers != NULL): ?>
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
                                    <form method="post"  action="<?php echo e((!$finalCheckList) ? route('storeFinalCheckList') : route('updateFinalCheckList')); ?> " enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?> <div class="box-body">
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="type_of_exit">Type Of Exit</label>
                                                <div class="col-sm-4">
                                                    <select name="type_of_exit" id="type_of_exit"  class="form-control" required>
                                                        <option value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->type_of_exit); ?>"><?php echo e((!$finalCheckList) ? 'Select' : $finalCheckList->type_of_exit); ?></option>
                                                        <option value="Voluntary">Voluntary</option>
                                                        <option value="Involuntary">Involuntary</option>
                                                    </select>
                                                    <?php $__errorArgs = ['type_of_exit'];
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
                                                <label class="control-label col-sm-2" for="date_of_leaving">Date Of Leaving</label>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" id="date_of_leaving" name="date_of_leaving" value="<?php echo e(($emp_resignation->changed_dol == NULL) ? $emp_resignation->date_of_leaving : $emp_resignation->changed_dol); ?>" readonly>
                                                <?php $__errorArgs = ['date_of_leaving'];
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
                                                <label class="control-label col-sm-2" for="reason_for_leaving">Reason For Leaving</label>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" id="reason_for_leaving" name="reason_for_leaving" value="<?php echo e(($emp_resignation->other_reason == NULL) ? $emp_resignation->reason : $emp_resignation->other_reason); ?>" readonly>
                                                <?php $__errorArgs = ['reason_for_leaving'];
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
                                                <label class="control-label col-sm-2" for="last_drawn_salary">Last Drawn Salary</label>
                                                <div class="col-sm-4">
                                                <input type="number" class="form-control" id="last_drawn_salary" name="last_drawn_salary" value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->last_drawn_salary); ?>" required>
                                                <?php $__errorArgs = ['last_drawn_salary'];
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
                                                <label class="control-label col-sm-2" for="consider_for_rehire">Can Be Considered For Rehire</label>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" id="consider_for_rehire" name="consider_for_rehire" value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->consider_for_rehire); ?>" required>
                                                <?php $__errorArgs = ['consider_for_rehire'];
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
                                                <label class="control-label col-sm-2" for="overall_feedback">Overall Feedback</label>
                                                <div class="col-sm-4">
                                                <input type="text" class="form-control" id="overall_feedback" name="overall_feedback" value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->overall_feedback); ?>" required>
                                                <?php $__errorArgs = ['overall_feedback'];
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
                                                <label class="control-label col-sm-2" for="relieving_letter">Relieving Letter</label>
                                                <div class="col-sm-4">
                                                    <select name="relieving_letter" id="relieving_letter"  class="form-control" required>
                                                        <option value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->relieving_letter); ?>"><?php echo e((!$finalCheckList) ? 'Select' : $finalCheckList->relieving_letter); ?></option>
                                                        <option value="Given">Given</option>
                                                        <option value="Pending">Pending</option>
                                                    </select>
                                                    <?php $__errorArgs = ['relieving_letter'];
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
                                                <label class="control-label col-sm-2" for="experience_letter">Experience Letter</label>
                                                <div class="col-sm-4">
                                                    <select name="experience_letter" id="experience_letter"  class="form-control" required>
                                                        <option value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->experience_letter); ?>"><?php echo e((!$finalCheckList) ? 'Select' : $finalCheckList->experience_letter); ?></option>
                                                        <option value="Given">Given</option>
                                                        <option value="Pending">Pending</option>
                                                    </select>
                                                    <?php $__errorArgs = ['experience_letter'];
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
                                                <label class="control-label col-sm-2" for="salary_certificate">Salary Certificate</label>
                                                <div class="col-sm-4">
                                                    <select name="salary_certificate" id="salary_certificate"  class="form-control" required>
                                                        <option value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->salary_certificate); ?>"><?php echo e((!$finalCheckList) ? 'Select' : $finalCheckList->salary_certificate); ?></option>
                                                        <option value="Given">Given</option>
                                                        <option value="Pending">Pending</option>
                                                    </select>
                                                    <?php $__errorArgs = ['salary_certificate'];
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
                                                <label class="control-label col-sm-2" for="final_comment">Final Comment</label>
                                                <div class="col-sm-4">
                                                <textarea name="final_comment" id="final_comment" class="form-control" cols="30" rows="10" required><?php echo e((!$finalCheckList) ? '' : $finalCheckList->final_comment); ?></textarea>
                                                <?php $__errorArgs = ['final_comment'];
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
                                                <label class="control-label col-sm-2" for="documents">Relieving Letter</label>
                                                <div class="col-sm-4">
                                                <input type="file" name="RelievingLetter" id="RelievingLetter" class="form-control">
                                                </div>
                                                <?php if($finalCheckList): ?>
                                                <?php if($finalCheckList->relieving_document): ?>
                                                <div class="col-sm-4">
                                                   <a href="<?php echo e(route('downloadDocs', ['filename' => $finalCheckList->relieving_document] )); ?>" class="btn btn-success"> <i class="fa fa-download" aria-hidden="true"></i></a> <?php echo e($finalCheckList->relieving_document); ?>

                                                </div>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="documents">Experience Letter</label>
                                                <div class="col-sm-4">
                                                <input type="file" name="ExperienceLetter" id="ExperienceLetter" class="form-control">
                                                </div>
                                                <?php if($finalCheckList): ?>
                                                <?php if($finalCheckList->experience_document): ?>
                                                <div class="col-sm-4">
                                                   <a href="<?php echo e(route('downloadDocs', ['filename' => $finalCheckList->experience_document] )); ?>" class="btn btn-success"> <i class="fa fa-download" aria-hidden="true"></i></a> <?php echo e($finalCheckList->experience_document); ?>

                                                </div>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="documents">Salary Certificate</label>
                                                <div class="col-sm-4">
                                                <input type="file" name="SalaryCertificate" id="SalaryCertificate" class="form-control">
                                                </div>
                                                <?php if($finalCheckList): ?>
                                                <?php if($finalCheckList->salary_document): ?>
                                                <div class="col-sm-4">
                                                   <a href="<?php echo e(route('downloadDocs', ['filename' => $finalCheckList->salary_document] )); ?>" class="btn btn-success"> <i class="fa fa-download" aria-hidden="true"></i></a> <?php echo e($finalCheckList->salary_document); ?>

                                                </div>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label class="control-label" for="date_of_entry"> Date: <span style="color: #757575;"><?php echo e(Date('d-m-Y')); ?></span> </label>
                                                    <input type="hidden" name="date_of_entry" value="<?php echo e(Date('Y-d-m')); ?>">
                                                </div>
                                                <div class="col-sm-4">
                                                <label class="control-label pull-right" for="updated_by">Updated By:
                                                <select name="updated_by" id="updated_by" style="color: #757575;">
                                                <option value="<?php echo e(Auth::User()->display_name); ?>"><?php echo e(Auth::User()->display_name); ?></option>
                                                <?php $__currentLoopData = $hr_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($hr->display_name); ?>"><?php echo e($hr->display_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <input type="hidden" id="resignationId" name="resignationId" value="<?php echo e($emp_resignation->id); ?>">
                                            <input type="hidden" id="finalChecklistId" name="finalChecklistId" value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->id); ?>">
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
                <?php endif; ?>
            </div>
            <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
</div>






<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/process/viewResignation.blade.php ENDPATH**/ ?>