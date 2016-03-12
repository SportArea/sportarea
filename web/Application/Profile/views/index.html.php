<!-- BEGIN PAGE HEADER-->
<h3 class="page-title" xmlns="http://www.w3.org/1999/html">
    Profilul meu
</h3>

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="javascript:void(0);">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="javascript:void(0);">Profilul meu</a>
        </li>
    </ul>
</div>

<div class="row margin-top-20">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light portlet-color profile-sidebar-portlet">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="../../../assets/img/user.png" class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
                    </div>
                    <div class="profile-usertitle-job">
                        <?php echo isset($userRole['name'])? $userRole['name'] : ''; ?>
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab">Informatii Personale</a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab">Schimbare Parola</a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-color">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Informatii profil</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                    <form id="edit_profile_info" action="" method="post">
                                        <div class="form-group">
                                            <label class="control-label">Nume<span
                                                    class="required"> * </span></label>
                                            <div class="input-icon right">
                                                <input name="user[first_name]" maxlength="100" type="text" class="form-control" placeholder="Nume" value="<?php echo (isset($user['first_name']) ? $user['first_name'] : null) ?>" required="required" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Prenume<span
                                                    class="required"> * </span></label>
                                            <div class="input-icon right">
                                                <input name="user[last_name]" maxlength="100" type="text" class="form-control" placeholder="Prenume" value="<?php echo (isset($user['last_name']) ? $user['last_name'] : null) ?>" required="required" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Email<span
                                                    class="required"> * </span></label>
                                            <div class="input-icon right">
                                                <input name="user[email]" maxlength="100" email="email" type="text" class="form-control" placeholder="Email" value="<?php echo (isset($user['email']) ? $user['email'] : null) ?>" required="required" />
                                            </div>
                                        </div>
                                        <div class="margiv-top-10">
                                            <button type="button" class="btn green-meadow save-profile">
                                                <i class="fa fa-save"></i>&nbsp;
                                                SALVEAZĂ
                                            </button>
                                            <button type="button" data-href="<?php echo BASE_URL ?>/dashboard/index" class="btn grey-cascade">
                                                <i class="fa fa-times"></i>&nbsp;
                                                RENUNȚĂ
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <form id="edit_profile_pass" action="" method="post" name="change_password">
                                        <div class="form-group">
                                            <label class="control-label">Parola veche<span
                                                    class="required"> * </span></label>
                                            <input type="password" id="oldPassword" name="oldPassword" class="form-control" placeholder="Parola veche" required="required"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Parola noua<span
                                                    class="required"> * </span></label>
                                            <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="Parola noua" required="required"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Confirma parola noua<span
                                                    class="required"> * </span></label>
                                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirma parola noua" required="required"/>
                                        </div>
                                        <div class="margiv-top-10">
                                            <button type="button" class="btn green-meadow save-change-password">
                                                <i class="fa fa-save"></i>&nbsp;
                                                SALVEAZĂ
                                            </button>
                                            <button type="button" data-href="<?php echo BASE_URL ?>/dashboard/index" class="btn grey-cascade">
                                                <i class="fa fa-times"></i>&nbsp;
                                                RENUNȚĂ
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- END CHANGE PASSWORD TAB -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>