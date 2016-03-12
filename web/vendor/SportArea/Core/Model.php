<?php

namespace SportArea\Core;

class Model extends Validate
{
    public $htmlEntitiesOnSelect = true;

    protected $db;
    protected $table;

    const DELETED = 1;
    const NOT_DELETED = 0;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    /**
     * @param	microtime	$start
     * @param	string		$query
     */
    private function stop($start, $query) {
        if(defined('SETTINGS_SQL_DEBUG') AND SetariSetariModel::get('sql_debug')) {
            $_SESSION['debug'][md5($query)]['start']	= $start;
            $_SESSION['debug'][md5($query)]['stop']		= microtime(true);
            $_SESSION['debug'][md5($query)]['query']	= $query;
        }
    }

    public function validate($params = array()) {
        $errors = \SportArea\Core\Validate::model($params, $this->table(), $this->table);
        if(\SportArea\Core\Validate::isArray($errors, null, 1)) {
            foreach ($errors as $error) {
                \SportArea\Core\Uim::addError($error);
            }
            return false;
        } else {
            return true;
        }
    }

    /**
     * Validates params but does not add errors to session
     * Only returns them
     *
     * @param array $params
     * @return array
     */
    public function validateModel($params = array()) {

        $errors = \SportArea\Core\Validate::model($params, $this->table(), $this->table);

        if (\SportArea\Core\Validate::isArray($errors, null, 1)) {
            return $errors;
        }

        return array();
    }

    /**
     * SELECT
     */
    public function query($query, $queryParams = array(), $ignore_errors = false) {

        $start = microtime(true);

        try {
            if(preg_match('/^UPDATE/i', $query)) {
                Exceptionhandler::myErrorHandler(0, 'For updates, please use ->exec() instead of ->query()', __FILE__, __LINE__, null, true);
            }

            $result = $this->db->query($query, $queryParams, $ignore_errors)->fetchAll(\PDO::FETCH_ASSOC);

            if($this->htmlEntitiesOnSelect === true) {
                $result = json_decode(htmlentities(json_encode($result), ENT_NOQUOTES), true);
            }

            $this->stop($start, $query);

            return $result;

        } catch (PDOException $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }
    }

    /**
     * INSERT, UPDATE & DELETE
     */
    public function exec($query, $queryParams = array(), $ignore_errors = false) {

        $start = microtime();

        try {

            if(preg_match('/^SELECT/i', $query)) {
                Exceptionhandler::myErrorHandler(0, 'For select, please use ->query() instead of ->exec()', __FILE__, __LINE__, null, true);
            }

            $result =  $this->db->query($query, $queryParams, $ignore_errors);
            $this->stop($start, $query);
            return $result;
        } catch (PDOException $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }
    }

    /**
     * Generic method for INSERT/UPDATE entries into DB
     *
     * @param	array	$params
     * @return	integer
     */
    public function save($params = array(), $log = true) {
        $start = microtime(true);

        try {
            $query = '';

            // UPDATE
            if(isset($params['id']) AND abs(intval($params['id'])) > 0) {

                $query .= 'UPDATE `'. $this->table .'` SET ';
                $i = 2;
                foreach ($params as $row => $value) {
                    if($row == 'id') {
                        continue;
                    }

                    $query .= "`{$row}` = :{$row}";

                    if ($i < count($params)) {
                        $query .= ", ";
                    }

                    ++$i;
                }

                $query .= ' WHERE `id` = :id ';

            // INSERT
            } else {
                $rows = array_keys($params);

                $query .= 'INSERT INTO `'. $this->table .'` (`'. str_replace(',', '`,`', implode(',', $rows)) ."`)
                            VALUES(:". implode(', :', $rows) .")";
            }

            foreach ($params as $row => $value) {
                $value = trim($value);

                // Boolean
                if(is_bool($params[$row])) {
                    $queryParams[":{$row}"] = ( ($params[$row]) ? 1 : 0 );

                } else {
                    $queryParams[":{$row}"] = ( !empty($value) ? $value : null );
                }
            }

            // ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
            // CRUD LOGS ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

            if($log AND isset($params['id']) AND abs(intval($params['id'])) > 0) {

                if(isset($params['deleted']) && $params['deleted'] == true) {
                    $type = \Application\CrudLogs\CrudLogsModel::TYPE_DELETE;
                } else if (isset($params['id'])) {
                    $type = \Application\CrudLogs\CrudLogsModel::TYPE_UPDATE;
                } else {
                    $type = \Application\CrudLogs\CrudLogsModel::TYPE_CREATE;
                }

                $CrudLogsModel = new \Application\CrudLogs\CrudLogsModel();
                $CrudLogsModel->log(
                                    $type,
                                    $this->getByID($params['id']),
                                    $params,
                                    $this->table,
                                    $params['id']
                                );
            }

            // ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~
            // ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~

            $this->db->query($query, $queryParams);
            $this->stop($start, $query);

            // Update
            if(isset($params['id']) AND abs(intval($params['id'])) > 0) {
                $ID = $params['id'];

            // Insert
            } else {
                $ID = $this->db->lastInsertId();
            }

            if($ID) {
                return $ID;
            }

        } catch (Exception $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }
    }

