

<?php $__env->startSection('content'); ?>


<?php if(session()->get('success')): ?>
<div class="alert alert-success">
<?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>
<!-- Employee details -->
<div class="container-fluid">
    <div class="box box-primary box-body">
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
    </div>
</div>

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


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\employee-offboarding\resources\views/resignation/resignationDetails.blade.php ENDPATH**/ ?>