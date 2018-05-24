<?php 

    include_once("functions.php");

    $date = new DateTime();
    $time_stamp= $date->getTimestamp();

    $allFiles=scanDirectories('C:\Users\user\Desktop\NIKHIL\Vishal');
    /***************************************************************change 
    the folder name with foldernameand timestamp*/


    /*run for all the files*/
    foreach ($allFiles as $file) {
        echo "$file <br>";
    }
?>