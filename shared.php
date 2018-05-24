<!DOCTYPE html>
<?php
ob_start();
?>
<html lang="en">

<?php
$title = "Shared With Me | Study Drive";
$page = "shared";
include_once("includes/header.php");

$session_user_email=$_SESSION['user_email'];

if(isset($_GET['file_id'])){
    $get_file_id=$_GET['file_id'];
}else
    $get_file_id=get_user_file_id($_SESSION['user_email']);

echo "<p hidden='true' type='hidden' id='file_id' >$get_file_id</p>";
check_file_owner($get_file_id);

$toShowNav = "Shared Files ";
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


                        <div class="col-md-4">
                            <button type="button" id="share_bulk" name="share_bulk" class="btn custom-outline outline-primary" data-target='#sharefile' data-toggle='modal'><i class="fas fa-share-square"></i> Share Files</button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">

                                    <th>Name</th>

                                    <th>File Owner</th>

                                    <th>Download</th>

                                    <th>Options</th>

                                    <th class="text-right">File Size</th>
                                    </thead>

                                    <tbody>


                                    <?php
                                        $query="SELECT * FROM shares join usertokens join filetokens join files join userfiletokens where userfiletokens.user_file_token_file_id=files.file_id and shares.share_id=usertokens.share_id and shares.share_id=filetokens.share_id and usertokens.user_id=$session_user_id and userfiletokens.user_token_id=usertokens.user_token_id and shares.deleted=0";
                                        $share_details_query=mysqli_query($connection,$query);

                                        while($row=mysqli_fetch_assoc($share_details_query)) {

                                        /*Type of share 1 strict share 0 link share*/
                                        /*$share_type=$row['share_type'];*/
                                        /*Person who shared the file*/
                                        //$share_user_id=$row['share_user_id'];
                                        //$created_at=$row['created_at'];
                                        //$validity=$row['validity'];
                                        $file_id=$row['user_file_token_file_id'];


                                        $file_name=$row['file_name'];
                                        $blob_id=$row['blob_id'];
                                        $parent_file_id=$row['parent_file_id'];
                                        $isdirectory=$row['isdirectory'];
                                        //$created_at=$row['created_at[0]'];
                                        $created_by=$row['created_by'];
                                        $created_by = $created_by[0];
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
                                        $user_fullname = get_user_fullname($created_by);
                                        /*end of query to find name user*/

                                        ?>

                                        <tr>

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

                                            <td><?php echo $user_fullname; ?></td>

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

            <?php include_once("includes/file-info-modal.php"); ?>

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

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

    });

</script>

</html>
