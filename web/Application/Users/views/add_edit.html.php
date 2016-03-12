<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered bg-inverse">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-wrench font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold">
                        Setări &#187; Utilizatori &#187; <?php echo isset($user['id']) ? 'Actualizare date' : 'Adăguare utilizator nou' ?>
                    </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="actions">
                </div>
            </div>

            <!-- Start body -->
            <div class="portlet-body">
                <div class="tabbable tabbable-custom">
                    <div class="tab-content">
                        <div class="tab-pane fade active in">
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form id="add_edit_user" action="" method="post" class="form-horizontal">
                                    <div class="form-body">
                                        <h3 class="form-section">Informatii personale</h3>
                                        <!-- User: First name / Nume -->
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Nume <span class="required"> * </span></label>

                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <input name="user[first_name]" maxlength="100" type="text"
                                                           class="form-control" placeholder="Nume"
                                                           value="<?php echo(isset($user['first_name']) ? $user['first_name'] : null) ?>"
                                                           required="required"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Prenume <span
                                                    class="required"> * </span></label>

                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <input name="user[last_name]" maxlength="100" type="text"
                                                           class="form-control" placeholder="Prenume"
                                                           value="<?php echo(isset($user['last_name']) ? $user['last_name'] : null) ?>"
                                                           required="required"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">E-mail<span
                                                    class="required"> * </span></label>

                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <i class="fa fa-envelope"></i>
                                                    <input name="user[email]" maxlength="100" email="email" type="text"
                                                           class="form-control" placeholder="Email"
                                                           value="<?php echo(isset($user['email']) ? $user['email'] : null) ?>"
                                                           required="required"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="credentials <?php if ($op == 'edit'): ?> hide<?php endif; ?>">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Parola <span
                                                        class="required"> * </span></label>

                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <input name="user[password]" type="password"
                                                               class="form-control" placeholder="Parola"
                                                               value="<?php echo(isset($user['cnp']) ? $user['cnp'] : null) ?>"
                                                               required="required"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Rol<span
                                                    class="required"> * </span></label>

                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select name="user[role]" class="form-control" required="required">
                                                        <option
                                                            value="<?php echo Application\Roles\RolesModel::ROLE_USER; ?>"
                                                            <?php echo ((isset($user['role']) && $user['role'] == Application\Roles\RolesModel::ROLE_USER) || !isset($user['role'])) ? "selected='selected'" : ""; ?>>
                                                            Utilizator
                                                        </option>
                                                        <option
                                                            value="<?php echo Application\Roles\RolesModel::ROLE_OPERATOR; ?>"
                                                            <?php echo ((isset($user['role']) && $user['role'] == Application\Roles\RolesModel::ROLE_OPERATOR) || !isset($user['role'])) ? "selected='selected'" : ""; ?>>
                                                            Operator
                                                        </option>
                                                        <option
                                                            value="<?php echo Application\Roles\RolesModel::ROLE_SUPERADMIN; ?>"
                                                            <?php echo((isset($user['role']) && $user['role'] == Application\Roles\RolesModel::ROLE_SUPERADMIN) ? "selected='selected'" : ""); ?>>
                                                            Superadmin
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Stare<span class="required"> * </span></label>

                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select name="user[status]" class="form-control"
                                                            required="required">
                                                        <option
                                                            value="<?php echo Application\Users\UsersModel::STATUS_ACTIVE; ?>"
                                                            <?php echo ((isset($user['status']) && $user['status'] == Application\Users\UsersModel::STATUS_ACTIVE) || !isset($user['status'])) ? "selected='selected'" : ""; ?>>
                                                            Activ
                                                        </option>
                                                        <option
                                                            value="<?php echo Application\Users\UsersModel::STATUS_SUSPENDED; ?>"
                                                            <?php echo((isset($user['status']) && $user['status'] == Application\Users\UsersModel::STATUS_SUSPENDED) ? "selected='selected'" : ""); ?>>
                                                            Inactiv
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Submit -->
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <button type="button" class="btn green-meadow save-user">
                                                    <i class="fa fa-save"></i>&nbsp;
                                                    SALVEAZĂ
                                                </button>
                                                <button type="button" data-href="<?php echo BASE_URL ?>/users/index"
                                                        class="btn grey-cascade">
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
                <!-- End body -->
            </div>
        </div>
    </div>
</div>