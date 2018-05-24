<?php

    include_once("db.php");
    include_once("../functions.php");


    if( isset( $_POST['file_info_id'] ) ) {
        $file_id = $_POST['file_info_id'];
        
        $sql = "SELECT * FROM files WHERE file_id = $file_id";
        $result_set = mysqli_query($connection, $sql);
        confirmQuery($result_set);
        
        if($row = mysqli_fetch_assoc($result_set)) {
            extract($row);
            
            $inner_query = "SELECT * FROM users WHERE user_id = $created_by";
            $inner_result = mysqli_query($connection, $inner_query);
            confirmQuery($inner_result);
            
            $get_last_updated_by_query = "SELECT * FROM users WHERE user_id = $updated_by";
            $updated_result = mysqli_query($connection, $get_last_updated_by_query);
            if($update_row = mysqli_fetch_assoc($updated_result)){
                $updated_user_firstname = $update_row['user_firstname'];
                $updated_user_lastname = $update_row['user_lastname'];
                $updated_user_email = $update_row['user_email'];
            }
            
            if($inner_row = mysqli_fetch_assoc($inner_result)){
                $user_firstname = $inner_row['user_firstname'];
                $user_lastname = $inner_row['user_lastname'];
                $user_emailID = $inner_row['user_email'];

            }
            
            $blob_query="select * from filecontents where blob_id=$blob_id";
            $file_size_query=mysqli_query($connection,$blob_query);
            confirmQuery($file_size_query);
            $brow=mysqli_fetch_assoc($file_size_query);
            $blob_size=$brow['blob_size'];
            
            if( ( $blob_size / 1024) / 1024 / 1024 > 0.9 ) {
                $size = ( ( $blob_size / 1024) / 1024 / 1024 );
                $size = round($size_gb , 2) . "GB";
            } else if(($blob_size / 1024) > 1024){
                $size = ceil(($blob_size / 1024) / 1024) . " MB";
            } 
            else{
                $size = ceil($blob_size / 1024) . " KB";
            }
            
            if($isdirectory == 0){
                echo " <strong>File Name</strong>: $file_name <br> <strong>Created At</strong>: $created_at <br> <strong>Last Modified</strong>: $updated_at <br> <strong>File Owner</strong>: $user_firstname $user_lastname &lt;$user_emailID&gt; <br> <strong>File Size</strong>: $size <br> <strong>Last Modified By</strong>: $updated_user_firstname $updated_user_lastname &lt;$updated_user_email&gt;";
            } else{
                echo " <strong>Folder Name</strong>: $file_name <br> <strong>Created At</strong>: $created_at <br> <strong>Last Modified</strong>: $updated_at <br> <strong>Folder Owner</strong>: $user_firstname $user_lastname &lt;$user_emailID&gt; <br> <strong>Last Modified By</strong>: $updated_user_firstname $updated_user_lastname &lt;$updated_user_email&gt;";
            }
        }
        
    } else if(isset($_GET['task'])){
        $task = $_GET['task'];
        if($task == "group_share"){
            $group_ids_string = $_POST['group_ids'];
            $group_ids_array = explode(",", $group_ids_string);
            $users_array="";
            foreach ($group_ids_array as $group_id){
                $users_query = "SELECT * FROM group_users WHERE group_id = $group_id";
                $user_selected_ids = mysqli_query($connection, $users_query);
                confirmQuery($user_selected_ids);
                $row_count=mysqli_num_rows($user_selected_ids);
                $i=1;
                while($row = mysqli_fetch_assoc($user_selected_ids)){
                    $current_user = $row['user_id'];
                    if($i!=$row_count)
                        $users_array .= $current_user . ",";
                    else
                        $users_array .= $current_user;
                    $i++;
                }
            }
            echo $users_array;
        }
    }
?>
