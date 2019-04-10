<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php 
    $title = "User Profile | Study Drive";
    $page = "user";
    $toShowNav = "User Profile";
    include_once("includes/header.php");
?>

<?php 
    $user_id = $_SESSION['user_id'];
    
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $select_user_details = mysqli_query($connection, $query);
    confirmQuery($select_user_details);
    
    if($row = mysqli_fetch_assoc($select_user_details)){
        extract($row);
        
        if($profile_photo === "") {
            $user_defined_image_name = strtolower(substr($user_firstname, 0, 1));
            $user_defined_image = "predefined_users/$user_defined_image_name.png";
        } else{
            $user_defined_image = "users/$profile_photo";
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">Edit Profile</h5>
                            </div>
                            <div class="card-body">
                                <form action="includes/update-user.php" enctype="multipart/form-data" method="post">
                                    <div class="row">
                                        <div class="col-md-12 pr-1">
                                            <div class="form-group">
                                                <label for="email-id">Email ID</label>
                                                <input type="email" id="email-id" class="form-control user_email" disabled placeholder="Company" value="<?php echo $user_email; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 pr-1">
                                            <div class="form-group">
                                                <label for="first-name">First Name</label>
                                                <input type="text" name="user_firstname" id="first-name" class="form-control user user_firstname" disabled placeholder="Company" value="<?php echo $user_firstname; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1">
                                            <div class="form-group">
                                                <label for="last-name">Last Name</label>
                                                <input type="text" name="user_lastname" id="last-name" class="form-control user user_lastname" disabled placeholder="Last Name" value="<?php echo $user_lastname; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="user-about">About Me</label>
                                                <textarea rows="4" name="user_aboutme" id="user-about" cols="80" class="form-control user user_about" disabled placeholder="Here can be your description"><?php echo $about_me; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" name="edit_profile" class="btn custom-outline outline-primary" id="edit-profile">Edit Profile</button>    
                                            <button type="submit" name="save_profile" class="btn custom-outline outline-success" id="save-profile" hidden="true">Save Profile</button>    
                                            <button type="button" class="btn custom-outline outline-danger" hidden id="cancel-profile">Cancel</button>   
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                       
                       <form action="includes/update-user.php" id="changephotoform" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="change_profile_photo" value="1">
                            <input type="file" name="profile_photo" id="profile_photo" hidden="true">
                       </form>
                       
                        <div class="card card-user">
                            <div class="image">
                               <div id="coverimage">
                                    <img src="assets/images/bg5.jpg" alt="...">   
                               </div>
                            </div>
                            <div class="card-body">
                                <div class="author">
                                    <div id="profileimage">
                                        <img class="avatar border-gray img-fluid" width="400px" src="assets/images/<? echo $user_defined_image; ?>" alt="...">
                                        <button class="btn custom-outline outline-custom-light-white" id="changeprofile" hidden="true" onclick="document.getElementById('profile_photo').click()"><i class="fas fa-images"></i></button>
                                    </div>
                                    <h5 class="title unselectable" id="user_name"><?php echo $user_firstname . " " . $user_lastname; ?></h5>
                                    <p class="description">
                                        <?php echo $user_email; ?>
                                    </p>
                                </div>
                                <p class="description text-center">
                                    <?php echo $about_me; ?>
                                </p>
                                
                                <div class="text-center">
                                    <button type="button" name="remove_profile" class="btn custom-outline outline-custom-white" id="remove_profile" hidden="true">Remove Photo</button>        
                                    <button class="btn custom-outline outline-custom-white" id="changeprofilephoto" hidden="true" onclick="document.getElementById('profile_photo').click()">Change Photo</button>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="button-container">
                                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                    <i class="fab fa-google-plus-g"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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