    /**
     * Update one table by where parameter
     *
     * @param   array   $set
     * @param   array   $where
     */
    public function update($set = array(), $where = array())
    {
        $query = 'UPDATE `'. $this->table .'` SET ';
        $i = 2;

        foreach ($set as $row => $value) {
            $query .= "`{$row}` = :{$row}";

            if ($i < count($set)) {
                $query .= ", ";
            }

            ++$i;
        }

        foreach ($set as $row => $value) {
            $value = trim($value);

            // Boolean
            if(is_bool($set[$row])) {
                $queryParams[":{$row}"] = ( ($set[$row]) ? 1 : 0 );

            } else {
                $queryParams[":{$row}"] = ( !empty($value) ? $value : null );
            }
        }

        $whereParams = array();
		if(isset($where) AND Validate::isArray($where, null, 1)) {
			$whereQuery = '';
			$i = 0;

			foreach ($where as $row => $value) {
                if($i == 0) {
                    $whereQuery .= ' WHERE ';
                } else {
                    $whereQuery .= ' AND ';
                }
                $whereQuery .= "`{$this->table}`.`{$row}` = :{$this->table}_{$row}";
                $whereParams[":{$this->table}_{$row}"] = $value;
				++$i;
			}

            $query .= " {$whereQuery}";
		}

        $this->db->query($query, $queryParams);
    }

    public function insertOndDuplicateUpdate($params = array(), $log = false) {
        $start = microtime(true);

        $rows = array_keys($params);
        $query = 'INSERT INTO `'. $this->table .'` (`'. str_replace(',', '`,`', implode(',', $rows)) ."`)
                    VALUES(:". implode(', :', $rows) .") ON DUPLICATE KEY UPDATE";

        $i = 1;
        foreach ($rows as $row) {
            $query .= " `{$row}` = :{$row}";
            ($i < count($rows)) ? $query .= "," : null;
            ++$i;
        }

        foreach ($params as $row => $value) {
            $value = trim($value);

            // Boolean
            if(is_bool($params[$row])) {
                $queryParams[":{$row}"] = ( ($params[$row]) ? 1 : 0 );

            } else {
                $queryParams[":{$row}"] = ( !empty($value) ? $value : null );
            }
        }

        //die($query);
        //print_r($queryParams);die;
        $this->db->query($query, $queryParams);
        $this->stop($start, $query);
    }

    /**
     * Delete all
     *
     * @param	integer	$ID
     * @return	boolean
     */
    public function deleteAll() {
        $start = microtime(true);

        try {
            $query = 'DELETE FROM `'. $this->table .'`';
            if($this->db->query($query, array())) {
                $this->stop($start, $query);
                return true;
            } else {
                $this->stop($start, $query);
                return false;
            }
        } catch (Exception $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }
    }

    /**
     * Delete one single entry by ID
     *
     * @param	integer	$ID
     * @return	boolean
     */
    public function deleteByID($ID) {
        $start = microtime(true);

        try {
            $query = 'DELETE FROM `'. $this->table .'` WHERE `id` = :id';
            if($this->exec($query, array(':id' => $ID))) {
                $this->stop($start, $query);
                return true;
            } else {
                $this->stop($start, $query);
                return false;
            }
        } catch (Exception $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }
    }

    /**
     * Delete multiple entries by params (WHERE x=y and z=q)
     *
     * @param	array	$params
     * @return
     */
    public function deleteByParams($params = array()) {

        $start = microtime(true);

        $query = 'DELETE FROM `'. $this->table .'` WHERE ';

        try {
            if(is_array($params) AND count($params) > 0) {
                $i = 1;
                foreach ($params as $row => $value) {

                    if(in_array($value, array('IS NULL'))) {
                        $query .= " `{$row}` IS NULL";

                    } else if(in_array($value, array('IS NOT NULL'))) {
                        $query .= " `{$row}` IS NOT NULL";

                    } else {
                        $query .= "`{$row}` = :{$row}";
                    }

                    if ($i < count($params)) {
                        $query .= " AND ";
                    }

                    ++$i;
                }

                $queryParams = array();
                foreach ($params as $row => $value) {
                    if(!in_array($value, array('IS NULL', 'IS NOT NULL'))) {
                        $queryParams[":{$row}"] = $value;
                    }
                }

                if(false) {
                    Utils::printR($query);
                    Utils::printR($queryParams, true);
                }

                if($this->exec($query, $queryParams)) {
                    $this->stop($start, $query);
                    return true;
                } else {
                    $this->stop($start, $query);
                    return false;
                }
            }

        } catch (Exception $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }
    }

