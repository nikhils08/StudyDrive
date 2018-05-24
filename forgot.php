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
    <title>Study Drive | Forgot Password </title>
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
    if(!isset($_GET['forgot'] ) ) {
        header("Location: index.php");
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['email'] ) ) {
            $email = $_POST['email'];
            $length = 500;
            $token = bin2hex(openssl_random_pseudo_bytes($length));
            
            $query = "SELECT * FROM users WHERE user_email = '$email'";
            $user = mysqli_query($connection, $query);
            confirmQuery($user);
            
            if(mysqli_num_rows($user) == 1){
                $query = "UPDATE users SET token = '$token' WHERE user_email = '$email'";
                $updateToken = mysqli_query($connection, $query);
                confirmQuery($updateToken);
                
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: Study Drive <hepdesk@studydrive.com>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
                $to = $_POST['email'];
        
                $subject ="Study Drive Change Password";
        
                $body = "Please Click the Link below to reset password<br> <a href = 'http://localhost/studyshare/ui/reset.php?email=$email&token=$token'>Reset Password</a>";
        
                mail($to, $subject, $body, $headers);
                
                echo "<h3 class = 'text-center'>An Email Has Been Sent Please Check And Change Password</h3>";
                
            } else{
                echo "<h3 class = 'text-center'>Some Issue with Email! No Such User Found</h3>";
            }
            
        } else{
            echo "<h3 class = 'text-center'>Email Was Not Entered</h3>";
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
            <h2 class="text-center">Forgot Password?</h2>
            <p class="login-box-msg">Reset Your Password Here!</p>
            <form action="" id="forgotpassword" method="post" data-parsley-validate>
                <div class="form-group has-feedback input-group">
                   <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="email" id="email" name="email" required parsley-type="email" placeholder="Enter Your Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class = "btn btn-lg btn-primary btn-block" name="reset_submit" id="reset_submit">
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