<!DOCTYPE html>
<html lang="en">

<?php 
    $title = "Home | Study Drive";
    $page = "dashboard";
    include_once("includes/header.php");

?>

<body class="">
    <div class="wrapper ">
        
        <?php 
            include_once("includes/sidebar.php");
        ?>
        
        
        <div class="main-panel">
            <!-- Navbar -->
            <?php 
                $toShowNav = "Dashboard";
                include_once("includes/navigation.php");
            ?>
            <!-- End Navbar -->
            <div class="panel-header panel-header-lg">
                <canvas id="bigDashboardChart"></canvas>
            </div>

            <div class="content">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="card-category">User Statistics</h5>
                                <h4 class="card-title">Files uploaded</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="barChartSimpleGradientsNumbers"></canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="now-ui-icons ui-2_time-alarm"></i> Last 7 days
                                </div>
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
<?php 
    include_once("includes/scripts.php");
?>
<script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();
    });
</script>

</html>