    /**
     * Get one single entry by ID
     *
     * @param	integer	$ID
     * @return	object
     */
    public function getByID($ID = null, $rows = array()) {

        $start = microtime(true);

        $ID = abs(intval($ID));

        try {
            if(!is_array($rows) OR (is_array($rows) AND count($rows) == 0)) {
                $query = 'SELECT * FROM `'. $this->table .'` ';
            } else {
                $query = 'SELECT `'. join('`,`', $rows) .'` FROM `'. $this->table .'` ';
            }

            $query .= ' WHERE `id` = :id';
            $stmt = $this->db->query($query, array(':id' => $ID));
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if($this->htmlEntitiesOnSelect === true) {
                $results = json_decode(htmlentities(json_encode($results), ENT_NOQUOTES), true);
            }

        } catch (Exception $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }

        $this->stop($start, $query);

        if(is_array($results) AND count($results) > 0) {
            return $results[0];
        } else {
            return false;
        }
    }

    /**
     * Generic method for select/count
     *
     * @param	array	$rows
     * @param	array	$where
     * @param	mixed	$orderBy
     * @param	string	$limit, eg: 1,12
     * @param	boolean	$count,	eg: true|false
     * @return	array
     *
     */
    public function getBy($rows = array(), $where = array(), $groupBy = array(), $orderBy = array(), $limit = null, $count = false) {

        $start = microtime(true);

        try {

            if(!is_array($rows) OR (is_array($rows) AND count($rows) == 0)) {
                $query = 'SELECT * FROM `'. $this->table .'` ';
            } else {
                $query = 'SELECT `'. join('`,`', $rows) .'` FROM `'. $this->table .'` ';
            }

            if($count === true) {
                // Count with goup by
                if(is_array($groupBy) AND count($groupBy) > 0) {
                    if(count($rows) > 0) {
                        $query = preg_replace('/SELECT (.*) FROM/', 'SELECT COUNT($1) AS `my_count` FROM (SELECT `'. implode('`, `', array_merge($rows, array_keys($where))) .'` FROM `'. $this->table .'` GROUP BY `'. $groupBy[0] .'`)', $query);
                    } else {
                        $query = preg_replace('/SELECT (.*) FROM/', 'SELECT COUNT($1) AS `my_count` FROM (SELECT $1 FROM `'. $this->table .'` GROUP BY `'. $groupBy[0] .'`)', $query);
                    }
                // Count normal
                } else {
                    $query = preg_replace('/SELECT (.*) FROM/', 'SELECT COUNT($1) AS `my_count` FROM', $query);
                }
            }

            $queryParams = null;

            // WHERE
            if(is_array($where) AND count($where) > 0) {

                $query .= ' WHERE (true) ';

                $i = 1;
                foreach ($where as $row => $value) {

                    $row	= trim($row);
                    $value	= (is_bool($value) ? $value : trim($value));

                    if(strlen($row) != 0 && !is_bool($value) && strlen($value) != 0) {

                        if(in_array($value, array('IS NULL'))) {
                            $query .= " AND `{$row}` IS NULL";

                        } else if(in_array($value, array('IS NOT NULL'))) {
                            $query .= " AND `{$row}` IS NOT NULL";

                        } else {
                            $query .= " AND `{$row}` = :{$row}";

                            /*
                            if ($i < count($where)) {
                                $query .= " AND ";
                            }
                             */

                            $queryParams[":{$row}"] = $value;
                        }

                        ++$i;

                    } else if(is_bool($value)) {
                        $query .= " AND `{$row}` = :{$row}";
                        $queryParams[":{$row}"] = boolval($value);

                    } else {
                        // return Exceptionhandler::myErrorHandler(0, 'Empty row or value: '. json_encode($where), __FILE__, __LINE__);
                    }
                }

                /*
                foreach ($where as $row => $value) {
                    $queryParams[":{$row}"] = $value;
                }
                 */
            }

            if(is_array($groupBy) AND count($groupBy) > 0 AND $count == false) {
                $query .= ' GROUP BY';

                foreach ($groupBy as $group) {
                    $query .= "`{$group}`";
                }
            }

            // ORDER BY
            if ($orderBy == 'RAND()') {
                $query .= ' ORDER BY RAND() ';
            } else if (is_array($orderBy) AND count($orderBy) > 0) {
                $query .= ' ORDER BY';

                $i = 1;
                foreach ($orderBy as $row => $value) {
                    $query .= "`{$row}` {$value}";

                    if ($i < count($orderBy)) {
                        $query .= ", ";
                    }

                    ++$i;
                }
            }

            if($limit != null) {
                $query .= ' LIMIT '. $limit;
            }

            if(false && $this->table == 'settings') {
                Utils::printR($where);
                Utils::printR($queryParams);
                die($query);
            }

            $resource = $this->db->query($query, $queryParams);

            if($count === true) {
                $return = $this->db->fetchAll($resource);
                $return = $return[0]['my_count'];
            } else {
                $return = $this->db->fetchAll($resource);
            }

            if($this->htmlEntitiesOnSelect === true) {
                $return = json_decode(htmlentities(json_encode($return), ENT_NOQUOTES), true);
            }

            $this->stop($start, $query);
            return $return;

        } catch (Exception $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }
    }

