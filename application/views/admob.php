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
                        Admob <small>enable/disable admob</small>
                    </h3>
                    <hr>
                    <!-- END PAGE HEADER-->
                    
                    <!-- BEGIN PAGE CONTENT -->
                    <div class="row page_content admob-panel">
                        <div class="col-md-8 col-sm-8">
                        <form action="<?php echo $basePath;?>user/update_profile.html" method="post" role="form">
                            <div class="row margin-bottom-10" >
                                <h4 style="color: red;" id="msg_alert"><?php echo $message;?></h4>
                            </div>

                            <div class="row margin-bottom-10">
                                <h4>Only one admob source can be enabled. The others will be disabled.</h4>
                            </div>
                            
                            <?php foreach ($admob as $row) {
                            ?>
                            <div class="row margin-bottom-10 form-group" data-kind="<?php echo $row['kind']; ?>">
                                <label class="control-label text-right col-md-3" for=""><?php echo $row['name'] ?> :</label>
                                <div class="col-md-2">
                                    <input type="checkbox" class="js-switch" <?php echo $row['status']=='1' ? "checked" : ""; ?> />
                                </div>
                                
                                <label class="control-label text-right col-md-3" for="">Frequency :</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control input-horizontal" value="<?php echo $row['frequency']; ?>">
                                </div>
                            </div>
                            <?php 
                            }?>
                            
                            <div class="row margin-bottom-10">
                                <label class="control-label text-right col-md-3" for=""></label>
                                <div class="col-md-6">
                                    <a class="btn btn-primary" href="#" id="btn_update" style="width: 200px;">Update</a>
                                </div>
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
       
        <?php require 'common/footer.php'; ?>
        
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core componets
                Layout.init(); // init layout
            });
        </script>
        <!-- END JAVASCRIPTS -->
        
        <script src="<?php echo $resPath;?>assets/scripts/admob.js" type="text/javascript"></script>
        
    </body>

    <!-- END BODY -->
</html>
