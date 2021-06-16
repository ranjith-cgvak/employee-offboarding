<?php $__env->startSection('content'); ?>

<!-- TABLE: Resignation mail -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title" data-toggle="tooltip" data-placement="bottom" title="Configuration of mail for Resignation based on the department wise. You can assign which departments should recieve resignation mails here!">Resignation Mail</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <input type="hidden" name="mailType" class="mailType" value="Resignation">
                <thead>
                    <th>Department</th>
                    <?php $__currentLoopData = $resignation_departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($title); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </thead>
                <?php $__currentLoopData = $Registation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><b class="department-name"> <?php echo e($key); ?></b></td>
                    <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td>  <input type="checkbox" class="form-input" name="<?php echo e($k); ?>"
                        <?php echo e($col ==1 ? 'checked' : ''); ?>

                        >
                    </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <td> <button type="submit" class="btn btn-primary saveToDb">Save</button>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
    <!-- /.table-responsive -->
    </div>
<!-- /.box-body -->
</div>
<!-- /.box -->
<!-- TABLE: No due mail -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title" data-toggle="tooltip" data-placement="bottom" title="Configuration of no due mails based on the department wise. You can assign which departments should recieve no due mails here!">No Due Mail</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <input type="hidden" class="mailType" value="No Due">
                <thead>
                    <th>Department</th>
                    <?php $__currentLoopData = $resignation_departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($title); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </thead>
                <?php $__currentLoopData = $Nodue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><b class="department-name"> <?php echo e($key); ?></b></td>
                    <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td>  <input type="checkbox" class="form-input" name="<?php echo e($k); ?>"
                        <?php echo e($col ==1 ? 'checked' : ''); ?>

                        >
                    </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <td> <button type="submit" class="btn btn-primary saveToDb">Save</button>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
    </div>
<!-- /.box-body -->
</div>
<!-- /.box -->



<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title" data-toggle="tooltip" data-placement="bottom" title="Configure the department head name, who can access the no dues for the particular department. You can select more than one department head.">Department head configuration for No-dues</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Heads</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $department_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $department_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><b class="department-name"><?php echo e($key); ?></b></td>
                            <td>
                                <div class="form-group department-head-selection" data-selected-user="<?php echo e($department_user['selected_users']); ?>">
                                    <select class="headSelect form-control form-input-head-select" name="departmentLeads[]" multiple="multiple" style="width:100%;">
                                        <?php $__currentLoopData = $department_user['list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </td>
                            <td><button type="submit" class="btn btn-primary headSave">Save</button></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <!-- /.table-responsive -->
    </div>
<!-- /.box-body -->
</div>


<script>
    $(document).ready(function() {
        $('.headSelect').select2();
        //make the selected value on the select options

        //Save regisnation mail and no due mail to DB
        $('.saveToDb').on('click', function() {
            var checkValues = [];
            var checkboxes = $(this).parents("tr").find('.form-input');
            var departmentName = $(this).parents("tr").find('.department-name').text();
            var mailType = $(this).parents("table").find('.mailType').val();
            let formData = {};
            $.each(checkboxes, function(){
                formData[$(this).attr('name')] = $(this).is(':checked');
            });
            console.log(formData);
            formData['departmentName'] = departmentName;
            formData['mailType'] =mailType;
            $.ajax({
                url: "<?php echo e(route('workflowStore')); ?>",
                type: "POST",
                data: {
                    formData,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                cache: false,
                success: function(dataResult){
                    toastr.options.timeOut = 10000;
                    toastr.success(dataResult.message);
                }
            });
        });
        $.each($('.department-head-selection'), function () {
            let selectedUsers = $(this).attr('data-selected-user');
            selectedUsers = JSON.parse(selectedUsers);
            $(this).find('.headSelect').css('border', 'red solid 2px');
            $(this).find('select').val(selectedUsers).trigger('change');
        })
        //To save department heads to DB

        $('.headSave').on('click', function() {
            var checkboxes = $(this).parents("tr").find('.form-input-head-select');
            var departmentName = $(this).parents("tr").find('.department-name').text();
            var mailType = $(this).parents("table").find('.mailType').val();
            let formData = {};
            $.each(checkboxes, function(){
                formData['headValues'] = $(this).val();
            });
            console.log(formData);
            formData['departmentName'] = departmentName;
            formData['mailType'] =mailType;
            console.log(formData);
            $.ajax({
                url: "<?php echo e(route('headSelectStore')); ?>",
                type: "POST",
                data: {
                    formData,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                cache: false,
                success: function(dataResult){
                    toastr.options.timeOut = 10000;
                    toastr.success(dataResult.message);
                }
            });
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/process/workflow.blade.php ENDPATH**/ ?>