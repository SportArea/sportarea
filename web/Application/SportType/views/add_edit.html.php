<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered bg-inverse">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-wrench font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold">
                        Setări &#187; Tipuri de sporturi &#187; <?php echo isset($type['id']) ? 'Actualizare date' : 'Adăugare tip de sport nou' ?>
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
                                <form id="add_edit_sport_type" action="" method="post" class="form-horizontal">
                                    <div class="form-body">
                                        <h3 class="form-section">Informatii</h3>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Denumire <span class="required"> * </span></label>

                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <input name="type[name]" maxlength="100" type="text"
                                                           class="form-control" placeholder="Denumire"
                                                           value="<?php echo(isset($type['name']) ? $type['name'] : null) ?>"
                                                           required="required"/>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Stare<span class="required"> * </span></label>

                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select name="type[status]" class="form-control"
                                                            required="required" title="Stare">
                                                        <option
                                                            value="<?php echo Application\SportType\SportTypeModel::STATUS_ACTIVE; ?>"
                                                            <?php echo ((isset($type['status']) && $type['status'] == Application\SportType\SportTypeModel::STATUS_ACTIVE) || !isset($type['status'])) ? "selected='selected'" : ""; ?>>
                                                            Activ
                                                        </option>
                                                        <option
                                                            value="<?php echo Application\SportType\SportTypeModel::STATUS_INACTIVE; ?>"
                                                            <?php echo((isset($type['status']) && $type['status'] == Application\SportType\SportTypeModel::STATUS_INACTIVE) ? "selected='selected'" : ""); ?>>
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
                                                <button type="button" class="btn green-meadow save-sport-type">
                                                    <i class="fa fa-save"></i>&nbsp;
                                                    SALVEAZĂ
                                                </button>
                                                <button type="button" data-href="<?php echo BASE_URL ?>/sport_type/index"
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