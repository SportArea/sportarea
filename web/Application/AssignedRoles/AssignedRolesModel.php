<?php

namespace Application\AssignedRoles;

// Core
use SportArea\Core\Model;

/**
 * Assigned Roles / Roluri asociate
 */
class AssignedRolesModel extends Model
{

    // Name of the model table
    protected $table = 'assigned_roles';

    public function __construct()
    {
        parent::__construct();
    }

    public function updateUserRole($userInRolesData)
    {
        $query = "UPDATE `" . $this->table . "`
                SET `" . $this->table . "`.`role_id` = " . $userInRolesData['role_id'] . "
                WHERE `" . $this->table . "`.`user_id` = :userId";

        $whereParams['userId'] = $userInRolesData['user_id'];

        $results = $this->exec($query, $whereParams);

        return true;
    }
}