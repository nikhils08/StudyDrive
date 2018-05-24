<?php
    define("SERVER","localhost");
    define("USER","Nikhil");
    define("PASSWORD","n20081998");
    define("DB","studyshare");
    $connection=mysqli_connect(SERVER,USER,PASSWORD,DB);
    
    if($connection){
       // echo "We are connected!!";
    }
?>