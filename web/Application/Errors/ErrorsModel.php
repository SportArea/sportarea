<?php

namespace Application\Errors;

use SportArea\Core\Validate;

class ErrorsModel extends \SportArea\Core\Model
{

    // Name of the model table
    protected $table = 'errors';

    public function listByFilters($limit = false, $count = false)
    {

        if ($count == false) {
            $query = "
				SELECT
                        `{$this->table}`.*
				";

        } else {
            $query = "SELECT COUNT(`{$this->table}`.`id`) AS `my_count`";
        }

        $query .= "
					FROM `{$this->table}`

					{{WHERE}}
				";

        $query .= " GROUP BY `{$this->table}`.`id`";

        if (!$count) {
            if (preg_match('/\./', $_SESSION[$this->table]['orderBy'])) {
                list($orderByTable, $orderByRow) = explode('.', $_SESSION[$this->table]['orderBy']);
                $query .= " ORDER BY `{$orderByTable}`.`{$orderByRow}` {$_SESSION[$this->table]['orderDirection']}";
            } else {
                $query .= " ORDER BY `{$_SESSION[$this->table]['orderBy']}` {$_SESSION[$this->table]['orderDirection']}";
            }
        }

        if (!$count AND $limit !== false) {
            list($offset, $limit) = explode(',', $limit);
            if ($offset < 0) {
                $offset = 0;
            }
            $query .= " LIMIT {$offset},{$limit}";
        }

        $whereParams = array();
        if (isset($_SESSION[$this->table]['filter']) AND Validate::isArray($_SESSION[$this->table]['filter'], null, 1)) {
            $where = '';
            $i = 0;

            foreach ($_SESSION[$this->table]['filter'] as $row => $value) {
                $where .= ' AND ';

                if ($row == 'account_id') {
                    $where .= "`{$this->table}`.`account_id` = :{$this->table}_account_id";
                    $whereParams[":{$this->table}_account_id"] = $value;

                } else if ($row == 'deleted') {
                    $where .= "`{$this->table}`.`deleted` = " . (($value) ? 'TRUE' : 'FALSE');

                } else if ($row == 'status') {
                    $where .= "`{$this->table}`.`status` IN ('" . implode($value, "','") . "')";

                } else if ($row == 'full_name') {
                    $where .= "(
                                    `{$this->table}`.`first_name` LIKE '%" . addslashes($value) . "%'
                                    OR `{$this->table}`.`last_name` LIKE '%" . addslashes($value) . "%'
                                    OR CONCAT(`{$this->table}`.`first_name`, ' ', `{$this->table}`.`last_name`) LIKE '%" . addslashes($value) . "%'
                                    OR CONCAT(`{$this->table}`.`last_name`, ' ', `{$this->table}`.`first_name`) LIKE '%" . addslashes($value) . "%'
                            )";
                } else {
                    $where .= "`{$this->table}`.`{$row}` LIKE '%" . addslashes($value) . "%'";
                }

                ++$i;
            }

            $query = str_replace('{{WHERE}}', "WHERE TRUE {$where}", $query);

        } else {
            $query = str_replace('{{WHERE}}', '', $query);
        }

        // COUNT + JOIN + GROUP BY
        if ($count) {
            $query = "SELECT COUNT(*) AS `my_count` FROM ({$query}) AS `my_count`";
        }

        if (!$count) {
            //die($_SESSION[$this->table]['resultsPerPage']);
            //die($query);
        }

        //die($query);

        $results = $this->query($query, $whereParams);

        if ($count == false) {
            return $results;
        } else {
            if (isset($results[0]) AND isset($results[0]['my_count'])) {
                return $results[0]['my_count'];
            } else {
                return false;
            }
        }
    }

}