

<?php $__env->startSection('content'); ?>

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
                  <th>&nbsp;&nbsp;&nbsp;&nbsp; Assign Lead</th>
                </tr>
                <?php $__currentLoopData = $emp_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($emp->user_id); ?></td>
                  <td><?php echo e($emp->name); ?></td>
                  <td><?php echo e($emp->designation); ?></td>
                  <td><?php echo e($emp->date_of_resignation); ?></td>
                  <td><?php echo e($emp->date_of_leaving); ?></td>
                  <td><span class="label <?php echo e(($emp->date_of_withdraw != NULL) ? 'label-danger' : 'label-primary'); ?>"><?php echo e(($emp->date_of_withdraw != NULL) ? 'Withdrawn' : 'New'); ?></span></td>
                  <td><a href="<?php echo e(route('process.edit', $emp->id )); ?>">View</a></td>
                  <td>
                    <form method="post" action="<?php echo e(route('process.update' , $emp->user_id )); ?>" style="display: <?php echo e(($emp->lead != NULL) ? 'none' : ' '); ?> ; ">
                      <?php echo csrf_field(); ?>
                      <?php echo e(method_field('PUT')); ?>

                      <div class="form-group">
                        <div class="col-sm-6">
                        <select class="form-control" name="lead" id="lead">
                          <option value="">Select</option>
                          <?php $__currentLoopData = $lead_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($lead->name); ?>"><?php echo e($lead->name); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        </div>
                        <div class="col-sm-1">
                          <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                      </div>
                    </form>
                    <?php echo e($emp->lead); ?>

                  </td>
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

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\gowthamraj\Documents\employee-offboarding\resources\views/head/resignationList.blade.php ENDPATH**/ ?>