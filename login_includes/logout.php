<?php 
    session_start();

    include_once("../includes/db.php");
    include_once("../functions.php");

    $_SESSION['user_email']=null;
    $_SESSION['user_id']=null;
    $_SESSION['user_firstname']=null;
    $_SESSION['file_id']=null;

    $current_activity_id = $_SESSION['current_activity_id'];
    $update_user_activity_query = "UPDATE users_activity SET logged_out_time=CURRENT_TIMESTAMP() WHERE ua_id = $current_activity_id";
    $update_user_activity = mysqli_query($connection, $update_user_activity_query);
    confirmQuery($update_user_activity);

    $_SESSION['current_activity_id']=null;

    session_destroy();

    header("Location: ../index.php");

?>