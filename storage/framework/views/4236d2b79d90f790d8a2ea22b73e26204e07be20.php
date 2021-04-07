<?php $__env->startSection('content'); ?>

<!-- Listing the resignations -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Employee Resignation List</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                    </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Employee ID</th>
                  <th>Employee Name</th>
                  <th>Designation</th>
                  <th>DOR</th>
                  <th>DOL</th>
                  <th>Status</th>
                  <th>View</th>
                  <!-- Assiging lead by head -->
                  <?php if(Auth::user()->designation_id == 3): ?>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp; Assign Lead</th>
                  <?php endif; ?>
                </tr>
                <?php $__currentLoopData = $emp_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($emp->employee_id); ?></td>
                  <td><?php echo e($emp->display_name); ?></td>
                  <td><?php echo e($emp->designation); ?></td>
                  <td><?php echo e($emp->date_of_resignation); ?></td>
                  <td><?php echo e(($emp->changed_dol == NULL) ? $emp->date_of_leaving : $emp->changed_dol); ?></td>
                  <td><span class="label <?php echo e(($emp->date_of_withdraw != NULL) ? 'label-danger' :($emp->is_completed == 1 ? 'label-success' : ($emp->lead ==NULL ? 'label-primary': 'label-warning' ))); ?>"><?php echo e(($emp->date_of_withdraw != NULL) ? 'Withdrawn' :($emp->is_completed == 1 ? 'Completed' : ($emp->lead ==NULL ? 'New': 'On-Progress' ) )); ?></span></td>
                  <td><a href="<?php echo e(route('process.edit', $emp->id )); ?>">View</a></td>
                  <!-- Assiging lead form by head -->
                  <?php if(Auth::user()->designation_id == 3): ?>
                  <form method="post" action="<?php echo e(route('process.update' , $emp->employee_id )); ?>">
                  <td>
                    <?php echo csrf_field(); ?>
                    <?php echo e(method_field('PUT')); ?>

                    <div class="form-group">
                        <div class="col-sm-6">
                        <select class="form-control" name="lead" id="lead">
                        <?php if($emp->lead == NULL): ?>
                        <option value="<?php echo e(($emp->lead == NULL) ? '' : $emp->lead); ?>"><?php echo e(($emp->lead == NULL) ? 'Select' : $emp->lead); ?></option>
                        <?php endif; ?>
                          <?php $__currentLoopData = $lead_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($lead->display_name); ?>" <?php echo e(($emp->lead == $lead->display_name) ? 'selected' : ""); ?>><?php echo e($lead->display_name); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        </div>
                        <div class="col-sm-1">
                          <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                      </div>
                  </td>
                  </form>
                  <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/process/resignationList.blade.php ENDPATH**/ ?>