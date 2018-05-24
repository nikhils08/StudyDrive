<!--MODAL -->
<form class="modal fade" id="sharefile" data-backdrop="static" action="" method="post">
    <div class="modal-dialog modal-md">
        <!--MODAL CONTENT-->
        <div class="modal-content">
           <!--MODAL HEADER-->
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>-->
                <h4 class="modal-title" id="modaltitle"> Share File / Folder <span id="file_name"></span> </h4>
            </div>

            <!--END OF MODAL HEADER -->
            <!--MODAL BODY-->
            
            
        <div class="modal-body">
            
            <div class="form-group">
                <select name="shareselection" id="shareselection" class="form-control shareselection" style="width: 100%;">
                    <option value="none" selected>How You want To share</option>
                    <option value="user_share">Share With User</option>
                    <option value="group_share">Share With Group</option>
                </select>
            </div>

            <div class="form-group">
                <select class="form-control selectusers" name="selectusers[]" multiple="multiple" id="selectusers" data-placeholder="Select Users" style="width: 100%;">

                    <?php
                        $sql = "SELECT * FROM users WHERE user_email != '$session_user_email'";
                        $result_set = mysqli_query($connection, $sql);
                        confirmQuery($result_set);
                        while($row = mysqli_fetch_assoc($result_set)){
                            extract($row);
                    ?>
                        <option value = "<?php echo $user_id; ?>"> <?php echo $user_email; ?> </option>;
                    <?php
                        }
                    ?>

                </select>
            </div>

            <div class="form-group">
                <select class="form-control selectgroup" name="selectgroup[]" multiple="multiple" id="selectgroup" data-placeholder="Select Group" style="width: 100%;" hidden>

                    <?php
                    $sql = "SELECT * FROM groups WHERE deleted=0";
                    $result_set = mysqli_query($connection, $sql);
                    confirmQuery($result_set);
                    while($row = mysqli_fetch_assoc($result_set)){
                        extract($row);
                        ?>
                        <option value = "<?php echo $group_id; ?>"> <?php echo $group_name; ?> </option>";
                        <?php
                    }
                   ?>

                </select>
            </div>
                   
            <div class="form-group">
                <input type="number" min="1" max="60" placeholder="Enter The Time Limit( LEAVE BLANK FOR NO TIME LIMIT )" class="form-control" id="input_time" name="input_time">
            </div>
            <div class="form-group">
                <select class="form-control selectTimeLimit" placeholder="Select Time Limit" id="selectTimeLimit" name="selectTimeLimit" style="width: 100%;" >
                    <option value="second">Seconds</option>
                    <option value="minute">Minutes</option>
                    <option value="hour">Hours</option>
                    <option value="day">Days</option>
                    <option value="week">Week</option>
                </select>
            </div>

            </div>
            <!--END OF MODAL BODY -->
            <!--MODAL FOOTER-->
            <div class="modal-footer">
                <button class="btn custom-outline outline-danger" id = "btntocancel" data-target = "#sharefile" data-dismiss = "modal"><span class="fa fa-times"></span> Cancel</button> 
                <button type="button" class="btn custom-outline outline-success" name="btntoshare" id = "btntoshare"><span class="fa fa-check"></span> Share</button>
            </div>
            <!--END OF MODAL-FOOTER -->
        </div>
        <!--END OF MODAL CONTENT -->
    </div>
    <!-- END OF MODAL DIALOG -->
</form>
<!--class modal -->
<!--END OF MODAL-->