<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered bg-inverse">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-wrench font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold">
                        Setări <?php echo (array_intersect(array('Superadmin'), $loggedUser['roles'])) ? ' globale' : null?>
                    </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="actions">

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
                                    <div class="form-body">
                                        <?php foreach ($settings as $settingCategory => $setting): ?>
                                        <h3 class="form-section">&nbsp;&nbsp;<?php echo $settingCategory?></h3>
                                            <?php foreach ($setting as $settingCategory => $setting): ?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3"><?php echo $setting['title'] ?></label>
                                                    <div class="col-md-4">
                                                        <?php if($setting['type'] == 'string'):?>
                                                        <input name="<?php echo $setting['setting']?>" type="text" class="form-control" placeholder="" value="<?php echo $setting['value']?>" />
                                                        <?php elseif($setting['type'] == 'textarea'):?>
                                                        <textarea name="<?php echo $setting['setting']?>" class="form-control" style="resize: none; height: 100px;"><?php echo $setting['value']?></textarea>
                                                        <?php elseif($setting['type'] == 'enum'):
                                                            $possibleValues = json_decode($setting['possible_values']);
                                                        ?>
                                                        <select name="<?php echo $setting['setting']?>" class="form-control">
                                                            <?php foreach ($possibleValues as $possibleValueKey => $possibleValue):?>
                                                                <option value="<?php echo $possibleValueKey?>" <?php echo ($setting['value'] == $possibleValueKey) ? 'selected="selected"' : null?>><?php echo $possibleValue?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                        <?php endif;
                                                        if(!empty($setting['description'])):
                                                        ?>
                                                        <span class="help-block">
                                                            <i class="fa fa-info-circle"></i>&nbsp;<?php echo $setting['description']?>
                                                        </span>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                            <?php endforeach;?>
                                        <?php endforeach;?>
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