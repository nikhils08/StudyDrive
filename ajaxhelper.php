<?php
    include_once("includes/db.php");
    include_once("functions.php");
    session_start();
    $session_user_id=$_SESSION['user_id'];

    if (isset($_POST['get_file_count'])){
        $files_user_id = $_POST['get_file_count'];
        $query = "SELECT COUNT(*) FROM files WHERE created_by =  $files_user_id";
    }

    if(isset($_GET['task'])){
        $task=$_GET['task'];



        if($task=='fileexists'){

            $parent_file_id=$_GET['parent_file_id'];
            $file_name=$_GET['file_name'];
            echo "$parent_file_id";
            echo "$file_name";

            $query="Select * from files where parent_file_id=$parent_file_id and file_name='$file_name'";
            $file_exists_query=mysqli_query($connection,$query);
            $rowCount=mysqli_num_rows($file_exists_query);

            echo $rowCount;
            if($rowCount>=1){
                echo "true";
            }else
                echo "false";

        }else if($task=='get_notification'){

            $query = "SELECT * from notification join userfiletokens join usertokens join shares where notification.notify=1 and notification.user_file_tokens_id=userfiletokens.user_file_tokens_id and userfiletokens.user_token_id=usertokens.user_token_id and shares.share_id=usertokens.share_id and usertokens.user_id=$session_user_id";
            $notification_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($notification_query)){
                $share_user_id=$row['share_user_id'];
                $noti_id=$row['noti_id'];
                $user_file_token_file_id=$row['user_file_token_file_id'];
                echo "$share_user_id[0] shared $user_file_token_file_id with you\n";
                $query="UPDATE notification SET notify=0 WHERE noti_id=$noti_id";
                $update_query=mysqli_query($connection,$query);
            }

        }else if($task=='share'){

            $share_user_array=array();

            if(isset($_GET['group'])){
                $group_ids_string = $_POST['group_ids'];

                $group_user_query = "SELECT DISTINCT * FROM group_users WHERE group_id in (".$group_ids_string.")";
                $user_selected_ids = mysqli_query($connection, $group_user_query);
                confirmQuery($user_selected_ids);
                while($row = mysqli_fetch_assoc($user_selected_ids))
                    array_push($share_user_array,$row['user_id']);

            }else{
                $share_user_array_string = $_POST['user_ids'];

                $share_user_array=explode(",",$share_user_array_string);

            }

            $share_file_array_string = $_POST['file_ids'];

            $share_file_array=explode(",",$share_file_array_string);

            $validity=$_POST['valid_time'];
            $validity_type=$_POST['valid_type'];


            /*Array of all the users whom you want to share user_token_id*/
            $shared_user_array=array();
            /*Array of all the files which you want to share*/
            $shared_file_array=array();



            $date = new DateTime();
            $time_stamp= $date->getTimestamp();
            $time_stamp=$time_stamp.$session_user_id;
            foreach($share_user_array as $share_user_id)
                $time_stamp=$time_stamp.$share_user_id;
            foreach($share_file_array as $share_file_id)
                $time_stamp=$time_stamp.$share_file_id;


            $query="INSERT INTO shares(share_type,share_user_id,created_at,created_by,token_value,validity,validity_type,deleted) VALUES (1,$session_user_id,CURRENT_TIMESTAMP(),$session_user_id,$time_stamp,$validity,'$validity_type',0)";
            $new_share_query=mysqli_query($connection,$query);
            confirmQuery($new_share_query);
            $share_id=mysqli_insert_id($connection);

            $user_emails="";

            foreach($share_user_array as $share_user_id){
                $user_emails.=get_user_email($share_user_id) . ",";
                /*Array in */
                $query = "INSERT INTO usertokens(user_id,share_id) VALUES ($share_user_id,$share_id)";
                $new_usertokens_query = mysqli_query($connection, $query);
                confirmQuery($new_usertokens_query);
                array_push($shared_user_array,mysqli_insert_id($connection));
                /*Array out user_token_id array*/
            }

            foreach($share_file_array as $share_file_id){
                /*Array in */
                $query="INSERT INTO filetokens(file_id,share_id) VALUES ($share_file_id,$share_id)";
                $new_filetokens_query=mysqli_query($connection,$query);
                confirmQuery($new_filetokens_query);
                array_push($shared_file_array,mysqli_insert_id($connection));
                /*Array out file_token_id array*/
            }



            /*For each user loop every file*/
            foreach($shared_user_array as $shared_user_id){

                $user_id=get_user_id_from_usertokens($shared_user_id);
                $user_home_file_id=get_user_home_file_id($user_id);

                foreach($shared_file_array as $shared_file_id){
                    $file_id=get_file_id_from_filetokens($shared_file_id);
                    $actual_file_id=insert_file_for_user($file_id,$user_home_file_id);

                    $query="INSERT INTO userfiletokens(user_token_id,file_token_id,user_file_token_file_id) VALUES ($shared_user_id,$shared_file_id,$actual_file_id)";
                    $new_filetokens_query=mysqli_query($connection,$query);
                    confirmQuery($new_filetokens_query);
                    $user_file_token_id=mysqli_insert_id($connection);
                    insertNotification($user_file_token_id);
                }
            }

            if($validity_type != "infinity"){
                /*CREATE EVENT TO STOP THE SHARE*/
                $query= "CREATE EVENT stop_sharing_$time_stamp
                     ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL $validity $validity_type
                     DO
                     UPDATE shares SET deleted = 1 where share_id=$share_id";
                $delete_event_query=mysqli_query($connection,$query);
                confirmQuery($delete_event_query);
                /*END CREATE EVENT*/
            }

            echo $user_emails;

        }else if($task=='compareHash'){
            /*compare hash and give the result to javascript it will decide what to do if it is not there*/
            $hashStr=$_GET['hashStr'];
            $file_name=$_GET['file_name'];
            $file_id=$_GET['file_id'];
            
            
            //echo $hashStr;
            $query="SELECT * FROM filecontents WHERE blob_hash='$hashStr'";
            $check_file_query=mysqli_query($connection,$query);
            confirmQuery($check_file_query);
            $rowCount=mysqli_num_rows($check_file_query);
            
            if($rowCount>=1){
                $row=mysqli_fetch_assoc($check_file_query);
                $db_blob_id=$row['blob_id'];
                $query="INSERT INTO files(file_name,parent_file_id,blob_id,isdirectory,created_at,created_by,updated_at,updated_by) VALUES ('$file_name',$file_id,$db_blob_id,'false',CURRENT_TIMESTAMP(),$session_user_id,CURRENT_TIMESTAMP(),$session_user_id)";
                $new_file_query=mysqli_query($connection,$query);
                confirmQuery($new_file_query);
                echo "true";
            }else{
                echo "false";
            }
            /***************************************************************************************************/
        }else if($task=='delete'){
            $file_id=$_POST['file_id'];
            delete_file($file_id);
        }else if($task=="unzipAndStore"){
            
            $parent_file_id=$_GET['file_id'];
            $date = new DateTime();
            $time_stamp= $date->getTimestamp();
            /*First move the file to zip folder*/
            if(isset($_FILES['data']) and !$_FILES['data']['error']){
                $fname ="zip/".$time_stamp.$_POST['folderName'].".zip";
                move_uploaded_file($_FILES['data']['tmp_name'],$fname);
            }
            
            /*Second extract to the extreact folder*/
            $zip = new ZipArchive();
            $extract_folder_name="";
            $res = $zip->open("zip/".$time_stamp.$_POST['folderName'].".zip");
            if ($res === TRUE) {
                echo 'ok';
                $extract_folder_name='zip/extract/'.$time_stamp.$_POST['folderName'];
                $zip->extractTo($extract_folder_name);
                $zip->close();
            } else {
                echo 'failed, code:' . $res;
            }
            unlink($fname);

            /*all files will give you the path of all the files inside the zip/extract folder*/
            $allFiles=scanDirectories('zip/extract/'.$time_stamp.$_POST['folderName'].'/'.$_POST['folderName']);
            /***************************************************************change 
            the folder name with foldernameand timestamp*/
            
            
            /*run for all the files*/
            foreach ($allFiles as $file) {
                $temp_parent_file_id=$parent_file_id;
                $j=0;
                /*Find the path as it will be from zip/extract/zipname/folder..... and we want from folder
                so we have to skip the three /*/
                for($i=0;$i<3;$i++){
                    $j=strpos($file,'/',$j+1);
                }
                
                
                $filePath=substr($file,$j+1);
                /*Find the path*/
                $file_name=substr($filePath,strrpos($filePath,"/")+1);
                /*get the  name of the file*/
                $filePath=substr($filePath,0,strrpos($filePath,"/"));
                /*final  file path excluding the filename hence remaning are all the folderes*/
                echo $filePath;
                $folders=explode('/',$filePath);
                
                /*create the entry of the folder if it doesnot exists*/
                foreach($folders as $folder){
                    $file_id=file_present($folder,$temp_parent_file_id);
                    if($file_id==-1){
                        $new_folder_name=$folder;
                        $query="INSERT INTO     files(file_name,parent_file_id,isdirectory,created_at,created_by,updated_at,updated_by) VALUES ('$new_folder_name',$temp_parent_file_id,'1',CURRENT_TIMESTAMP(),$session_user_id,CURRENT_TIMESTAMP(),$session_user_id)";
                        $new_folder_query=mysqli_query($connection,$query);
                        confirmQuery($new_folder_query);
                        $temp_parent_file_id=mysqli_insert_id($connection);
                    }else{
                        $temp_parent_file_id=$file_id;
                    }
                }
                /*now move the file*/
                $fileContents="";
                $fileContents=file_get_contents($file);
                $hashStr="";
                $hashStr = hash("sha512",$fileContents,false);
                
                $query="SELECT * FROM filecontents WHERE blob_hash='$hashStr'";
                $check_file_query=mysqli_query($connection,$query);
                confirmQuery($check_file_query);
                $rowCount=mysqli_num_rows($check_file_query);
            
                
                /*check with the help of hash if we have the file or not*/
                if($rowCount>=1){
                    $row=mysqli_fetch_assoc($check_file_query);
                    $db_blob_id=$row['blob_id'];
                    $query="INSERT INTO files(file_name,parent_file_id,blob_id,isdirectory,created_at,created_by,updated_at,updated_by) VALUES ('$file_name',$temp_parent_file_id,$db_blob_id,'false',CURRENT_TIMESTAMP(),$session_user_id,CURRENT_TIMESTAMP(),$session_user_id)";
                    $new_file_query=mysqli_query($connection,$query);
                    confirmQuery($new_file_query);
                }else{
                   /*Sorry we dont have it*/
                    $date = new DateTime();
                    $time_stamp= $date->getTimestamp();
                    
                    copy($file,"allfiles/$time_stamp$session_user_id$file_name");

                    $fileSize = filesize ($file);
                    
                   

                    $query="INSERT INTO filecontents(blob_path,blob_size,blob_hash,created_at,created_by,updated_at,updated_by) VALUES ('$time_stamp$session_user_id$file_name','$fileSize','$hashStr',CURRENT_TIMESTAMP(),$session_user_id,CURRENT_TIMESTAMP(),$session_user_id)";
                    $new_blob_query=mysqli_query($connection,$query);
                    confirmQuery($new_blob_query);

                    $blob_id=mysqli_insert_id($connection);

                    $query="INSERT INTO files(file_name,parent_file_id,blob_id,isdirectory,created_at,created_by,updated_at,updated_by) VALUES ('$file_name',$temp_parent_file_id,$blob_id,'false',CURRENT_TIMESTAMP(),$session_user_id,CURRENT_TIMESTAMP(),$session_user_id)";
                    $new_file_query=mysqli_query($connection,$query);
                    confirmQuery($new_file_query);

                    //header("Location: index.php?file_id=$get_file_id");
                }
                
            }


            delete_directory($extract_folder_name);
        }
        
    }
    
?>