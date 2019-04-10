<!DOCTYPE html>
<?php 
    ob_start();
?>
<html lang="en">

<?php 
    $title = "My Drive | Study Drive";
    $page = "mydrive";
    include_once("includes/header.php");
    
    $session_user_email=$_SESSION['user_email'];

    if(isset($_GET['file_id'])){
        $get_file_id=$_GET['file_id'];
    }else
        $get_file_id=get_user_file_id($_SESSION['user_email']);

    echo "<p hidden='true' type='hidden' id='file_id' >$get_file_id</p>";
    check_file_owner($get_file_id);

    $toShowNav = "Drive";
?>


<?php

                
        if(isset($_POST['new_folder_name'])){
            $new_folder_name=$_POST['new_folder_name'];
            $query="INSERT INTO files(file_name,parent_file_id,isdirectory,created_at,created_by,updated_at,updated_by) VALUES ('$new_folder_name',$get_file_id,'1',CURRENT_TIMESTAMP(),$session_user_id,CURRENT_TIMESTAMP(),$session_user_id)";
            $new_folder_query=mysqli_query($connection,$query);
            confirmQuery($new_folder_query);

            header("Location: mydrive.php?file_id=$get_file_id");
        } else if(isset($_FILES['fileUpload']['name'])&&$_FILES['fileUpload']['name']!=""){
            
            /*Code when you choose a file*/
            $file_name=$_FILES['fileUpload']['name'];
            $date = new DateTime();
            $time_stamp= $date->getTimestamp();
            
            move_uploaded_file($_FILES['fileUpload']['tmp_name'],"allfiles/$time_stamp$session_user_id$file_name");
            
            $fileSize = $_FILES['fileUpload']['size'];
            $fileHash=$_GET['fileHash'];
            
            
            
            $query="INSERT INTO filecontents(blob_path,blob_size,blob_hash,created_at,created_by,updated_at,updated_by) VALUES ('$time_stamp$session_user_id$file_name','$fileSize','$fileHash',CURRENT_TIMESTAMP(),$session_user_id,CURRENT_TIMESTAMP(),$session_user_id)";
            $new_blob_query=mysqli_query($connection,$query);
            confirmQuery($new_blob_query);
            
            $blob_id=mysqli_insert_id($connection);
            
            $query="INSERT INTO files(file_name,parent_file_id,blob_id,isdirectory,created_at,created_by,updated_at,updated_by) VALUES ('$file_name',$get_file_id,$blob_id,'false',CURRENT_TIMESTAMP(),$session_user_id,CURRENT_TIMESTAMP(),$session_user_id)";
            $new_file_query=mysqli_query($connection,$query);
            confirmQuery($new_file_query);
            
            header("Location: mydrive.php?file_id=$get_file_id");
            
            
        } else if(isset($_FILES['folderUpload']['name'])&&$_FILES['folderUpload']['name']!=""){
            /*Code to choose when you upload a folder*/
            foreach ($_FILES['folderUpload']['name'] as $i => $name) {
                $tmp_name=$_FILES['folderUpload']['tmp_name'][$i];
                echo "This is might be index $i and this is  the name $tmp_name ";
                //if (strlen($_FILES['files']['name'][$i]) > 1) {
                  //  if (move_uploaded_file($_FILES['files']['tmp_name'][$i], 'upload/'.$name)) {
                    //    $count++;
                    //}
                //}
            }
        }
                
                
            ?>



