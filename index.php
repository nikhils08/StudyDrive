
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in | Study Drive</title>
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
    
    <link rel="stylesheet" href="assets/Background-Slider/sliderResponsive.css">
    
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
<body class="hold-transition login-page" style="overflow: hidden;">
   
    <div class="login-box">
        <div class="login-logo">
            <a href="index.php"><b>STUDY</b>DRIVE</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body custom-form">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="login_includes/login.php" id="loginForm" method="post" data-parsley-validate>
                <div class="form-group has-feedback">
                <input type="email" class="form-control" required parsley-type="email" placeholder="Email" name="user_email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" required placeholder="Password" name="user_password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                      <br>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn custom-outline outline-success btn-block btn-flat" name="login">Sign In</button>
            </div>
            <!-- /.col -->
          </div>

          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                      <a href="forgot.php?forgot=<?php echo uniqid(true); ?>"> I forgot my password</a><br>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
              <a type="button" class="btn custom-outline outline-primary btn-block btn-flat" href="register.php#registerDiv">Register</a>
            </div>
            <!-- /.col -->
          </div>

        </form>

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

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
          
        $('#loginForm').parsley();
          
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
    
    
    </body>
    </html>
