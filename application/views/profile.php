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
                        Profile <small>account information</small>
                    </h3>
                    <hr>
                    <!-- END PAGE HEADER-->
                    
                    <!-- BEGIN PAGE CONTENT -->
                    <div class="row page_content profile-page">
                        <div class="col-md-8 col-sm-8">
                        <form action="<?php echo $basePath;?>user/update_profile.html" method="post" role="form">
                            <div class="row margin-bottom-10" >
                                <h4 style="color: red;" id="msg_alert"><?php echo $message;?></h4>
                            </div>

                            <div class="row margin-bottom-10 form-group">
                                <label class="control-label col-md-3" for="email">E-mail :</label>
                                <div class="col-md-5">
                                <input type="text" placeholder="" id="email" name="email" class="form-control" required maxlength="200" value="<?php echo $account['email'];?>">
                                </div>
                            </div>
                            <div class="row margin-bottom-20 form-group">
                                <label class="control-label col-md-3" for="password">Password :</label>
                                <div class="col-md-5">
                                <input type="password" placeholder="" id="password" name="password" class="form-control" required maxlength="100" value="">
                                </div>
                            </div>
                            <div class="row margin-bottom-20 form-group">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-5">
                                <button type="submit" class="btn btn-warning">Update Profile</button>
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
                
                $('form').bootstrapValidator({
                    feedbackIcons: {
                        valid: 'has-success',
                        invalid: 'has-error',
                        validating: ''
                    },
                })
                .on('success.field.bv', function(e, data) {
                    if (data.bv.isValid()) {
                        data.bv.disableSubmitButtons(false);
                    }
                });
                
                if ($("#msg_alert").html()!=''){
                    setTimeout(hideAlert, 2000);
                }
            });
        </script>
        <!-- END JAVASCRIPTS -->
        
    </body>

    <!-- END BODY -->
</html>
