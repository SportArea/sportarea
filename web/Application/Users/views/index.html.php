<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered bg-inverse">
            <div class="portlet-title">
                <div class="caption">
                    <i class="<?php echo $menuModules[$template['module']]['menu_icon']?> font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold">
                        <?php echo $menuModules[$template['module']]['name']?>
                    </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="actions">
                    <button class="btn btn-sm margin-bottom green-meadow" data-href="<?php echo BASE_URL ?>/users/add" style="border: solid #1CAF9A 1px">
                        <i class="fa fa-plus"></i>
                        &nbsp;Adaugă utilizator nou
                    </button>
                    <button class="btn btn-sm filter-submit margin-bottom blue-madison filter-submit">
                        <i class="fa fa-search"></i>
                        &nbsp;Filtreaza
                    </button>
                </div>
            </div>
            <!-- Start body -->
            <div class="portlet-body">
                <div class="tabbable tabbable-custom">
                    <div class="tab-content">
                        <div class="tab-pane fade active in custom-table-list">
                            <?php  require_once('filter.html.php'); ?>
                            <div class="portlet-body">
                                <table id="users" class="table table-striped table-bordered table-hover dataTable table-turquoise">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nume</th>
                                        <th>Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End body -->
            </div>
        </div>
    </div>
</div>