<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered bg-inverse">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-wrench font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold">Setări &#187; Roluri <?php echo (array_intersect(array('Superadmin'), $loggedUser['roles'])) ? ' globale' : null?></span>
                    <span class="caption-helper"></span>
                </div>

                <div class="actions">
                    <?php if(!array_intersect(array('Superadmin'), $loggedUser['roles'])):?>
                    <button class="btn btn-sm filter-submit margin-bottom green-meadow" data-toggle="modal" href="#modal-add-role" style="border: solid #1CAF9A 1px">
                        <i class="fa fa-plus"></i>
                        &nbsp;Adaugă rol nou
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Start body -->
            <div class="portlet-body">
                <div class="tabbable tabbable-custom">
                    <?php require_once ROOT .'/Application/Settings/views/_tabs.html.php'; ?>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_1_1">
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="" method="post" class="form-horizontal">

                                    <div class="form-body" style="padding-left: 10px;">
                                        <?php foreach ($roles as $role): ?>
                                            <div class="pull-left">
                                                <div class="form-group">
                                                    <label class="control-label bold">&nbsp;&nbsp;<?php echo $role['name'] ?></label>
                                                    <?php if ($role['account_id']): ?>
                                                        <a href="" data-target="#modal-delete-role-<?php echo $role['id'] ?>" data-toggle="modal"><i class="fa fa-trash-o font-red"></i></a>
                                                        <!-- Modal : START - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                                                        <div class="modal fade" id="modal-delete-role-<?php echo $role['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                        <h4 class="modal-title">Șterge rol</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                Sunteti sigur ca doriti sa stergeti rolul <strong><?php echo $role['name'] ?></strong>?
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" data-href="<?php echo BASE_URL ?>/roles/delete/<?php echo $role['id'] ?>" class="btn red">
                                                                            <i class="fa fa-trash-o"></i>&nbsp;
                                                                            ȘTERGE ROLUL
                                                                        </button>
                                                                        <button type="button" class="btn grey-cascade" data-dismiss="modal">
                                                                            <i class="fa fa-times"></i>&nbsp;
                                                                            RENUNȚĂ
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal : END  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                                                    <?php endif; ?>
                                                    <div class="col-md-11">
                                                        <div class="checkbox-list">
                                                            <?php
                                                            foreach ($modules as $module):
                                                                $disabled = (!$role['account_id'] && !array_intersect(array('Superadmin'), $loggedUser['roles']) ? true : false);
                                                                ?>
                                                                <label><input <?php if (!$disabled): ?>name="rolesInModules[<?php echo $role['id'] ?>][<?php echo $module['id'] ?>]"<?php else : ?>disabled="disabled"<?php endif; ?> type="checkbox" <?php echo (in_array($role['id'] . '_' . $module['id'], $rolesInModulesCompact)) ? 'checked="checked"' : null ?>  value="1" /><?php echo $module['name'] ?></label>
                                                                <?php
                                                                if(isset($module['submodules']) && \SportArea\Core\Validate::isArray($module['submodules'], null, 1)):
                                                                    foreach ($module['submodules'] as $submodule):
                                                                ?>
                                                                <label style="margin-left: 20px;"><input <?php if (!$disabled): ?>name="rolesInModules[<?php echo $role['id'] ?>][<?php echo $submodule['id'] ?>]"<?php else : ?>disabled="disabled"<?php endif; ?> type="checkbox" <?php echo (in_array($role['id'] . '_' . $submodule['id'], $rolesInModulesCompact)) ? 'checked="checked"' : null ?>  value="1" /><?php echo $submodule['name'] ?></label>
                                                                <?php
                                                                    endforeach;
                                                                endif;
                                                            endforeach;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <div class="clearfix"></div>
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


<?php if(!array_intersect(array('Superadmin'), $loggedUser['roles'])):?>
<!-- Add new role / Adaugă rol nou -->
<div class="modal fade" id="modal-add-role" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo BASE_URL?>/roles/add" method="post" class="validate" novalidate="novalidate">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Adaugă rol nou</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-icon right">
                                <input name="name" type="text" class="form-control" placeholder="Denumirea rolului" required="required" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Submit -->
                    <button type="button" data-action="submit" class="btn green-meadow save">
                        <i class="fa fa-save"></i>&nbsp;
                        SALVEAZĂ
                    </button>

                    <button type="button" data-dismiss="modal" class="btn grey-cascade">
                        <i class="fa fa-times"></i>&nbsp;
                        RENUNȚĂ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>