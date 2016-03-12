<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered bg-inverse">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-wrench font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold">
                        Setări &#187; Checkpoints
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
                        <div class="tab-pane fade active in">
                            <div class="portlet-body form">

                                <!-- ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ -->
                                <!-- PHP/MySQL TIME  ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ -->

                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Servers time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($times as $serveName => $serverTime):?>
                                        <tr>
                                            <td style="width: 100px;"><?php echo $serveName?></td>
                                            <td><?php echo $serverTime?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>

                                <!-- ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ -->
                                <!-- CRON  ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ -->

                                <!-- ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ -->
                                <!-- REQUIREMENTS  ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ -->

                                <table class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mandatory requirements</th>
                                            <th style="width: 50px; white-space: nowrap;">Request</th>
                                            <th style="width: 50px; white-space: nowrap;">Current</th>
                                            <th style="width: 50px; text-align: center;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $errors     = 0;
                                        $iconGood   = 'fa-check-square-o';
                                        $iconBad    = 'fa-square-o';

                                        foreach ($checkpoints['mandatory'] as $checkpoint):?>
                                            <tr>
                                                <td><?php echo $checkpoint['name']?></td>
                                                <td><?php echo $checkpoint['request']?></td>
                                                <td><?php echo $checkpoint['current']?></td>
                                                <td align="center" style="text-align: center;">
                                                    <?php
                                                    switch ($checkpoint['type']):
                                                        case 'phpVersion':
                                                            $icon = (($checkpoint['current'] >= str_replace('+', '', $checkpoint['request'])) ?  $iconGood : $iconBad);
                                                            ($checkpoint['current'] >= str_replace('+', '', $checkpoint['request'])) ? null : $errors++;
                                                            break;

                                                        case 'maxUploadSize':
                                                        case 'maxExecutionTime':
                                                        case 'maxInputTime':
                                                        case 'memoryLimit':
                                                            $icon = (($checkpoint['current'] >= intval($checkpoint['request'])) ? $iconGood : $iconBad);
                                                            ($checkpoint['current'] >= intval($checkpoint['request'])) ? null : $errors++;
                                                            break;

                                                        default:
                                                            $icon = (($checkpoint['current'] == $checkpoint['request']) ? $iconGood : $iconBad);
                                                            ($checkpoint['current'] == $checkpoint['request']) ? null : $errors++;
                                                    endswitch;
                                                    ?>
                                                    <i class="fa <?php echo $icon?>" style="font-size: 18px; <?php echo ($icon == $iconBad) ? 'color:red;' : null?>" />
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>

                                <!-- ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ -->
                                <!-- ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End body -->
        </div>
    </div>
</div>