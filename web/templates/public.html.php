<?php
/**
 * Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.2.0
 * Version: 3.3.0
 */
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--[if !IE]><!-->
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $template['title']?> | SportArea</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="shortcut icon" href="<?php echo BASE_URL ?>/favicon.ico" />

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link id="style_color" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->

        <!-- BEGIN OVERWRITE THEME STYLE -->
        <link href="<?php echo BASE_URL ?>/assets/css/custom.css?version=<?=\Application\Settings\SettingsModel::get('environment') == 'development' ? time() : VERSION?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/css/public.css?version=<?=\Application\Settings\SettingsModel::get('environment') == 'development' ? time() : VERSION?>" rel="stylesheet" type="text/css"/>
        <?php echo $css; ?>       
        <!-- END OVERWRITE THEME STYLE -->

        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/respond.min.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/excanvas.min.js"></script>
        <![endif]-->
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
        <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/select2/select2.min.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/js/plugins/jquery-numeric/jquery.numeric.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/scripts/demo.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/scripts/login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <script type="text/javascript">
            var BASE_URL = '<?php echo BASE_URL?>';
        </script>

        <!-- START CONTROLLER JS -->
        <?php echo $js ?>
        <!-- END -->

        <script src="<?php echo BASE_URL ?>/assets/js/global.js?version=<?=\Application\Settings\SettingsModel::get('environment') == 'development' ? time() : VERSION?>" type="text/javascript"></script>

    </head>
    <body class="login">

        <?php echo $body; ?>

        <!-- BEGIN COPYRIGHT -->
        <div class="copyright">
             <?php echo date('Y') ?> &copy; SportArea. Toate drepturile rezervate.
        </div>
        <!-- END COPYRIGHT -->

        <script type="text/javascript">
            jQuery(document).ready(function() {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                QuickSidebar.init(); // init quick sidebar
            });
        </script>
        <!-- END JAVASCRIPTS -->

    </body>
</html>
