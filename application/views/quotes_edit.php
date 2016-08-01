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
                        <?php echo $page_title; ?> 
                    </h3>
                    <!--<hr>-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo $basePath;?>quotes/index.html">Quotes</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <?php echo $page_title; ?> 
                            </li>
                        </ul>
                    </div>                    
                    <!-- END PAGE HEADER-->

                    <!-- BEGIN PAGE CONTENT -->
                    <div class="row page_content">
                        <div class="col-md-12">

                            <div class="row margin-bottom-10">
                                <h4 style="color: red;" id="msg_alert"></h4>
                            </div>

                            <form id="frm_input" name="frm_input" action="#" method="post" role="form" class="form-horizontal">
                            <div class="row margin-bottom-30">
                                <div class="col-md-8">
                                    <div class="row form-group">
                                        <label class="control-label col-md-2">Likes :</label>
                                        <div class="col-md-8">
                                            <input type="number" class="form-control" name="txt_likes" id="txt_likes" value="<?php echo $quotes['rv']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="control-label col-md-2">Quotes :</label>
                                        <div class="col-md-8">
                                            <button type="button" class="btn blue" id="btn_add_logo">Select..</button>
                                            <input type="file" name="file" id="takeFileUpload" style="display: none;" accept=".jpg,.jpeg,.png,.gif" data-url="<?php echo $basePath;?>api/upload/v1">
                                        </div>
                                    </div>
                                    <div class="row margin-bottom-10  form-group">
                                        <label class="control-label col-md-2"></label>
                                        <div class="col-md-8">
                                            <div class="progress" id="upload_progressbar">
                                                <span class="meter" style="width: 0;"></span>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="row margin-bottom-10 form-group">
                                        <label class="control-label col-md-2"></label>
                                        <div class="col-md-8">
                                            <img id="subject_logo" data-filename="<?php echo $kind=="add" ? '' : $quotes['url']; ?>" src="<?php echo RESOURCE_PREFIX . $quotes['url'];?>" alt="" style="width:250px; border: 1px solid #ddd; padding: 2px;">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4"></div>
                            </div>
                                
                            <div class="row margin-bottom-10 form-actions">
                                <button type="submit" class="btn btn-warning">Submit</button>
                                <span>After finish editing, click submit to save quotes.</span>
                                <input type="hidden" name="kind" id="edit_detail_kind" value="<?php echo $kind;?>">
                                <input type="hidden" name="quotes_id" id="edit_detail_id" value="<?php echo $quotes_id;?>">
                            </div>
                                
                            </form>

                        </div>
                    </div>    
                    <!-- END PAGE CONTENT -->

                </div>
            </div>
            <!-- END CONTENT -->

        </div>
        <!-- END CONTAINER -->

        <form id="form_move_list" action="<?php echo $basePath;?>quotes/index.html" method="post">
        </form>

        
        <?php require 'common/footer.php'; ?>
        <script src="<?php echo $resPath;?>assets/plugins/jquery-crop/script/jquery.mousewheel.min.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core componets
                Layout.init(); // init layout
            });
        </script>
        <!-- END JAVASCRIPTS -->

        <script src="<?php echo $resPath;?>assets/scripts/quotes_edit.js" type="text/javascript"></script>

    </body>

    <!-- END BODY -->
</html>
