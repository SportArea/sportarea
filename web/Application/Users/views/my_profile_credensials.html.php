<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered bg-inverse">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-user font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold">
                        &nbsp;Profilul meu &#187; <?php echo $template['title'] ?>
                    </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="actions"></div>
            </div>

            <!-- Start body -->
            <div class="portlet-body">
                <div class="tabbable tabbable-custom">
                    <?php require_once ROOT .'/Application/Users/views/_tabs.html.php'; ?>
                    <div class="tab-content">
                        <div class="tab-pane fade active in">
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="" method="post" class="form-horizontal validate" novalidate="novalidate">
                                    <div class="form-body">

                                        <!-- E-mail / E-mail -->
                                        <div class="form-group">
                                            <label class="control-label col-md-3">E-mail</label>
                                            <div class="col-md-4">
                                                <div class="input-icon">
                                                    <i class="fa fa-envelope-o"></i>
                                                    <input type="text" class="form-control" placeholder="E-mail" value="<?php echo (isset($user['email']) ? $user['email'] : null)?>" readonly="readonly" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Current password / Parola curenta -->
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Parola curenta</label>
                                            <div class="col-md-4">
                                                <div class="input-icon left">
                                                    <i class="fa fa-key"></i>
                                                    <input name="password" type="password" class="form-control" placeholder="Parola curenta" required="requried" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- New password / Parola noua -->
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Parola noua</label>
                                            <div class="col-md-4">
                                                <div class="input-icon left">
                                                    <i class="fa fa-key"></i>
                                                    <input name="new_password" type="password" class="form-control" placeholder="Parola noua" required="requried" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Repeat new password / Repetati parola noua -->
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Repetati parola noua</label>
                                            <div class="col-md-4">
                                                <div class="input-icon left">
                                                    <i class="fa fa-key"></i>
                                                    <input name="repeat_new_password" type="password" class="form-control" placeholder="Repetati parola noua" required="requried" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Submit -->
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <button type="button" data-action="submit" class="btn green-meadow save">
                                                    <i class="fa fa-save"></i>&nbsp;
                                                    SALVEAZĂ
                                                </button>

                                                <button type="button" data-href="<?php echo BASE_URL ?>" class="btn grey-cascade">
                                                    <i class="fa fa-times"></i>&nbsp;
                                                    RENUNȚĂ
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End body -->
        </div>
    </div>
</div>