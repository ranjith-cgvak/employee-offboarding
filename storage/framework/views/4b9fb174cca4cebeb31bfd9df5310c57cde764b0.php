<?php $__env->startSection('content'); ?>

<!-- Employee details -->
<div class="container-fluid">
    <div class="box box-primary box-body">
        <div class="row">
            <div class="col-xs-4">
                <p><b>Employee Name: </b><?php echo e($user->display_name); ?></p>
            </div>
            <div class="col-xs-4">
                <p><b>Employee ID: </b><?php echo e($user->emp_id); ?></p>
            </div>
            <div class="col-xs-4">
                <p><b>Date of Joining: </b><?php echo e($converted_dates['joining_date']); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <p><b>Designation: </b><?php echo e($user->designation); ?></p>
            </div>
            <div class="col-xs-4">
                <p><b>Department: </b><?php echo e($user->department_name); ?></p>
            </div>
            <div class="col-xs-4">
                <p><b>Lead: </b><?php echo e(($user->lead == NULL) ? 'Not Assigned' : $user->lead); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- My resignation details -->
<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">My Resignation Details</h3>
        </div>

        <div class="box-body">
            <div class="form-group row">
                <label for="reason" class="col-sm-3 form-label">Reason For Leaving </label>
                <div class="col-sm-6">
                    <p><?php echo e($myResignation->reason); ?></p>
                </div>
            </div>
            <?php if($myResignation->other_reason != NULL): ?>
            <div class="form-group row">
                <label for="reason" class="col-sm-3 form-label">Other Reason </label>
                <div class="col-sm-6">
                    <p><?php echo e($myResignation->other_reason); ?></p>
                </div>
            </div>
            <?php endif; ?>
            <div class="form-group row">
                <label for="comment_on_resignation" class="col-sm-3 form-label">Comments </label>
                <div class="col-sm-6">
                    <p><?php echo e($myResignation->comment_on_resignation); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label for="dateOfResignation" class="col-sm-3 form-label">Date Of Resignation </label>
                <div class="col-sm-4">
                    <p><?php echo e($converted_dates['date_of_resignation']); ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label for="dateOfLeaving" class="col-sm-3 form-label">Date Of Leaving As Per Policy </label>
                <div class="col-sm-4">
                    <p><?php echo e($converted_dates['date_of_leaving']); ?></p>
                </div>
            </div>
            <?php if($myResignation->changed_dol != NULL): ?>
            <div class="form-group row">
                <label for="dateOfLeaving" class="col-sm-3 form-label">Accepted Date Of Leaving </label>
                <div class="col-sm-4">
                    <p><?php echo e($converted_dates['changed_dol']); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/resignation/resignationDetails.blade.php ENDPATH**/ ?>