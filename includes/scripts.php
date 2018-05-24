<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="assets/js/plugins/bootstrap-switch.js"></script>
<?php 
    if($page == "maps"){
?>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<?php 
    }
?>
<!-- Chart JS -->
<script src="assets/js/plugins/chartjs.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/now-ui-dashboard.js?v=1.0.0"></script>
<script src="assets/demo/demo.js"></script>

<script src="assets/uitoastr/toastr.min.js"></script>
<!--CUSTOM JS-->
<script src="assets/js/scripts.js"></script>

<script src="assets/js/filejs/blob.js"></script>
<script src="assets/js/filejs/FileSaver.js"></script>
<script src="assets/js/filejs/jszip.js"></script>
<script src="assets/js/filejs/script.js"></script>
<script src="assets/js/filejs/sha512.js"></script>

<?php if($page == "mydrive" || $page == "shared"){ ?>
<script src="assets/select2/dist/js/select2.full.min.js"></script>
<script src="assets/sweet-alert/sweetalert2.min.js"></script>
<!-- iCheck -->
<script src="login_includes/iCheck/icheck.min.js"></script>
<?php } ?>

