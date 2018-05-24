<!DOCTYPE html>
<?php
ob_start();
?>
<html lang="en">

<?php
$title = "Search Results | Study Drive";
$page = "search";
include_once("includes/header.php");

$session_user_email=$_SESSION['user_email'];

if(isset($_GET['file_id'])){
    $get_file_id=$_GET['file_id'];
}else
    $get_file_id=get_user_file_id($_SESSION['user_email']);

echo "<p hidden='true' type='hidden' id='file_id' >$get_file_id</p>";
check_file_owner($get_file_id);

$toShowNav = "Search Results ";

$user_logged_id = $session_user_id;

if (isset($_POST['search_keyword'])){
    $to_search = $_POST['search_keyword'];
} else{
    header("Location: dashboard.php");
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

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">

                                    <th>Sr. No</th>

                                    <th>Name</th>

                                    <th class="text-center">File Owner</th>

                                    <th>File Path</th>

                                    </thead>

                                    <tbody>


                                    <?php
                                        $query = "SELECT * FROM files WHERE created_by = $user_logged_id AND parent_file_id IS NOT NULL AND file_name LIKE '%$to_search%'";
                                        $files_info_query = mysqli_query($connection, $query);
                                        $j= 1;
                                        confirmQuery($files_info_query);
                                        $row_count = mysqli_num_rows($files_info_query);

                                        while ($row = mysqli_fetch_assoc($files_info_query)) {
                                            extract($row);

                                            $user_name_query = "SELECT * FROM users WHERE user_id = $created_by";
                                            $user_info = mysqli_query($connection, $user_name_query);
                                            confirmQuery($user_info);
                                            if ($row = mysqli_fetch_assoc($user_info)){
                                                $user_first_name = $row['user_firstname'];
                                                $user_lastname = $row['user_lastname'];
                                                $user_email = $row['user_email'];
                                            }

                                        ?>

                                            <tr>

                                                <td><?php echo $j; ?></td>


                                                <?php
                                                    $temp_file_path_redirect=get_file_path($file_id);
                                                    $parent_to_redirect = $temp_file_path_redirect[1];
                                                ?>

                                                <td><a href="mydrive.php?file_id=<?php echo $parent_to_redirect; ?>"><?php echo $file_name; ?></a></td>

                                                <td class="text-center"><?php echo "$user_first_name " . " $user_lastname" . " &lt;$user_email&gt;"; ?></td>

                                                <td>

                                                    <nav aria-label="breadcrumb" class="col-md-12">
                                                        <ol class="breadcrumb">
                                                            <?php
                                                            //echo "<li class='breadcrumb-item'><a href='index.php?file_id=$get_file_id'>Home</a></li>";
                                                            $temp_file_path=get_file_path($file_id);
                                                            for ($i=(sizeof($temp_file_path)-1);$i>0;$i--){
                                                                $file_id=$temp_file_path[$i];
                                                                $file_name=get_file_name($file_id);
                                                                if($file_name == $session_user_email){
                                                                    echo "<li class='breadcrumb-item'><a href='mydrive.php?file_id=$file_id'>Home</a></li>";
                                                                } else{
                                                                    echo "<li class='breadcrumb-item'><a href='mydrive.php?file_id=$file_id'>$file_name</a></li>";
                                                                }
                                                            }
                                                            echo "<li class='breadcrumb-item'></li>"
                                                            ?>
                                                        </ol>
                                                    </nav>

                                                </td>

                                            </tr>

                                        <?php
                                            $j++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

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


</html>
