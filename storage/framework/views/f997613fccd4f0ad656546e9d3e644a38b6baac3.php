

<?php $__env->startSection('content'); ?>


<!-- Add questions form -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary formBox">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Question</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="<?php echo e(route('addquestions.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="question_number" class="col-sm-2 form-label">Question Number<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly="true" required name="question_number" id="question_number" value="<?php echo e($count); ?>">
                                <?php $__errorArgs = ['question_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="question" class="col-sm-2 form-label">Question <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" required name="question" id="question">
                                <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="question_type" class="col-sm-2 form-label">Question Type <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <select id="selectBox" class="form-control " name="question_type" onchange="changeFunc();">
                                    <option value="0">--Select--</option>

                                    <?php $__currentLoopData = $QuestionType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $QuestionTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($QuestionTypes->id); ?>"><?php echo e($QuestionTypes->type); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['question_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe1">
                            <label for="question" class="col-sm-2 form-label">Option-1 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="1" id="option-1">
                                <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe2">
                            <label for="question" class="col-sm-2 form-label">Option-2 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="2" id="option-2">
                                <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe3">
                            <label for="question" class="col-sm-2 form-label">Option-3 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="3" id="option-3">
                                <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row" style="display: none" id="textboxe4">
                            <label for="question" class="col-sm-2 form-label">Option-4 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="4" id="option-4">
                                <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <br>
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger"></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" id="myBtn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    function changeFunc() {
        var selectBox = document.getElementById("selectBox");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if (selectedValue == 2) {
            $('#textboxe1').show();
            $('#textboxe2').show();
            $('#textboxe3').show();
            $('#textboxe4').show();
            $("#option-1").val("");
            $("#option-2").val("");
        } else {
            $('#textboxe1').hide();
            $('#textboxe2').hide();
            $('#textboxe3').hide();
            $('#textboxe4').hide();
        }
        if (selectedValue == 3) {
            $('#textboxe1').show();
            $('#textboxe2').show();
            $("#option-1").val("Yes");
            $("#option-2").val("No");
        }

    }
</script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/questions/create.blade.php ENDPATH**/ ?>