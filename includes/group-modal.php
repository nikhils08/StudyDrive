<?php
/**
 * Created by PhpStorm.
 * User: NIKHIL SHADIJA
 * Date: 3/21/2018
 * Time: 3:56 PM
 */

if(isset($_POST['create_group'])){
    $users_array = $_POST['selectusers'];
    $group_name = $_POST['group_name'];

    $group_create_query = "INSERT INTO groups(group_name, created_at, updated_at, created_by, updated_by, deleted) VALUES ('$group_name', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), $session_user_id, $session_user_id,0)";
    $group_create = mysqli_query($connection, $group_create_query);
    confirmQuery($group_create);
    $group_id = mysqli_insert_id($connection);

    foreach ($users_array as $selected_user_id) {
        $insert_user_to_group_query = "INSERT INTO group_users(group_id, user_id) VALUES ($group_id, $selected_user_id)";
        $insert_user_to_group = mysqli_query($connection, $insert_user_to_group_query);
        confirmQuery($insert_user_to_group);
    }
    header("Location: mydrive.php?file_id=$get_file_id");
}
?>
<!--MODAL -->
<form class="modal fade" id="creategroup" data-backdrop="static" action="" method="post">
    <div class="modal-dialog modal-md">
        <!--MODAL CONTENT-->
        <div class="modal-content">
            <!--MODAL HEADER-->
            <div class="modal-header">
                <!--                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>-->
                <h4 class="modal-title" id="modaltitle"> Create Group </h4>
            </div>

            <!--END OF MODAL HEADER -->
            <!--MODAL BODY-->


            <div class="modal-body">

                <div class="form-group">
                    <input type="text" name="group_name" id="group_name" placeholder="Enter Group Name" class="form-control">
                </div>


                <div class="form-group">
                    <select class="form-control selectusersgroup" name="selectusers[]" multiple="multiple" id="selectusers" data-placeholder="Select Users" style="width: 100%;">

                        <?php
                        $sql = "SELECT * FROM users WHERE user_email != '$session_user_email'";
                        $result_set = mysqli_query($connection, $sql);
                        confirmQuery($result_set);
                        while($row = mysqli_fetch_assoc($result_set)){
                            extract($row);
                            ?>
                            <option value = "<?php echo $user_id; ?>"> <?php echo $user_email; ?> </option>";
                            <?php
                        }
                        ?>

                    </select>
                </div>

            </div>
            <!--END OF MODAL BODY -->
            <!--MODAL FOOTER-->
            <div class="modal-footer">
                <button class="btn custom-outline outline-danger" id = "btn_group_cancel" data-target = "#creategroup" data-dismiss = "modal"><span class="fa fa-times"></span> Cancel</button>
                <button type="submit" class="btn custom-outline outline-success" name="create_group" id = "create_group"><span class="fa fa-check"></span> Create</button>
            </div>
            <!--END OF MODAL-FOOTER -->
        </div>
        <!--END OF MODAL CONTENT -->
    </div>
    <!-- END OF MODAL DIALOG -->
</form>
<!--class modal -->
<!--END OF MODAL-->
