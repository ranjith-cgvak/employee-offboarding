<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
    <li>
        <a href="<?php echo e(route('resignation.create')); ?>">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <?php if(Auth::user()->designation == 'Software Engineer'): ?>
    <li data-toggle="tooltip" data-placement="right" <?php if(!$myResignation): ?> title= 'Apply resignation to enable' <?php endif; ?> >
        <a class="<?php echo e(($myResignation == NULL) ? 'isDisabled' : ' '); ?>" href="<?php echo e(route('resignation.index')); ?>">
        <i class="fa fa-list-alt"></i> <span>My Resignation</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" <?php if(!$myResignation): ?> title= 'Apply resignation to enable' <?php endif; ?>>
        <a class="<?php echo e(($myResignation == NULL) ? 'isDisabled' : ' '); ?>" href="<?php echo e(route('acceptanceStatus')); ?>">
        <i class="fa fa-check-square-o"></i> <span>Acceptance Details</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" <?php if(!$myResignation): ?> title= 'Apply resignation to enable' <?php endif; ?>>
        <a class="<?php echo e(($myResignation == NULL) ? 'isDisabled' : ' '); ?>" href="<?php echo e(route('withdrawForm')); ?>">
        <i class="fa fa-file-text-o"></i> <span>Withdraw Form</span>
        </a>
    </li>
    <?php endif; ?>
    </ul>
</section><?php /**PATH C:\xampp\htdocs\employee-offboarding\resources\views/common/sidebar.blade.php ENDPATH**/ ?>