<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Study Drive | Register User</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="login_includes/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="login_includes/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="login_includes/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="login_includes/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="login_includes/iCheck/square/blue.css">
  
  <link rel="icon" type="image/png" href="assets/images/favicon.png">
  
  <link rel="stylesheet" href="assets/css/styles.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page"  id="registerDiv" style="overflow: hidden;">
<div class="register-box">
  <div class="register-logo">
    <a href="index.php"><b>STUDY</b>DRIVE</a>
  </div>

  <div class="register-box-body custom-form">
    <p class="login-box-msg">Register Yourself</p>

    <form action="login_includes/registeruser.php" method="post" id="registerForm">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" required placeholder="First Name" name="user_firstname">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="text" class="form-control" required placeholder="Last Name" name="user_lastname">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="email" class="form-control" required parsley-type="email" placeholder="Email" name="user_email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="password" class="form-control" required parsley-type="alphanumeric" minlength="8" placeholder="Password" id="user_password" name="user_password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="password" class="form-control" required data-parsley-equalto="#user_password" placeholder="Retype password" name="user_confirm">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <textarea name="user_aboutme" id="" cols="" rows="" style="resize: none;" placeholder="About Yourself" required class="form-control"></textarea>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      
      
      <div class="row">
       
       <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" id="termsConditions"><span style="font-size: 16px;"> I agree to the <a href="#">terms</a></span>
            </label>
          </div>
        </div>
       
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="register_user" name="register_user" disabled>Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <h4>Already A Member?<a href="index.php" class="text-center"> Log In</a></h4> 
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="login_includes/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="login_includes/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="login_includes/iCheck/icheck.min.js"></script>

<!--Parsley JS-->
<script src="assets/parsleyjs/parsley.min.js"></script>

<script src="assets/js/scripts.js"></script>

<script>
  $(function () {
    $('#registerForm').parsley();
      
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    
});
</script>
</body>
</html>