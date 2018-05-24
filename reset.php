<?php 
    ob_start();
?>

<?php 
    include_once ("includes/db.php");
    include_once("functions.php");
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Study Drive | Reset Password </title>
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
    
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    
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

<?php 
    if(!isset($_GET['token']) || !isset($_GET['email'])) {
        header("Location: index.php");
    } else{
        $token = $_GET['token'];
        $user_email = $_GET['email'];
        $query = "SELECT * FROM users WHERE token='$token'";
        $checkUser = mysqli_query($connection, $query);
        if(mysqli_num_rows($checkUser) == 0){
            header("Location: index.php");
        }
    }
    if(isset($_POST['change_reset_submit'] ) ) {
        if(!empty($_POST['password']) && !empty($_POST['confirm_password'] ) ) {
            
            $password = $_POST['password'];
            $confirm_pass = $_POST['confirm_password'];
            
            if($password === $confirm_pass) {
                
                $options = [
                    'cost' => 10,
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),            
                ];

                $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
                
                $query = "UPDATE users SET token='', user_password='$hashed_password', updated_at=CURRENT_TIMESTAMP() WHERE token='$token' AND user_email='$user_email'";
                
                $userUpdate = mysqli_query($connection, $query);
                
                confirmQuery($userUpdate);
                
                echo "<h3 class = 'text-center'> Passwords Updated Successfully<br>Please Login And Verify! Please Do not Refresh</h3>" ;
                
                header("refresh: 3, url=index.php");
                
            } else{
                echo "<h3 class = 'text-center'> Passwords Do Not Match</h3>";
            }
        } else{
            echo "<h3 class = 'text-center'> Password Not Entered </h3>";
        }
    }
?>


<html>

<body class="hold-transition login-page" style="overflow: hidden;">
   
    <div class="login-box">
        <div class="login-logo">
            <a href="index.php"><b>STUDY</b>DRIVE</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body custom-form text-center">
           
           <h3><i class="fa fa-lock fa-4x"></i></h3>
            <h2 class="text-center">Reset Password!</h2>
            <p class="login-box-msg">Your New Password Here!</p>
            
            <form action="" id="forgotpassword" method="post" data-parsley-validate>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" id="password" required parsley-type="alphanum" minlength="8" name="password" placeholder="Enter Your password" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" id="confirm_password" required data-parsley-equalto="#password" name="confirm_password" placeholder="Enter Your password Again" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class = "btn btn-lg btn-primary btn-block" name="change_reset_submit" id="change_reset_submit">
                </div>
            </form>

      </div>
      <!-- /.Forgot-body -->
    </div>
    <!-- /.Forgot-box -->

    <!-- jQuery 3 -->
    <script src="login_includes/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="login_includes/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--Parsley JS-->
    <script src="assets/parsleyjs/parsley.min.js"></script>
    
    <script src="assets/js/scripts.js"></script>
    
    <script>
      $(function () {
          
        $('#forgotpassword').parsley();

      });
    </script>
    
    
    </body>



</html>