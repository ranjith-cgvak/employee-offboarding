

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
        <form method="get" action="<?php echo e(route('addOrUpdateDolComments')); ?>">
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
                    <?php if(\Auth::User()->designation_id == 2): ?><textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required><?php echo e(($leadDolComment != NULL) ? $leadDolComment['comment'] : ' '); ?></textarea><?php endif; ?>
                    <?php if(\Auth::User()->designation_id == 3): ?><textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required><?php echo e(($headDolComment != NULL) ? $headDolComment['comment'] : ' '); ?></textarea><?php endif; ?>
                    <?php if(\Auth::User()->department_id == 2): ?><textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required><?php echo e(($hrDolComment != NULL) ? $hrDolComment['comment'] : ' '); ?></textarea><?php endif; ?>
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
                <li><a href="#tab_2-2" data-toggle="tab">Acceptance status</a></li>
                <li><a href="#tab_3-2" data-toggle="tab">No Due</a></li>
                <?php if(\Auth::User()->department_id != 7): ?>
                <li><a href="#tab_4-2" data-toggle="tab">Feedback</a></li>
                <?php endif; ?>
                <?php if(Auth::User()->department_id == 2): ?>
                <li><a href="#tab_5-2" data-toggle="tab">Exit Interview Answers</a></li>
                <?php endif; ?>
                <?php if(\Auth::User()->department_id == 2): ?>
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
                                        <?php if($emp_resignation->date_of_withdraw == NULL): ?>
                                        <div class="form-group row">
                                            <label class="col-sm-2 form-label">Date Of Leaving </label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-sm-1">
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
                                    <form method="get" action="<?php echo e(route('addOrUpdateResignationComment')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo e(method_field('PUT')); ?>

                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label for="leadComment" class="col-sm-2 form-label">Lead Comment </label>
                                                <div class="col-sm-6">
                                                <?php if(Auth::User()->designation_id == 2): ?>
                                                <textarea class="form-control" name="leadComment" id="leadComment" cols="30" rows="10" required><?php echo e(($leadGeneralComment != NULL) ? $leadGeneralComment['comment'] : ' '); ?></textarea>
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
                                                    <p><?php echo e(($leadGeneralComment != NULL) ? $leadGeneralComment['comment'] : 'N/A'); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if(Auth::User()->designation_id != 2): ?>
                                            <div class="form-group row">
                                                <label for="headComment" class="col-sm-2 form-label">Head comment</label>
                                                <div class="col-sm-6">
                                                    <?php if(Auth::User()->designation_id == 3 ): ?>
                                                    <textarea name="headComment" class="form-control" id="headComment" cols="30" rows="10" required><?php echo e(($headGeneralComment != NULL) ? $headGeneralComment['comment'] : ' '); ?></textarea>
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
                                                    <p><?php echo e(($headGeneralComment != NULL) ? $headGeneralComment['comment'] : 'N/A'); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(Auth::User()->department_id == 2 ): ?>
                                            <div class="form-group row">
                                                <label for="hrComment" class="col-sm-2 form-label">HR comment</label>
                                                <div class="col-sm-6">
                                                    <textarea name="hrComment" class="form-control" id="hrComment" cols="30" rows="10" required><?php echo e(($hrGeneralComment != NULL) ? $hrGeneralComment['comment'] : ' '); ?></textarea>
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
                                        <input type="hidden" name="leadGeneralCommentId" value="<?php echo e(($leadGeneralComment != NULL) ? $leadGeneralComment['id'] : NULL); ?> ">
                                        <input type="hidden" name="headGeneralCommentId" value="<?php echo e(($headGeneralComment != NULL) ? $headGeneralComment['id'] : NULL); ?> ">
                                        <input type="hidden" name="hrGeneralCommentId" value="<?php echo e(($hrGeneralComment != NULL) ? $hrGeneralComment['id'] : NULL); ?> ">
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
                                                    <td class="<?php echo e(($leadGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($leadGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted'); ?></td>
                                                    <?php if(\Auth::User()->department_id != 7): ?>
                                                    <td><?php echo e($leadGeneralComment['comment']); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $leadDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' '); ?></td>
                                                    <td><?php echo e($leadDolComment['comment']); ?></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>Department Head / Unit Head</td>
                                                    <td class="<?php echo e(($headGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($headGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted'); ?></td>
                                                    <?php if(\Auth::User()->department_id != 7): ?>
                                                    <td><?php echo e($headGeneralComment['comment']); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $headDolComment['comment'] != NULL ) ? $converted_dates['changed_dol'] : ' '); ?></td>
                                                    <td><?php echo e($headDolComment['comment']); ?></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>HR</td>
                                                    <td class="<?php echo e(($hrGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($hrGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted'); ?></td>
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

                <!-- No due forms -->
                <div class="tab-pane" id="tab_3-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-secondary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">No Due</h3>
                                    </div>
                                    <form method="get" action="<?php echo e((!$nodue) ? route('storeNodue') : route('updateNodue')); ?>">
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
                                                                        <input type="checkbox" name="knowledge_transfer" value="completed" required <?php if($nodue): ?> <?php echo e(($nodue->knowledge_transfer_lead != NULL) ? 'checked' : ''); ?> <?php endif; ?>> Knowledge Transfer
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
                                                                    <textarea name="knowledge_transfer_comment" class="form-control" id="knowledge_transfer_comment" cols="30" rows="3" required><?php echo e((!$nodue) ? '' :  $nodue->knowledge_transfer_lead_comment); ?></textarea>
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
                                                                        <input type="checkbox" name="mail_id_closure" value="completed" required <?php if($nodue): ?> <?php echo e(($nodue->mail_id_closure_lead != NULL) ? 'checked' : ''); ?> <?php endif; ?>> Mail ID closure
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
                                                                    <textarea name="mail_id_closure_comment" class="form-control" id="mail_id_closure_comment" cols="30" rows="3" required><?php echo e((!$nodue) ? '' :  $nodue->mail_id_closure_lead_comment); ?></textarea>
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
                                                    <!-- No due forms for head -->
                                                    <?php if(Auth::User()->designation_id == 3): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="knowledge_transfer" value="completed" required <?php if($nodue): ?> <?php echo e(($nodue->knowledge_transfer_head != NULL) ? 'checked' : ''); ?> <?php endif; ?>> Knowledge Transfer
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
                                                                    <textarea name="knowledge_transfer_comment" class="form-control" id="knowledge_transfer_comment" cols="30" rows="3" required><?php echo e((!$nodue) ? '' :  $nodue->knowledge_transfer_head_comment); ?></textarea>
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
                                                                        <input type="checkbox" name="mail_id_closure" value="completed" required <?php if($nodue): ?> <?php echo e(($nodue->mail_id_closure_head != NULL) ? 'checked' : ''); ?> <?php endif; ?>> Mail ID closure
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
                                                                    <textarea name="mail_id_closure_comment" class="form-control" id="mail_id_closure_comment" cols="30" rows="3" required><?php echo e((!$nodue) ? '' :  $nodue->mail_id_closure_head_comment); ?></textarea>
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
                                                                        <input type="checkbox" name="id_card" value="completed" required <?php if($nodue): ?> <?php echo e(($nodue->id_card != NULL) ? 'checked' : ''); ?> <?php endif; ?>> ID Card
                                                                    </label>
                                                                    <?php $__errorArgs = ['id_card'];
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
                                                                    <textarea name="id_card_comment" class="form-control" id="id_card_comment" cols="30" rows="3" required><?php echo e((!$nodue) ? '' :  $nodue->id_card_comment); ?></textarea>
                                                                    <?php $__errorArgs = ['id_card_comment'];
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
                                                                        <input type="checkbox" name="nda" value="completed" required <?php if($nodue): ?> <?php echo e(($nodue->nda != NULL) ? 'checked' : ''); ?> <?php endif; ?>> NDA
                                                                    </label>
                                                                    <?php $__errorArgs = ['nda'];
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
                                                                    <textarea name="nda_comment" class="form-control" id="nda_comment" cols="30" rows="3" required><?php echo e((!$nodue) ? '' :  $nodue->nda_comment); ?></textarea>
                                                                    <?php $__errorArgs = ['nda_comment'];
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
                                                                        <input type="checkbox" name="official_email_id" value="completed" required <?php if($nodue): ?> <?php echo e(($nodue->official_email_id != NULL) ? 'checked' : ''); ?> <?php endif; ?>> Official Email ID
                                                                    </label>
                                                                    <?php $__errorArgs = ['official_email_id'];
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
                                                                    <textarea name="official_email_id_comment" class="form-control" id="official_email_id_comment" cols="30" rows="3" required><?php echo e((!$nodue) ? '' :  $nodue->official_email_id_comment); ?></textarea>
                                                                    <?php $__errorArgs = ['official_email_id_comment'];
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
                                                                        <input type="checkbox" name="skype_account" value="completed" required <?php if($nodue): ?> <?php echo e(($nodue->skype_account != NULL) ? 'checked' : ''); ?> <?php endif; ?>> NDA
                                                                    </label>
                                                                    <?php $__errorArgs = ['skype_account'];
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
                                                                    <textarea name="skype_account_comment" class="form-control" id="skype_account_comment" cols="30" rows="3" required><?php echo e((!$nodue) ? '' :  $nodue->skype_account_comment); ?></textarea>
                                                                    <?php $__errorArgs = ['skype_account_comment'];
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
                                            <input type="hidden" id="nodueId" name="nodueId" value="<?php echo e((!$nodue) ? '' : $nodue->id); ?>">
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
                                                <th>Lead</th>
                                                <th>Department Head / Unit Head</th>
                                                <th>HR</th>
                                                <th>SA</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td <?php if($nodue): ?> class="<?php echo e(($nodue->knowledge_transfer_lead == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?>>Knowledge Transfer</td>
                                                    <td <?php if($nodue): ?> class="<?php echo e(($nodue->knowledge_transfer_head == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?>>Knowledge Transfer</td>
                                                    <td <?php if($nodue): ?> class="<?php echo e(($nodue->id_card == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?>>ID Card</td>
                                                    <td <?php if($nodue): ?> class="<?php echo e(($nodue->official_email_id == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?>>Official Email ID</td>
                                                </tr>
                                                <tr>
                                                    <td <?php if($nodue): ?> class="<?php echo e(($nodue->mail_id_closure_lead == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?>>Mail ID Closure</td>
                                                    <td <?php if($nodue): ?> class="<?php echo e(($nodue->mail_id_closure_head == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?>>Mail ID Closure</td>
                                                    <td <?php if($nodue): ?> class="<?php echo e(($nodue->nda == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?>>NDA</td>
                                                    <td <?php if($nodue): ?> class="<?php echo e(($nodue->skype_account == NULL) ? 'bg-warning' : 'bg-success'); ?>" <?php else: ?> class="bg-warning" <?php endif; ?>>Skype Account</td>
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

                <?php if(\Auth::User()->department_id != 7): ?>
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
                <?php endif; ?>

