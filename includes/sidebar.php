<div class="sidebar custom-sidebar" data-color="custom-darkblue">
    <!--
                Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
            -->
    <div class="logo">
        <a href="dashboard.php" class="simple-text logo-mini">
                    SD
        </a> <a href="dashboard.php" class="simple-text logo-normal">
                    Study Drive
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li <?php if($page=="dashboard" ) echo "class='active'"; ?> >
                <a href="dashboard.php"> 
                    <i class="now-ui-icons design_app"></i>
                    <p>Home</p>
                </a>
            </li>

            <li <?php if($page=="mydrive" ) echo "class='active'"; ?> >
               <?php 
                    $file_id = $_SESSION['file_id'];
                ?>
                <a href="mydrive.php?file_id=<?php echo $file_id; ?>"> 
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>My Drive</p>
                </a>
            </li>

            <li <?php if($page=="shared" ) echo "class='active'"; ?> >
                <a href="shared.php"> 
                    <i class="now-ui-icons users_single-02"></i>
                    <p>Shared With Me</p>
                </a>
            </li>

        </ul>
    </div>
</div>
