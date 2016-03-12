<?php

namespace Application\CrudLogs;

// Core
use SportArea\Core\Model;
use SportArea\Core\Validate;
use SportArea\Core\Session;

class CrudLogsModel extends Model
{

    // Name of the model table
    protected $table = 'crud_logs';

    const TYPE_CREATE   = 'c';
    const TYPE_READ     = 'r';
    const TYPE_UPDATE   = 'u';
    const TYPE_DELETE   = 'd';

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

        if(!$count) {
            if(preg_match('/\./', $_SESSION[$this->table]['orderBy'])) {
                list($orderByTable, $orderByRow) = explode('.', $_SESSION[$this->table]['orderBy']);
                $query .= " ORDER BY `{$orderByTable}`.`{$orderByRow}` {$_SESSION[$this->table]['orderDirection']}";
            } else {
                $query .= " ORDER BY `{$_SESSION[$this->table]['orderBy']}` {$_SESSION[$this->table]['orderDirection']}";
            }
        }

		if (!$count AND $limit !== false) {
            list($offset, $limit) = explode(',', $limit);
            if($offset < 0) {
                $offset = 0;
            }
            $query .= " LIMIT {$offset},{$limit}";
		}

		$whereParams = array();
		if(isset($_SESSION[$this->table]['filter']) AND Validate::isArray($_SESSION[$this->table]['filter'], null, 1)) {
			$where = '';
			$i = 0;

			foreach ($_SESSION[$this->table]['filter'] as $row => $value) {
				$where .= ' AND ';

				if($row == 'account_id') {
                    $where .= "`{$this->table}`.`account_id` = :{$this->table}_account_id";
                    $whereParams[":{$this->table}_account_id"] = $value;

                } else if($row == 'deleted') {
                    $where .= "`{$this->table}`.`deleted` = ". (($value) ? 'TRUE' : 'FALSE');

                } else if($row == 'status') {
                    $where .= "`{$this->table}`.`status` IN ('". implode($value, "','") ."')";

				} else {
                    $where .= "`{$this->table}`.`{$row}` LIKE '%". addslashes($value) ."%'";
				}

				++$i;
			}

            $query = str_replace('{{WHERE}}', "WHERE TRUE {$where}", $query);

		} else {
			$query = str_replace('{{WHERE}}', '', $query);
		}

		// COUNT + JOIN + GROUP BY
		if($count) {
			$query = "SELECT COUNT(*) AS `my_count` FROM ({$query}) AS `my_count`";
		}

		if(!$count) {
			//die($_SESSION[$this->table]['resultsPerPage']);
    		//die($query);
		}

        //die($query);

		$results = $this->query($query, $whereParams);

		if ($count == false) {
			return $results;
		} else {
			if(isset($results[0]) AND isset($results[0]['my_count'])) {
				return $results[0]['my_count'];
			} else {
				return false;
			}
		}
	}

    /**
     * Add new CRUD log
     *
     * @param   string  $type
     * @param   array   $oldEntry
     * @param   array   $newEntry
     * @param   string  $tableName
     * @param   integer $tableID
     */
	public function log($type = null, $oldEntry = array(), $newEntry = array(), $tableName = null, $tableID = null) {

		$Session = new Session();

		$diffs = array_diff_assoc($newEntry, $oldEntry);

		$changes = array();
		if(Validate::isArray($diffs, null, 1)) {
			foreach ($diffs as $row => $newValue) {
				$changes[$row] = array(
                    'old' => ( is_bool($oldEntry[$row]) ? boolval($oldEntry[$row]) : $oldEntry[$row] ),
                    'new' => ( is_bool($newValue) ? boolval($newValue) : $newValue )
                );
			}
		}

		if(Validate::isArray($changes, null, 1)) {
            $loggedUser = $Session->get('loggedUser');
			$params = array(
								'type'              =>	$type,
                                'date'				=>	date('Y-m-d H:i:s'),
								'table'             =>	$tableName,
                                'table_id'          =>  $tableID,
                                'data'              =>  json_encode($changes),
                                'user_agent'        =>  $_SERVER['HTTP_USER_AGENT'],
                                'ip'                =>  \SportArea\Core\Utils::getRealIp(),
								'user_id'           =>	$loggedUser['id']
							);
			$this->save($params);
		} else {
			// TODO: what to do todo ?
		}
	}

}