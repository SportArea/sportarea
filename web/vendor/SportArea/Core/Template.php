<?php

namespace SportArea\Core;

/**
 * Template utitities
 * All function are/must be static
 */
class Template
{
    public static function search($table, $searchParams, $displayLimit)
    {
    ?>
        <div id="search" class="note note-light <?php echo (!isset($_SESSION[$table]['filter']) || (isset($_SESSION[$table]['filter']) && !\SportArea\Core\Validate::isArray($_SESSION[$table]['filter'], null, $displayLimit))) ? 'display-none' : null ?>">
            <div class="portlet-body">
                <form role="form" action="<?php echo BASE_URL ?>/<?php echo $table?>/filter" method="post">
                    <table data-params="<?php echo count($searchParams)?>">
                        <tr>
                        <?php
                        $i = 1;
                        foreach ($searchParams as $rowName => $options):

                            if(Validate::isArray($options, null, 1) && isset($options['colspan'])) {
                                $i += ($options['colspan']-1);
                            }
                        ?>
                            <td colspan="<?php echo (Validate::isArray($options, null, 1) && isset($options['colspan']) ? $options['colspan'] : 1) ?>" data-i="<?php echo $i?>">
                                <?php if(Validate::isArray($options, null, 1) && isset($options['calendar']) && $options['calendar'] == true):?>
                                    <input type="text" name="<?php echo $rowName?>" class="form-control tooltips datepicker" data-placement="top" data-html="true" data-original-title="<?php echo $options['tooltip']?>" placeholder="<?php echo $options['tooltip']?>" value="<?php echo isset($_SESSION[$table]['filter'][$rowName]) ? $_SESSION[$table]['filter'][$rowName] : null ?>" readonly="readonly" />

                                <?php elseif(Validate::isArray($options, null, 1) && isset($options['tags']) && $options['tags'] == true):?>
                                    <input type="text" name="<?php echo $rowName?>" class="form-control tooltips tags jqueryTags" data-placement="top" data-html="true" data-original-title="<?php echo $options['tooltip']?>" placeholder="<?php echo $options['tooltip']?>" value="<?php echo isset($_SESSION[$table]['filter'][$rowName]) ? $_SESSION[$table]['filter'][$rowName] : null ?>" />

                                <?php elseif(Validate::isArray($options, null, 1) && ( (isset($options['checkbox']) && $options['checkbox'] == true) || (isset($options['radio']) && $options['radio'] == true) )):?>
                                    <div style="position: relative; top: 7px;">
                                        <div class="pull-left" style="padding-right: 10px;">
                                            <h4><?php echo $options['tooltip']?>:</h4>
                                        </div>
                                        <div class="pull-left">
                                            <?php foreach ($options['options'] as $optionKey => $optionText):?>
                                                <label style="padding-right: 5px;">
                                                    <input type="<?php echo (isset($options['checkbox']) && $options['checkbox'] == true) ? 'checkbox' : 'radio'?>" name="a" value="<?php echo $optionKey?>" />
                                                    <?php echo $optionText?>
                                                </label>
                                            <?php endforeach;?>
                                        </div>
                                    </div>

                                <?php elseif(Validate::isArray($options, null, 1)):?>
                                    <select name="<?php echo $rowName?>" class="form-control tooltips" data-placement="top" data-html="true" data-original-title="<?php echo $options['tooltip']?>">
                                        <option value="">-- Selectați --</option>
                                    <?php foreach ($options['options'] as $option):?>
                                        <option value="<?php echo $option[$options['optionKey']] ?>" <?php echo (isset($_SESSION[$table]['filter'][$rowName]) && $_SESSION[$table]['filter'][$rowName] == $option[$options['optionKey']]) ? 'selected="selected"' : null ?>>
                                            <?php
                                            if(!Validate::isArray($options['optionValue'], null, 1)):
                                                echo $option[$options['optionValue']];

                                            else:
                                                $j = 1;
                                                foreach ($options['optionValue'] as $optionValue) {
                                                    echo $option[$optionValue] . ($j < count($options['optionValue']) ? ' ' : null);
                                                    ++$j;
                                                }
                                            endif;
                                            ?>
                                        </option>
                                    <?php endforeach;?>
                                    </select>
                                <?php else:?>
                                    <input type="text" name="<?php echo $rowName?>" class="form-control tooltips" data-placement="top" data-html="true" data-original-title="<?php echo $options?>" placeholder="<?php echo $options?>" value="<?php echo isset($_SESSION[$table]['filter'][$rowName]) ? $_SESSION[$table]['filter'][$rowName] : null ?>" />
                                <?php endif;?>
                            </td>
                        <?php
                            // Submit buttons
                            if( ($i == 4) || (count($searchParams) < 4 && $i == count($searchParams)) ):
                        ?>
                            <th rowspan="100%">
                                <button type="submit" class="btn btn-default tooltips" data-placement="top" data-html="true" data-original-title="Aplică filtrele">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button type="button" data-href="<?php echo BASE_URL ?>/<?php echo $table?>/filter/reset" class="btn btn-default tooltips" data-placement="top" data-html="true" data-original-title="Resetează filtrele">
                                    <i class="fa fa-times"></i>
                                </button>
                            </th>
                        <?php
                            endif;

                            if($i%4==0):
                                echo '</tr><tr>';
                            endif;
                            ++$i;
                        endforeach;
                        ?>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    <?php
    }

    public static function navigation($template)
    {
    ?>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="dataTables_paginate paging_bootstrap_full_number">
    <?php
        $Navigation = new \SportArea\Core\Navigation();
        $linkFormat = BASE_URL . '/'. $template['module'] .'/index/{{PAGE}}';
        $Navigation->nrPagesNavigation(ceil($template['pagination']['totalEntries'] / $template['pagination']['resultsPerPage']), $linkFormat, $template['pagination']['currentPage']);
    ?>
                                            </div>
                                        </div>
                                    </div>
    <?php
    }
}