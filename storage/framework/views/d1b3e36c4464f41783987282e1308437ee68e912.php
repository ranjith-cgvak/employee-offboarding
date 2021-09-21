

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
                            <th class="text-center">Lead</th>
                            <th class="text-center">Department Head / Unit Head</th>
                            <th class="text-center">HR</th>
                        </thead>
                        <tbody>
                            <td class="text-center <?php echo e(($leadAcceptance == NULL || $leadAcceptance == 'Pending' ) ? 'bg-warning' :( $leadAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )); ?>"><?php echo e(($leadAcceptance == NULL ) ? 'Pending' : $leadAcceptance); ?></td>
                            <td class="text-center <?php echo e(($headAcceptance == NULL || $headAcceptance == 'Pending' ) ? 'bg-warning' :( $headAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )); ?>"><?php echo e(($headAcceptance == NULL ) ? 'Pending' : $headAcceptance); ?></td>
                            <td class="text-center <?php echo e(($hrAcceptance == NULL || $hrAcceptance == 'Pending' ) ? 'bg-warning' :( $hrAcceptance == 'Accepted' ? 'bg-success' : 'bg-danger' )); ?>"><?php echo e(($hrAcceptance == NULL ) ? 'Pending' : $hrAcceptance); ?></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\OfzProjects\Laravel\employee-offboarding\resources\views/resignation/acceptanceStatus.blade.php ENDPATH**/ ?>