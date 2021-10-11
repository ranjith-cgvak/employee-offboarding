<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee offboarding</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/font-awesome/css/font-awesome.min.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('css/AdminLTE.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo e(asset('css/_all-skins.min.css')); ?>">
    <!-- Custom style -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
            rel = "stylesheet">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- Toaster CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery 3 -->
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <!-- <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script> -->
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo e(asset('vendor/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo e(asset('js/adminlte.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CV</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo e(asset('img/cg-logo-01.png')); ?>"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav-custom pull-right">
          <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="<?php echo e(asset('img/placeholders/avatars/avatar9.jpg')); ?>"  class="img-circle" height="30" width="30" alt="avatar">
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li class="dropdown-header">
                <strong>Hi <?php echo e(Auth::user()->name); ?> </strong>
              </li>
              <li>
                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                Log out <i class="fa fa-power-off fa-fw"></i>
                </a>
                <form id="frm-logout" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                  <?php echo e(csrf_field()); ?>

                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php echo $__env->make('common.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  
  <div class="<?php echo e(Request::is('workflow') ? 'content-wrapper-workFlow' : ''); ?> content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
    <?php echo $__env->yieldContent('content'); ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
     All rights
    reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->




<!-- Toaster CDN -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js">
</script>

<script>

  <?php if(Session::has('message')): ?>
  var type = "<?php echo e(Session::get('alert-type', 'info')); ?>"
  switch(type){
  case 'info':

  toastr.options.timeOut = 10000;
  toastr.info("<?php echo e(Session::get('message')); ?>");
  break;
  case 'success':

  toastr.options.timeOut = 10000;
  toastr.success("<?php echo e(Session::get('message')); ?>");

  break;
  case 'warning':

  toastr.options.timeOut = 10000;
  toastr.warning("<?php echo e(Session::get('message')); ?>");

  break;
  case 'error':

  toastr.options.timeOut = 10000;
  toastr.error("<?php echo e(Session::get('message')); ?>");

  break;
  }
  <?php endif; ?>


  $( function() {
    $( ".jquery-datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: 0,
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0), ''];
        },
        onSelect : function(dateText, inst) {
        var date = $(this).datepicker('getDate');
        if($.datepicker.formatDate('DD', date) =='Saturday')
            toastr.warning("You have selected Saturday. Please check whether it is working day or not");
        }
    });
  } );

  $(function(){
      //HR EXIT INTERVIEW
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var tableBody = $(".table_body_wrap");
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
      if(x < max_fields){ //max input box allowed
        x++; //text box increment
        // $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        $(tableBody).append(`
        <tr>
        <td>
            <input type="text" name='hr_exitinterview_comment[]' class="form-control" required>
        </td>
        <td>
            <select name="hr_exitinterview_actionarea[]" class="form-control" required>
                <option value="">Select</option>
                <option value="Salary">Salary</option>
                <option value="Leave and Holiday">Leave and Holiday</option>
                <option value="Benifits">Benifits</option>
            </select>
        </td>
        <td>
        <button type="button" class="remove_field btn btn-danger">Remove</button>
        <td>
        </tr>
        `);
      }

    });

    $(tableBody).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('td').parent('tr').remove(); x--;
    })
  })
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Office projects\employee-offboarding\resources\views/layouts/app_home.blade.php ENDPATH**/ ?>