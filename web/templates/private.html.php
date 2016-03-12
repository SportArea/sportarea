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
    <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title>SportArea | Admin - <?php echo $template['title']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="shortcut icon" href="<?php echo BASE_URL ?>/favicon.ico" />

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>

        <!-- <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/> -->
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/css/timeline.css" rel="stylesheet" type="text/css"/>

        <!-- Form components -->
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/typeahead/typeahead.css">

        <!-- Toastr Notifications -->
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-toastr/toastr.min.css" />

        <!-- Date picker -->
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/clockface/css/clockface.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>

        <!-- END PAGE LEVEL PLUGIN STYLES -->

        <!-- BEGIN PAGE STYLES -->
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE STYLES -->

        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->

        <?php echo $css; ?>

        <!-- BEGIN OVERWRITE THEME STYLE -->
        <link href="<?php echo BASE_URL ?>/assets/css/custom.css?version=<?=\Application\Settings\SettingsModel::get('environment') == 'development' ? time() : VERSION?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo BASE_URL ?>/assets/css/private.css?version=<?=\Application\Settings\SettingsModel::get('environment') == 'development' ? time() : VERSION?>" rel="stylesheet" type="text/css"/>
        <!-- END OVERWRITE THEME STYLE -->

        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

        <script type="text/javascript">
            var BASE_URL            =   '<?php echo BASE_URL?>';
            var DATE_FORMAT         =   '<?php echo str_replace(array('Y', 'm', 'd'), array('yyyy', 'mm', 'dd'), Application\Settings\SettingsModel::get('date_format'));?>';
            var DATE_FORMAT_JQUERY  =   '<?php echo str_replace(array('Y', 'm', 'd'), array('yyyy', 'MM', 'dd'), Application\Settings\SettingsModel::get('date_format'));?>';
        </script>
    </head>
    <!-- BEGIN BODY -->
    <!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
    <!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
    <!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
    <!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
    <!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
    <!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
    <!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
    <!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
    <!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
    <body class="page-header-fixed page-quick-sidebar-over-content">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="<?php echo BASE_URL?>">
                        <img src="<?php echo BASE_URL ?>/assets/img/logo.png" alt="logo" class="logo-default"/>
                    </a>
                    <div class="menu-toggler sidebar-toggler hide">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="#" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown dropdown-user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle hide1" src="<?php echo \Application\Users\UsersModel::getAvatar($loggedUser['id']) ?>" />
                                <span class="username username-hide-on-mobile"><?php echo $loggedUser['first_name']?></span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo BASE_URL?>/profile/index"><i class="icon-user"></i>&nbsp;&nbsp;Profilul meu</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL?>/admin/logout"><i class="icon-key"></i>&nbsp;&nbsp;Log Out</a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <div class="clearfix">
        </div>

        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler">
                            </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>

                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        <li class="sidebar-search-wrapper">
                            <?php if(false):?>
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                            <form class="sidebar-search " action="extra_search.html" method="POST">
                                <a href="#" class="remove">
                                    <i class="icon-close"></i>
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <a href="#" class="btn submit"><i class="icon-magnifier"></i></a>
                                    </span>
                                </div>
                            </form>
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                            <?php else:?>
                            <br />
                            <?php endif;?>
                        </li>

                        <!-- Dashboard -->
                        <li class="start <?php echo (isset($template['activeMenu']) AND $template['activeMenu'] == 'dashboard') ? 'open active' : null?>">
                            <a href="<?php echo BASE_URL?>/dashboard/index">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <?php
                        if(isset($menuModules) && \SportArea\Core\Validate::isArray($menuModules, null, 1)):
                            foreach ($menuModules as $module):
                                // If has access to module
                                if(isset($loggedUser) && isset($loggedUser['modules']) && \SportArea\Core\Validate::isArray($loggedUser['modules'], null, 1) && $module['menu'] && in_array($module['table'], $loggedUser['modules'])):
                        ?>
                        <!-- <?php echo $module['name']?> -->
                        <li class="<?php echo (isset($template['activeMenu']) AND $template['activeMenu'] == $module['table']) ? 'open active' : null?>">
                            <a href="<?php echo BASE_URL?>/<?php echo $module['table']?>/index">
                                <i class="<?php echo $module['menu_icon']?>"></i>
                                <span class="title"><?php echo $module['name']?></span>
                                <?php echo (isset($template['activeMenu']) AND $template['activeMenu'] == $module['table']) ? '<span class="selected"></span>' : null?>
                            </a>
                        </li>
                        <?php
                                endif;
                            endforeach;
                        endif;
                        ?>

                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <?php if(true):?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <?php echo \SportArea\Core\Uim::showErrorAndMessagesLogs(); ?>
                    <?php echo $body?>
                </div>
            </div>
            <?php else:?>
            <!-- BEGIN PAGE -->
            <div class="page-content">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div id="portlet-config" class="modal hide">
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button"></button>
                        <h3>portlet Settings</h3>
                    </div>
                    <div class="modal-body">
                        <p>Here will be a configuration form</p>
                    </div>
                </div>
                <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <!-- BEGIN PAGE CONTAINER-->
                <div class="container-fluid">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="row-fluid">
                        <div class="span12">
                            <!-- BEGIN STYLE CUSTOMIZER -->
                            <div class="color-panel hidden-phone">
                                <div class="color-mode-icons icon-color"></div>
                                <div class="color-mode-icons icon-color-close"></div>
                                <div class="color-mode">
                                    <p>THEME COLOR</p>
                                    <ul class="inline">aaa</ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="#" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
            <div class="page-quick-sidebar-wrapper">
                <div class="page-quick-sidebar">
                    <div class="nav-justified">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active">
                                <a href="#quick_sidebar_tab_1" data-toggle="tab">
                                    Users <span class="badge badge-danger">2</span>
                                </a>
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_2" data-toggle="tab">
                                    Alerts <span class="badge badge-success">7</span>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    More<i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-bell"></i> Alerts </a>
                                    </li>
                                    <li>
                                        <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-info"></i> Notifications </a>
                                    </li>
                                    <li>
                                        <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-speech"></i> Activities </a>
                                    </li>
                                    <li class="divider">
                                    </li>
                                    <li>
                                        <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                            <i class="icon-settings"></i> Settings </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                                <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                    <h3 class="list-heading">Staff</h3>
                                    <ul class="media-list list-items">
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-success">8</span>
                                            </div>
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar3.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Bob Nilson</h4>
                                                <div class="media-heading-sub">
                                                    Project Manager
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar1.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Nick Larson</h4>
                                                <div class="media-heading-sub">
                                                    Art Director
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-danger">3</span>
                                            </div>
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar4.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Deon Hubert</h4>
                                                <div class="media-heading-sub">
                                                    CTO
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar2.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Ella Wong</h4>
                                                <div class="media-heading-sub">
                                                    CEO
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <h3 class="list-heading">Customers</h3>
                                    <ul class="media-list list-items">
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-warning">2</span>
                                            </div>
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar6.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Lara Kunis</h4>
                                                <div class="media-heading-sub">
                                                    CEO, Loop Inc
                                                </div>
                                                <div class="media-heading-small">
                                                    Last seen 03:10 AM
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="label label-sm label-success">new</span>
                                            </div>
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar7.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Ernie Kyllonen</h4>
                                                <div class="media-heading-sub">
                                                    Project Manager,<br>
                                                    SmartBizz PTL
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar8.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Lisa Stone</h4>
                                                <div class="media-heading-sub">
                                                    CTO, Keort Inc
                                                </div>
                                                <div class="media-heading-small">
                                                    Last seen 13:10 PM
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-success">7</span>
                                            </div>
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar9.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Deon Portalatin</h4>
                                                <div class="media-heading-sub">
                                                    CFO, H&D LTD
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar10.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Irina Savikova</h4>
                                                <div class="media-heading-sub">
                                                    CEO, Tizda Motors Inc
                                                </div>
                                            </div>
                                        </li>
                                        <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-danger">4</span>
                                            </div>
                                            <img class="media-object" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar11.jpg" alt="...">
                                            <div class="media-body">
                                                <h4 class="media-heading">Maria Gomez</h4>
                                                <div class="media-heading-sub">
                                                    Manager, Infomatic Inc
                                                </div>
                                                <div class="media-heading-small">
                                                    Last seen 03:10 AM
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="page-quick-sidebar-item">
                                    <div class="page-quick-sidebar-chat-user">
                                        <div class="page-quick-sidebar-nav">
                                            <a href="#" class="page-quick-sidebar-back-to-list"><i class="icon-arrow-left"></i>Back</a>
                                        </div>
                                        <div class="page-quick-sidebar-chat-user-messages">
                                            <div class="post out">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar3.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:15</span>
                                                    <span class="body">
                                                        When could you send me the report ? </span>
                                                </div>
                                            </div>
                                            <div class="post in">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar2.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Ella Wong</a>
                                                    <span class="datetime">20:15</span>
                                                    <span class="body">
                                                        Its almost done. I will be sending it shortly </span>
                                                </div>
                                            </div>
                                            <div class="post out">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar3.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:15</span>
                                                    <span class="body">
                                                        Alright. Thanks! :) </span>
                                                </div>
                                            </div>
                                            <div class="post in">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar2.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Ella Wong</a>
                                                    <span class="datetime">20:16</span>
                                                    <span class="body">
                                                        You are most welcome. Sorry for the delay. </span>
                                                </div>
                                            </div>
                                            <div class="post out">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar3.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:17</span>
                                                    <span class="body">
                                                        No probs. Just take your time :) </span>
                                                </div>
                                            </div>
                                            <div class="post in">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar2.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Ella Wong</a>
                                                    <span class="datetime">20:40</span>
                                                    <span class="body">
                                                        Alright. I just emailed it to you. </span>
                                                </div>
                                            </div>
                                            <div class="post out">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar3.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:17</span>
                                                    <span class="body">
                                                        Great! Thanks. Will check it right away. </span>
                                                </div>
                                            </div>
                                            <div class="post in">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar2.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Ella Wong</a>
                                                    <span class="datetime">20:40</span>
                                                    <span class="body">
                                                        Please let me know if you have any comment. </span>
                                                </div>
                                            </div>
                                            <div class="post out">
                                                <img class="avatar" alt="" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/img/avatar3.jpg"/>
                                                <div class="message">
                                                    <span class="arrow"></span>
                                                    <a href="#" class="name">Bob Nilson</a>
                                                    <span class="datetime">20:17</span>
                                                    <span class="body">
                                                        Sure. I will check and buzz you if anything needs to be corrected. </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="page-quick-sidebar-chat-user-form">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Type a message here...">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn blue"><i class="icon-paper-clip"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                                <div class="page-quick-sidebar-alerts-list">
                                    <h3 class="list-heading">General</h3>
                                    <ul class="feeds list-items">
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            You have 4 pending tasks. <span class="label label-sm label-warning ">
                                                                Take action <i class="fa fa-share"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    Just now
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bar-chart-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                Finance Report for year 2013 has been released.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                        20 mins
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-danger">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            You have 5 pending membership that requires a quick review.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    24 mins
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            New order received with <span class="label label-sm label-success">
                                                                Reference Number: DR23923 </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    30 mins
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            You have 5 pending membership that requires a quick review.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    24 mins
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            Web server hardware needs to be upgraded. <span class="label label-sm label-warning">
                                                                Overdue </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    2 hours
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-default">
                                                                <i class="fa fa-briefcase"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                IPO Report for year 2013 has been released.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                        20 mins
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <h3 class="list-heading">System</h3>
                                    <ul class="feeds list-items">
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            You have 4 pending tasks. <span class="label label-sm label-warning ">
                                                                Take action <i class="fa fa-share"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    Just now
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-danger">
                                                                <i class="fa fa-bar-chart-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                Finance Report for year 2013 has been released.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                        20 mins
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-default">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            You have 5 pending membership that requires a quick review.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    24 mins
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            New order received with <span class="label label-sm label-success">
                                                                Reference Number: DR23923 </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    30 mins
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            You have 5 pending membership that requires a quick review.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    24 mins
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-warning">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
                                                                Overdue </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    2 hours
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-briefcase"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                IPO Report for year 2013 has been released.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                        20 mins
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                                <div class="page-quick-sidebar-settings-list">
                                    <h3 class="list-heading">General Settings</h3>
                                    <ul class="list-items borderless">
                                        <li>
                                            Enable Notifications <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                        </li>
                                        <li>
                                            Allow Tracking <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                        </li>
                                        <li>
                                            Log Errors <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                        </li>
                                        <li>
                                            Auto Sumbit Issues <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                        </li>
                                        <li>
                                            Enable SMS Alerts <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                        </li>
                                    </ul>
                                    <h3 class="list-heading">System Settings</h3>
                                    <ul class="list-items borderless">
                                        <li>
                                            Security Level
                                            <select class="form-control input-inline input-sm input-small">
                                                <option value="1">Normal</option>
                                                <option value="2" selected>Medium</option>
                                                <option value="e">High</option>
                                            </select>
                                        </li>
                                        <li>
                                            Failed Email Attempts <input class="form-control input-inline input-sm input-small" value="5"/>
                                        </li>
                                        <li>
                                            Secondary SMTP Port <input class="form-control input-inline input-sm input-small" value="3560"/>
                                        </li>
                                        <li>
                                            Notify On System Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                        </li>
                                        <li>
                                            Notify On SMTP Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                        </li>
                                    </ul>
                                    <div class="inner-content">
                                        <button class="btn btn-success"><i class="icon-settings"></i> Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner">
                <?php echo date('Y') ?> &copy; SportArea. Toate drepturile rezervate.
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->

        <!-- START IFRAME MODAL -->
        <div class="modal fade" id="iframe-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <iframe frameborder="0" id="iframe-in-modal"></iframe>
                    </div>
                    <div class="modal-footer">
                        <!-- Submit -->
                        <!--<button type="button" onclick="document.getElementById('iframe-in-modal').contentWindow.submitForm();" class="btn green-meadow save">-->
                        <button type="button" onclick="$('#iframe-in-modal').contents().find('button[data-action=submit]').trigger('click')" class="btn green-meadow save">
                            <i class="fa fa-save"></i>&nbsp;
                            SALVEAZĂ
                        </button>

                        <button type="button" data-dismiss="modal" class="btn grey-cascade">
                            <i class="fa fa-times"></i>&nbsp;
                            RENUNȚĂ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END IFRAME MODAL -->

        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/respond.min.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/excanvas.min.js"></script>
        <![endif]-->
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
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/select2/select2_locale_ro.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/scripts/datatable.js" type="text/javascript"></script>
        <!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/js/plugins/jquery-numeric/jquery.numeric.js" type="text/javascript"></script>

        <!-- FORM TAGS -->
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/js/table.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/js/helper.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function () {
                if (!jQuery().tagsInput) {
                    return;
                }
                $('.jqueryTags').tagsInput({
                    width: 'auto',
                    'defaultText':'Adaugă',
                    'removeWithBackspace' : true,
                    'onAddTag': function () {
                        //alert(1);
                    }
                });
            });
        </script>

        <!-- Date picker -->
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/clockface/js/clockface.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

        <!-- Toastr Notifications -->
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-toastr/toastr.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/scripts/ui-toastr.js"></script>
        <script>
            jQuery(document).ready(function () {
                UIToastr.init();
            });
        </script>


        <!-- wysiwyg -->
        <?php if(true):?>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/wysiwyg/src/wysiwyg-editor.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-summernote/summernote.css">

        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/wysiwyg/src/wysiwyg.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/wysiwyg/src/wysiwyg-editor.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/wysiwyg.js"></script>
        <?php else:?>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/assets/js/components-editors.js"></script>
        <script>
            jQuery(document).ready(function () {
                ComponentsEditors.init();
            });
        </script>
        <?php endif;?>

        <!-- ?? -->
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/fuelux/js/spinner.min.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
        <!-- wysiwyg conflict:<script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/plugins/ckeditor/ckeditor.js"></script> -->
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/layout/scripts/demo.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/scripts/index.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/scripts/tasks.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/scripts/table-managed.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/scripts/ui-extended-modals.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/scripts/components-pickers.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/vendor/metronic3.3.0/admin/pages/scripts/components-form-tools.js"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core componets
                Layout.init(); // init layout
                QuickSidebar.init(); // init quick sidebar
                TableManaged.init(); // Table manager
                ComponentsPickers.init(); // Datepicker
                AppTable.init();
                /*
                Demo.init(); // init demo features
                Index.init();
                Index.initDashboardDaterange();
                Index.initJQVMAP(); // init index page's custom scripts
                Index.initCalendar(); // init index page's custom scripts
                Index.initCharts(); // init index page's custom scripts
                Index.initChat();
                Index.initMiniCharts();
                Index.initIntro();
                Tasks.initDashboardWidget();
                UIExtendedModals.init();
                */
            });
        </script>
        <!-- END JAVASCRIPTS -->
        <?php echo $js?>
        <?php echo $inlineJs; ?>

        <script src="<?php echo BASE_URL ?>/assets/js/global.js?version=<?=\Application\Settings\SettingsModel::get('environment') == 'development' ? time() : VERSION?>" type="text/javascript"></script>
        <script src="<?php echo BASE_URL ?>/assets/js/vendor/jquery-dateFormat.min.js" type="text/javascript"></script>
    </body>
    <!-- END BODY -->
</html>