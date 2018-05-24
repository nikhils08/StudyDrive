<?php 
    session_start();

    include_once("db.php");
    include_once("../functions.php");

    $user_id = $_SESSION['user_id'];

    if(isset($_POST['save_profile'])){
        extract($_POST);
        
        $sql = "UPDATE users SET user_firstname='$user_firstname', user_lastname='$user_lastname', about_me='$user_aboutme', updated_at=CURRENT_TIMESTAMP() WHERE user_id = $user_id";
        $confirm_query = mysqli_query($connection, $sql);
        confirmQuery($confirm_query);
        header("Location: ../user.php");
        
    } else if(isset($_POST['remove_profile_photo'])){
        
        $sql = "UPDATE users SET profile_photo = '', updated_at=CURRENT_TIMESTAMP() WHERE user_id = $user_id";
        $confirm_query = mysqli_query($connection, $sql);
        confirmQuery($confirm_query);
        header("Location: ../user.php");
        
    } else if(isset($_POST['change_profile_photo'])){
        
        $profile_photo = $_FILES['profile_photo']['name'];
        $profile_photo_temp = $_FILES['profile_photo']['tmp_name'];
        move_uploaded_file($profile_photo_temp, "../assets/images/users/$profile_photo");
        
        $sql = "UPDATE users SET profile_photo = '$profile_photo', updated_at=CURRENT_TIMESTAMP() WHERE user_id = $user_id";
        $confirm_query = mysqli_query($connection, $sql);
        confirmQuery($confirm_query);
        header("Location: ../user.php");
        
    }
    
?>