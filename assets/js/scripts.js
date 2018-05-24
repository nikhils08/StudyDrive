$(document).ready(function () {

    $('.share_file').on('click', function(){
        var button = $(this);
        //console.log(button);
        var file_id = button.data("file-id");
        $('.share_file').blur();
        $('.share_file').hidefocus = true;
        //window.alert(file_id);
        $("#input_file_id").attr("data-file-id", file_id);
        $("#input_file_id").attr("value", file_id);
    });

    var file_ids = [];
    var files_selected = 0;

    $('#share_bulk').on("click", function () {
        file_ids = [];

        $('.checkBoxes').each(function (event) {
            if($(this).is(":checked")){
                file_ids.push($(this).val());
            }
        });

        files_selected = file_ids.length;

        //window.alert(file_ids + " " + files_selected);
    });

    var selected_share = "";

    $('.selectusers').prop('disabled', true);

    $("#shareselection").on("change", function () {
        selected_share = ($("#shareselection").select2("val"));
        if(selected_share == "user_share"){
            $('.selectusers').prop('disabled', false);
            $('.selectgroup').prop('disabled', true)
        } else if(selected_share == "group_share"){
            $('.selectusers').prop('disabled', true);
            $('.selectgroup').prop('disabled', false);
        } else{
        	$('.selectusers').prop('disabled', true);
            $('.selectgroup').prop('disabled', true);
        }
    });

    /*$('.shareselection').on('select2:selecting', function(e) {
        var selected_share = ($("#shareselection").select2("val"));
        window.alert(selected_share);
    });*/

    $('#selectAllBoxes').on('ifChecked', function(event){
        //window.alert("Checked");
        $('.checkBoxes').each(function() {
            $(this).iCheck('check');
        });
    });
    
    $('#selectAllBoxes').on('ifUnchecked', function(event){
        //window.alert("unChecked");
        $('.checkBoxes').each(function() {
            $(this).iCheck('uncheck');
        });
    });

    $("#btntoshare").on("click", function(){

        var user_ids = [];
        var users_selected;
        var input_time = $("#input_time").val();
        var valid_type = $("#selectTimeLimit").select2("val");

        if(input_time == ""){
            input_time = -1;
            valid_type = "infinity";
        }

        if(selected_share == "user_share"){
            user_ids = $("#selectusers").select2("val");
            users_selected = user_ids.length;

            var fd = new FormData();
            fd.append("user_ids",user_ids);
            fd.append("file_ids", file_ids);
            fd.append("valid_time", input_time);
            fd.append("valid_type", valid_type);

            $.ajax({
                type: "POST",
                url: "ajaxhelper.php?task=share",
                data: fd,
                processData: false,
                contentType: false
            }).done(function(response){
                toastr["success"]("Files Were Shared With " + users_selected + " Users", "SHARE FILES")
                console.log(response);
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "swing",
                }
            }).fail(function(response){
                toastr["error"]("Error While Sharing ", "SHARE FILES")
                console.log(response);
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "swing",
                }
            })

        } else if(selected_share == "group_share"){
            var group_ids = $("#selectgroup").select2("val");
            var fd = new FormData();
            fd.append("group_ids", group_ids);
            fd.append("file_ids", file_ids);
            fd.append("valid_time", input_time);
            fd.append("valid_type", valid_type);

            $.ajax({
                type: "POST",
                url: "ajaxhelper.php?task=share&group=1",
                data: fd,
                processData: false,
                contentType: false
            }).done(function(response){
                toastr["success"]("Files Were Shared With " + users_selected + " Users", "SHARE FILES")
                console.log(response);
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "swing",
                }
            }).fail(function(response){
                toastr["error"]("Error While Sharing ", "SHARE FILES")
                console.log(response);
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "swing",
                }
            })
        }

        $("#sharefile").modal("hide");
    });

    var file_id;

    $('.file_option').on('click', function(){
        var span = $("#file_to_show");
        span.empty();
        span.blur();
        span.hidefocus = true;
        var button = $(this);
        file_id = button.data("file-id");
        //window.alert(file_id);
        
        $.ajax({
            type: "POST",
            url: "includes/process-ajax-request.php",
            data: "file_info_id=" + file_id
        }).done(function(response){
            span.append(response);
        }).fail(function(response){
            span.append("Error occurred " + response);
        })
        
    });


    $("#btndelete").on("click", function () {
        $.ajax({
            type: 'POST',
            url: 'ajaxhelper.php?task=delete',
            data: 'file_id=' + file_id
        }).done(function (response) {
            var parent_id = $("#file_id").text();
            self.location = "mydrive.php?file_id="+parent_id;
        }).fail(function (response) {
            console.log(response);
            window.alert("Error");
        })
    });


    $("#termsConditions").on("ifUnchecked", function(){
        $("#register_user").attr("disabled", "true");
    });
    
    $("#termsConditions").on("ifChecked", function(){
        $("#register_user").removeAttr("disabled");
    });
    
    var first_name;
    var last_name;
    var about_me;
    
    $("#profile_photo").on("change", function(){
        $("#changephotoform").submit();
    });
    
    $("#remove_profile").on("click", function(){
        
        $.ajax({
            type: "POST",
            url: "includes/update-user.php",
            data: "remove_profile_photo=1"
        }).done(function(response){
            location.reload();
        }).fail(function(response){
            window.alert("Error " + response);
        })
        
    });
    
    $('#edit-profile').on("click", function () {

        first_name = $("#first-name").val();
        last_name = $("#last-name").val();
        about_me = $("#user-about").val();
        $('.user').removeAttr("disabled");
        
        $("#changeprofile").removeAttr("hidden");
        $("#changeprofilephoto").removeAttr("hidden");
        $('#cancel-profile').removeAttr("hidden");
        $('#save-profile').removeAttr("hidden");
        $('#remove_profile').removeAttr("hidden");
        $('#edit-profile').attr("hidden", "true");

    });

    $('#cancel-profile').on("click", function () {
        
        $("#first-name").val(first_name);
        $("#last-name").val(last_name);
        $("#user-about").val(about_me);
        $('.user').attr("disabled", "true");
        $("#save-profile").attr("hidden", "true");
        $("#changeprofile").attr("hidden", "true");
        $("#changeprofilephoto").attr("hidden", "true");
        $('#cancel-profile').attr("hidden", "true");
        $('#remove_profile').attr("hidden", "true");
        $('#edit-profile').removeAttr("hidden");

    });


    function loadNotification(){
        $.get("ajaxhelper.php?task=get_notification",function(data){
            var notiString=JSON.stringify(data);
            if(notiString.length>2){

                toastr["success"](data + " Shared Files With You. You Must Reload The Page To view Files", "SHARE FILES")

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "500",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "swing",
                }
            }
        });
    }


    setInterval(function(){
        loadNotification();
    },500);

});
