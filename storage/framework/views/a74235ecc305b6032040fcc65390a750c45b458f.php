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
                    <br>
                    <?php if($completed_no_due): ?>
                    <a href="<?php echo e(route('questions.index')); ?>" class="btn btn-primary" style="float: right;">Exit Interview</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/resignation/noDueStatus.blade.php ENDPATH**/ ?>