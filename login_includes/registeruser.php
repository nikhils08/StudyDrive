<?php
    include_once("../includes/db.php");
    include_once("../functions.php");
    session_start();
    
    if(isset($_POST['register_user'])){
        extract($_POST);
        
        if(empty($user_email) || empty($user_firstname) || empty($user_lastname) || empty($user_confirm) || empty($user_password) || empty($user_aboutme) ){
            echo "<h3 class = 'text-center'>Some Values Missing</h3>";
        } else{

            $user_firstname = mysqli_real_escape_string($connection, $user_firstname);
            $user_email = mysqli_real_escape_string($connection, $user_email);
            $user_lastname = mysqli_real_escape_string($connection, $user_lastname);
            $user_confirm = mysqli_real_escape_string($connection, $user_confirm);
            $user_password = mysqli_real_escape_string($connection, $user_password);
            $user_about = mysqli_real_escape_string($connection, $user_aboutme);
            
            if($user_confirm === $user_password){
                
                $query = "SELECT * FROM users WHERE user_email = '$user_email'";
                $checkuseremail = mysqli_query($connection, $query);
                confirmQuery($checkuseremail);
                
                if(mysqli_num_rows($checkuseremail) > 0){
                    echo "<h2 class = 'text-center'>User Already Exists</h2>";
                    header("refresh: 2, url=../register.php#registerDiv");
                } else{
                    $options = [
                        'cost' => 10,
                        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),            
                    ];

                    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, $options);

                    $query = "INSERT INTO users (user_firstname, user_lastname, user_email, user_password, about_me) VALUES ('$user_firstname', '$user_lastname', '$user_email', '$hashed_password', '$user_about')";

                    $add_user_query = mysqli_query($connection, $query);

                    confirmQuery($add_user_query);
                    
                    $query = "SELECT * FROM users WHERE user_email = '$user_email'";
                    
                    $get_user_id = mysqli_query($connection, $query);
                    
                    confirmQuery($get_user_id);
                    
                    if($row = mysqli_fetch_assoc($get_user_id)){
                        extract($row);
                        $query = "INSERT INTO files(isdirectory, created_by, file_name) VALUES (1, $user_id, '$user_email')";
                        $add_user_file = mysqli_query($connection, $query);
                        confirmQuery($add_user_file);
                    }
                    
                    echo "<h2 class = 'text-center'> User Registered Successfully. Please Login To Enjoy Our Services</h2>";

                    header("refresh: 2, url=../index.php");

                }
            
            } else{
                echo "<h2 class = 'text-center'> Passwords Do Not Match</h2>";
            }
                
        }
        
        
    }

?>
