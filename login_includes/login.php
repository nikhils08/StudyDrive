<head>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
</head>

<?php
    include_once("../includes/db.php");
    include_once("../functions.php");
    session_start();
    if(isset($_POST['login'])){

        $user_email=$_POST['user_email'];
        $user_password=$_POST['user_password'];

        $query="select * from users where user_email='$user_email'";
        $select_user_details=mysqli_query($connection,$query);
        confirmQuery($select_user_details);

        if($row=mysqli_fetch_assoc($select_user_details)){    
            $db_user_id=$row['user_id'];
            $db_user_email=$row['user_email'];
            $db_user_firstname = $row['user_firstname'];
            $db_hashed_password=$row['user_password'];
            $file_id=get_user_file_id($db_user_email);   
            $db_token = $row['token'];
        }

        if(password_verify($user_password,$db_hashed_password) && $user_email===$db_user_email){
            $_SESSION['user_email']=$db_user_email;
            $_SESSION['user_id']=$db_user_id;
            $_SESSION['file_id']=$file_id;
            $_SESSION['user_firstname']=$db_user_firstname;

            $date = new DateTime();
            $today = date_format($date, 'Y-m-d');

            $update_user_activity_query = "INSERT INTO users_activity(user_id, logged_in_time, logged_out_time) VALUES ($db_user_id, CURRENT_TIMESTAMP(), '$today 23:59:59')";
            $update_user_activity = mysqli_query($connection, $update_user_activity_query);
            confirmQuery($update_user_activity);
            $current_activity_id = $connection->insert_id;
            $_SESSION['current_activity_id'] = $current_activity_id;

            //echo $file_id;
            if($db_token == ""){
                header("Location: ../dashboard.php");
            } else{
                echo "<div class='text-center'><h3 class='text-center'>Cannot Login! <br> You have Either Not Verified Email Or Requested For Password Change</h3></div>";
                header("refresh: 5, url=../index.php");
            }
        }else{
            header("Location: ../index.php");
        }

    }
?>
