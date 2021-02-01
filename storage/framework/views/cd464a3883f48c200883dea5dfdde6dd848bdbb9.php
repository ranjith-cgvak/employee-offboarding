

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
                <p><b>Date of joinig: </b><?php echo e($converted_dates['joining_date']); ?></p>
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
                            <td class="<?php echo e(($leadGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($leadGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted'); ?></td>
                            <td class="<?php echo e(($headGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($headGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted'); ?></td>
                            <td class="<?php echo e(($hrGeneralComment['comment'] == NULL) ? 'bg-warning' : 'bg-success'); ?>"><?php echo e(($hrGeneralComment['comment'] == NULL) ? 'Pending' : 'Accepted'); ?></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\employee-offboarding\resources\views/resignation/acceptanceStatus.blade.php ENDPATH**/ ?>