<!-- No due forms -->
<div class="tab-pane" id="tab_5-2">
    <?php if(Auth::User()->department_id == 2): ?>
    <!-- No Due status -->
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
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<!-- /.tab-pane -->

                <?php if(\Auth::User()->department_id == 2): ?>
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
                                                    <select name="type_of_exit" id="type_of_exit"  class="form-control">
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
                                                <input type="date" class="form-control" id="date_of_leaving" name="date_of_leaving" value="<?php echo e(($emp_resignation->changed_dol == NULL) ? $emp_resignation->date_of_leaving : $emp_resignation->changed_dol); ?>" readonly>
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
                                                <input type="number" class="form-control" id="last_drawn_salary" name="last_drawn_salary" value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->last_drawn_salary); ?>">
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
                                                <input type="text" class="form-control" id="consider_for_rehire" name="consider_for_rehire" value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->consider_for_rehire); ?>">
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
                                                <input type="text" class="form-control" id="overall_feedback" name="overall_feedback" value="<?php echo e((!$finalCheckList) ? '' : $finalCheckList->overall_feedback); ?>">
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
                                                    <select name="relieving_letter" id="relieving_letter"  class="form-control">
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
                                                    <select name="experience_letter" id="experience_letter"  class="form-control">
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
                                                    <select name="salary_certificate" id="salary_certificate"  class="form-control">
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
                                                <textarea name="final_comment" id="final_comment" class="form-control" cols="30" rows="10"><?php echo e((!$finalCheckList) ? '' : $finalCheckList->final_comment); ?></textarea>
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
                                                <label class="control-label col-sm-2" for="date_of_entry">Date: <?php echo e(Date('Y-m-d')); ?></label>
                                                <input type="hidden" name="date_of_entry" value="<?php echo e(Date('Y-m-d')); ?>"> 
                                                <div class="col-sm-4">
                                                <label class="control-label pull-right" for="updated_by">Updated By: <?php echo e(Auth::User()->display_name); ?></label>
                                                <input type="hidden" name="updated_by" value="<?php echo e(Auth::User()->display_name); ?>">
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

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\employee-offboarding\resources\views/process/viewResignation.blade.php ENDPATH**/ ?>