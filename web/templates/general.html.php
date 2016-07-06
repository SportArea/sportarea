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
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN OVERWRITE THEME STYLE -->
    <link href="<?php echo BASE_URL ?>/assets/css/custom.css?version=<?=\Application\Settings\SettingsModel::get('environment') == 'development' ? time() : VERSION?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo BASE_URL ?>/assets/css/public.css?version=<?=\Application\Settings\SettingsModel::get('environment') == 'development' ? time() : VERSION?>" rel="stylesheet" type="text/css"/>
    <?php echo $css; ?>
    <!-- END OVERWRITE THEME STYLE -->

    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript">
        var BASE_URL = '<?php echo BASE_URL?>';
    </script>
    <!-- START CONTROLLER JS -->
    <?php echo $js ?>
    <!-- END -->
</head>
<body id="body">
    <?php echo $body; ?>
</body>
</html>