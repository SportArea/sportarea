<?php
/**
 * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
 */
namespace Application\SportType;

use SportArea\Core\Model;

class SportTypeModel extends Model
{
    protected $table = 'sport_type';

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const STATUS_ACTIVE_LABEL = 'Activ';
    const STATUS_INACTIVE_LABEL = 'Inactiv';

    public function __construct()
    {
        parent::__construct();
    }

    public function table()
    {
        return array(
            'id' => array(
                'i18n' => array('RO-RO' => 'ID'),
                'rules' => array(Model::V_INTEGER_UNSIGNED)
            ),

            'name' => array(
                'i18n' => array('RO-RO' => 'Denumire'),
                'rules' => array(Model::V_REQUIRED)
            ),

            'status' => array(
                'i18n' => array('RO-RO' => 'Stare'),
                'rules' => array(Model::V_REQUIRED, Model::V_REGEXP => '/^(' . SportTypeModel::STATUS_ACTIVE . '|' . SportTypeModel::STATUS_INACTIVE . ')$/')
            ),

            'deleted' => array(
                'i18n' => array('RO-RO' => 'Sters'),
                'rules' => array(Model::V_BOOLEAN)
            ),
        );
    }

    /**
     * Save sport type data
     *
     * @param $sportType
     * @return bool
     */
    public function saveSportType($sportType)
    {
        try {
            $this->save($sportType);
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * Edit sport type data
     * @param array $sportType
     * @return bool
     */
    public function editSportType(array $sportType)
    {
        foreach ($sportType as $key => $sportTypeData) {
            if (!in_array($key, array('id', 'name'))) {
                unset($sportType['key']);
            }
        }

        try {
            $this->save($sportType);
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * Delete sport type by id
     *
     * @param $sportTypeId
     * @return bool
     */
    public function deleteSportType($sportTypeId)
    {
        $query = 
            "DELETE FROM `" . $this->table . "` WHERE `" . $this->table . "`.`id` = :sportTypeId";

        $whereParams['sportTypeId'] = $sportTypeId;

        $this->exec($query, $whereParams);

        return true;
    }

    /**
     * List sport types by filter
     *
     * @param $filter
     * @return mixed
     */
    public function listByFilters($filter)
    {

        $query = "
            SELECT `" . $this->table . "`.*
            FROM `" . $this->table . "`";

        $filterResult = $this->filter($filter['search']);
        $query .= $filterResult['sql'];

        $whereParams = $filterResult['where'];

        $query = $this->orderBy($query, $filter);
        $query = $this->setPagination($query, $filter);
        $results = $this->query($query, $whereParams);

        $response['aaData'] = $results;
        $response['iTotalRecords'] = (int)$this->countByFilters($filter);
        $response['iTotalDisplayRecords'] = (int)$this->countByFilters($filter);

        return $response;
    }

    /**
     * Build filter query
     *
     * @param $search
     * @return array
     */
    private function filter($search)
    {
        parse_str($search, $filters);

        $sql = '';
        $whereParams = array();
        $hasWhere = false;

        if (isset($filters['name']) && strlen($filters['name'])) {
            $sql .= (true === $hasWhere) ? " AND " : " WHERE ";
            $sql .= "`" . $this->table . "`.`name` LIKE :name";
            $whereParams['name'] = '%' . $filters['name'] . '%';
        }

        return array('sql' => $sql, 'where' => $whereParams);
    }


    /**
     * Count number of items returned after filtering
     *
     * @param $filter
     * @return int
     */
    public function countByFilters($filter)
    {
        $query = "
            SELECT COUNT(`" . $this->table . "`.`id`) AS `count`
            FROM `" . $this->table . "`";

        $filterResult = $this->filter($filter['search']);
        $query .= $filterResult['sql'];

        $whereParams = $filterResult['where'];
        $result = $this->query($query, $whereParams);

        return (int)$result[0]['count'];
    }
}