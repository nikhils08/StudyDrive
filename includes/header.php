<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo $title; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <!--     Fonts and icons     -->
<!--    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />-->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,700" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/uitoastr/toastr.css" type="text/css">
    <?php 
        if($page == "mydrive" || $page == "shared") {
    ?>
            <link rel="stylesheet" href="assets/select2/dist/css/select2.min.css">
            <!-- iCheck -->
            <link rel="stylesheet" href="login_includes/iCheck/square/blue.css">
    <?php
        }
    ?>
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="assets/css/now-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
    <!-- Custom CSS Files-->
    <link rel="stylesheet" href="assets/css/styles.css">
    
    <link rel="stylesheet" href="assets/sweet-alert/sweetalert2.min.css">
    
    <?php
        session_start();
    
        include_once("includes/db.php");
        include_once("functions.php");
    
        $session_user_id=check_user();
    ?>
    
</head>