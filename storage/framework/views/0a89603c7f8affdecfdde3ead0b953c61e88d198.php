

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
                    <p><b>Employee Name: </b><?php echo e($emp_resignation->name); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Employee ID: </b><?php echo e($emp_resignation->user_id); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date of joinig: </b><?php echo e($emp_resignation->created_at); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Designation: </b><?php echo e($emp_resignation->designation); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Department: </b>IT</p>
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
                    <input type="date" class="form-control disablePast" value="<?php echo e($emp_resignation->date_of_leaving); ?>" id="dateOfLeaving" name="dateOfLeaving">
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
                    <textarea class="form-control" name="commentDol" id="commentDol" cols="30" rows="10" required><?php echo e((Auth::user()->designation != 'Lead' ) ? $emp_resignation->comment_dol_head : $emp_resignation->comment_dol_lead); ?></textarea>
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
                <?php endif; ?>
                <?php if($emp_resignation->date_of_withdraw == NULL ): ?>
                <li><a href="#tab_3-2" data-toggle="tab">No Due</a></li>
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
                                            <label for="reason" class="col-sm-2 form-label">Reason For Leaving the job</label>
                                            <div class="col-sm-6">
                                                <p><?php echo e($emp_resignation->reason); ?></p>
                                            </div>
                                        </div>
                                        <?php if($emp_resignation->other_reason != NULL): ?>
                                        <div class="form-group row">
                                            <label for="reason" class="col-sm-2 form-label">Other Reasons </label>
                                            <div class="col-sm-6">
                                                <p><?php echo e($emp_resignation->other_reason); ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-group row">
                                            <label for="dateOfResignation" class="col-sm-2 form-label">Date Of Resignation</label>
                                            <div class="col-sm-4">
                                                <p><?php echo e($emp_resignation->date_of_resignation); ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dateOfLeaving" class="col-sm-2 form-label">Date Of Leaving As Per Policy </label>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-sm-1">
                                                    <p><?php echo e(($emp_resignation->changed_dol == NULL) ? $emp_resignation->date_of_leaving : $emp_resignation->changed_dol); ?></p>
                                                    </div>
                                                    <div class="col-sm-4" style="display:<?php echo e(($emp_resignation->date_of_withdraw != NULL || $emp_resignation->changed_dol != NULL ) ? 'none' : ' '); ?>;">
                                                    <button type="button" class="btn btn-primary modelBtn" data-toggle="modal" data-target="#exampleModalCenter"><i style='font-size:17px' class='fa fa-edit'></i></button>
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
                                                <?php if(Auth::user()->designation == 'Lead' ): ?>
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
                                                    <?php if(Auth::user()->designation != 'Lead' ): ?>
                                                    <p><?php echo e($emp_resignation->comment_lead); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if(Auth::user()->designation != 'Lead'): ?>
                                            <div class="form-group row">
                                                <label for="headComment" class="col-sm-2 form-label">Head comment</label>
                                                <div class="col-sm-6">
                                                    <?php if(Auth::user()->designation == 'Head' ): ?>
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
                                                    <?php if(Auth::user()->designation == 'HR'): ?>
                                                    <p><?php echo e($emp_resignation->comment_head); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(Auth::user()->designation == 'HR' ): ?>
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
                                                    <?php if(Auth::user()->designation == 'Lead' ): ?>
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

                                                    <?php if(Auth::user()->designation != 'Lead' ): ?>
                                                    <p><?php echo e($emp_resignation->comment_dow_lead); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <?php if(Auth::user()->designation != 'Lead'): ?>
                                            <div class="form-group row">
                                                <label for="withdrawHeadComment" class="col-sm-2 form-label">Head comment on Withdraw </label>
                                                <div class="col-sm-4">
                                                    <?php if(Auth::user()->designation == 'Head' ): ?> 
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

                                                    <?php if(Auth::user()->designation == 'HR' ): ?>
                                                    <p><?php echo e($emp_resignation->comment_dow_head); ?></p>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(Auth::user()->designation == 'HR' ): ?> 
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
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_lead != NULL ) ? $emp_resignation->changed_dol : ' '); ?></td>
                                                    <td><?php echo e($emp_resignation->comment_dol_lead); ?></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>Department Head / Unit Head</td>
                                                    <td class="<?php echo e(($emp_resignation->comment_head == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($emp_resignation->comment_head == NULL) ? 'Pending' : 'Accepted'); ?></td>
                                                    <?php if(Auth::user()->designation != 'SA'): ?>
                                                    <td><?php echo e($emp_resignation->comment_head); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_head != NULL ) ? $emp_resignation->changed_dol : ' '); ?></td>
                                                    <td><?php echo e($emp_resignation->comment_dol_head); ?></td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr>
                                                    <td>HR</td>
                                                    <td class="<?php echo e(($emp_resignation->comment_hr == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($emp_resignation->comment_hr == NULL) ? 'Pending' : 'Accepted'); ?></td>
                                                    <?php if(Auth::user()->designation != 'SA'): ?>
                                                    <td><?php echo e($emp_resignation->comment_hr); ?></td>
                                                    <td><?php echo e(( $emp_resignation->changed_dol != NULL && $emp_resignation->comment_dol_hr != NULL ) ? $emp_resignation->changed_dol : ' '); ?></td>
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