    public function __DEPRECATED__getByIn($rows = array(), $whereIn = array(), $groupBy = array(), $orderBy = array(), $limit = null, $count = false) {

        $start = microtime(true);

        try {

            if(!is_array($rows) OR (is_array($rows) AND count($rows) == 0)) {
                $query = 'SELECT * FROM `'. $this->table .'` ';
            } else {
                $query = 'SELECT `'. join('`,`', $rows) .'` FROM `'. $this->table .'` ';
            }

            if($count === true) {
                // Count with goup by
                if(is_array($groupBy) AND count($groupBy) > 0) {
                    if(count($rows) > 0) {
                        $query = preg_replace('/SELECT (.*) FROM/', 'SELECT COUNT($1) AS `my_count` FROM (SELECT `'. implode('`, `', array_merge($rows, array_keys($whereIn))) .'` FROM `'. $this->table .'` GROUP BY `'. $groupBy[0] .'`)', $query);
                    } else {
                        $query = preg_replace('/SELECT (.*) FROM/', 'SELECT COUNT($1) AS `my_count` FROM (SELECT $1 FROM `'. $this->table .'` GROUP BY `'. $groupBy[0] .'`)', $query);
                    }
                // Count normal
                } else {
                    $query = preg_replace('/SELECT (.*) FROM/', 'SELECT COUNT($1) AS `my_count` FROM', $query);
                }
            }

            $queryParams = null;

            // WHERE
            if(is_array($whereIn) AND count($whereIn) > 0) {

                $query .= ' WHERE ';


                foreach ($whereIn as $row => $values) {
                    $i = 1;
                    foreach ($values as $value) {
                        $query .= "`{$row}` = :{$row}_{$i}";

                        if ($i < count($values)) {
                            $query .= " OR ";
                        }
                        ++$i;
                    }
                }

                foreach ($whereIn as $row => $values) {
                    $i = 1;
                    foreach ($values as $value) {
                        $queryParams[":{$row}_{$i}"] = $value;
                        ++$i;
                    }
                }
            }

            if(is_array($groupBy) AND count($groupBy) > 0 AND $count == false) {
                $query .= ' GROUP BY';

                foreach ($groupBy as $group) {
                    $query .= "`{$group}`";
                }
            }

            // ORDER BY
            if(is_array($orderBy) AND count($orderBy) > 0) {

                $query .= ' ORDER BY';

                $i = 1;
                foreach ($orderBy as $row => $values) {
                    $query .= "`{$row}` {$values}";

                    if ($i < count($orderBy)) {
                        $query .= ", ";
                    }

                    ++$i;
                }
            }

            if($limit != null) {
                $query .= ' LIMIT '. $limit;
            }

            $resource = $this->db->query($query, $queryParams);

            if($count === true) {
                $return = $this->db->fetchAll($resource);
                $return = $return[0]['my_count'];
            } else {
                $return = $this->db->fetchAll($resource);
            }

            if($this->htmlEntitiesOnSelect === true) {
                $return = json_decode(htmlentities(json_encode($return), ENT_NOQUOTES), true);
            }

            $this->stop($start, $query);
            return $return;

        } catch (Exception $e) {
            return Exceptionhandler::myErrorHandler($e->getCode(), $e->getMessage(), __FILE__, __LINE__, $e);
        }
    }

    /**
     * Set pagination
     *
     * @param $query
     * @param $filter
     * @return
     */
    public function setPagination($query, array $filter)
    {
        if (isset($filter['iDisplayStart']) && $filter['iDisplayLength'] != '-1') {
            $query .= ' LIMIT ' . $filter['iDisplayStart'] . ', ' .  $filter['iDisplayLength'];
        }

        return $query;
    }

    /**
     * Order by
     *
     * @param  $query
     * @param $filter
     * @return string
     */
    public function orderBy($query, $filter)
    {
        $headers = explode(',', $filter['sColumns']);

        if (isset($filter['iSortCol_0'])) {
            $query .= ' ORDER BY ' .  $headers[$filter['iSortCol_0']] . ' ' . $filter['sSortDir_0'];
        }

        return $query;
    }
}