<?php require 'common/variable.php'; ?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <?php require 'common/header.php'; ?>
    </head>

    <body class="page-header-fixed page-quick-sidebar-over-content">
        <!-- BEGIN HEADER -->
        <?php require 'common/topbar.php'; ?>
        <!-- END HEADER -->

        <div class="clearfix">
        </div>

        <!-- BEGIN CONTAINER -->
        <div class="page-container">

            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <?php require 'common/sidebar.php'; ?>
                    <!-- END SIDEBAR MENU -->
                </div>
            </div>
            <!-- END SIDEBAR -->

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">

                    <!-- BEGIN PAGE HEADER-->
                    <h3 class="page-title">
                        Quotes <small>Add, Edit, Delete Quotes</small>
                    </h3>
                    <hr>
                    <!-- END PAGE HEADER-->
                    
                    <!-- BEGIN PAGE CONTENT -->
                    <div class="row page_content">
                        <div class="col-md-12">
                            
<!--                            <div class="row">
                                <div class="note note-info">
                                    <h3><font color="red">Manager</font> and <font color="red">SubjectManager</font> can do it. But <font color="red">SubjectManager</font> should have permission to update Subject.</h3>
                                    <ol>
                                        <li>
                                            Add, Edit or Delete Subject.
                                        </li>
                                        <li>
                                            Add topic to their Subject. (Add Topic)
                                        </li>
                                        <li>
                                            Rearrange topic in Subject. (Order Topic)
                                        </li>
                                        <li>
                                            Allow Subject to <font color="red">SubjectManager</font>. (Allocate Subject)
                                            <p>Only <font color="red">Manager</font> can do it. <font color="red">SubjectManager</font> will have permission to update Subject.</p>
                                        </li>
                                        <li>
                                            Allow Topic to <font color="red">TopicManager</font> in Subject. (Allocate Topic)
                                            <p><font color="red">TopicManager</font> will have permission to update all Topic in Subject.</p>
                                        </li>
                                        <li>
                                            Update Status to Editing/Serving. (Editing/Serving)
                                            <p>Only Subject of Serving will be served to Customer.</p>
                                        </li>
                                        <li>
                                            Update Sku ID. (Sku ID)
                                            <p>Sku ID is primary key for "In-App Purchase". Only <font color="red">Manager</font> can do it. </p>
                                        </li>
                                    </ol>
                                </div>                                    
                            </div>-->
                            
                            <div class="row margin-bottom-10">
                                <h4 style="color: red;" id="msg_alert"></h4>
                            </div>

                            <div class="row margin-bottom-20">
                                <div class="btn-group">
                                    <button id="btn_add" class="btn green">Add New <i class="fa fa-plus"></i></button>
                                    <button id="btn_import" class="btn red" style="margin-left: 10px;">Import Images <i class="fa fa-plus"></i></button>
                                </div>                                
                            </div>

                            <div class="row table-responsive">
                                <table id="table_content" class="display" cellspacing="0" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Quotes</th>
                                            <th width="5%" style="text-align: center;">Likes</th>
                                            <th width="15%" style="text-align: center;">Updated Time</th>
                                            <th width="10%" style="text-align: center;"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>    
                    <!-- END PAGE CONTENT -->

                </div>
            </div>
            <!-- END CONTENT -->

        </div>
        <!-- END CONTAINER -->
        
        <div class="modal fade " role="dialog" id="detail_dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h2 class="modal-title"></h2>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <img id="subject_logo" src="" alt="" style="width:150px; height: 150px; border: 1px solid #ddd; padding: 1px;">
                            </div>
                            <div class="col-md-8">
                                <h3 class="teacher_name"></h3>
                                <h5 class="price"></h5>
                                <p class="desc"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade " role="dialog" id="sku_dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Sku ID</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row modal-form-control">
                            <input type="text" id="sku_id" value="" placeholder="Sku ID" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
        <form id="form_move_edit" action="<?php echo $basePath;?>quotes/edit.html" method="post">
            <input type="hidden" name="kind" id="edit_detail_kind" value="">
            <input type="hidden" name="quotes_id" id="edit_detail_id" value="">
        </form>

        <form id="form_move_import" action="<?php echo $basePath;?>quotes/import.html" method="post">
        </form>
        
        <?php require 'common/footer.php'; ?>
        
        <input type="hidden" id="resource_path" value="<?php echo RESOURCE_PREFIX; ?>">
        
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core componets
                Layout.init(); // init layout
            });
        </script>
        <!-- END JAVASCRIPTS -->

        <script src="<?php echo $resPath;?>assets/scripts/quotes_list.js" type="text/javascript"></script>
        
    </body>

    <!-- END BODY -->
</html>
