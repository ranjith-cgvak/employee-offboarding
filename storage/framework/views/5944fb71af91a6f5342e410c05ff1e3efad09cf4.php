

<?php $__env->startSection('content'); ?>


<?php if(session()->get('success')): ?>
<div class="alert alert-success">
    <?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>
<?php if(\Auth::User()->department_id == 2): ?>

<!-- My resignation details -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Exit Interview Question List</h3>
                    <a href="<?php echo e(route('addquestions.index')); ?>" class="btn btn-primary" style="float: right;">Add Question</a>
                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive ">
                    <table class="table table-hover">
                        <tr>
                            <th width=5%>Question Number</th>
                            <th>Question</th>
                            <th>Options</th>
                            <th>Action</th>
                        </tr>

                        <?php $__currentLoopData = $Question; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $Question_options = \DB::table('options')
                            ->where('question_id', $questions->id)
                            ->get(); ?>

                        <tr>
                            <td><?php echo e($questions->question_number); ?></td>
                            <td><?php echo e($questions->questions); ?></td>
                            <td> <?php $__currentLoopData = $Question_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <ul>
                                    <li><?php echo e($options->option_value); ?></li>
                                </ul></b>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                            <td><a href="<?php echo e(route('questions.edit', $questions->id )); ?>" class="btn btn-primary">Edit</a>&nbsp;<a href="<?php echo e(url('deletequestion/'.$questions->id)); ?>" class="btn btn-primary">Delete</a></td>
                        </tr> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>


<?php else: ?>
<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Exit Interview questions</h3>
        </div>

        <form method="post" action="<?php echo e(route('questions.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="box-body">

                <?php $__currentLoopData = $Question; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $Question_options = \DB::table('options')
                    ->where('question_id', $questions->id)
                    ->get(); ?>

                <div class="form-group row"><br>
                    <label for="withdrawDate" class="col-sm-8  form-label"><?php echo e($questions->id); ?>. <?php echo e($questions->questions); ?> <span class="text-danger">*</span></label>
                    <br>
                    <div class="col-sm-8">
                        <?php if($questions->question_type == 1): ?>
                        <input type="text" name="<?php echo e($questions->id); ?>" required class="form-control">
                        <?php elseif($questions->question_type == 2): ?>
                        <?php $__currentLoopData = $Question_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="radio" class=" <?php echo e($questions->id); ?>" required name="<?php echo e($questions->id); ?>" value="<?php echo e($options->option_value); ?>" id="<?php echo e($options->question_id); ?><?php echo e($options->id); ?>">
                        <label class="radio-custom-label" for="<?php echo e($questions->question_id); ?><?php echo e($questions->id); ?>">
                            <b> <?php echo e($options->option_value); ?></b>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif($questions->question_type == 3): ?>
                        <?php $__currentLoopData = $Question_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="radio" id="chk<?php echo e($options->option_value); ?>" required name="<?php echo e($questions->id); ?>" value="<?php echo e($options->option_value); ?>" onclick="ShowHideDiv()">
                        <label class="radio-custom-label" for="<?php echo e($questions->question_id); ?><?php echo e($questions->id); ?>">
                            <b> <?php echo e($options->option_value); ?></b>
                        </label>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div id="dvtext" style="display: none">
                            <label class="radio-custom-label" for="<?php echo e($questions->question_id); ?><?php echo e($questions->id); ?>">
                                <b> Specify If Yes.</b>
                            </label>
                            <input type="text" id="txtBox" name="<?php echo e($questions->id); ?>" class="form-control">

                        </div>
                        <div id="dv1text" style="display: none">

                            <input type="hidden" id="txtBox" name="<?php echo e($questions->id); ?>" value="No" class="form-control">

                        </div>
                        <?php elseif($questions->question_type == 4): ?>
                        <input type="date" name="<?php echo e($questions->id); ?>" required class="form-control">
                        <?php endif; ?>
                        <?php $__errorArgs = ['withdrawDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <br>
                        <span class="invalid-feedback" role="alert">
                            <strong class="text-danger"><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div><?php endif; ?>

<!-- Exit Interview questions -->
<script>
    function ShowHideDiv() {
        var chkYes = document.getElementById("chkYes");
        var dvtext = document.getElementById("dvtext");
        var dv1text = document.getElementById("dv1text");
        dvtext.style.display = chkYes.checked ? "block" : "none";
        dv1text.style.display = chkYes.checked ? "none" : "block";
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\employee-offboarding\resources\views/resignation/questions.blade.php ENDPATH**/ ?>