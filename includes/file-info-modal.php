<!--MODAL -->
<form class="modal fade form-file-info" id="fileinfo" data-backdrop="static" action="" method="post">
    <div class="modal-dialog modal-md">
        <!--MODAL CONTENT-->
        <div class="modal-content">
            <!--MODAL HEADER-->
            <div class="modal-header">
                <!--                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>-->
                <h4 class="modal-title unselectable" id="modaltitle"> Information <span id="file_name"></span> </h4>
            </div>

            <!--END OF MODAL HEADER -->

            <!--MODAL BODY-->


            <div class="modal-body">

                <input type="text" id="file_id" class="form-control unselectable" hidden="true" name="input_file_id">

                <div id="file_to_show" class="unselectable"></div>

            </div>
            <!--END OF MODAL BODY -->

            <!--MODAL FOOTER-->
            <div class="modal-footer">
                <button class="btn custom-outline outline-danger" id="btndelete"><i class="fa fa-times"></i> Delete</button>
                <button class="btn custom-outline outline-custom-blue" id="btnokay" data-target="#fileinfo" data-dismiss="modal"><span class="fa fa-check"></span> Okay</button>
            </div>

            <!--END OF MODAL-FOOTER -->
        </div>
        <!--END OF MODAL CONTENT -->
    </div>
    <!-- END OF MODAL DIALOG -->
</form>
<!--class modal -->
<!--END OF MODAL-->
