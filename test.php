<?php
/**
 * Created by PhpStorm.
 * User: NIKHIL SHADIJA
 * Date: 3/20/2018
 * Time: 2:37 PM
 */

if (isset($_GET['task'])){
    //echo $_POST['user_ids'];
    $user_array[] = $_POST['user_ids'];
    foreach ($user_array as $item) {
        echo $item;
    }
}

?>