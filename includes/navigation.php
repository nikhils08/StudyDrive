<nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand">

                <?php
                    $session_user_id=check_user();

                    $session_user_name=$_SESSION['user_firstname'];
                    echo " " . $toShowNav . " of " . $session_user_name;
                    if ($toShowNav == "Dashboard")
                        echo "<br>" . "Active Login Hours Past 7 Days";
                
                    $user_defined_image_name = strtolower(substr($session_user_name, 0, 1));
                    $user_defined_navigation_image = "predefined_users/$user_defined_image_name.png";

                ?>
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">

            <ul class="navbar-nav">

                <?php
                if($page == "mydrive"){
                ?>

                    <form action="search.php" method="POST">
                        <div class="input-group no-border">
                            <input type="text" value="" name="search_keyword" class="form-control" placeholder="Search..." 0>
                            <span class="input-group-addon">
                                        <i class="now-ui-icons ui-1_zoom-bold"></i>
                                    </span>
                        </div>
                    </form>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="now-ui-icons ui-1_simple-add"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">New</span>
                                    </p>
                                </a>
                        <div class="dropdown-menu dropdown-menu-right" id="new-dropdown" aria-labelledby="navbarDropdownMenuLink">
                            <button class="dropdown-item" data-toggle="modal" data-target="#newFolderModal" data-type="newFolder"><i class="fas fa-folder-open fa-2x"></i> <span class="new-dropdown-text">New Folder</span></button>
                            <button class="dropdown-item" onclick="document.getElementById('fileUpload').click()"> <i class="far fa-file-code fa-2x"></i> <span class="new-dropdown-text">Upload File</span></button>
                            <button class="dropdown-item" onclick="document.getElementById('folderUpload').click()"> <i class="far fa-folder fa-2x"></i><span class="new-dropdown-text">Upload Folder</span></button>
                            <button class="dropdown-item" data-toggle="modal" data-target="#creategroup"> <i class="fas fa-users fa-2x"></i><span class="new-dropdown-text">New Group</span></button>
                        </div>
                    </li>
                    <?
                    }
                ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle account_dropdown" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="assets/images/<?php echo $user_defined_navigation_image; ?>" alt="" width="28px" height="28px" class="img-fluid rounded-circle">
                            <p>
                                <span class="d-lg-none d-md-block">Account</span>
                            </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="user.php">User Profile</a>
                        <a class="dropdown-item" href="login_includes/logout.php">Log Out</a>
                    </div>
                </li>

                <form action="" method="post" id="actionForm" class="form-group" enctype="multipart/form-data">
                    <input type="file" name="fileUpload" id="fileUpload" class="form-control file-selection" hidden="true">
                    <input type="file" name="folderUpload[]" id="folderUpload" multiple="" directory="" webkitdirectory="" hidden="true" mozdirectory="" class="form-control">
                </form>

            </ul>
        </div>
    </div>
</nav>
