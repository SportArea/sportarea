<?php

namespace Application\Roles;

/**
 * Roles / Roluri
 */
class RolesModel extends \SportArea\Core\Model
{

    const ROLE_SUPERADMIN = 1;
    const ROLE_OPERATOR = 2;
    const ROLE_USER = 3;

    // Name of the model table
    protected $table = 'roles';

    public function __construct()
    {
        parent::__construct();
    }

	/**
     * Returneaza toate ID-urile rolurilor in care se afla un utilizator
     *
     * @param	integer	$userID
     * @return	array
     */
    public function getRolsForUser($userID = 0)
    {
        $roles = $this->query("
									SELECT
                                        `roles`.`id`,
                                        `roles`.`name`
									FROM `roles`
									JOIN `assigned_roles` ON `assigned_roles`.`role_id` = `roles`.`id`
									WHERE `assigned_roles`.`user_id` = :user_id
									", array(':user_id' => $userID));

        $return = array();

        foreach ($roles as $role) {
            $return[$role['id']] = $role['name'];
        }

        return $return;
    }

    public function getGlobalAndAccountRoles($accountID)
    {
        $roles = $this->query("
									SELECT *
									FROM `roles`
									WHERE `roles`.`account_id` IS NULL
                                        OR
                                        `roles`.`account_id` = :account_id
									", array(':account_id' => $accountID));
        return $roles;
    }
}