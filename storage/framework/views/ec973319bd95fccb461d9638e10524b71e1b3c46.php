<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
    <!-- For Lead, Head, HR, SA -->
    <?php if(in_array(\Auth::User()->emp_id, $headId) || in_array(\Auth::User()->emp_id, $leadId)): ?>
    <li class=" <?php echo e((request()->segment(1) == 'process') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('process.index')); ?>">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <?php else: ?>
    <!-- For employees -->
    <li data-toggle="tooltip" data-placement="right" <?php if($myResignation): ?> title= 'Applied Already' style="cursor: not-allowed;" <?php endif; ?> class=" <?php echo e(((request()->segment(1) == 'resignation') && (request()->segment(2) == 'create')) ? 'active' : ''); ?>">
        <a class="<?php echo e(($myResignation != NULL) ? 'isDisabled' : ' '); ?>" href="<?php echo e(route('resignation.create')); ?>">
        <i class="fa fa-file-text-o"></i> <span>Resignation Form</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" <?php if(!$myResignation): ?> title= 'Apply resignation to enable' style="cursor: not-allowed;" <?php endif; ?> class=" <?php echo e(((request()->segment(1) == 'resignation') && (request()->segment(2) == NULL)) ? 'active' : ''); ?>">
        <a class="<?php echo e(($myResignation == NULL) ? 'isDisabled' : ' '); ?>" href="<?php echo e(route('resignation.index')); ?>">
        <i class="fa fa-list-alt"></i> <span>My Resignation</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" <?php if(!$myResignation): ?> title= 'Apply resignation to enable' style="cursor: not-allowed;" <?php endif; ?> class=" <?php echo e((request()->segment(1) == 'acceptanceStatus') ? 'active' : ''); ?>">
        <a class="<?php echo e(($myResignation == NULL) ? 'isDisabled' : ' '); ?>" href="<?php echo e(route('acceptanceStatus')); ?>">
        <i class="fa fa-check-square-o"></i> <span>Acceptance Details</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" <?php if(!$myResignation): ?> title= 'Apply resignation to enable' style="cursor: not-allowed;" <?php endif; ?> class=" <?php echo e(((request()->segment(1) == 'noDueStatus') || (request()->segment(1) == 'questions') ) ? 'active' : ''); ?>">
        <a class="<?php echo e(($myResignation == NULL) ? 'isDisabled' : ' '); ?>" href="<?php echo e(route('noDueStatus')); ?>">
        <i class="fa fa-check-circle-o"></i> <span>No Due Status</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" <?php if(!$myResignation): ?> title= 'Apply resignation to enable' style="cursor: not-allowed;" <?php endif; ?> class=" <?php echo e((request()->segment(1) == 'withdrawForm') ? 'active' : ''); ?>">
        <a class="<?php echo e(($myResignation == NULL) ? 'isDisabled' : ' '); ?>" href="<?php echo e(route('withdrawForm')); ?>">
        <i class="fa fa-file-text-o"></i> <span>Withdraw Form</span>
        </a>
    </li>
    <?php endif; ?>
    <!-- Exit interview sidebar only for HR -->
    <?php if(Auth::User()->department_id == 2): ?>
    <li class=" <?php echo e(((request()->segment(1) == 'questions') || (request()->segment(1) == 'addquestions') ) ? 'active' : ''); ?> ">
        <a href="<?php echo e(route('questions.index')); ?>">
        <i class="fa fa-comments"></i> <span>Exit Interview</span>
        </a>
    </li>
    <li class=" <?php echo e((request()->segment(1) == 'workflow') ? 'active' : ''); ?> ">
        <a href="<?php echo e(route('workflow')); ?>">
        <i class="fa fa-comments"></i> <span>Work Flow</span>
        </a>
    </li>
    <?php endif; ?>

    </ul>
</section>
<?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/common/sidebar.blade.php ENDPATH**/ ?>