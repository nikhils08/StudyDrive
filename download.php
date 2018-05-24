<?php

    include_once("includes/db.php");
    include_once("functions.php");
    session_start();

    if(isset($_GET['file_id'])){
        $date = new DateTime();
        $time_stamp= $date->getTimestamp();
        
        $get_file_id=$_GET['file_id'];

        $u_id=check_user();
        check_file_owner($get_file_id);

        $session_user_id=$_SESSION['user_id'];

        $query="SELECT * FROM files WHERE file_id=$get_file_id";
        $parent_query=mysqli_query($connection,$query);
        confirmQuery($parent_query);
        $row=mysqli_fetch_assoc($parent_query);

        $is_directory=$row['isdirectory'];
        $file_name=$row['file_name'];
        $parent_file_id=$row['parent_file_id'];

        if ($is_directory=='0') {
            /*This means we have to download a file*/

            $blob_id=$row['blob_id'];

            $query="SELECT * FROM filecontents WHERE blob_id=$blob_id";
            $blob_query=mysqli_query($connection,$query);
            confirmQuery($blob_query);
            $row=mysqli_fetch_assoc($blob_query);


            $blob_path=$row['blob_path'];
            $blob_size=$row['blob_size'];

            $file_path="allfiles/".$blob_path;

            $content_type=mime_content_type($file_path);



            header('Content-Description: File Transfer');
            header("Content-Type: $content_type");
            header('Content-Disposition: attachment; filename="'.$file_name.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
        
        }else if($is_directory=='1'){

            /*THis means we have to download folder*/

            $zip = new ZipArchive();

            if ($zip->open($time_stamp.$file_name.'.zip', ZipArchive::CREATE)!==TRUE) {
                exit("cannot open $file_name\n");
            }
            
            /*outut zip creates the zip of the selected folder and stores it 
            it requires the zip object and the file id which we want to download*/
            outputZip($get_file_id,$zip,$get_file_id);
            $zip->close();

            header("Content-type: application/zip"); 
            header("Content-Disposition: attachment; filename=$file_name.zip");
            header("Content-length: " . filesize($time_stamp.$file_name.'.zip'));
            header("Pragma: no-cache"); 
            header("Expires: 0"); 
            readfile($time_stamp.$file_name.'.zip');
            $no_use=unlink($time_stamp.$file_name.'.zip');/*PREVENT FROM ECHO*/
        } 
    }
?>