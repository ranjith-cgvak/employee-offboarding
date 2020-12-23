

<?php $__env->startSection('content'); ?>


<!-- edit questions form -->

<?php if(Auth::User()->department_id == 2): ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary formBox">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Question</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="<?php echo e(route('questions.update',$questions->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo e(method_field('PUT')); ?>

                    <div class="box-body">
                        <div class="form-group row">
                            <label for="question_number" class="col-sm-2 form-label">Question Number<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly="true" required name="question_number" id="question_number" value="<?php echo e($questions->question_number); ?>">
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
                                <input type="text" class="form-control" required name="question" id="question" value="<?php echo e($questions->questions); ?>">
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
                                    <option value="<?php echo e($questions->question_type); ?>"><?php echo e($questions->type); ?></option>

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
                            </div><?php $i = 0; ?>
                        </div>
                        <?php $__currentLoopData = $Question_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                        <div class="form-group row" style="display: none" <?php echo e($i++); ?> id="textboxe<?php echo e($i); ?>">
                            <label for="question" class="col-sm-2 form-label">Option-<?php echo e($i); ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="<?php echo e($question_option->option_value); ?>" name="<?php echo e($i); ?>" id="option-<?php echo e($i); ?>">
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
                        </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($questions->question_type==3): ?>
                        <div class="form-group row" style="display: none" id="textboxe3">
                            <label for="question" class="col-sm-2 form-label">Option-3 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="3" id="option-3">
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
                                <input type="text" class="form-control" name="4" id="option-4">
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
                        <?php endif; ?>
                        <?php if($questions->question_type==1 || $questions->question_type== 4): ?>
                        <div class="form-group row" style="display: none" id="textboxe1">
                            <label for="question" class="col-sm-2 form-label">Option-1 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="1" id="option-1">
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
                                <input type="text" class="form-control" name="2" id="option-2">
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
                                <input type="text" class="form-control" name="3" id="option-3">
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
                                <input type="text" class="form-control" name="4" id="option-4">
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
                        <?php endif; ?>
                        <div class="form-group row" style="display: none" id="textboxe5">
                            <label for="question" class="col-sm-2 form-label">Option-1 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="5" id="option-5">
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
                        <div class="form-group row" style="display: none" id="textboxe6">
                            <label for="question" class="col-sm-2 form-label">Option-2 <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="6" id="option-6">
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
                        <div class="col-6"></div>
                        <div class="col-6">
                            <button type="submit" id="myBtn" class="btn btn-primary ">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script type="text/javascript">
    function changeFunc() {
        var selectBox = document.getElementById("selectBox");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if (selectedValue == 2) {
            $('#textboxe1').show();
            $('#textboxe2').show();
            $('#textboxe3').show();
            $('#textboxe4').show();

        } else {
            $('#textboxe1').hide();
            $('#textboxe2').hide();
            $('#textboxe3').hide();
            $('#textboxe4').hide();
        }
        if (selectedValue == 3) {
            $('#textboxe5').show();
            $('#textboxe6').show();
            $("#option-5").val("Yes");
            $("#option-6").val("No");
        } else {
            $('#textboxe5').hide();
            $('#textboxe6').hide();
        }

    }
</script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\employee-offboarding\resources\views/questions/edit.blade.php ENDPATH**/ ?>