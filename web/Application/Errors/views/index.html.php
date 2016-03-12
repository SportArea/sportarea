<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered bg-inverse">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-wrench font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold">
                        Setări &#187; Erori sistem
                    </span>
                    <span class="caption-helper"></span>
                </div>
                <div class="actions">
                    <button class="btn btn-sm filter-submit margin-bottom blue-madison" onclick="$('#search').toggle(300);">
                        <i class="fa fa-search"></i>
                        &nbsp;Filtrează
                    </button>
                </div>
            </div>

            <!-- Start body -->
            <div class="portlet-body">
                <div class="tabbable tabbable-custom">

                    <!-- Start: Search filters -->
                    <?php SportArea\Core\Template::search(
                            $template['module'],array(
                                'type'           =>  array(
                                                                    'tooltip'       =>  'Tip',
                                                                    'options'       =>  array(
                                                                                                array('type' => 'TRIGGERED'),
                                                                                                array('type' => 'E_ERROR'),
                                                                                                array('type' => 'E_WARNING'),
                                                                                                array('type' => 'E_PARSE'),
                                                                                                array('type' => 'E_NOTICE'),
                                                                                                array('type' => 'E_CORE_ERROR'),
                                                                                                array('type' => 'E_CORE_WARNING'),
                                                                                                array('type' => 'E_COMPILE_ERROR'),
                                                                                                array('type' => 'E_COMPILE_WARNING'),
                                                                                                array('type' => 'E_USER_ERROR'),
                                                                                                array('type' => 'E_USER_WARNING'),
                                                                                                array('type' => 'E_USER_NOTICE'),
                                                                                                array('type' => 'E_STRICT'),
                                                                                                array('type' => 'E_RECOVERABLE_ERROR'),
                                                                                                array('type' => 'E_DEPRECATED'),
                                                                                                array('type' => 'E_ALL'),
                                                                                                array('type' => 'E_USER_DEPRECATED'),
                                                                                                array('type' => 'SQLSTATE')
                                                                                            ),
                                                                    'optionKey'     =>  'type',
                                                                    'optionValue'   =>  'type',
                                                            )
                            ), 1);?>
                    <!-- End: Search filters -->

                    <?php require_once ROOT . '/Application/Settings/views/_tabs.html.php'; ?>
                    <div class="tab-content">

                        <div class="tab-pane fade active in custom-table-list">
                            <div class="portlet-body">
                                <?php if (!\SportArea\Core\Validate::isArray($errors, null, 1)): ?>
                                    <div class="note note-danger" style="margin-bottom: 8px;">
                                        <p>
                                            Filtrarea datelor nu a returnat nici un rezultat.
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <table class="table table-striped table-bordered dataTable table-turquoise" data-module="<?php echo $template['module']?>" data-location="<?php echo \SportArea\Core\Utils::whereIAm()?>">
                                        <thead>
                                            <tr role="row">

                                                <th style="width: 1px;"></th>

                                                <th data-row="errors.type" class="<?=($_SESSION[$template['module']]['orderBy'] == 'errors.type') ? 'sorting_'. strtolower($_SESSION[$template['module']]['orderDirection']) : 'sorting'?>">
                                                    Tip
                                                </th>
                                                <th data-row="errors.file" class="<?=($_SESSION[$template['module']]['orderBy'] == 'errors.file') ? 'sorting_'. strtolower($_SESSION[$template['module']]['orderDirection']) : 'sorting'?>">
                                                    Fisier & Eroare
                                                </th>
                                                <th data-row="errors.first_seen" class="<?=($_SESSION[$template['module']]['orderBy'] == 'errors.first_seen') ? 'sorting_'. strtolower($_SESSION[$template['module']]['orderDirection']) : 'sorting'?>">
                                                    Prima
                                                </th>
                                                <th data-row="errors.last_seen" class="<?=($_SESSION[$template['module']]['orderBy'] == 'errors.last_seen') ? 'sorting_'. strtolower($_SESSION[$template['module']]['orderDirection']) : 'sorting'?>">
                                                    Ultima
                                                </th>
                                                <th data-row="errors.hits" class="<?=($_SESSION[$template['module']]['orderBy'] == 'errors.hits') ? 'sorting_'. strtolower($_SESSION[$template['module']]['orderDirection']) : 'sorting'?>">
                                                    Aparitii
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($errors as $error): ?>
                                            <tr class="odd gradeX">
                                                <td>
                                                    <!-- Delete -->
                                                    <span>
                                                        <a href="#" class="tooltips red" data-target="#modal-delete-<?php echo $error['id'] ?>" data-toggle="modal" data-placement="top" data-html="true" data-original-title="Șterge eroarea">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    </span>

                                                    <!-- Modal : START - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                                                    <div class="modal fade" id="modal-delete-<?php echo $error['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                    <h4 class="modal-title">Ștergere eroare</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <p>Sunteți sigur că doriți sa stergeți eroarea <strong><?php echo $error['type'] ?></strong> generata in <strong><?php echo $error['file']?></strong> pe linia <strong><?php echo $error['line']?></strong>?</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-href="<?php echo BASE_URL ?>/errors/delete/<?php echo $error['id'] ?>" class="btn red">
                                                                        <i class="fa fa-trash-o"></i>&nbsp;
                                                                        ȘTERGE EROAREA
                                                                    </button>
                                                                    <button type="button" class="btn grey-cascade" data-dismiss="modal">
                                                                        <i class="fa fa-times"></i>&nbsp;
                                                                        RENUNȚĂ
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal : END  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - --->
                                                </td>

                                                <td>
                                                    <table class="table table-striped table-bordered dataTable" style="width: 100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td style="text-align: center; width: 1px;"><i class="fa fa-bolt" style="font-size: 16px;"></i></td>
                                                                <td style="width: 50px;">
                                                                    <?php echo $error['type']?>
                                                                </td>
                                                                <td style="text-align: center; width: 1px;"><i class="fa fa-user" style="font-size: 16px; color: #DDDDDD;"></i></td>
                                                                <td style="width: 120px;">
                                                                    <a href="http://forte-web.lcl/utilizatori/filtrare?id=" target="_new"></a>
                                                                </td>
                                                                <td style="text-align: center; width: 1px;"><i class="fa fa-list-alt" style="font-size: 16px; color: #DDDDDD;"></i></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;"><i class="fa fa-link" style="font-size: 16px;"></i></td>
                                                                <td colspan="100%">
                                                                    <?php echo $error['request']?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;"><i class="fa fa-desktop" style="font-size: 16px;"></i></td>
                                                                <td colspan="100%">
                                                                    <?php echo $error['ip']?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </td>

                                                <td>
                                                    Line <?php echo $error['line'] ?> @ <?php echo $error['file'] ?>
                                                    <hr />
                                                    <?php echo $error['error'] ?>
                                                </td>

                                                <td>
                                                    <?php echo date('d.m.Y', strtotime($error['first_seen'])); ?>
                                                </td>

                                                <td>
                                                    <?php echo date('d.m.Y', strtotime($error['last_seen'])); ?>
                                                </td>

                                                <td>
                                                    <?php echo $error['hits'] ?>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="dataTables_paginate paging_bootstrap_full_number">
                                                <?php
                                                $Navigation = new \SportArea\Core\Navigation();
                                                $linkFormat = BASE_URL . '/errors/index/{{PAGE}}';
                                                $Navigation->nrPagesNavigation(ceil($template['pagination']['totalEntries'] / $template['pagination']['resultsPerPage']), $linkFormat, $template['pagination']['currentPage']);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End body -->
            </div>
        </div>
    </div>
</div>