<body class="">
    <div class="wrapper ">
        <?php 
            include_once("includes/sidebar.php");
        ?>
        <div class="main-panel">
            <!-- Navbar -->
            <?php 
                include_once("includes/navigation.php");            
            ?>
            <!-- End Navbar -->
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> Your Files</h4>
                            </div>

                            <?php 
                                if( isset( $_POST['btntoshare'] ) ) {

                                }
                            ?>

                            <!--START OF BREADCRUMB-->

                            <nav aria-label="breadcrumb" class="col-md-12">
                                <ol class="breadcrumb">
                                    <?php
                                    //echo "<li class='breadcrumb-item'><a href='index.php?file_id=$get_file_id'>Home</a></li>";
                                    $temp_file_path=get_file_path($get_file_id);
                                    for ($i=(sizeof($temp_file_path)-1);$i>=0;$i--){
                                        $file_id=$temp_file_path[$i];
                                        $file_name=get_file_name($file_id);
                                        if($file_name == $session_user_email){
                                            echo "<li class='breadcrumb-item'><a href='mydrive.php?file_id=$file_id'>Home</a></li>";    
                                        } else{
                                            echo "<li class='breadcrumb-item'><a href='mydrive.php?file_id=$file_id'>$file_name</a></li>";
                                        }
                                    }  
                                ?>
                                </ol>
                            </nav>

                            <!--END OF BREADCRUMB-->

                                <div class="col-md-4">
                                    <button type="button" id="share_bulk" name="share_bulk" class="btn custom-outline outline-primary" data-target='#sharefile' data-toggle='modal'><i class="fas fa-share-square"></i> Share Files</button>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th><input type="checkbox" id="selectAllBoxes" class="form-control"></th>

                                                <th>Name</th>

                                                <th>Download</th>

                                                <th>Options</th>

                                                <th class="text-right">File Size</th>
                                            </thead>

                                            <tbody>

                                                <?php
                                            $query="SELECT * FROM files WHERE parent_file_id=$get_file_id and deleted=0 ORDER BY isdirectory DESC";
                                            $all_files_query=mysqli_query($connection,$query);

                                            
                                                confirmQuery($all_files_query);

                                            while($row=mysqli_fetch_assoc($all_files_query)){

                                                $file_id=$row['file_id'];
                                                $file_name=$row['file_name'];
                                                $blob_id=$row['blob_id'];
                                                $parent_file_id=$row['parent_file_id'];
                                                $isdirectory=$row['isdirectory'];
                                                $created_at=$row['created_at'];
                                                $created_by=$row['created_by'];
                                                
                                                if($isdirectory == 0){
                                                    /*query to find size of file*/
                                                    $query="select * from filecontents where blob_id=$blob_id";
                                                    $file_size_query=mysqli_query($connection,$query);
                                                    confirmQuery($file_size_query);
                                                    $brow=mysqli_fetch_assoc($file_size_query);
                                                    $blob_size=$brow['blob_size'];
                                                    /*end of query to find size of file*/   
                                                }

                                                /*query to find name of user*/
                                                $query="select * from users  where user_id=$created_by";
                                                $user_name_query=mysqli_query($connection,$query);
                                                confirmQuery($user_name_query);
                                                $urow=mysqli_fetch_assoc($user_name_query);
                                                $user_firstname=$urow['user_firstname'];
                                                /*end of query to find name user*/

                                        ?>

                                                    <tr>
                                                        <td><input type='checkbox' name='checkBoxArray[]' class='checkBoxes' value='<?php echo $file_id; ?>'></td>

                                                        <td>
                                                            <?php
                                                        if($isdirectory == 1){
                                                            echo "<a href='mydrive.php?file_id=$file_id'>$file_name </a>";
                                                        }
                                                        else{
                                                            echo "$file_name";    
                                                        }
                                                    ?>
                                                        </td>

                                                        <td><a class="btn custom-outline outline-success" href="download.php?file_id=<?php echo $file_id; ?>" download style="font-size: 16px;"><i class="fas fa-cloud-download-alt"></i> Download</a></td>

                                                        <td><button type="button" class="btn custom-outline outline-custom-white file_option" style="font-size: 16px;" data-file-id="<?php echo $file_id;?>" data-target='#fileinfo' data-toggle='modal'><i class="fas fa-info-circle"></i> More Info</button></td>

                                                        <td class="text-right">
                                                            <?php 
                                                            if($isdirectory == 0){
                                                                
                                                                if( ( $blob_size / 1024) / 1024 / 1024 > 0.9 ) {
                                                                    $size_mb = ( ( $blob_size / 1024) / 1024 / 1024 );
                                                                    $size_gb = round($size_mb , 2);
                                                                    echo "$size_gb GB";
                                                                } else if(($blob_size / 1024) > 1024){
                                                                    echo ceil(($blob_size / 1024) / 1024) . " MB";
                                                                } 
                                                                else{
                                                                    echo ceil($blob_size / 1024) . " KB";
                                                                }
                                                            }
                                                            else
                                                                echo "Folder";
                                                        ?>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                            } 
                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>


                <!--START OF MODAL OF NEW FOLDER-->

                <div class="modal fade" id="newFolderModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New folder</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                            </button>
                            </div>
                            <div class="modal-body">
                                <form action="mydrive.php?file_id=<?php echo $get_file_id?>" id="new-folder-form" method="post">
                                    <div class="form-group">
                                        <label for="txtFolderName" class="col-form-label">Folder name</label>
                                        <input type="text" class="form-control" id="txtFolderName" name="new_folder_name">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn custom-outline outline-danger" data-dismiss="modal">Close</button>
                                <button type="button" class="btn custom-outline outline-success" id="btnCreateFolder">Create</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--END OF MODAL OF NEW FOLDER-->

                <?php include_once("includes/share-modal.php"); ?>
                <?php include_once("includes/file-info-modal.php"); ?>
                <?php include_once("includes/group-modal.php"); ?>

            </div>
            <?php 
                include_once("includes/footer.php");
            ?>
        </div>
    </div>


</body>
<!--   Core JS Files   -->
<?php 
    include_once("includes/scripts.php");
?>


<script>
    $(function() {
        $('.selectusers').select2()
        $('.selectTimeLimit').select2()
        $('.selectgroup').select2()
        $('.selectusersgroup').select2()
        $('.selectgroup').prop('disabled', true)
        $('.shareselection').select2()

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

    });

</script>


</html>
