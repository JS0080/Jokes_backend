<?php require 'common/variable.php'; ?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->

    <!-- Head BEGIN -->
    <head>
        <meta charset="utf-8">
        <title><?php echo APP_TITLE; ?></title>

        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <meta content="Modern Education" name="description">
        <meta content="keywords" name="keywords">
        <meta content="cjh124" name="author">

        <meta property="og:site_name" content="-CUSTOMER VALUE-">
        <meta property="og:title" content="-CUSTOMER VALUE-">
        <meta property="og:description" content="-CUSTOMER VALUE-">
        <meta property="og:type" content="website">
        <meta property="og:image" content="-CUSTOMER VALUE-"><!-- link to image for socio -->
        <meta property="og:url" content="-CUSTOMER VALUE-">

        <!-- Global styles START -->          
        <!--<link href="<?php echo $resPath; ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">-->
        <link href="<?php echo $resPath; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Global styles END --> 

        <!-- Theme styles START -->
        <link href="<?php echo $resPath; ?>assets/layout/css/components.css" rel="stylesheet">
        <link href="<?php echo $resPath; ?>assets/layout/css/themes/darkblue.css" rel="stylesheet" id="style-color">

        <link href="<?php echo $resPath; ?>assets/plugins/bootstrap-validator/css/bootstrapValidator.css" rel="stylesheet">

        <link href="<?php echo $resPath; ?>assets/layout/css/custom.css" rel="stylesheet">        

    </head>
    <!-- Head END -->

    <!-- Body BEGIN -->
    <body class="corporate">
        <div class="main">
            <div class="container">
                <div class="row register-box">
                    <form action="<?php echo $basePath; ?>user/signin.html" method="post" role="form">
                        <div class="row margin-bottom-10" style="text-align: center;">
                            <h1 style="color: #009be3;">Funny Quotes Admin</h1>
                        </div>

                        <div class="row margin-bottom-10" style='text-align: center;'>
                            <h4 style="color: red;" id="msg_alert"><?php echo $message; ?></h4>
                        </div>

                        <div class="row margin-bottom-10 form-group">
                            <input type="email" placeholder="E-mail" id="email" name="email" class="form-control" required maxlength="200" value="<?php echo $login_email; ?>">
                        </div>
                        <div class="row margin-bottom-30 form-group">
                            <input type="password" placeholder="Password" id="password" name="password" class="form-control" required maxlength="100">
                        </div>
                        <div class="row margin-bottom-20" style="text-align: center;">
                            <button type="submit" class="btn btn-warning">Log In</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <input type="hidden" id="basePath" value="<?php echo $basePath; ?>">
        <input type="hidden" id="resPath" value="<?php echo $resPath; ?>">

        <script src="<?php echo $resPath; ?>assets/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script src="<?php echo $resPath; ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
        <script src="<?php echo $resPath; ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>      
        <script src="<?php echo $resPath; ?>assets/plugins/bootstrap-validator/js/bootstrapValidator.min.js" type="text/javascript"></script>      

        <script src="<?php echo $resPath; ?>assets/scripts/common.js" type="text/javascript"></script>

        <script type="text/javascript">
            jQuery(document).ready(function () {
                $('form').bootstrapValidator({
                    feedbackIcons: {
                        valid: 'has-success',
                        invalid: 'has-error',
                        validating: ''
                    }
                })
                        .on('success.field.bv', function (e, data) {
                            if (data.bv.isValid()) {
                                data.bv.disableSubmitButtons(false);
                            }
                        });

                if ($("#msg_alert").html() != '') {
                    showAlert($("#msg_alert").html());
                }
            });
        </script>
        <!-- END PAGE LEVEL JAVASCRIPTS -->
    </body>

    <!-- END BODY -->
</html>
