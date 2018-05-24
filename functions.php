<?php
    
    /*FUNCTIONS RELATED TO USER*/
    function check_user(){
        if(!isset($_SESSION['user_id'])){
            die("<p style='color:black; font-weight:bold; font-size: 20px;' class='text-center'>You have not logged in ,please login from <a href='index.php'>here</a></p>");
        }
        $user_id=$_SESSION['user_id'];
        return $user_id;
    }

    function get_user_email($user_id){
        /*Get the  email from user_id*/
        global $connection;

        $query="SELECT * FROM users where user_id=$user_id";
        $user_name_query=mysqli_query($connection,$query);
        $row=mysqli_fetch_assoc($user_name_query);

        $user_email=$row['user_email'];
        return $user_email;
    }

    /*END OF FUNCTIONS RELATED TO USER*/


    /*DELETE DIRECTORY*/
    function delete_directory($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
                else
                    delete_directory($dirname.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }




    /*FUNCTIONS RELATED TO DB*/
    function confirmQuery($result){
        global $connection;
        if(!$result){
            die("Query Failed".mysqli_error($connection));
        }
    }
    /*END OF FUNCTIONS RELATED TO DB*/



    /*FUNCTIONS RELATED TO FILE*/

    function get_root_file_id($file_id)
    {
        global $connection;
        $root_file_id=-1;
        $query = "select * from files where file_id=(select parent_file_id from files where file_id=$file_id)";
        $file_parent_query = mysqli_query($connection, $query);
        $rowcount = mysqli_num_rows($file_parent_query);
        while ($rowcount > 0) {
            $row = mysqli_fetch_assoc($file_parent_query);
            $root_file_id = $row['file_id'];
            $query = "select * from files where file_id=(select parent_file_id from files where file_id=$root_file_id)";
            $file_parent_query = mysqli_query($connection, $query);
            $rowcount = mysqli_num_rows($file_parent_query);
        }
        return $root_file_id;
    }

    function check_file_owner($file_id){
        global $connection;

        $query="SELECT * FROM files where file_id=$file_id";
        $user_id_query=mysqli_query($connection,$query);
        $row=mysqli_fetch_assoc($user_id_query);
        $db_user_id=$row['created_by'];
        //echo "This is the user_id $db_user_id";
        $user_id=$_SESSION['user_id'];
        $root_file_id=get_root_file_id($file_id);
        //echo " is the root file_id $root_file_id";
        if($db_user_id!=$user_id && $root_file_id!=get_user_file_id(get_user_email($user_id))){
            die("<p style='color:red; font-size: 20px; font-weight: bold' class='text-center'>This file does not belongs to the logged in user <a href=\"javascript:history.go(-1)\" style='color: black;'>GO BACK FROM HERE</a>  </p>");
        }
    }


    function get_user_file_id($user_email){
        /*Get the root file the user*/
        global $connection;

        $query="SELECT * FROM files where file_name='$user_email' and parent_file_id is NULL";
        $file_id_query=mysqli_query($connection,$query);
        $row=mysqli_fetch_assoc($file_id_query);

        $file_id=$row['file_id'];
        return $file_id;
    }

    function get_file_path($file_id){
        /*give him file id and he will give you the path of file inside the array
        eg A
            B
            C
                D
        if i request the path of d
        files[0]=D
        files[1]=C
        files[2]=A
            */
        global $connection;
        $files=[];
        $files[0]=$file_id;
        $i=1;
        $query="select * from files where file_id=(select parent_file_id from files where file_id=$file_id)";
        $file_parent_query=mysqli_query($connection,$query);
        $rowcount=mysqli_num_rows($file_parent_query);
        while($rowcount>0){
            $row=mysqli_fetch_assoc($file_parent_query);
            $file_id=$row['file_id'];
            $files[$i++]=$file_id;
            $query="select * from files where file_id=(select parent_file_id from files where file_id=$file_id)";
            $file_parent_query=mysqli_query($connection,$query);
            $rowcount=mysqli_num_rows($file_parent_query);
        }   
        return $files;
    }

    function get_file_name($file_id){
        /*give me file id i will give you the name*/
        global $connection;
        $query="select * from files where file_id=$file_id";
        $file_name_query=mysqli_query($connection,$query);
        $row=mysqli_fetch_assoc($file_name_query);
        $file_name=$row['file_name'];
        return $file_name;
    }

    function file_present($file_name,$parent_file_id){
        /*Check wether the file exists or not*/
        global $connection;
        $query="select * from files where file_name='$file_name' and parent_file_id=$parent_file_id and deleted=0";
        $file_name_query=mysqli_query($connection,$query);
        $rowcount=mysqli_num_rows($file_name_query);
        if($rowcount==1){
            $row=mysqli_fetch_assoc($file_name_query);
            $file_id=$row['file_id'];
            return $file_id;    
        }
        return -1;
    }


    function scanDirectories($rootDir, $allData=array()) {
        /*give the directory i will give you the path of all the files inside the direcctory*/
        // set filenames invisible if you want
        $invisibleFileNames = array(".", "..", ".htaccess", ".htpasswd");
        // run through content of root directory
        $dirContent = scandir($rootDir);
            foreach($dirContent as $key => $content) {
                // filter all files not accessible
                $path = $rootDir.'/'.$content;
                if(!in_array($content, $invisibleFileNames)) {
                    // if content is file & readable, add to array
                    if(is_file($path) && is_readable($path)) {
                        // save file name with path
                        $allData[] = $path;
                    // if content is a directory and readable, add path and name
                    }elseif(is_dir($path) && is_readable($path)) {
                        // recursive callback to open new directory
                        $allData = scanDirectories($path, $allData);
                    }
                }
            }
        return $allData;
    }


    /*END OF FUNCTIONS RELATED TO USER*/


    function get_file_path_till($file_id,$end_parent_id){
            global $connection;
            $file_path="";
            
            $i=0;
            $query="select * from files where file_id=(select parent_file_id from files where file_id=$file_id)";
            $file_parent_query=mysqli_query($connection,$query);
            $rowcount=mysqli_num_rows($file_parent_query);
        
            while($rowcount>0){
                $row=mysqli_fetch_assoc($file_parent_query);
                $file_id=$row['file_id'];
                $file_name=$row['file_name'];
                $file_path=$file_name.$file_path;
                    if($file_id==$end_parent_id)
                        return $file_path;
                $file_path="/".$file_path;
                $query="select * from files where file_id=(select parent_file_id from files where file_id=$file_id)";
                $file_parent_query=mysqli_query($connection,$query);
                $rowcount=mysqli_num_rows($file_parent_query);
            }   
            return $file_path;
        }


    /*WORK OUT FOR EMPTY FOLDER*/
    function outputZip($file_id,$zip,$folder_id){
            global $connection;
            /*$file_id=current file id
            $zip zip object
            $folder_id the id of the folder in which we have to add all the files*/
        
            $query="select * from files where parent_file_id=$file_id";
            /*Query to find all the childerns of the parent folder($file_id)*/
            $child_files_query=mysqli_query($connection,$query);
            $rowcount=mysqli_num_rows($child_files_query);
            
            while($rowcount>0&&($row=mysqli_fetch_assoc($child_files_query))){
                $file_id=$row['file_id'];
                $file_name=$row['file_name'];
                $isdirectory=$row['isdirectory'];
                $blob_id=$row['blob_id'];
                
                if($isdirectory==0){
                    /*The child is a file*/
                    $query="SELECT * FROM filecontents WHERE blob_id=$blob_id";
                    $blob_query=mysqli_query($connection,$query);
                    confirmQuery($blob_query);
                    $row=mysqli_fetch_assoc($blob_query);

                    $blob_path=$row['blob_path'];
                    $blob_size=$row['blob_size'];
                    
                    $path=get_file_path_till($file_id,$folder_id);
                    /*This method will get the path of itself from the parent iefolderid
                    here parent refers to the folder which we want to download
                    it takes the file_id and the parent folder id
                    (exxcluding itself)*/
                    
                    $zip->addFile("allfiles/$blob_path",$path."/".$file_name);
                    
                }else{
                    /*The child is a folder*/
                    outputZip($file_id,$zip,$folder_id);
                }
                
            
            }   
            return $zip;
        }


    function get_user_home_file_id($user_id){
        /*Get the root file the user*/
        global $connection;

        $query="select * from files where file_name = (SELECT user_email FROM users where user_id=$user_id)";
        $home_file_id_query=mysqli_query($connection,$query);
        $row=mysqli_fetch_assoc($home_file_id_query);
        return $row['file_id'];
    }



/*Functions related to sharing*/

    function get_user_id_from_usertokens($shared_user_id){
        global $connection;
        $query="select * from usertokens where user_token_id=$shared_user_id";
        $user_query=mysqli_query($connection,$query);
        confirmQuery($user_query);
        $row=mysqli_fetch_assoc($user_query);
        return $row["user_id"];
    }

    function get_file_id_from_filetokens($shared_file_id){
        global $connection;
        $query="select * from filetokens where file_token_id=$shared_file_id";
        $file_query=mysqli_query($connection,$query);
        confirmQuery($file_query);
        $row=mysqli_fetch_assoc($file_query);
        return $row["file_id"];
    }

    function insert_file_for_user($file_id,$parent_file_id)
    {

        global $connection;

        echo "<h1>The file whose copy is made is $file_id and the parent is $parent_file_id</h1>";
        $query = "select * from files where file_id=$file_id";
        $file_query = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($file_query);

        $child_file_id = $row['file_id'];
        $child_file_name = $row['file_name'];
        $child_isdirectory = $row['isdirectory'];
        $child_blob_id = $row['blob_id'];
        $child_created_by = $row['created_by'];




        $query = "INSERT INTO files(file_name,parent_file_id,blob_id,isdirectory,created_at,created_by,updated_at,updated_by) VALUES ('$child_file_name',$parent_file_id,$child_blob_id,$child_isdirectory,CURRENT_TIMESTAMP(),$child_created_by,CURRENT_TIMESTAMP(),$child_created_by)";
        $insert_directory_query = mysqli_query($connection, $query);
        confirmQuery($insert_directory_query);
        $parent_file_id=mysqli_insert_id($connection);

        /*Query to find all the childerns of the parent folder($file_id)*/

        $query = "select * from files where parent_file_id=$file_id";
        /*Query to find all the childerns of the parent folder($file_id)*/
        $child_files_query = mysqli_query($connection, $query);
        $rowcount = mysqli_num_rows($child_files_query);

        while ($rowcount > 0 && ($row = mysqli_fetch_assoc($child_files_query))) {
            $child_file_id = $row['file_id'];
            $child_file_name = $row['file_name'];
            $child_isdirectory = $row['isdirectory'];
            $child_blob_id = $row['blob_id'];
            $child_created_by = $row['created_by'];

            if ($child_isdirectory == 0) {
                /*The child is a file*/
                $query = "INSERT INTO files(file_name,parent_file_id,blob_id,isdirectory,created_at,created_by,updated_at,updated_by) VALUES ('$child_file_name',$parent_file_id,$child_blob_id,0,CURRENT_TIMESTAMP(),$child_created_by,CURRENT_TIMESTAMP(),$child_created_by)";
                $insert_file_query = mysqli_query($connection, $query);
                confirmQuery($insert_file_query);
            } else {
                /*The child is a folder*/
                insert_file_for_user($child_file_id,$parent_file_id);
            }
        }
        return $parent_file_id;
    }



    /*Notification Part*/

    function insertNotification($user_file_token_id){
        global $connection;
        $query="INSERT INTO notification(user_file_tokens_id,notify) VALUES ($user_file_token_id,1)";
        $new_notification_query=mysqli_query($connection,$query);
        confirmQuery($new_notification_query);
    }



    /*End of Notification Part*/


    /*end of functions related to sharing*/

    /*Functions to delete a file*/
    function delete_file($file_id){

        global $connection;

        $query="select * from files where file_id=$file_id and deleted=0";
        echo $query;
        $file_query=mysqli_query($connection,$query);
        $row=mysqli_fetch_assoc($file_query);
        $is_directory=$row['isdirectory'];

        /*Update the deleted of file to 1 true not supported*/
        $query="Update files set deleted=1,deleted_at=CURRENT_TIMESTAMP() where file_id=$file_id";
        $delete_query=mysqli_query($connection,$query);
        confirmQuery($delete_query);
    //            End of update

        if($is_directory==1) {

            $query = "select * from files where parent_file_id=$file_id and deleted=0";
            $file_childs_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($file_childs_query)) {

                $is_directory = $row['isdirectory'];
                $file_id = $row['file_id'];

                if ($is_directory == 1)
                    delete_file($file_id);
                else {
                    $query = "Update files set deleted=1,deleted_at=CURRENT_TIMESTAMP() where file_id=$file_id";
                    $delete_query = mysqli_query($connection, $query);
                    confirmQuery($delete_query);
                }
            }    /*End of while*/
        }
    }


    function get_user_fullname($user_id){
        /*Get the root file the user*/
        global $connection;

        $query="SELECT * FROM users where user_id=$user_id";
        $user_name_query=mysqli_query($connection,$query);
        $row=mysqli_fetch_assoc($user_name_query);

        $user_first_name=$row['user_firstname'];
        $user_last_name=$row['user_lastname'];
        return ($user_first_name." ".$user_last_name);
    }


?>