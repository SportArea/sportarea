<div class="logo">
    <img src="<?php echo BASE_URL ?>/assets/img/logo.png" />
</div>
<!-- END LOGO -->

<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->

<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form id="login-form" class="login-form" action="<?php echo BASE_URL ?>/admin" method="post">
        <h3 class="form-title">Logheaza-te in contul tau</h3>

        <?php \SportArea\Core\Uim::showErrorAndMessagesLogs() ?>

        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">E-mail</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" autofocus="true" placeholder="E-mail" name="email" 
                       required="required" email="email" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Parola</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Parolă" name="password" required="required"/>
            </div>
        </div>
        <div class="form-actions">
            <label class="checkbox">
                <input type="checkbox" name="remember" value="1" /> Ține minte datele de logare
            </label>
            <button type="submit" class="btn green pull-right">
                Login <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>

        <div class="forget-password">
            <div class="clearfix"></div>
        </div>
    </form>
    <!-- END LOGIN FORM -->
</div>