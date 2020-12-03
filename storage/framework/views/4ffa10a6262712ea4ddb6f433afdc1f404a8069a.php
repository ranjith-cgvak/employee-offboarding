

<?php $__env->startSection('content'); ?>


<?php if(session()->get('success')): ?>
<div class="alert alert-success">
<?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>

<!-- My resignation details -->
<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">My Resignation Details</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Employee Name: </b><?php echo e($user->name); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Employee ID: </b><?php echo e($user->id); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date of joinig: </b><?php echo e($user->created_at); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Designation: </b><?php echo e($user->designation); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Department: </b>IT</p>
                </div>
                <div class="col-xs-4">
                    <p><b>Lead: </b><?php echo e(($user->lead == NULL) ? 'Not Assigned' : $user->lead); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <p><b>Reason : </b><?php echo e($myResignation->reason); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date of Resignation: </b><?php echo e($myResignation->date_of_resignation); ?></p>
                </div>
                <div class="col-xs-4">
                    <p><b>Date of leaving as per policy: </b><?php echo e(($myResignation->changed_dol == NULL) ? $myResignation->date_of_leaving : $myResignation->changed_dol); ?></p>
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
                            <td class="<?php echo e(($myResignation->comment_lead == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($myResignation->comment_lead == NULL) ? 'Pending' : 'Accepted'); ?></td>
                            <td class="<?php echo e(($myResignation->comment_head == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($myResignation->comment_head == NULL) ? 'Pending' : 'Accepted'); ?></td>
                            <td class="<?php echo e(($myResignation->comment_hr == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($myResignation->comment_hr == NULL) ? 'Pending' : 'Accepted'); ?></td>
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
                                <form method="post" action="<?php echo e(route('resignation.update', $myResignation->id )); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo e(method_field('PUT')); ?>

                                    <div class="box-body">
                                        <div class="form-group row">
                                            <label for="withdrawDate" class="col-sm-2 form-label">Withdraw Date <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control disablePast" value="<?php echo e(Date('Y-m-d')); ?>" id="withdrawDate" name="withdrawDate">
                                                <?php $__errorArgs = ['withdrawDate'];
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
                                            <label for="comment" class="col-sm-2 form-label">Comment <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" required></textarea>
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


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\employee-offboarding\resources\views/resignation/index.blade.php ENDPATH**/ ?>