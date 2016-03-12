<?php

namespace Application\RolesInModules;

class RolesInModulesModel extends \SportArea\Core\Model
{

    // Name of the model table
    protected $table = 'roles_in_modules';


    public function deleteAllGlobal()
    {
        $query = "
                    DELETE `{$this->table}`
                    FROM `{$this->table}`
                    LEFT JOIN `roles`
                        ON `roles`.`id` = `{$this->table}`.`role_id`
                    WHERE `roles`.`account_id` IS NULL
                ";

        $this->exec($query);
    }

    public function deleteAllByAccountID($accountID)
    {
        $query = "
                    DELETE `{$this->table}`
                    FROM `{$this->table}`
                    LEFT JOIN `roles`
                        ON `roles`.`id` = `{$this->table}`.`role_id`
                    WHERE `roles`.`account_id` = '{$accountID}'
                ";
        $this->exec($query);
    }
}